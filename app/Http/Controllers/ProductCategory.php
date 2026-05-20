<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ImageKitService;

class ProductCategory extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('categories')->where('is_deleted', 0);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('id', 'DESC')->paginate(10);
        $categories->appends($request->only(['search']));

        if ($request->ajax()) {
            $tableHtml      = view('admin.pages.category.partials.category-table', compact('categories'))->render();
            $paginationHtml = view('admin.pages.category.partials.pagination', compact('categories'))->render();
            return response()->json(['table' => $tableHtml, 'pagination' => $paginationHtml]);
        }

        return view('admin.pages.category.list', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.category.create');
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:10240',
            'show_in_top_bar' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        // Fetch existing record for update
        $oldCategory        = $id ? DB::table('categories')->where('id', $id)->first() : null;
        $oldImagePath       = $oldCategory->image              ?? null;
        $oldImagekitFileId  = $oldCategory->imagekit_file_id   ?? null;

        // Defaults — preserve existing values on update (no new file uploaded)
        $imagePath          = $oldImagePath;
        $imagekitFileId     = $oldImagekitFileId;
        $imagekitUrl        = $oldCategory->imagekit_url         ?? null;
        $imagekitUrlDesktop = $oldCategory->imagekit_url_desktop ?? null;
        $imagekitUrlTablet  = $oldCategory->imagekit_url_tablet  ?? null;
        $imagekitUrlMobile  = $oldCategory->imagekit_url_mobile  ?? null;
        $uploadedToImagekit = $oldCategory->uploaded_to_imagekit ?? 0;

        if ($request->hasFile('image')) {
            $imagekitService = new ImageKitService();

            // Upload with category portrait sizes + WebP conversion via ImageKit
            $uploadResult = $imagekitService->uploadWithFallback(
                $request->file('image'),
                'uploads/categories',
                'categories',
                ImageKitService::CATEGORY_SIZES
            );

            Log::info('Category image upload result', $uploadResult);
            $uploadedToImagekit = $uploadResult['uploaded_to_imagekit'];

            if ($uploadedToImagekit) {
                // ImageKit success — store responsive URLs
                $imagePath          = $uploadResult['file_path'];
                $imagekitFileId     = $uploadResult['imagekit_file_id'];
                $imagekitUrl        = $uploadResult['imagekit_url'];
                $imagekitUrlDesktop = $uploadResult['imagekit_url_desktop'];
                $imagekitUrlTablet  = $uploadResult['imagekit_url_tablet'];
                $imagekitUrlMobile  = $uploadResult['imagekit_url_mobile'];
            } else {
                // Local fallback
                $imagePath          = $uploadResult['file_path'];
                $imagekitFileId     = null;
                $imagekitUrl        = null;
                $imagekitUrlDesktop = null;
                $imagekitUrlTablet  = null;
                $imagekitUrlMobile  = null;
            }

            // Delete old image
            if ($oldImagePath) {
                if ($oldImagekitFileId && $imagekitService->isEnabled()) {
                    $imagekitService->deleteImage($oldImagekitFileId);
                }
                $localPath = public_path('uploads/' . $oldImagePath);
                if (file_exists($localPath)) {
                    unlink($localPath);
                }
            }
        }

        $data = [
            'name'                  => $request->input('name'),
            'image'                 => $imagePath,
            'show_in_top_bar'       => $request->boolean('show_in_top_bar'),
            'imagekit_file_id'      => $imagekitFileId,
            'imagekit_url'          => $imagekitUrl,
            'imagekit_url_desktop'  => $imagekitUrlDesktop,
            'imagekit_url_tablet'   => $imagekitUrlTablet,
            'imagekit_url_mobile'   => $imagekitUrlMobile,
            'uploaded_to_imagekit'  => $uploadedToImagekit ? 1 : 0,
        ];

        if ($id) {
            DB::table('categories')->where('id', $id)->update($data);
            $message = 'Category updated successfully!';
        } else {
            DB::table('categories')->insert($data);
            $message = 'Category created successfully!';
        }

        return response()->json(['status' => 'success', 'message' => $message], 200);
    }

    public function edit(Request $request, $id)
    {
        $categories = DB::table('categories')->where('id', $id)->first();
        if ($categories) {
            return view('admin.pages.category.create', compact('categories'));
        }
        return redirect()->route('category.index')->with('error', 'Something Error');
    }

    public function destroy($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if ($category) {
            DB::table('categories')->where('id', $id)->update(['is_deleted' => 1]);
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = DB::table('sub_categories')
            ->where('category_id', $request->category_id)
            ->where('is_deleted', 0)
            ->get();
        return response()->json(['subcategories' => $subcategories]);
    }
}

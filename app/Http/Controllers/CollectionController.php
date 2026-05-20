<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ImageKitService;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('collections')
            ->select('collections.*', 'sub_categories.name as categoryname')
            ->leftJoin('sub_categories', 'sub_categories.id', 'collections.sub_category_id')
            ->where('collections.is_deleted', 0);

        if ($request->has('search') && $request->search != '') {
            $query->where('collections.name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('subcategory') && $request->subcategory != '') {
            $query->where('collections.sub_category_id', $request->subcategory);
        }

        $collections = $query->orderBy('collections.id', 'DESC')->paginate(10);

        $subcategories = DB::table('sub_categories')
            ->where('is_deleted', 0)
            ->orderBy('name', 'ASC')
            ->get();

        if ($request->ajax()) {
            $tableHtml      = view('admin.pages.collections.partials.collection-table', compact('collections'))->render();
            $paginationHtml = view('admin.pages.collections.partials.pagination', compact('collections'))->render();
            return response()->json(['table' => $tableHtml, 'pagination' => $paginationHtml]);
        }

        return view('admin.pages.collections.list', compact('collections', 'subcategories'));
    }

    public function create()
    {
        return view('admin.pages.collections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'collection_name'  => 'required|string|max:255',
            'sub_category'     => 'required|integer',
            'collection_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic|max:10240',
        ]);

        try {
            // Fetch existing record for update
            $oldCollection      = $request->id ? DB::table('collections')->where('id', $request->id)->first() : null;
            $oldImagePath       = $oldCollection->image_path          ?? null;
            $oldImagekitFileId  = $oldCollection->imagekit_file_id    ?? null;

            // Defaults — preserve existing on update
            $imagePath          = $oldImagePath;
            $imagekitFileId     = $oldImagekitFileId;
            $imagekitUrl        = $oldCollection->imagekit_url         ?? null;
            $imagekitUrlDesktop = $oldCollection->imagekit_url_desktop ?? null;
            $imagekitUrlTablet  = $oldCollection->imagekit_url_tablet  ?? null;
            $imagekitUrlMobile  = $oldCollection->imagekit_url_mobile  ?? null;
            $uploadedToImagekit = $oldCollection->uploaded_to_imagekit ?? 0;

            if ($request->hasFile('collection_image')) {
                $imagekitService = new ImageKitService();

                $uploadResult = $imagekitService->uploadWithFallback(
                    $request->file('collection_image'),
                    'uploads/collection',
                    'collections',
                    ImageKitService::COLLECTION_SIZES
                );

                Log::info('Collection image upload result', $uploadResult);

                $uploadedToImagekit = $uploadResult['uploaded_to_imagekit'];

                if ($uploadedToImagekit) {
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
                'name'                  => $request->collection_name,
                'sub_category_id'       => $request->sub_category,
                'image_path'            => $imagePath,
                'imagekit_file_id'      => $imagekitFileId,
                'imagekit_url'          => $imagekitUrl,
                'imagekit_url_desktop'  => $imagekitUrlDesktop,
                'imagekit_url_tablet'   => $imagekitUrlTablet,
                'imagekit_url_mobile'   => $imagekitUrlMobile,
                'uploaded_to_imagekit'  => $uploadedToImagekit ? 1 : 0,
            ];

            if ($request->id) {
                DB::table('collections')->where('id', $request->id)->update($data);
                $message = 'Collection updated successfully.';
            } else {
                DB::table('collections')->insert($data);
                $message = 'Collection added successfully.';
            }

            return response()->json(['status' => 'success', 'message' => $message]);

        } catch (\Exception $e) {
            Log::error('Collection store error', ['message' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $collections = DB::table('collections')->where('id', $id)->first();
        if ($collections) {
            return view('admin.pages.collections.create', compact('collections'));
        }
        return redirect()->route('collections.index')->with('error', 'Something Error');
    }

    public function destroy(string $id)
    {
        $collections = DB::table('collections')->where('id', $id)->first();
        if ($collections) {
            DB::table('collections')->where('id', $id)->update(['is_deleted' => 1]);
            return response()->json(['success' => true, 'message' => 'Collection deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Collection not found.']);
    }
}

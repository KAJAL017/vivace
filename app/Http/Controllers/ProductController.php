<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ProductController extends Controller
{

    public function index()
    {
        $result['products'] = DB::table('products')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->join('brands', 'brands.id', '=', 'products.brand_id')
        ->join('collections', 'collections.id', '=', 'products.collection_id')
        ->select(
            'products.*',
            // 'product_attributes.size_id',
            // 'product_attributes.color_id',
            // 'product_attributes.mrp',
            'collections.name as collectionName',
            'categories.name as categoryname',
            'brands.name as brandname',
        )
        ->orderBy('products.id','DESC')
        ->get();



        return view('admin.pages.product.list',$result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->POST());
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'category' => 'required',
            'subcategory' => 'nullable',
            'brand' => 'required',
            'gender' => 'required',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'mrp.*' => 'required|numeric',
            'price.*' => 'required|numeric',
            'qty.*' => 'required|numeric',
            'attr_image.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
            'featured' => 'nullable|boolean',
            'discounted' => 'nullable|boolean',
            'newarrival' => 'nullable|boolean',
            'bestseller' => 'nullable|boolean',
            'tags.*' => 'nullable|exists:tags,id'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();



            $productId = DB::table('products')->insertGetId([
                'name' => $request->product_name,
                 'slug' => \Illuminate\Support\Str::slug($request->input('product_name')),
                'category_id' => $request->category,
                'subcategory' => $request->subcategory,
                'collection_id' => $request->collection,
                'brand_id' => $request->brand,
                'gender' => $request->gender,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'yt_link' => $request->yt_link,
                'featured' => $request->has('featured') ? 1 : 0,
                'discounted' => $request->has('discounted') ? 1 : 0,
                'newarrival' => $request->has('newarrival') ? 1 : 0,
                'bestseller' => $request->has('bestseller') ? 1 : 0,
                'special' => $request->has('special') ? 1 : 0,
                'date'=>date('d-m-Y')
            ]);

            if ($request->hasFile('product_images')) {
                $images = $request->file('product_images'); // This will be an array of files

                // Loop through each file and process it
                foreach ($images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('uploads/product_images');
                    $image->move($destinationPath, $imageName);

                    // Save file information in the database along with the product_id
                    DB::table('product_images')->insert([
                        'product_id' => $productId, // Store product_id
                        'file_name' => $imageName,
                        'file_path' => 'uploads/product_images/' . $imageName, // Update path based on where it's stored
                    ]);
                }
            }

            if ($request->has('tags')) {
                foreach ($request->tags as $tagId) {
                    DB::table('product_tags')->insert([
                        'product_id' => $productId,
                        'tag_id' => $tagId
                    ]);
                }
            }



            if ($request->has('mrp')) {
                foreach ($request->mrp as $key => $mrp) {
                    $attrImagePath = null;
                    if ($request->hasFile('attr_image.' . $key)) {
                        $attrImage = $request->file('attr_image.' . $key);
                        $attrImageName = Str::random(10) . '.' . $attrImage->getClientOriginalExtension();
                        $attrImage->move(public_path('products'), $attrImageName);
                        $attrImagePath = 'products/' . $attrImageName;
                    }

                    DB::table('product_attributes')->insert([
                        'product_id' => $productId,
                        'mrp' => $request->mrp[$key],
                        'price' => $request->price[$key],
                        'size_id' => $request->size[$key],
                        'color_id' => $request->color[$key],
                        'qty' => $request->qty[$key],
                        'image' => $attrImagePath,
                        'date'=>date('d-m-Y')
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the product: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function uploadImage($request, $imageName)
    {
        if ($request->hasFile($imageName)) {
            $file = $request->file($imageName);
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            return 'uploads/products/' . $filename;
        }
        return null;
    }

    public function image_upload($id)
    {
        $data = $id;

        return view('admin.pages.product.image_upload', compact('data'));
    }
    public function upload(Request $request)
    {
        // Validate the request (image files with specific size and types)
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,heic|max:2048', // Validation rules
            'product_id' => 'required|exists:products,id', // Validate the product_id
        ]);

        // Check if the request has files
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/product_images');
            $image->move($destinationPath, $imageName);

            // Save file information in the database along with the product_id
            DB::table('product_images')->insert([
                'product_id' => $request->input(key: 'product_id'), // Store product_id
                'file_name' => $imageName,
                'file_path' => 'uploads/product_images/' . $imageName, // Update path based on where it's stored
            ]);

            return response()->json(['success' => 'Image uploaded successfully']);
        }

        return response()->json(['error' => 'No file uploaded']);
    }

    public function show()
    {

    }
    public function bulk_upload()
    {
        return view('admin.pages.product.bulk_upload');
    }
    public function generateDemoFile(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Product Data');

        // Add headers for products table
        $sheet->setCellValue('A1', 'name');
        $sheet->setCellValue('B1', 'title');
        $sheet->setCellValue('C1', 'category_id');
        $sheet->setCellValue('D1', 'brand_id');
        $sheet->setCellValue('E1', 'gender');
        $sheet->setCellValue('F1', 'short_description');
        $sheet->setCellValue('G1', 'additional_description');
        $sheet->setCellValue('H1', 'description');
        $sheet->setCellValue('I1', 'first_image');
        $sheet->setCellValue('J1', 'second_image');
        $sheet->setCellValue('K1', 'featured');
        $sheet->setCellValue('L1', 'discounted');
        $sheet->setCellValue('M1', 'newarrival');
        $sheet->setCellValue('N1', 'bestseller');

        // Add headers for product_attributes table
        $sheet->setCellValue('O1', 'mrp');
        $sheet->setCellValue('P1', 'price');
        $sheet->setCellValue('Q1', 'size_id');
        $sheet->setCellValue('R1', 'color_id');
        $sheet->setCellValue('S1', 'qty');
        $sheet->setCellValue('T1', 'image');

    // Use Laravel's storage path
    $filePath = storage_path('app/public/demo_file.xlsx');

    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

        return response()->download($filePath);
    }
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('excel_file')->getRealPath();
        $spreadsheet = IOFactory::load($file);

        $productSheet = $spreadsheet->getSheet(0)->toArray();
        $attributeSheet = $spreadsheet->getSheet(1)->toArray();

        DB::beginTransaction();

        try {
            for ($i = 1; $i < count($productSheet); $i++) {
                $productRow = $productSheet[$i];
                $productId = DB::table('products')->insertGetId([
                    'name' => $productRow[0],
                    'title' => $productRow[1],
                    'category_id' => $productRow[2],
                    'brand_id' => $productRow[3],
                    'gender' => $productRow[4],
                    'short_description' => $productRow[5],
                    'additional_description' => $productRow[6],
                    'description' => $productRow[7],
                    'first_image' => $productRow[8],
                    'second_image' => $productRow[9],
                    'featured' => $productRow[10],
                    'discounted' => $productRow[11],
                    'newarrival' => $productRow[12],
                    'bestseller' => $productRow[13],
                ]);

                for ($j = 1; $j < count($attributeSheet); $j++) {
                    $attributeRow = $attributeSheet[$j];
                    if ($attributeRow[0] == $i) {
                        DB::table('product_attributes')->insert([
                            'product_id' => $productId,
                            'mrp' => $attributeRow[1],
                            'price' => $attributeRow[2],
                            'size_id' => $attributeRow[3],
                            'color_id' => $attributeRow[4],
                            'qty' => $attributeRow[5],
                            'image' => $attributeRow[6],
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Products and attributes uploaded successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteImage($id)
{
    $image = DB::table('product_images')->where('id', $id)->first();

    if ($image) {
        $file_path = public_path($image->file_path);

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        DB::table('product_images')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.', 'id' => $id]);
    }

    return response()->json(['success' => false, 'message' => 'Image not found.']);
}

public function getSubcategories($categoryId)
{
    $subcategories = DB::table('sub_categories')
    ->where('category_id', $categoryId)
    ->select('id', 'name')
    ->get();

    // Return the subcategories as a JSON response
    return response()->json($subcategories);
}





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->where('is_deleted', 0)->get();
        $brands = DB::table('brands')->where('is_deleted', 0)->get();
        $tags = DB::table('tags')->where('is_deleted', 0)->get();
        $sizes = DB::table('sizes')->where('is_deleted', 0)->get();
        $colors = DB::table('colors')->where('is_deleted', 0)->get();
        $sub_categories = DB::table('sub_categories')->where('is_deleted', 0)->get();
        $product_images = DB::table('product_images')->where('product_id', $id)->get();
        $product_attributes = DB::table('product_attributes')->where('product_id', $id)->get();

        return view('admin.pages.product.edit', compact('product', 'categories', 'brands', 'tags', 'sizes', 'colors','product_images','product_attributes','sub_categories'));
    }
    public function ProductCopy(string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->where('is_deleted', 0)->get();
        $brands = DB::table('brands')->where('is_deleted', 0)->get();
        $tags = DB::table('tags')->where('is_deleted', 0)->get();
        $sizes = DB::table('sizes')->where('is_deleted', 0)->get();
        $colors = DB::table('colors')->where('is_deleted', 0)->get();
        $sub_categories = DB::table('sub_categories')->where('is_deleted', 0)->get();
        $product_images = DB::table('product_images')->where('product_id', $id)->get();
        $product_attributes = DB::table('product_attributes')->where('product_id', $id)->get();

        return view('admin.pages.product.copy', compact('product', 'categories', 'brands', 'tags', 'sizes', 'colors','product_images','product_attributes','sub_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData(Request $request, $productId)
    {


                    // $productId = $request->input('ProductID');
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'category' => 'required',
            'subcategory' => 'nullable',
            'brand' => 'required',
            'gender' => 'required',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'mrp.*' => 'required|numeric',
            'price.*' => 'required|numeric',
            'qty.*' => 'required|numeric',
            'attr_image.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
            'featured' => 'nullable|boolean',
            'discounted' => 'nullable|boolean',
            'newarrival' => 'nullable|boolean',
            'bestseller' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();


            $product = DB::table('products')->where('id', $productId)->first();

                       if ($request->hasFile('product_images')) {
                $images = $request->file('product_images'); // This will be an array of files

                // Loop through each file and process it
                foreach ($images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('uploads/product_images');
                    $image->move($destinationPath, $imageName);

                    // Save file information in the database along with the product_id
                    DB::table('product_images')->insert([
                        'product_id' => $productId, // Store product_id
                        'file_name' => $imageName,
                        'file_path' => 'uploads/product_images/' . $imageName, // Update path based on where it's stored
                    ]);
                }
            }
        $attrImagePath = "";
            // Update product details
            DB::table('products')->where('id', $productId)->update([
                 'name' => $request->product_name,
                 'slug' => \Illuminate\Support\Str::slug($request->input('product_name')),
                'category_id' => $request->category,
                'subcategory' => $request->subcategory,
                'collection_id' => $request->collection,
                'brand_id' => $request->brand,
                'gender' => $request->gender,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'yt_link' => $request->yt_link,
                'featured' => $request->has('featured') ? 1 : 0,
                'discounted' => $request->has('discounted') ? 1 : 0,
                'newarrival' => $request->has('newarrival') ? 1 : 0,
                'bestseller' => $request->has('bestseller') ? 1 : 0,
                'special' => $request->has('special') ? 1 : 0,
                'date'=>date('d-m-Y')
            ]);

                // Update product attributes
            // if ($request->has('mrp')) {
            //     foreach ($request->mrp as $key => $mrp) {
            //         $attrImagePath = null;
            //         if ($request->hasFile('attr_image.' . $key)) {
            //             $attrImage = $request->file('attr_image.' . $key);
            //             $attrImageName = Str::random(10) . '.' . $attrImage->getClientOriginalExtension();
            //             $attrImage->move(public_path('products'), $attrImageName);
            //             $attrImagePath = 'products/' . $attrImageName;
            //         }

            //         DB::table('product_attributes')->updateOrInsert(
            //             ['product_id' => $productId, 'size_id' => $request->size[$key], 'color_id' => $request->color[$key]],
            //             [
            //                 'mrp' => $mrp,
            //                 'price' => $request->price[$key],
            //                 'qty' => $request->qty[$key],
            //                 'image' => $attrImagePath ?? DB::raw('image')
            //             ]
            //         );
            //     }
            // }

            // Update product attributes
            if ($request->has('mrp')) {
                foreach ($request->mrp as $key => $mrp) {
                    $attrImagePath = null;
                    if ($request->hasFile('attr_image.' . $key)) {
                        $attrImage = $request->file('attr_image.' . $key);
                        $attrImageName = Str::random(10) . '.' . $attrImage->getClientOriginalExtension();
                        $attrImage->move(public_path('products'), $attrImageName);
                        $attrImagePath = 'products/' . $attrImageName;
                    }

                    DB::table('product_attributes')->updateOrInsert(
                        ['product_id' => $productId, 'size_id' => $request->size[$key], 'color_id' => $request->color[$key]],
                        [
                            'mrp' => $mrp,
                            'price' => $request->price[$key],
                            'qty' => $request->qty[$key],
                            'image' => $attrImagePath ?? DB::raw('image')
                        ]
                    );
                }
            }

            if ($request->has('tags')) {
                $tags = $request->input('tags', []); // Ensure it's an array
                if (!is_array($tags)) {
                    $tags = [];
                }

                DB::table('product_tags')->where('product_id', $productId)->delete();

                $tagData = array_map(function($tagId) use ($productId) {
                    return ['product_id' => $productId, 'tag_id' => $tagId];
                }, $tags);

                DB::table('product_tags')->insert($tagData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the product: ' . $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the product using DB query
    $product = DB::table('products')->where('id', $id)->first();

    if (!$product) {
        return response()->json(['status' => 'error', 'message' => 'Product not found']);
    }

    // // Optionally, delete any related data or media (e.g., images)
    // if ($product->image) {
    //     $imagePath = public_path('storage/' . $product->image); // Adjust path if necessary
    //     if (file_exists($imagePath)) {
    //         unlink($imagePath); // Delete the image file from the server
    //     }
    // }

    // Delete the product using DB query
    DB::table('products')->where('id', $id)->delete();
    DB::table('product_attributes')->where('product_id', $id)->delete();

    return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
    }


    public function deleteAttribute($id)
{
    // Find the attribute by ID and delete it
    $attribute = DB::table('product_attributes')->where('id', $id)->first();

    if ($attribute) {
        // Optionally, delete the image if it exists
        if ($attribute->image) {
            $imagePath = public_path('public/' . $attribute->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Delete the image file
            }
        }

        // Delete the attribute from the database
        DB::table('product_attributes')->where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Attribute deleted successfully']);
    }

    return response()->json(['status' => 'error', 'message' => 'Attribute not found']);
}
}

<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
function admin_assets(){
    $path = url('public/admin_assets');
   return $path;
}

 function CheckLogin($user){
    Session::put('user_id', $user->id);
    Session::put('user_login', true);
}
function getUserData() {
    $userId = Session::get('user_id');
    if (!$userId) {
        return null;
    }
    return DB::table('users')->find($userId);
}
function getUser($id) {

    return DB::table('users')->find($id);
}
if (!function_exists('getColorData')) {
    function getColorData($id) {
        if (!is_numeric($id) || $id <= 0) {
            return 'Unknown';
        }

        $user = DB::table('colors')->where('id', $id)->first();

        return $user ? $user->name : 'color not found';
    }
}
if (!function_exists('getAddressData')) {
    function getAddressData($id) {

        if (!is_numeric($id) || $id <= 0) {
            return null;
        }
        $address = DB::table('addresses')->where('id', $id)->first();
        return $address ?: null;
    }
}

if (!function_exists('getSizeData')) {
    function getSizeData($id) {
        if (!is_numeric($id) || $id <= 0) {
            return 'Unknown';
        }

        $sizes = DB::table('sizes')->where('id', $id)->first();

        return $sizes ? $sizes->name : 'sizes not found';
    }
}



function getCartData(){
    $user_id = session('user_id') ?? session('temporary_user_id');
    if ($user_id) {
        $cartData = DB::table('cart')
            ->where('user_id', $user_id)
            ->orderBy('id','ASC')
            ->get();

        return $cartData;
    }
    return collect();
}

function CartProductData()
{
    $userId = session('user_id') ?? session('temporary_user_id');

    if (!$userId) {
        return [];
    }

    $cartItems = DB::table('cart')
        ->where('user_id', $userId)
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->leftJoin('product_attributes', 'product_attributes.product_id', '=', 'cart.product_id')
        ->leftJoin('product_images', 'product_images.product_id', '=', 'cart.product_id')
        ->select(
            'cart.id as cart_item_id',
            'cart.quantity',
            'cart.size_id',
            'cart.color_id',
            'products.name as name',
            'products.slug as slug',
            'products.id as product_id',
            'product_attributes.price as price',
            'product_attributes.mrp as mrp',
            DB::raw('MIN(product_images.file_path) as image')
        )
        ->groupBy('cart.id', 'cart.quantity', 'cart.size_id', 'cart.color_id', 'products.name','products.slug', 'products.id', 'product_attributes.price', 'product_attributes.mrp')
        ->get();

    return $cartItems->map(function ($item) {
        return [
            'cart_item' => [
                'id' => $item->cart_item_id,
                'quantity' => $item->quantity,
                'size_id' => $item->size_id,
                'color_id' => $item->color_id,
            ],
            'product' => [
                'id' => $item->product_id,
                'name' => $item->name,
                'slug' => $item->slug,
                'price' => $item->price,
                'mrp' => $item->mrp,
                'image' => url('public/' . ($item->image ?? 'default-image.jpg')),
            ],
        ];
    })->toArray();
}


function getWishlistData() {
    $user_id = session('user_id') ?? session('temporary_user_id');
    if ($user_id) {
        $wishlistData = DB::table('wishlists')
            ->where('user_id', $user_id)
            ->orderBy('id', 'ASC')
            ->get();

        return $wishlistData;
    }
    return collect();
}

function WishlistProductData() {
    $WishlistItems = getWishlistData();
    $productData = [];

    foreach ($WishlistItems as $wishlistItem) {
        $ProductID = $wishlistItem->product_id;
        $SizeID = $wishlistItem->size_id;
        $ColorID = $wishlistItem->color_id;

        // Fetch product details with the correct size and color
        $product = DB::table('products')
            ->join('product_attributes', function ($join) use ($SizeID, $ColorID) {
                $join->on('products.id', '=', 'product_attributes.product_id')
                     ->where('product_attributes.size_id', '=', $SizeID)
                     ->where('product_attributes.color_id', '=', $ColorID);
            })
            ->leftJoin('product_images', 'product_images.product_id', '=', 'products.id')
            ->where('products.id', $ProductID)
            ->select(
                'products.id as product_id',
                'products.name',
                'product_attributes.price',
                'product_attributes.mrp',
                DB::raw('MIN(product_images.file_path) as image_path') // Fetch the first image
            )
            ->groupBy('products.id', 'products.name', 'product_attributes.price', 'product_attributes.mrp')
            ->first();

        if ($product) {
            $productData[] = [
                'wishlist_item' => [
                    'id' => $wishlistItem->id,
                    'size_id' => $SizeID,
                    'color_id' => $ColorID
                ],
                'product' => [
                    'id' => $product->product_id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'mrp' => $product->mrp,
                    'image' => url('public/' . ($product->image_path ?? 'default-image.jpg')) // Handle missing image
                ]
            ];
        }
    }

    return $productData;
}

function get_product_data($id){
    $result = DB::table('products')->where(['id'=>$id])->first();
    if($result){
         return $result;
    }else{
        return  '';
    }

}


function invoice_assets(){
    $path = url('public/invoice_asstes');
   return $path;
}
function path(){
    $path = url('public');
   return $path;
}
function website_assets(){
    $path = url('public/website_assets');
   return $path;
}
function login_assets(){
    $path = url('public/login_assets');
   return $path;
}
function image_path(){
    $path = url('storage/app/public/');
   return $path;
}
function p($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}
function get_designation($id){
    $result = DB::table('mr_designation')->where(['id'=>$id])->first();
    if($result){
         return $result->name;
    }else{
        return  '';
    }

}
function get_second_image($productId){
    // Get the second image for the given product
    $result = DB::table('product_images')
        ->where('product_id', $productId)
        ->orderBy('id') // Order images by ID or another column that determines the image order
        ->skip(1) // Skip the first image
        ->take(1) // Take the second image
        ->first();

    // Check if an image is found
    if($result) {
        return $result->file_path; // Return the file path of the second image
    } else {
        return ''; // Return empty string if no second image is found
    }
}

function Product_first_image($id){
    $result = DB::table('product_images')->where(['product_id'=>$id])->first();
    if($result){
         return $result->file_path;
    }else{
        return  '';
    }

}
function get_category($id){
    $result = DB::table('consumable_category')->where(['id'=>$id])->first();
    if($result){
         return $result->name;
    }else{
        return  '';
    }

}
function get_medicine_category($id){
    $result = DB::table('medicine_categories')->where(['id'=>$id])->first();
    if($result){
         return $result->name;
    }else{
        return  '';
    }

}


?>

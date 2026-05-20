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
        ->leftJoin(
            DB::raw('(SELECT product_id, MIN(id) as min_id FROM product_images GROUP BY product_id) as pi_min'),
            'pi_min.product_id', '=', 'cart.product_id'
        )
        ->leftJoin('product_images', 'product_images.id', '=', 'pi_min.min_id')
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
            'product_images.file_path as image',
            'product_images.imagekit_url as image_ik'
        )
        ->groupBy('cart.id', 'cart.quantity', 'cart.size_id', 'cart.color_id', 'products.name', 'products.slug', 'products.id', 'product_attributes.price', 'product_attributes.mrp', 'product_images.file_path', 'product_images.imagekit_url')
        ->get();

    return $cartItems->map(function ($item) {
        $imageUrl = !empty($item->image_ik)
            ? $item->image_ik
            : (!empty($item->image) ? upload_url($item->image) : url('public/5.png'));
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
                'image' => $imageUrl,
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
            ->leftJoin(
                DB::raw('(SELECT product_id, MIN(id) as min_id FROM product_images GROUP BY product_id) as pi_min'),
                'pi_min.product_id', '=', 'products.id'
            )
            ->leftJoin('product_images', 'product_images.id', '=', 'pi_min.min_id')
            ->where('products.id', $ProductID)
            ->select(
                'products.id as product_id',
                'products.name',
                'product_attributes.price',
                'product_attributes.mrp',
                'product_images.file_path as image_path',
                'product_images.imagekit_url as image_ik'
            )
            ->first();

        if ($product) {
            $imageUrl = !empty($product->image_ik)
                ? $product->image_ik
                : (!empty($product->image_path) ? upload_url($product->image_path) : url('public/5.png'));

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
                    'image' => $imageUrl,
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

/**
 * Get correct URL for uploaded files.
 *
 * Production server: document root = /public
 *   Files at: /public/uploads/path
 *   asset('uploads/path') = https://domain/uploads/path ✓
 *
 * Local XAMPP: APP_URL = http://localhost/.../public
 *   Files at: /public/uploads/path
 *   asset('uploads/path') = http://localhost/.../public/uploads/path ✓
 *
 * DB path formats:
 *   'uploads/product_images/file.jpg' → strip 'uploads/' → asset('uploads/file.jpg')
 *   'product_images/file.jpg'         → asset('uploads/product_images/file.jpg')
 *   'banners/file.jpg'                → asset('uploads/banners/file.jpg')
 */
function upload_url($path = '') {
    if (empty($path)) return asset('5.png');

    $path = ltrim($path, '/');

    // Strip 'uploads/' prefix if already present in stored path
    if (str_starts_with($path, 'uploads/')) {
        $path = substr($path, strlen('uploads/'));
    }

    // asset() uses APP_URL as base — works correctly on both local and production
    return asset('uploads/' . $path);
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
    $result = DB::table('product_images')
        ->where('product_id', $productId)
        ->orderBy('id')
        ->skip(1)->take(1)
        ->first();

    if($result) {
        if (!empty($result->imagekit_url)) {
            return $result->imagekit_url;
        }
        return upload_url($result->file_path);
    }
    return Product_first_image($productId);
}

function Product_first_image($id){
    $result = DB::table('product_images')->where(['product_id'=>$id])->orderBy('id','asc')->first();
    if($result){
        if (!empty($result->imagekit_url_desktop)) return $result->imagekit_url_desktop;
        if (!empty($result->imagekit_url))         return $result->imagekit_url;
        return upload_url($result->file_path);
    }
    return asset('5.png');
}

function product_responsive_image($id) {
    $result = DB::table('product_images')->where(['product_id'=>$id])->orderBy('id','asc')->first();
    if (!$result) {
        return ['src'=>asset('5.png'),'desktop'=>null,'tablet'=>null,'mobile'=>null,'has_ik'=>false];
    }
    $hasIK = !empty($result->imagekit_url);
    return [
        'src'     => $hasIK
            ? ($result->imagekit_url_desktop ?? $result->imagekit_url)
            : upload_url($result->file_path),
        'desktop' => $result->imagekit_url_desktop ?? null,
        'tablet'  => $result->imagekit_url_tablet  ?? null,
        'mobile'  => $result->imagekit_url_mobile  ?? null,
        'has_ik'  => $hasIK && !empty($result->imagekit_url_desktop),
    ];
}

function product_second_image($id) {
    $result = DB::table('product_images')
        ->where('product_id', $id)
        ->orderBy('id')
        ->skip(1)->take(1)
        ->first();
    if (!$result) return product_responsive_image($id);
    $hasIK = !empty($result->imagekit_url);
    return [
        'src'     => $hasIK
            ? ($result->imagekit_url_desktop ?? $result->imagekit_url)
            : upload_url($result->file_path),
        'desktop' => $result->imagekit_url_desktop ?? null,
        'tablet'  => $result->imagekit_url_tablet  ?? null,
        'mobile'  => $result->imagekit_url_mobile  ?? null,
        'has_ik'  => $hasIK && !empty($result->imagekit_url_desktop),
    ];
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\ManualOrderMail;

class WebsiteContoller extends Controller
{

    public function login_process(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        // Check if the user exists and if the hashed password matches
        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user_login', true);
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);

            // Merge cart after login
            $this->mergeCart();

            if ($request->remember == 'true') {
                Cookie::queue('email', $request->email, 43200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('website.home'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
        ]);
    }


    public function mergeCart()
    {
        $temporaryUserId = session('temporary_user_id');
        $userId = session('user_id');

        // Only proceed if we have both a temporary user ID and a logged-in user ID
        if ($temporaryUserId && $userId) {
            // Fetch temporary cart items
            $temporaryCartItems = DB::table('cart')->where('user_id', $temporaryUserId)->get();

            foreach ($temporaryCartItems as $item) {
                // Merge or update cart items for logged-in user
                DB::table('cart')->updateOrInsert(
                    [
                        'user_id' => $userId,
                        'product_id' => $item->product_id,
                        'size_id' => $item->size_id,
                        'color_id' => $item->color_id,
                    ],
                    [
                        'quantity' => DB::raw("COALESCE(quantity, 0) + $item->quantity"),
                    ]
                );
            }

            // Clear temporary cart
            DB::table('cart')->where('user_id', $temporaryUserId)->delete();
            session()->forget('temporary_user_id'); // Remove temporary user ID from session
        }
    }




    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Insert the user data into the database
        DB::table('users')->insert([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash the password
            'date' => date('d-m-Y'),
        ]);

        // Retrieve the newly registered user
        $user = DB::table('users')->where('email', $request->input('email'))->first();

        // Log the user in immediately after registration
        Session::put('user_login', true);
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);

        // Explicitly save the session to ensure it's stored
        Session::save();

        // Merge cart after login
        $this->mergeCart(); // Ensure this method works as expected

        // Return success message along with the redirect URL
        return response()->json([
            'success' => true,
            'message' => 'Account created and logged in successfully!',
            'redirect' => route('website.home'), // Redirect URL after registration
        ]);

    }



    public function getProductDetails(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|integer|exists:products,id',
        ]);

        $productId = $validated['id'];

        // Fetch the product details along with price and MRP from the product_attributes table
        $product = DB::table('products')
            ->join('product_attributes', 'product_attributes.product_id', '=', 'products.id')
            ->where('products.id', $productId)
            ->select(
                'products.id',
                'products.name',
                'product_attributes.price',
                'product_attributes.mrp',
                'products.short_description'
            )
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Fetch associated images or set a default image
        $images = DB::table('product_images')
            ->where('product_id', $productId)
            ->pluck('file_path')
            ->map(fn($path) => url('public/' . $path))
            ->toArray();

        if (empty($images)) {
            $images = [url('storage/default-image.jpg')];
        }

        // Return the product details as JSON
        return response()->json([
            'success' => true,
            'name' => $product->name,
            'price' => $product->price,
            'mrp' => $product->mrp,
            'details' => $product->short_description ?? 'No details available.',
            'images' => $images,
        ]);
    }




    public function logout(Request $request)
    {
        $request->session()->forget(['user_id', 'user_login']);
        $request->session()->invalidate();
        return redirect()->route('website.home')->with('success','Logout Successfully');

    }


    public function home(){

        $categories = DB::table('categories')->where(['is_deleted'=>0])->get();
        $brands = DB::table('brands')->where(['is_deleted'=>0])->get();

        $result['newarrival_products'] = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.newarrival', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.slug',
            'products.featured',
            'products.discounted',
            'products.newarrival',
            'products.bestseller',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->limit(4)
        ->get();


        $result['featured_products'] = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.featured', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.discounted',
            'products.newarrival',
            'products.bestseller',
            'products.slug',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->limit(4) // Initial limit
        ->get();



        $result['discounted_products'] = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.discounted', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.slug',
            'products.featured',
            'products.discounted',
            'products.newarrival',
            'products.bestseller',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->limit(4)
        ->get();

        $result['BestSeller_products'] = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.bestseller', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.featured',
            'products.discounted',
            'products.slug',
            'products.newarrival',
            'products.bestseller',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->limit(4)
        ->get();

        $result['special_products'] = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.special', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.featured',
            'products.discounted',
            'products.slug',
            'products.newarrival',
            'products.bestseller',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->limit(4)
        ->get();

        $result['collections'] = DB::table('collections')->where(['is_deleted'=>0])->orderBy('id','DESC')->limit(3)->get();



        return view('website.pages.home',compact('categories','brands'),$result);


    }
    public function collections()
    {
        $result['collections'] = DB::table('collections')
            ->where('is_deleted', 0)
            ->orderBy('id','DESC')
            ->paginate(9);
        return view('website.pages.product.collections', $result);
    }
    public function searchCollections(Request $request)
{
    $query = $request->input('query');
    $collections = DB::table('collections')
        ->where('is_deleted', 0)
        ->where('name', 'LIKE', "%{$query}%")
        ->get(['id', 'name', 'image_path']);

    $collections = $collections->map(function($collection) {
        return [
            'id' => $collection->id,
            'name' => $collection->name,
            'image_path' => url('public/uploads/' . $collection->image_path),
            'url' => route('collction.filter', [$collection->id]),
        ];
    });

    return response()->json(['collections' => $collections]);
}

    public function brands()
    {
        $result['brands'] = DB::table('brands')
            ->where('is_deleted', 0)
            ->orderBy('id','DESC')
            ->paginate(27);
        return view('website.pages.product.brands', $result);
    }
    public function SubcategoriesCollection($slug)
    {
        $subcategory = DB::table('sub_categories')->where('slug', $slug)->first();
        if (!$subcategory) {
            return response()->json(['error' => 'Collection not found'], 404);
        }
        $result['collections'] =  DB::table('collections')
        ->where(['is_deleted'=>0])
        ->orderBy('id','desc')
        ->where('sub_category_id',$subcategory->id)
        ->paginate(9);

       return view('website.pages.product.collections', $result);

    }

    public function view_product(){
        return view('website.pages.product.view');
    }
    public function refund(){
        return view('website.pages.refund');
    }
    public function login(){
        return view('website.auth.login');
    }
    public function register(){
        return view('website.auth.register');
    }
    public function privacy(){
        return view('website.pages.privacy');
    }
    public function terms(){
        return view('website.pages.terms');
    }
    public function shipping(){
        return view('website.pages.shipping');
    }




    public function ProductView($slug) {

       $products = DB::table('products')->where('slug',$slug)->first();


       $id = $products->id;
        $productAttributes = DB::table('product_attributes')
        ->select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.mrp',
            'product_attributes.price',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.qty',
            'product_attributes.image'
        )
        ->where('product_id', $id)
        ->get();

    // Transform the data for the view
    $productData = [];
    foreach ($productAttributes as $attribute) {
        // Get color information based on color_id
        $color = DB::table('colors')
            ->where('id', $attribute->color_id)
            ->first();

        // Get size information based on size_id
        $size = DB::table('sizes')
            ->where('id', $attribute->size_id)
            ->first();

        // Build the color data array
        $colorData = [
            'id' => $attribute->color_id,
            'bg_color' => $color ? $color->name : '#000000',
        ];

        // Build the size data array
        $sizeData = [
            'id' => $attribute->size_id,
            'name' => $size ? $size->name : 'Any',
        ];

        // Add to product variations array
        $productData['variations'][] = [
            'id' => $attribute->id,
            'mrp' => $attribute->mrp,
            'price' => $attribute->price,
            'color' => $colorData,
            'size' => $sizeData,
            'qty' => $attribute->qty,
            'image' => $attribute->image,
        ];
    }

    // Get basic product information
    $product = DB::table('products')
        ->select('id', 'title', 'description', 'brand_id', 'category_id','name','short_description','additional_description','yt_link')
        ->where('slug', $slug)
        ->first();

    if (!$product) {
        abort(404);
    }

    // Add basic product info to the data array
    $productData['id'] = $product->id;
    $productData['title'] = $product->title;
    $productData['description'] = $product->description;
    $productData['additional_description'] = $product->description;
    $productData['short_description'] = $product->short_description;
    $productData['additional_description'] = $product->additional_description;
    $productData['name'] = $product->name;
    $productData['yt_link'] = $product->yt_link;
    // $productData['sku'] = $product->sku;

    // Get brand information
    $brand = DB::table('brands')
        ->where('id', $product->brand_id)
        ->first();
    $productData['brand'] = $brand ? $brand->name : null;

    // Get category information
    $category = DB::table('categories')
        ->where('id', $product->category_id)
        ->first();
    $productData['category'] = $category ? $category->name : null;
    $productData['category_id'] = $category ? $category->id : null;


      $product_images = DB::table('product_images')->where(['product_id'=>$id])->get();
    //   p($product_images);

        // Pass product details to the view
        return view('website.pages.product.view', compact('productData','product_images'));
    }
    public function getColorsBySize(Request $request)
{
    $productId = $request->product_id;
    $sizeId = $request->size_id;

    $attributes = DB::table('product_attributes')
        ->where('product_id', $productId)
        ->where('size_id', $sizeId)
        ->get();

    $colors = [];
    foreach ($attributes as $attribute) {
        $color = DB::table('colors')->where('id', $attribute->color_id)->first();
        if ($color) {
            $colors[] = [
                'id' => $color->id,
                'bg_color' => $color->name,
            ];
        }
    }

    return response()->json(['colors' => $colors]);
}


public function addToCart(Request $request)
{
    $userId = session('user_id');

    // Generate a temporary user ID for guests if not logged in
    if (!$userId) {
        if (!session()->has('temporary_user_id')) {
            session(['temporary_user_id' => uniqid('temp_')]);
        }
        $userId = session('temporary_user_id');
    }

    $productId = $request->input('product_id');
    $sizeId = $request->input('size_id');
    $colorId = $request->input('color_id');
    $quantity = $request->input('quantity', 1);

    if (!is_numeric($quantity) || $quantity <= 0) {
        $quantity = 1;
    }

    try {
        // Fetch product details
        $product = DB::table('products')->where('id', $productId)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        // Update or insert cart item
        DB::table('cart')->updateOrInsert(
            [
                'user_id' => $userId,
                'product_id' => $productId,
                'size_id' => $sizeId,
                'color_id' => $colorId,
            ],
            [
                'quantity' => DB::raw("COALESCE(quantity, 0) + $quantity"),
            ]
        );

        // Retrieve updated cart data
        $cartData = DB::table(table: 'cart')
            ->where('user_id', $userId)
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->leftJoin('product_attributes', 'product_attributes.product_id', '=', 'cart.product_id')
            ->leftJoin('product_images', 'product_images.product_id', '=', 'cart.product_id')
            ->select(
                'cart.id as cart_item_id',
                'cart.quantity',
                'cart.size_id',
                'cart.color_id',
                'products.name',
                'products.id as product_id',
                'product_attributes.price as price',
                'product_attributes.mrp as mrp',
                DB::raw('MIN(product_images.file_path) as file_path')
            )
            ->groupBy('cart.id', 'cart.quantity', 'cart.size_id', 'cart.color_id', 'products.name', 'products.id', 'product_attributes.price', 'product_attributes.mrp')
            ->get();

        $cartItems = $cartData->map(function ($item) {
            return [
                'id' => $item->cart_item_id,
                'product_id' => $item->product_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'mrp' => $item->mrp,
                'price' => $item->price,
                'size_id' => $item->size_id,
                'color_id' => $item->color_id,
                'image' => url('public/' . ($item->file_path ?? 'default-image.jpg'))
            ];
        });

        $subtotal = $cartItems->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cartItems' => $cartItems,
            'subtotal' => number_format($subtotal, 2),
            'cartCount' => $cartItems->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to add product to cart! Error: ' . $e->getMessage()
        ]);
    }
}

/**
 * Merge temporary cart into user cart after login
 */






 public function WishlistAddToCart(Request $request)
 {
     $userId = session('user_id');
     if (!$userId) {
         return response()->json([
             'success' => false,
             'message' => 'Please log in to add products to your cart.'
         ], 401);
     }

     $productId = $request->input('product_id');
     $quantity = $request->input('quantity', 1); // Default quantity to 1 if not provided

     // Ensure quantity is a valid integer and greater than zero
     if (!is_numeric($quantity) || $quantity <= 0) {
         $quantity = 1; // Set default quantity to 1 if invalid
     }

     try {
         // Fetch product details
         $product = DB::table('products')->where('id', $productId)->first();
         if (!$product) {
             return response()->json([
                 'success' => false,
                 'message' => 'Product not found.'
             ], 404);
         }

         // Update or insert cart item, ensure quantity is handled safely
         DB::table('cart')->updateOrInsert(
             ['user_id' => $userId, 'product_id' => $productId],
             [
                 'quantity' => DB::raw("COALESCE(quantity, 0) + $quantity"), // Safely add quantity
             ]
         );

         // Remove the product from the wishlist
         DB::table('wishlist')->where('user_id', $userId)->where('product_id', $productId)->delete();

         // Retrieve updated cart data
         $cartData = DB::table('cart')
             ->where('user_id', $userId)
             ->join('products', 'cart.product_id', '=', 'products.id')
             ->select('cart.id as cart_item_id', 'cart.quantity', 'products.*')
             ->get();

         $subtotal = $cartData->sum(function($item) {
             return $item->quantity * $item->new_price;
         });

         return response()->json([
             'success' => true,
             'message' => 'Product added to cart successfully',
             'cartCount' => $cartData->count(),
             'cartItems' => $cartData, // Include the cart items
             'subtotal' => number_format($subtotal, 2), // Send subtotal formatted as a string
         ]);

     } catch (\Exception $e) {
         return response()->json([
             'success' => false,
             'message' => 'Failed to add product to cart! Error: ' . $e->getMessage()
         ]);
     }
 }


    public function removeFromCart(Request $request)
    {
        $userId = session('user_id');
        $cartItemId = $request->input('id');


        try {
            // Remove item from cart
            DB::table('cart')->where('id', $cartItemId)->where('user_id', $userId)->delete();

            // Retrieve updated cart subtotal and count
            $cartItems = DB::table('cart')
                ->where('user_id', $userId)
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->leftJoin('product_attributes', 'product_attributes.product_id', '=', 'cart.product_id')
                ->select('cart.quantity', 'product_attributes.price')
                ->get();

            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully.',
                'subtotal' => number_format($subtotal, 2),
                'cartCount' => $cartItems->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart! Error: ' . $e->getMessage()
            ]);
        }
    }


    public function removeFromWishlist(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User not logged in.'
            ], 401);
        }

        $wishlistItemId = $request->input('wishlist_item_id');  // Updated to handle wishlist item ID

        try {
            // Remove the item from the wishlist
            DB::table('wishlist')->where('id', $wishlistItemId)->where('user_id', $userId)->delete();

            // Retrieve updated wishlist data
            $wishlistData = DB::table('wishlist')
                ->where('user_id', $userId)
                ->join('products', 'wishlist.product_id', '=', 'products.id')
                ->select('wishlist.id as wishlist_item_id', 'wishlist.quantity', 'products.id as product_id', 'products.product_name', 'products.first_image', 'products.new_price')
                ->get();

            $subtotal = $wishlistData->sum(function($item) {
                return $item->quantity * $item->new_price;
            });

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully.',
                'wishlistItems' => $wishlistData,  // Updated wishlist items
                'wishlistCount' => $wishlistData->count()  // Send updated wishlist count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from wishlist! Error: ' . $e->getMessage()
            ]);
        }
    }

    public function Viewcart(){
        return view('website.pages.product.cart');
    }

    public function removeProductFromCart(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Please log in to remove items from your cart.'], 401);
        }

        $cartItemId = $request->input('cart_item_id');

        try {
            // Remove item from cart
            DB::table('cart')->where('id', $cartItemId)->delete();

            // Recalculate subtotal
            $cartData = DB::table('cart')
                ->where('user_id', $userId)
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->select('cart.quantity', 'products.new_price')
                ->get();

            $subtotal = $cartData->sum(function($item) {
                return $item->quantity * $item->new_price;
            });

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully',
                'subtotal' => number_format($subtotal, 2),
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove item.'], 500);
        }
    }

    public function wishlist()
    {
        return view('website.pages.product.wishlist');

    }

    public function order_placed(){
        // $CartData = CartProductData();
        // p($CartData);
        return view('website.pages.order_placed');
    }

    public function checkout()
    {
        $cartData = getCartData();  // Assuming this function returns the cart data
        $user_id = Session::get('user_id');

        // Check if the user is logged in
        if (!$user_id) {
            return redirect()->route('login')->with('error', 'You need to log in to proceed with the checkout.');
        }

        // Check if the cart is empty
        if ($cartData->isEmpty()) {
            return redirect()->route('login')->with('error', 'Your cart is empty. Please add products to your cart before proceeding.');
        }

        $users = DB::table('users')->where('id', $user_id)->first();

        return view('website.pages.checkout', compact('users', 'cartData'));
    }

    public function getajaxdata(Request $request){
        $pin = $request->post('pin');
        $data = file_get_contents('http://postalpincode.in/api/pincode/'.$pin);
        $result = json_decode($data);
        if(isset($result->PostOffice['0'])){
            $arry['city'] = $result->PostOffice['0']->Taluk;
            $arry['State'] = $result->PostOffice['0']->State;
            $arry['District'] = $result->PostOffice['0']->District;
            $arry['Country'] = $result->PostOffice['0']->Country;
            $arry['Taluk'] = $result->PostOffice['0']->Taluk;
            return  json_encode($arry);
        }else{
            return 1;
        }

    }
    public function applyCoupon(Request $request) {
        $couponCode = $request->coupon_code;
        $subtotal = $request->subtotal;

        $nowForDB = Carbon::now()->format('d-m-Y');  // Use the database format (YYYY-MM-DD)

        // Fetch coupon based on the current date
        $coupon = DB::table('coupons')
            ->where('coupon_code', $couponCode)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->whereDate('start_date', '<=', $nowForDB)
            ->whereDate('end_date', '>=', $nowForDB)
            ->first();

        // Check if coupon is valid
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code']);
        }


        $discount = 0;

        // Calculate discount based on coupon type
        if ($coupon->coupon_type == 1) {  // Percentage discount
            $discount = ($coupon->discount_value / 100) * $subtotal;
        } elseif ($coupon->coupon_type == 2) {  // Fixed discount
            $discount = $coupon->discount_value;
        }

        // Ensure discount does not exceed subtotal
        $discount = min($discount, $subtotal);

        // Calculate the new total
        $newTotal = $subtotal - $discount;

        return response()->json(['success' => true, 'message' => 'Coupon applied successfully!', 'new_total' => $newTotal]);
    }
    public function filter_product(Request $request, $slug)
    {
        try {
            // Find the subcategory by its slug
            $sub_category = DB::table('sub_categories')->where('slug', $slug)->first();
            if (!$sub_category) {
                return response()->json(['error' => 'Subcategory not found'], 404);
            }

            // Fetch products related to the selected subcategory
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.subcategory', $sub_category->id)
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Apply filters if any
            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            // Get the filtered products
            $products = $query->get();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }

            // Return the filtered products along with the subcategory
            return view('website.pages.product.shop', compact('products', 'sub_category'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function Searchfilter_product(Request $request, $slug = null)
    {
        try {
            // Building the query with necessary joins
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->leftJoin('product_tags', 'products.id', '=', 'product_tags.product_id') // Join on product_id
                ->leftJoin('tags', 'product_tags.tag_id', '=', 'tags.id') // Join with tags to filter by tag
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Search by product name or tag name
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('products.name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('tags.name', 'like', '%' . $searchTerm . '%');
                });
            }

            // Filter by tag name (exact match)
            if ($request->has('tag') && !empty($request->tag)) {
                $tagName = $request->tag;
                $query->where('tags.name', $tagName);
            }

            // Filter by category if provided
            if ($request->has('category') && !empty($request->category)) {
                $query->where('products.category_id', $request->category);
            }

            if ($request->has('sub_category') && !empty($request->sub_category)) {
                $query->where('products.subcategory', $request->sub_category);
            }
            if ($request->has('brandId') && !empty($request->brandId)) {
                $query->where('products.brand_id', $request->brandId);
            }
            if ($request->has('collectionID') && !empty($request->collectionID)) {
                $query->where('products.collection_id', $request->collectionID);
            }


            // Filter by subcategory slug
            if (!empty($slug)) {
                $sub_category = DB::table('sub_categories')->where('slug', $slug)->first();
                if (!$sub_category) {
                    return response()->json(['error' => 'Subcategory not found'], 404);
                }
                $query->where('products.subcategory', $sub_category->id);
            }

            // Filter by price range
            if ($request->has('min_price') && $request->min_price > 0) {
                $query->where('product_attributes.price', '>=', (int)$request->min_price);
            }
            if ($request->has('max_price') && $request->max_price > 0) {
                $query->where('product_attributes.price', '<=', (int)$request->max_price);
            }

            // Paginate results
            $products = $query->paginate(12); // 12 items per page

            if (!$request->ajax()) {
                return view('website.pages.product.collectionFilter', compact('products'));
            }

            $html = '';
            foreach ($products as $product) {
                $html .= view('website.pages.product.partials.product', compact('product'))->render();
            }
            return response()->json(['html' => $html]); // Return JSON response for AJAX requests

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }






    public function categoryFilter(Request $request, $slug)
    {
        try {
            // Find the subcategory by its slug
            $sub_category = DB::table('sub_categories')->where('slug', $slug)->first();
            if (!$sub_category) {
                return response()->json(['error' => 'Subcategory not found'], 404);
            }

            // Fetch products related to the selected subcategory
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.subcategory', $sub_category->id)
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Apply filters if any
            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            // Get the filtered products
            $products = $query->get();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }

            // Return the filtered products along with the subcategory
            return view('website.pages.product.shop', compact('products', 'sub_category'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
    public function brandFilter(Request $request, $slug)
    {
        try {
            // Find the subcategory by its slug
            $brands = DB::table('brands')->where('id', $slug)->first();

            if (!$brands) {
                return response()->json(['error' => 'brands not found'], 404);
            }

            // Fetch products related to the selected subcategory
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.brand_id', $brands->id)
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Apply filters if any
            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            // Get the filtered products
            $products = $query->get();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }
            return view('website.pages.product.brand_filter', compact('products'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function FilterProduct(Request $request)
    {
        try {
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->join('sub_categories', 'products.subcategory', '=', 'sub_categories.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            if ($request->has('min_price')) {
                $query->where('product_attributes.price', '>=', (int) $request->min_price);
            }

            if ($request->has('max_price')) {
                $query->where('product_attributes.price', '<=', (int) $request->max_price);
            }

            if ($request->has('categories') && !empty($request->categories)) {
                $query->whereIn('products.category_id', $request->categories);
            }

            if ($request->has('subcategories') && !empty($request->subcategories)) {
                $query->whereIn('products.subcategory', $request->subcategories);
            }

            if ($request->has('colors') && !empty($request->colors)) {
                $query->whereIn('product_attributes.color_id', $request->colors);
            }

            $products = $query->get();

            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }

            $categories = DB::table('categories')->where('is_deleted', 0)->get();
            $sub_categories = DB::table('sub_categories')->where('is_deleted', 0)->get();
            return view('website.pages.product.brand_filter', compact('products', 'categories', 'sub_categories'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function filter_product_category(Request $request, $slug)
    {
        try {
            // Find the category by its slug (was 'subcategory', but should be 'category')
            $category = DB::table('categories')->where('slug', $slug)->first();
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }

            // Fetch products related to the selected category
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.category_id', $category->id) // Changed to 'category' instead of 'subcategory'
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Apply filters if any
            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            // Get the filtered products
            $products = $query->get();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }

            // Fetch all categories to pass to the view
            $categories = DB::table('categories')->get(); // Fetch all categories

            // Return the filtered products along with the categories
            return view('website.pages.product.category_filter', compact('products', 'categories', 'category')); // Pass 'category' instead of 'categories'
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function SubcategoryFilter(Request $request, $slug)
    {
        try {
            // Find the subcategory by its slug
            $sub_categories = DB::table('sub_categories')->where('slug', $slug)->first();
            if (!$sub_categories) {
                return response()->json(['error' => 'Subcategory not found'], 404);
            }

            // Fetch products related to the selected subcategory
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.subcategory', $sub_categories->id)
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Apply filters if any
            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            // Get the filtered products
            $products = $query->get();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }

            // Fetch all categories to pass to the view
            $categories = DB::table('categories')->get(); // Fetch all categories

            // Return the filtered products along with the categories
            return view('website.pages.product.sub_category_filter', compact('products', 'categories', 'sub_categories'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function collectionFilter(Request $request, $collectId)
    {
        try {

            $collections = DB::table('collections')->where('id', $collectId)->first();
            if (!$collections) {
                return response()->json(['error' => 'Collection not found'], 404);
            }


            // Fetch products related to the selected collection
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.collection_id', $collections->id)
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            // Apply filters if any
            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            // Get the filtered products
            $products = $query->paginate(12); // 12 items per page

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json(['html' => $html]);
            }

            // Fetch all categories to pass to the view
            $categories = DB::table('categories')->get(); // Fetch all categories

            // Return the filtered products along with the categories
            return view('website.pages.product.collectionFilter', compact('products', 'categories','collections'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
    public function DiscountedProduct(Request $request)
    {
        try {
            $query = DB::table('products')
                ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                ->where('products.discounted', 1)
                ->where('products.is_deleted', 0)
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    DB::raw('MIN(product_attributes.price) as price'),
                    DB::raw('MIN(product_attributes.mrp) as mrp')
                )
                ->groupBy('products.id', 'products.name', 'products.slug');

            if ($request->has('search') && !empty($request->search)) {
                $query->where('products.name', 'like', '%' . $request->search . '%');
            }

            $minPrice = $request->has('min_price') ? (int)$request->min_price : 0;
            $maxPrice = $request->has('max_price') ? (int)$request->max_price : 0;

            if ($minPrice > 0) {
                $query->where('product_attributes.price', '>=', $minPrice);
            }

            if ($maxPrice > 0) {
                $query->where('product_attributes.price', '<=', $maxPrice);
            }

            $products = $query->paginate(12);

            if ($request->ajax()) {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('website.pages.product.partials.product', compact('product'))->render();
                }
                return response()->json([
                    'html' => $html,
                    'next_page_url' => $products->nextPageUrl() // Next page URL for infinite scroll
                ]);
            }

            $categories = DB::table('categories')->get();

            return view('website.pages.product.DiscountedFilter', compact('products', 'categories'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }











    public function account(){
       $user_id = session::get('user_id');
       $isLogin = DB::table('users')->where('id',$user_id)->first();
       if($isLogin){
           return view('website.auth.dashboard');
       }else{
        abort(404);
       }

    }

    public function updateAddress(Request $request)
    {
        $user_id = session::get('user_id');
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
            'phone' => 'required|digits:10',
        ]);

        try {
            DB::table('users')->where('id',$user_id)->update([
                'address_title' => $validatedData['title'],
                'address' => $validatedData['address'],
                'country' => $validatedData['country'],
                'state' => $validatedData['state'],
                'city' => $validatedData['city'],
                'pincode' => $validatedData['pincode'],
                'phone_number' => $validatedData['phone']
            ]);

            return response()->json(['success' => true, 'message' => 'Address added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add address.']);
        }
    }

    public function addToWishlist(Request $request)
    {
        $user_id = session('user_id');

        // Generate a temporary user ID for guests if not logged in
        if (!$user_id) {
            if (!session()->has('temporary_user_id')) {
                session(['temporary_user_id' => uniqid('temp_')]);
            }
            $user_id = session('temporary_user_id');
        }

        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            // 'size_id' => 'required|integer',
            // 'color_id' => 'required|integer',
        ]);



        try {
            // Insert or update the wishlist
            DB::table('wishlists')->updateOrInsert(
                [
                    'user_id' =>  $user_id,
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'color_id' => $request->color_id,
                ],
                [
                    'quantity' => $request->quantity
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to wishlist. Error: ' . $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }
    public function loadMoreFeaturedProducts(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = 4;
        $featured_products = DB::table('products')
            ->join(
                DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
                'products.id',
                '=',
                'first_attribute.product_id'
            )
            ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
            ->where('products.featured', 1)
            ->where('products.is_deleted', 0)
            ->select(
                'products.id',
                'products.name',
                'products.title',
                'products.description',
                'products.first_image',
                'products.second_image',
                'products.featured',
                'products.discounted',
                'products.newarrival',
                'products.bestseller',
                'products.slug',
                'product_attributes.id as attr_id',
                'product_attributes.size_id',
                'product_attributes.color_id',
                'product_attributes.mrp',
                'product_attributes.qty',
                'product_attributes.price'
            )
            ->offset(($page - 1) * $perPage)
            ->limit($perPage + 1)
            ->get();

        $hasMore = $featured_products->count() > $perPage;
        if ($hasMore) {
            $featured_products = $featured_products->slice(0, $perPage);
        }

        $html = '';
        foreach ($featured_products as $product) {
            $html .= view('website.pages.product.partials.loadmore_product', compact('product'))->render();
        }
        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
        ]);
    }
    public function loadMoreLatestProducts(Request $request)
{
    $page = $request->page ?? 1;
    $perPage = 4;
    $featured_products = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.newarrival', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.discounted',
            'products.newarrival',
            'products.bestseller',
            'products.slug',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->offset(($page - 1) * $perPage)
        ->limit($perPage + 1)
        ->get();

    $hasMore = $featured_products->count() > $perPage;
    if ($hasMore) {
        $featured_products = $featured_products->slice(0, $perPage);
    }

    $html = '';
    foreach ($featured_products as $product) {
        $html .= view('website.pages.product.partials.loadmore_product', compact('product'))->render();
    }
    return response()->json([
        'html' => $html,
        'hasMore' => $hasMore,
    ]);
}
    public function loadMoreSellerProducts(Request $request)
{
    $page = $request->page ?? 1;
    $perPage = 4;
    $featured_products = DB::table('products')
        ->join(
            DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute'),
            'products.id',
            '=',
            'first_attribute.product_id'
        )
        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
        ->where('products.bestseller', 1)
        ->where('products.is_deleted', 0)
        ->select(
            'products.id',
            'products.name',
            'products.title',
            'products.description',
            'products.first_image',
            'products.second_image',
            'products.featured',
            'products.discounted',
            'products.newarrival',
            'products.bestseller',
            'products.slug',
            'product_attributes.id as attr_id',
            'product_attributes.size_id',
            'product_attributes.color_id',
            'product_attributes.mrp',
            'product_attributes.qty',
            'product_attributes.price'
        )
        ->offset(($page - 1) * $perPage)
        ->limit($perPage + 1)
        ->get();

    $hasMore = $featured_products->count() > $perPage;
    if ($hasMore) {
        $featured_products = $featured_products->slice(0, $perPage);
    }

    $html = '';
    foreach ($featured_products as $product) {
        $html .= view('website.pages.product.partials.loadmore_product', compact('product'))->render();
    }
    return response()->json([
        'html' => $html,
        'hasMore' => $hasMore,
    ]);
}

public function storeOrder(Request $request)
{
    $validated = $request->validate([
        'total_price' => 'required',
        'payment_method' => 'required|string',
        'cart_items' => 'required|array',
        'cart_items.*.product_id' => 'required|integer',
        'cart_items.*.quantity' => 'required|integer|min:1',
        'cart_items.*.price' => 'required|numeric',
        'shipping_address_id' => 'required|exists:addresses,id',
    ]);


    // Handle billing address based on the billing option
    if ($request->input('billing_option') == 'same_as_shipping') {
        $validated['billing_address_id'] = $validated['shipping_address_id'];
    } else {
        $request->validate([
            'billing_address_id' => 'required|exists:addresses,id',
        ]);
        $validated['billing_address_id'] = $request->input('billing_address_id');
    }
    $userId = session('user_id') ?? session('temporary_user_id');
    if (!$userId) {
        if (!session()->has('temporary_user_id')) {
            session(['temporary_user_id' => uniqid('temp_')]);
        }
        $userId = session('temporary_user_id');
    }

    try {
        DB::beginTransaction();

        // Generate custom order ID
        $lastOrder = DB::table('orders')
            ->select('custom_order_id')
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->first();

        $newOrderId = 'VC00001';
        if ($lastOrder) {
            $lastIdNumber = (int) substr($lastOrder->custom_order_id, 2);
            $newOrderId = 'VC' . str_pad($lastIdNumber + 1, 5, '0', STR_PAD_LEFT);
        }

        // Insert order to get order_id
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $userId,
            'custom_order_id' => $newOrderId,
            'payment_method' => $validated['payment_method'],
            'total_amount' => $request->total_price,
            'status' => 'pending',
            'billing_address_id' => $validated['billing_address_id'],
            'shipping_address_id' => $validated['shipping_address_id'],
            'date' => now()->format('d-m-Y H:i:s A'),
        ]);

        $orderItems = [];
        $orderDetails = [];
        foreach ($request->cart_items as $item) {
            $product = DB::table('products')->find($item['product_id']);
            $orderItems[] = [
                'order_id' => $orderId,
                'custom_order_id' => $newOrderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'color_id' => $item['color'],
                'size_id' => $item['size'],
                'price' => $item['price'],
                'date' => now()->format('d-m-Y'),
            ];

            $orderDetails[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ];
        }

        DB::table('order_items')->insert($orderItems);
        DB::table('cart')->where('user_id', $userId)->delete();

        DB::commit();

        // Store billing and shipping address IDs in session
        session([
            'order_success' => [
                'order_id' => $newOrderId,
                'total_price' => $request->total_price,
                'address' => $validated,
                'order_items' => $orderDetails,
                'billing_address_id' => $validated['billing_address_id'],
                'shipping_address_id' => $validated['shipping_address_id'],
            ],
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('order.placed'),
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}




public function hashPassword($password)
{
    return response()->json([
        'hashed_password' => Hash::make($password)
    ]);
}

public function initiatePayment(Request $request)
{
    $validated = $request->validate([
        'total_price' => 'required',
        'payment_method' => 'required|string',
        'cart_items' => 'required|array',
        'cart_items.*.product_id' => 'required|integer',
        'cart_items.*.quantity' => 'required|integer|min:1',
        'cart_items.*.price' => 'required|numeric',
        'shipping_address_id' => 'required|exists:addresses,id',
    ]);

     if ($request->input('billing_option') == 'same_as_shipping') {
        $validated['billing_address_id'] = $validated['shipping_address_id'];
    } else {
        $request->validate([
            'billing_address_id' => 'required|exists:addresses,id',
        ]);
        $validated['billing_address_id'] = $request->input('billing_address_id');
    }
    $userId = session('user_id') ?? session('temporary_user_id');
    if (!$userId) {
        if (!session()->has('temporary_user_id')) {
            session(['temporary_user_id' => uniqid('temp_')]);
        }
        $userId = session('temporary_user_id');
    }
    // Generate a unique transaction ID
    $merchantTransactionId = uniqid('txn_');

    // Save initial transaction
    DB::table('transactions')->insert([
        'user_id' => $userId,
        'transaction_id' => $merchantTransactionId,
        'amount' => $validated['total_price'],
        'status' => 'pending',
        'created_at' => now(),
    ]);

    // Prepare payment payload
    $payload = [
        'merchantId' => 'M22I1H3KU5WIL',
        'merchantTransactionId' => $merchantTransactionId,
        'amount' => ($validated['total_price'] * 100), // Smallest currency unit
        'redirectUrl' => route('order.placed'),
        'callbackUrl' => route('phonepe.payment.callback'),
        'paymentInstrument' => [
            'type' => 'PAY_PAGE',
        ],
    ];

    $payloadJson = json_encode($payload);
    $base64EncodedPayload = base64_encode($payloadJson);

    $endpoint = '/pg/v1/pay';
    $saltKey = '26c1d1b9-e7f9-48ba-ac69-a009a25efee8';
    $saltIndex = 1;

    $stringToHash = $base64EncodedPayload . $endpoint . $saltKey;
    $checksum = hash('sha256', $stringToHash);

    $xVerify = $checksum . '###' . $saltIndex;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.phonepe.com/apis/hermes/pg/v1/pay');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['request' => $base64EncodedPayload]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-VERIFY: ' . $xVerify,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        Log::error('cURL Error', ['error' => curl_error($ch)]);
        curl_close($ch);
        return response()->json([
            'success' => false,
            'message' => 'Failed to initiate payment.',
        ]);
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['data']['instrumentResponse']['redirectInfo']['url'])) {
        $redirectUrl = $responseData['data']['instrumentResponse']['redirectInfo']['url'];
        return response()->json(['success' => true, 'redirect_url' => $redirectUrl]);
    } else {
        Log::error('PhonePe API Invalid Response', ['response' => $responseData]);
        return response()->json(['success' => false, 'message' => 'Failed to obtain redirect URL.']);
    }
}

public function handleCallback(Request $request)
{
    $data = $request->all();

    // Verify checksum (to ensure the callback is authentic)
    // [Add checksum validation logic here]

    if ($data['status'] === 'SUCCESS') {
        DB::beginTransaction();

        try {
            // Update transaction status
            DB::table('transactions')
                ->where('transaction_id', $data['merchantTransactionId'])
                ->update(['status' => 'success']);

            // Retrieve user and cart details (stored in session or temporary storage)
            $userId = session('user_id') ?? session('temporary_user_id');
            $cart = session('cart_items');

            // Save address, order, and order items
            $addressId = DB::table('addresses')->insertGetId([
                'user_id' => $userId,
                'name' => session('address.name'),
                'address' => session('address.address'),
                'phone' => session('address.phone'),
                'state' => session('address.state'),
                'city' => session('address.city'),
                'pincode' => session('address.pincode'),
                'date' => now(),
            ]);

            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $userId,
                'address_id' => $addressId,
                'payment_method' => 'phonepe',
                'total_amount' => $data['amount'] / 100,
                'status' => 'completed',
                'transaction_id' => $data['merchantTransactionId'],
                'date' => now(),
            ]);

            $orderDetails = [];
            foreach ($cart as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'date' => now(),
                ]);

                $orderDetails[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
            }

            // Store order success data in the session
            session([
                'order_success' => [
                    'order_id' => $orderId,
                    'total_price' => $data['amount'] / 100,
                    'address' => [
                        'name' => session('address.name'),
                        'address' => session('address.address'),
                        'phone' => session('address.phone'),
                        'state' => session('address.state'),
                        'city' => session('address.city'),
                        'pincode' => session('address.pincode'),
                    ],
                    'order_items' => $orderDetails,
                ],
            ]);

            // Clear cart
            DB::table('cart')->where('user_id', $userId)->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to process order.']);
        }
    } else {
        // Handle payment failure
        DB::table('transactions')
            ->where('transaction_id', $data['merchantTransactionId'])
            ->update(['status' => 'failed']);

        return response()->json(['success' => false, 'message' => 'Payment failed.']);
    }
}

public function getCartData()
{
    $user_id = session('user_id') ?? session('temporary_user_id');
    if ($user_id) {
        return DB::table('cart')
            ->where('user_id', $user_id)
            ->get();
    }
    return collect();
}


public function contact(){
  return view('website.pages.contact');
}
public function storeContact(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|digits:10',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);


    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    DB::table('contacts')->insert([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'subject' => $request->input('subject'),
        'message' => $request->input('message'),
        'date' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Your message has been sent successfully!',
    ]);
}
public function updateQuantity(Request $request)
{
    $cartId = $request->input('cart_id');
    $userId = session('user_id') ?? session('temporary_user_id');
    $quantity = $request->input('quantity');

    // Validate input
    $request->validate([
        'cart_id' => 'required|exists:cart,id',
        'user_id' => 'required',
        'quantity' => 'required|integer|min:1',
    ]);

    // Check if cart item exists for the user
    $cartItem = DB::table('cart')
        ->where('id', $cartId)
        ->where('user_id', $userId)
        ->first();

    if ($cartItem) {
        // Update quantity
        DB::table('cart')
            ->where('id', $cartId)
            ->update(['quantity' => $quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart quantity updated successfully',
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Cart item not found or unauthorized',
    ]);
}
public function clearAll(Request $request)
{
    $userId = session('user_id') ?? session('temporary_user_id');

    // Validate input
    $request->validate([
        'user_id' => 'required',
    ]);

    // Delete all cart items for the user
    DB::table('cart')->where('user_id', $userId)->delete();

    return response()->json([
        'success' => true,
        'message' => 'All cart items cleared successfully',
    ]);
}


public function UserAddressStore(Request $request)
{
    DB::beginTransaction();
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|string|max:500',
            'pincode' => 'required|string|regex:/^\d{6}$/',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address_type' => 'required|in:1,2',
        ]);

        $userId = session('user_id');

        DB::table('addresses')->insert([
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
            'address_type' => $request->address_type,
        ]);

        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
public function UserAddressUpdate(Request $request)
{
    DB::beginTransaction();
    try {
        // Validate the incoming request data
        $validated = $request->validate([
            'id' => 'required|exists:addresses,id',  // Ensure that the address ID exists
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|string|max:500',
            'pincode' => 'required|string|regex:/^\d{6}$/',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address_type' => 'required|in:1,2',
        ]);

        // Retrieve the address by ID and update the fields
        $address = DB::table('addresses')->where('id', $request->id)->where('user_id', session('user_id'))->first();

        if (!$address) {
            return response()->json(['status' => 'error', 'message' => 'Address not found or you do not have permission to edit this address.']);
        }

        DB::table('addresses')->where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
            'address_type' => $request->address_type,
        ]);

        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Address updated successfully.']);
    } catch (\Exception $e) {
        DB::rollback();
        // Return detailed error message
        return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

public function Address_destroy($id)
{
    try {
        // Use DB query to delete the address
        $deleted = DB::table('addresses')->where('id', $id)->update(['is_deleted'=>1]);

        if ($deleted) {
            return response()->json(['success' => true]); // Return success response
        } else {
            return response()->json(['success' => false, 'error' => 'Address not found']); // Return error if not deleted
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]); // Return error response
    }
}
public function UserupdateOrderCancelStatus($orderId, Request $request)
{
    try {
        // Fetch the order using DB query
        $order = DB::table('orders')->where('id', $orderId)->first();

        // Check if the order exists
        if ($order) {
            // Update the order status to canceled (is_cancel = 1)
            $update = DB::table('orders')->where('id', $orderId)->update(['is_cancel' => 1]);

            if ($update) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => 'Failed to update order status']);
            }
        }

        return response()->json(['success' => false, 'error' => 'Order not found']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}

public function forget_password(){
    return view('website.auth.forget_password');
}
public function sendResetPasswordEmail(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
    ]);
    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => 'Invalid email address!'], 422);
    }
    $email = $request->input('email');
    $token = Str::random(60);
    DB::table('password_resets')->insert([
        'email' => $email,
        'token' => $token,
        'created_at' => now(),
    ]);

    $link = route('password.reset', ['token' => $token, 'email' => $email]);


    Mail::send('emails.reset_password', ['link' => $link], function ($message) use ($email) {
        $message->to($email)->subject('Reset Password');
    });

    return response()->json(['status' => 'success', 'message' => 'Reset password link sent!']);
}

public function password_reset(){
   return view('website.auth.reset_password');
}

public function password_update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors(),
        ], 422);
    }

    $reset = DB::table('password_resets')->where([
        ['email', '=', $request->email],
        ['token', '=', $request->token],
    ])->first();

    if (!$reset) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid token or email.',
        ], 422);
    }

    DB::table('users')->where('email', $request->email)->update([
        'password' => Hash::make($request->password),
    ]);

    DB::table('password_resets')->where('email', $request->email)->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Password has been reset!',
    ]);
}

public function MaualOrderPage(){
    return view('website.pages.manual.add');
}

public function StoreManualOrder(Request $request)
{
    DB::beginTransaction();

    try {
        $validator = Validator::make($request->all(), [
            'productScreenshots.*' => 'required|image|mimes:jpg,jpeg,png',
            'paymentScreenshots.*' => 'required|image|mimes:jpg,jpeg,png',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'alternateMobile' => 'nullable|digits:10',
            'streetAddress' => 'required|string|max:255',
            'colony' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $productScreenshotsPaths = [];
        $paymentScreenshotsPaths = [];

        if ($request->hasFile('productScreenshot')) {
            foreach ($request->file('productScreenshot') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/manualorders/products'), $filename);
                $productScreenshotsPaths[] = 'public/uploads/manualorders/products/' . $filename;
            }
        }

        if ($request->hasFile('paymentScreenshot')) {
            foreach ($request->file('paymentScreenshot') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/manualorders/payments'), $filename);
                $paymentScreenshotsPaths[] = 'public/uploads/manualorders/payments/' . $filename;
            }
        }

        $lastOrder = DB::table('manual_orders')->latest('id')->first();
        if ($lastOrder) {
            $lastOrderId = $lastOrder->id;
            $lastNumber = (int) str_replace('VC-DO-', '', $lastOrderId);
            $newOrderId = 'VC-DO-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newOrderId = 'VC-DO-001';
        }

        $orderData = [
            'order_id' => $newOrderId,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'alternate_mobile' => $request->input('alternateMobile'),
            'street_address' => $request->input('streetAddress'),
            'colony' => $request->input('colony'),
            'pincode' => $request->input('pincode'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'product_screenshot' => json_encode($productScreenshotsPaths),
            'payment_screenshot' => json_encode($paymentScreenshotsPaths),
            'date' => now(),
        ];

        DB::table('manual_orders')->insert($orderData);

        try {
            Mail::to('manual@vivacecollections.com')->send(new ManualOrderMail($orderData));

            // Email to User
            Mail::to($request->input('email'))->send(new ManualOrderMail($orderData));


        } catch (\Exception $e) {
            Log::error('Email could not be sent: ' . $e->getMessage());
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Order placed successfully, but email could not be sent.',
                'error' => $e->getMessage(),
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully and email sent!',
            'order_id' => $newOrderId
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again later.',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}








}

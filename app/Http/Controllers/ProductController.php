<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()

    {

        $products = Product::all();

        return view('products', compact('products'));
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function cart()

    {

        return view('cart');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function addToCart(Request $request)

    {
        $product_id = $request->product_id;
        $product = Product::findOrFail($product_id);

        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {

            $cart[$product_id]['quantity']++;
        } else {
            $cart[$product_id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);

        return response()->JSON();

        // return redirect()->back()->with('success', 'Product added to cart successfully!');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function update(Request $request)

    {

        if ($request->id && $request->quantity) {

            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function remove(Request $request)

    {

        if ($request->id) {

            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
}

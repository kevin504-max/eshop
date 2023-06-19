<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        try {
            $cartItems = Cart::where('user_id', Auth::id())->get();

            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->first();

                if (isset($product) && ($product->stock <= $item->quantity)) {
                    $item->delete();
                }
            }

            $cartItems = Cart::where('user_id', Auth::id())->get();

            return view('frontend.checkout', compact('cartItems'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later.'
            ]);
        }
    }

    public function placeOrder(Request $request)
    {
        try {
            $order = new Order();
            $order->user_id = Auth::id();
            $order->username = $request->username;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->cpf_cnpj = $request->cpf_cnpj;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->tracking_number = 'samambaia'.rand(1111, 9999);
            $order->save();

            $cartItems = Cart::where('user_id', Auth::id())->get();

            foreach($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->items,
                    'price' => ($item->product->price - $item->product->discountPercentage)
                ]);

                $product = Product::find($item->product_id);
                $product->stock -= $item->items;
                $product->update();
            }

            if (!isset(Auth::user()->state)) {
                $user = User::find(Auth::id());
                $user->cpf = $request->cpf_cnpj;
                $user->phone = $request->phone;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->update();
            }

            Cart::destroy($cartItems);

            return redirect('/')->with(['status' => 'success', 'message' => 'Order placed successfully!']);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }
}

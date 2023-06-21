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

            // To calculate total price
            $total = 0;
            foreach (Cart::where('user_id', Auth::id())->get() as $item) {
                $total += ($item->product->price - $item->product->discountPercentage) * $item->items;
            }

            $order->total_price = $total;

            $order->payment_mode = $request->payment_mode;
            $order->payment_id = $request->payment_id;

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

            if ($request->payment_mode == "Paid by Razorpay" || $request->payment_mode == "Paid by Paypal") {
                return response()->json([
                    "status" => "success",
                    "message" => "Order placed successfully!"
                ]);
            }

            return redirect('/my-orders')->with(['status' => 'success', 'message' => 'Order placed successfully!']);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function razorpayCheck(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        $total_price = 0;
        foreach ($cartItems as $item) {
            $total_price += (($item->product->price - $item->product->discountPercentage) * $item->items);
        }

        $username = $request->input('username');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $cpf_cnpj = $request->input('cpf_cnpj');
        $state = $request->input('state');
        $city = $request->input('city');

        return response()->json([
            "username" => $username,
            "email" => $email,
            "phone" => $phone,
            "cpf_cnpj" => $cpf_cnpj,
            "state" => $state,
            "city" => $city,
            "total_price" => $total_price
        ]);
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\OptionValue;
use App\Models\Topping;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        if (empty($cart)) return redirect()->route('front.home')->with('error', 'Giỏ hàng trống.');

        // Build cart items for display
        $items = [];
        $total = 0;

        foreach ($cart as $key => $data) {
            $product = Product::find($data['product_id']);
            if (!$product) continue;

            $price = $product->base_price;

            if (!empty($data['options'])) {
                $ovs = OptionValue::whereIn('id', $data['options'])->get();
                foreach ($ovs as $ov) $price += $ov->price_adjustment;
            }
            if (!empty($data['toppings'])) {
                $tps = Topping::whereIn('id', $data['toppings'])->get();
                foreach ($tps as $tp) $price += $tp->price;
            }

            $subtotal = $price * $data['quantity'];
            $total += $subtotal;

            $items[] = [
                'product'  => $product,
                'quantity' => $data['quantity'],
                'price'    => $price,
                'subtotal' => $subtotal,
            ];
        }

        $addresses = [];
        if (auth()->check()) {
            $addresses = auth()->user()->addresses()->orderBy('is_default', 'desc')->latest()->get();
        }

        return view('front.checkout', compact('items', 'total', 'addresses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'payment_method'   => 'required|string|in:cod,banking',
        ]);

        $cart = $this->getCart();
        if (empty($cart)) return redirect()->route('front.home');

        DB::transaction(function () use ($data, $cart) {
            $total = 0;

            $order = Order::create([
                'user_id'          => auth()->id(),
                'customer_name'    => $data['customer_name'],
                'customer_email'   => $data['customer_email'],
                'customer_phone'   => $data['customer_phone'],
                'customer_address' => $data['customer_address'],
                'total_amount'     => 0,
                'status'           => 'pending',
                'payment_method'   => $data['payment_method'],
            ]);

            foreach ($cart as $key => $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->base_price;
                $optionsData = [];
                $toppingsData = [];

                if (!empty($item['options'])) {
                    $ovs = OptionValue::whereIn('id', $item['options'])->get();
                    foreach ($ovs as $ov) {
                        $price += $ov->price_adjustment;
                        $optionsData[] = ['id' => $ov->id, 'name' => $ov->name, 'price_adjustment' => $ov->price_adjustment];
                    }
                }

                if (!empty($item['toppings'])) {
                    $tps = Topping::whereIn('id', $item['toppings'])->get();
                    foreach ($tps as $tp) {
                        $price += $tp->price;
                        $toppingsData[] = ['id' => $tp->id, 'name' => $tp->name, 'price' => $tp->price];
                    }
                }

                $subtotal = $price * $item['quantity'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_image' => $product->image_url,
                    'quantity'      => $item['quantity'],
                    'price'         => $price,
                    'options'       => !empty($optionsData) ? json_encode($optionsData) : null,
                    'toppings'      => !empty($toppingsData) ? json_encode($toppingsData) : null,
                ]);
            }

            $order->update(['total_amount' => $total]);
        });

        $this->clearCart();

        return redirect()->route('thankyou')->with('success', 'Đặt hàng thành công!');
    }

    public function thankYou()
    {
        return view('front.thankyou');
    }

    private function getCart()
    {
        if (auth()->check()) {
            $cartModel = Cart::with('items')->firstOrCreate(['user_id' => auth()->id()]);
            $items = [];
            foreach ($cartModel->items as $item) {
                $options = $item->options ?? [];
                $toppings = $item->toppings ?? [];
                sort($options);
                sort($toppings);
                $key = $item->product_id . '_' . md5(json_encode($options) . json_encode($toppings));
                
                $items[$key] = [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'options'    => $options,
                    'toppings'   => $toppings,
                ];
            }
            return $items;
        }
        return session('cart', []);
    }

    private function clearCart()
    {
        if (auth()->check()) {
            $cartModel = Cart::where('user_id', auth()->id())->first();
            if ($cartModel) {
                $cartModel->items()->delete();
            }
        } else {
            session()->forget('cart');
        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

use App\Models\Order;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ShopPanelController extends Controller
{
    public function show()
    {
        $orders = new Order;
        $orders = DB::table('orders')->select("*")->get();

        foreach ($orders as $order){
            if ($order->created_at){
                $order->created_at = Carbon::parse($order->created_at)->format('H:i - d.m.Y');
            }
            if ($order->updated_at){
                $order->updated_at = Carbon::parse($order->updated_at)->format('H:i - d.m.Y');
            }
        }

        return view("shop.shopPanel", compact('orders'));
    }

    public function getOrderDetails($id)
    {
        $order = Order::find($id);

        if ($order) {
            return response()->json([
                'customer_name' => $order->customer_name,
                'customer_surname' => $order->customer_surname,
                'items' => json_decode($order->items, true),
                'price' => $order->price,
                'status' => $order->status,
                'note' => $order->note,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
                'country' => $order->country,
                'state' => $order->state,
                'city' => $order->city,
                'postal_code' => $order->postal_code,
                'address_line_1' => $order->address_line_1,
                'address_line_2' => $order->address_line_2,
            ]);
        }

        return response()->json(['error' => 'Order not found'], 404);
    }
}

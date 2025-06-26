<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Address;
Use App\Models\OrderItem;
Use App\Models\Transaction;
use Carbon\Carbon;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function account_details()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        
        return view('user.account-details',compact('user'));
    }

    public function account_details_update(Request $request)
    {
        $request->validate([ 
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'current_password' => 'required|current_password'
        ]);

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.account.details')->with('status','User details have been updated successfully');
    }

    public function account_security()
    {
        return view('user.account-security');
    }

    public function account_security_update(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => ['required','confirmed', Rules\Password::defaults()],
            'new_password_confirmation' => 'required'           
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($request->new_password)            
        ])->save();

        return redirect()->route('user.account.security')->with('status','Password has been changed successfully');
    }

    public function orders()
    {
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        return view('user.orders',compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('user_id',Auth::user()->id)->where('id',$order_id)->first();
        if($order)
        {
            $orderItems = OrderItem::where('order_id',$order->id)->orderBy('id')->paginate(12); 
            $transaction = Transaction::where('order_id',$order->id)->first();
            return view('user.order-details',compact('order','orderItems','transaction'));
        }
        else
        {
            return redirect()->route('login');
        }
    }

    public function order_cancel(Request $request){
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status',"Order has been canceled successfully!");
    }

    public function account_address()
    {
        $addresses = Address::where('user_id',Auth::user()->id)->get();
        
        return view('user.account-address',compact('addresses'));
    }

    public function account_address_add()
    {
        return view('user.account-address-add');
    }

    public function account_address_store(Request $request)
    {
        $address = new Address();
        
        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->country = 'Ukraine';
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        if($request->isdefault)
        {
            $address->isdefault = 1;
        }else{
            $address->isdefault = 0;
        }
        $address->save();

        return redirect()->route('user.account.address');
    }

    public function account_address_edit($id)
    {
        $address = Address::find($id);        
        return view('user.account-address-edit',compact('address'));
    }

    public function account_address_update(Request $request)
    {
        $address = Address::find($request->id);

        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->country = 'Ukraine';
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        if($request->isdefault)
        {
            $address->isdefault = 1;
        }else{
            $address->isdefault = 0;
        }
        $address->save();
        
        return redirect()->route('user.account.address');
    }

    public function account_wishlist()
    {
        $items = Cart::instance('wishlist')->content();
        return view('user.wishlist', compact('items'));
    }
}

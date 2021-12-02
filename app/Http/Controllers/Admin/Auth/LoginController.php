<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = User::where(['email' => $email])->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                if (!$user->seller_id) {
                    Auth::guard('admin_user')->login($user, true);
                    Auth::guard('seller')->logout();
                    if (Auth::guard('admin_user')->user()->hasRole('courier')) {
                        return redirect(route('orders.index') . '/?order_status=3');
                    }
                    return redirect()->route('orders.index');
                } else {
                    Auth::guard('seller')->login($user, true);
                    Auth::guard('admin_user')->logout();
                    return redirect()->route('orders.index');
                }
            } else {
                return redirect()->back()->withErrors(['error' => "Password yanlisdir"]);
            }
        }
        return redirect()->back()->withErrors(['error' => "Bele bir user tapilmadi"]);
//        dd(Hash::make('123456'));
//        dd(Auth::attempt(['email' => 'h@mail.ru', 'password' => bcrypt('123456')]));
//        dd(Auth::guard('web')->attempt(['email' => 'h@mail.ru', 'password' => Hash::make('123456')]));
//        if (Auth::guard('admin_user')->attempt(['email' => $request->email, 'password' => $request->password])) {
//            return redirect()->route('appeals.index');
//        }
    }
}

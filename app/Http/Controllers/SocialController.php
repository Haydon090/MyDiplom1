<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function index()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function callback(Request $request)
    {
        try {

            $user = Socialite::driver('vkontakte')->user();
            $email = $user->getEmail();
            $name = $user->getName();
            $password = '111111';
            $u = User::where('email', $email)->first();
            $data = ['name' => $name, 'password' => $password,'role_id' =>2];

            if ($u) {
                $u->name = $name;
                $u->email = $email;
                $u->role_id=2;
                $u->save();
            } else {
                $u = User::create($data);
            }
            Auth::login($u);

            return redirect()->route('dashboard');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

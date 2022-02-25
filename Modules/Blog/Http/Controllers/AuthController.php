<?php

namespace Modules\Blog\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Support\Renderable;

class AuthController extends Controller
{
    /**
     * Register User
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        User::create([
           'name' => $request->get('name'),
           'family' => $request->get('family'),
           'mobile' => $request->get('mobile'),
           'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'message' => 'ثبت نام با موفقیت انجام شد'
        ]);
    }

    /**
     * Login User
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('mobile', $request->get('mobile'))->first();

        if (! $user || ! Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'errors' => [
                    'mobile' => 'اطلاعات ورود اشتباه است',
                ]
            ], 403);
        }

        $token = $user->createToken('Client Access Token')->accessToken;

        return response()->json([
            'token'  => $token,
            'name'   => $user->name,
            'family' => $user->family,
            'mobile' => $user->mobile,
        ]);
    }
}

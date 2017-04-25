<?php

namespace App\Http\Controllers;

use GenTux\Jwt\JwtToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class TokenController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    public function login(Request $request, JwtToken $jwt) {
        $payload = User::find($request->input('itsc'));
        if (isset($payload) and Hash::check($request->input('password'), ($payload->makeVisible('password'))['password'])) {
            $payload['exp'] = time() + 3600 * 24;
            $token = $jwt->createToken($payload);

            // lol somehow the Authorization token need to add 'Bearer ' at front, dunno is it just a joke :/
            return (string) 'Bearer '.$token;
        }
        abort(403, 'Failed login');
    }
}

<?php

namespace App\Http\Controllers;

use GenTux\Jwt\JwtToken;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class TokenController extends Controller {
    use GetsJwtToken;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Login user
     *
     * @param Request $request
     * @param JwtToken $jwt
     * @return void
     */
    public function login(Request $request, JwtToken $jwt) {
        $payload = User::find($request->input('itsc'));
        if (isset($payload) and Hash::check($request->input('password'), ($payload->makeVisible('password'))['password'])) {
            $payload['exp'] = time() + 3600 * 24 * 100;
            $token = $jwt->createToken($payload);

            // lol somehow the Authorization token need to add 'Bearer ' at front, dunno is it just a joke :/
            return response(['success' => 'true', 'token' => 'Bearer '.$token]);
        }
        // TODO: distringuish between wrong password or wrong itsc
        return response(['success' => 'false', 'message' => 'Failed login']);
    }

    public function logout(Request $request) {
        $user = User::find($this->jwtPayload()['itsc']);

        if (isset($user)) {
            $user->delete();
            return response(array_merge(['success' => 'true'], $user));
        }
    }
}

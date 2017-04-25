<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use GenTux\Jwt\JwtToken;
use GenTux\Jwt\GetsJwtToken;

class UserController extends Controller
{
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
     * Register user
     *
     * @param Request $request
     * @return void
     */
    public function create_user(Request $request, JwtToken $jwt) {
        $form = $request->input();
        $form['password'] = app('hash')->make($form['password']);

        $payload = User::create($form);
        $payload['exp'] = time() + 3600 * 24;

        $token = $jwt->createToken($payload);
        return (string) 'Bearer '.$token;
    }

    /**
     * Retrieve user by itsc
     *
     * @param Request $request
     * @param string $_itsc
     * @return void
     */
    public function get_user_by_id(Request $request, $_itsc) {
        return User::find($_itsc);
    }

    /**
     * Update user information
     *
     * @param Request $request
     * @return void
     */
    public function update_user(Request $request) {
        $form = $request->input();
        unset($form['itsc']);
        
        $user = User::find($this->jwtPayload()['itsc']);
        $user->fill($form);
        $user->save();

        return User::find($this->jwtPayload()['itsc']);
    }

    public function delete_user(Request $request) {
        $user = User::find($this->jwtPayload()['itsc']);

        if (isset($user)) {
            $user->delete();
            return response(['success' => 'true']);
        }

        abort(403, 'Entry not exist');
    }
}

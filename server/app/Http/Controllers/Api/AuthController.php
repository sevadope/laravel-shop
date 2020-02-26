<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use \Request;

class AuthController extends Controller
{
	public function register(RegisterRequest $request)
	{
		$data = $request->validated();

		$user = User::create([
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);

		$resp = $this->requestAccessToken($user->email, $data['password']);
        
		return response([
			'access_token' => $resp->access_token,
			'expires_in' => $resp->expires_in,
		], 201);
	}

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        $resp = $this->requestAccessToken($user->email, $data['password']);

        return response([
            'access_token' => $resp->access_token,
            'expires_in' => $resp->expires_in,
        ], 200);
    }

    public function refreshToken()
    {
        info('refreshing');
        $refresh_token = request()->cookie('refresh_token');

        abort_unless($refresh_token, 403, 'Your refresh token is expired.');

        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
        ];

        $resp = $this->makePostRequest($params);

        return response([
            'access_token' => $resp->access_token,
            'expires_in' => $resp->expires_in,
            'message' => 'Token has been refreshed.',
        ], 200);
    }

    private function requestAccessToken(string $email, string $password)
    {
        $params = [
            'grant_type' => 'password',
            'username' => $email,
            'password' => $password,
        ];

        return $this->makePostRequest($params);
    }

    private function makePostRequest(array $params)
    {
        $params = array_merge([
            'client_id' => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'scope' => '*',
        ], $params);

        $request = Request::create('oauth/token', 'post', $params);
        $response = json_decode(app()->handle($request)->getContent());

        cookie()->queue(
            'refresh_token',
            $response->refresh_token,
            14400,
            null,
            null,
            false,
            true
        );

        return $response;
    }
}

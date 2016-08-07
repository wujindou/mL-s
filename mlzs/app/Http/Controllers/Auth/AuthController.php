<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Session;

class AuthController extends Controller
{
	protected $redirectPath = '/index';
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	 */

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'useranmename' => 'required|max:255',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}
	public function postLogin(Request $request)
	{
		$rules = array(
			'username' => 'required|max:255',
			'password' => 'required|min:6'
		);
		$validator = Validator::make(Input::all(), $rules);
		$username = $request->input('username');
		$password = $request->input('password');

		if ($username!='zhang3' && $password!='123456')
		{
			return Redirect::to('/auth/login')->withErrors(array('msg' =>'用户名或密码错误'))->withInput();
		}else{
			$user =array('username'=>'zhang3','password'=>'123456');
			\Auth::login(new User($user));
			Session::put('user',\Auth::user());
			return redirect()->intended('/');	
		}
		
	}

}

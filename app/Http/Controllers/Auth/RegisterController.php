<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
      */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => 'required|same:password',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add_information()
    {
        return view('auth.add_information');
    }

    public function post_add_information(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'intro' => 'required',
            'img_no' => 'required',
        ]);

        $user = Auth::user();

        $data = $request->all();

        $user->name = $data['name'];
        $user->intro = $data['intro'];
        $user->img_no = $data['img_no'];

        // if ($request->file('img_url')) {
        //   $extension = $request->file('img_url')->getClientOriginalExtension();
        //   $url_path = Storage::disk('local')->putFileAs('public/image', $data['img_url'], date('YmdHis') . $data['name'] . "." . $extension, 'public');
        //   $user->img_url = Storage::url($url_path);
        // }
        $user->save();

        return view('auth.add_information_complete');
    }
}

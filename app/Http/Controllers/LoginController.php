<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
      if (Auth::check()) {
        return view('siswa');
      }
      return view('login.signin');
    }

    public function login(Request $request)
    {
      $remember = $request->remember;
      $email = $request->email;
      $password = $request->password;
      $request->validate([
        'email' => 'required',
        'password' => 'required',
      ]);
      if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
        $request->session()->regenerate();
        return response()->json([
           'status' => 200
        ]);
      }

      return response()->json([
        'status' => 505
     ]);
    }

    public function register()
    {
      return view('login.register');
    }

    public function register_action(Request $request)
    {
      $email = $request->email;
      
      if(User::where('email' , $email)->get()->count() <= 0){
        $user = new User([
          'name' => $request->nama,
          'email' => $request->email,
          'password' => Hash::make($request->password),
        ]);
        return $user->save();
      }else{
        return response()->json([
          'status' => 'ada'
        ]);
      }
    }

    public function email(Request $request)
    {
      $email = $request->email;
      if(User::where('email' , $email)->get()->count() < 0){
        return response()->json([
          'status' => 'tidak ada'
       ]);
      }else{
        return response()->json([
          'status' => 'ada'
       ]);
      }
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // $token = Str::random(64);

        // DB::table('password_resets')->insert([
        //     'email' => $request->email, 
        //     'token' => $token, 
        //     'created_at' => Carbon::now()
        //   ]);

        // Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
        //     $message->to($request->email);
        //     $message->subject('Reset Password');
        // });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm() { 
      //  return view('auth.forgetPasswordLink', ['token' => $token]);
      return view('login.reset');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function submitResetPasswordForm(Request $request)

    {

        $request->validate([

            'email' => 'required|email|exists:users',

            'password' => 'required|string|min:6|confirmed',

            'password_confirmation' => 'required'

        ]);



        $updatePassword = DB::table('password_resets')

                            ->where([

                              'email' => $request->email, 

                              'token' => $request->token

                            ])

                            ->first();



        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();



        return redirect('/login')->with('message', 'Your password has been changed!');

    }
    

    public function logout(Request $request)
    {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/');
    }

    public function __construct()
      {
          $this->middleware('guest')->except('logout');
      }
}

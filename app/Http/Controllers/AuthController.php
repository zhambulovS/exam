<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;


class AuthController extends Controller
{
    // loads pages
    public function loadRegister(){
        return view('auth.register');
    }
    public function loadLogin(){
        return view('auth.login');
    }
    public function loadDashboard(){
        return view('user.dashboard');
    }
    public function adminDashboard(){
        $subjects = Subject::all();
        return view('admin.dashboard', compact('subjects'));
    }
    public function forgetPasswordLoad()
    {
        return view('auth.forget-password');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('loadLogin');
    }

    //login register functions
    public function studentRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'You have been registered successfully');
    }
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $userCredentials = $request->only('email', 'password');
        // dd($userCredentials);

        if (Auth::attempt($userCredentials)) {
            // Debugging: Uncomment below to check authenticated user
            // dd(Auth::user());

            if (Auth::user()->is_admin == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('load.dashboard');
            }
        } else {
            return back()->with('error', 'Invalid Credentials');
        }
    }
    //password functions
    public function forgetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->get();

            if(count($user)>0){
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $request -> email;
                $data['title'] = "Password Reset";
                $data['body'] = 'Please click on the link to reset your password';

                Mail::send('auth.forgetPasswordMail', ['data'=>$data], function ($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });
                $dataTime = Carbon::now()->format('Y-m-d H:i:s');

                PasswordReset::updateOrCreate(
                    ['email'=>$request->email],
                    [
                        'email'=>$request->email,
                        'token'=>$token,
                        'created_at'=>$dataTime]
                );
                return back()->with('success', 'We have e-mailed your password reset link!');
            }else{
                return back()->with('error', 'User not found');
            }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->first();
        if ($resetData && isset($request->token)) {
            $user = User::where('email', $resetData->email)->first();
            if ($user) {
                return view('auth.reset-password', compact('user'));
            }
        }
        return view('/404');
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);
        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();
        PasswordReset::where('email', $user->email)->delete();
        return "<h2> You have been updated successfully</h2>";
    }

}

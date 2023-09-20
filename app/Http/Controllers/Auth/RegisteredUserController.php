<?php

namespace App\Http\Controllers\Auth;

use Response;
use App\Models\User;
use Illuminate\View\View;
use Plusemon\Notify\Notify;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Display the registration view.
     */
    public function phoneVerify(Request $request)
    {
        $value = $request->phone;
        // Checking already user exist
        $uniq = User::where('phone', $request->phone)->get()->count();
        if($uniq > 0) {
            $value = 'phone laready ache';
            return response()->json($value);
        }

        if (!preg_match("/^(?:\+88|88)?(01[3-9]\d{8})$/", $request->phone)) {
            $value = 'Phone invalid';
            return response()->json($value);
        }

        $random_code = rand(100000, 999999);
        session([
            'session_otp' => $random_code,
        ]);

        $url = "http://66.45.237.70/api.php";
        $number = "88$request->phone";
        $text = "প্রিয় গ্রাহক, Your cityDokan OTP Verification Code : " . $random_code;
        $data = array(
            'username' => "Shawon1521",
            'password' => "WS@HAW%ON",
            'number' => "$number",
            'message' => "$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|", $smsresult);
        $sendstatus = $p[0];

        $value = "successfully submitted otp";


        return response()->json($value);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

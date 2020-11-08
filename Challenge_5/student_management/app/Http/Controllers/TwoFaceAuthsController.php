<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFaceAuthsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $google2FA = new Google2FA();
        $secretCode = $google2FA->generateSecretKey();

        $qrCodeUrl = $google2FA->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secretCode
        );

        session(["secret_code" => $secretCode]);

        return view('2fa.index', ['qrCodeUrl' => $qrCodeUrl]);
    }

    public function enable(Request $request)
    {
        $this->validate($request, [
            "code" => "required|digits:6",
        ]);

        $google2FA = new Google2FA();

        $secretCode = session("secret_code");
        $code = $request->input("code");

        if (!$google2FA->verify($code, $secretCode)) {
            $errors= new MessageBag();
            $errors->add("code", "Invalid authentication code");
            return redirect()->back()->withErrors($errors);
        }

        $user = auth()->user();
        $user->google2fa_secret = $secretCode;
        $user->save();

        return redirect("/")->with("status", "2FA enabled!");
    }
}

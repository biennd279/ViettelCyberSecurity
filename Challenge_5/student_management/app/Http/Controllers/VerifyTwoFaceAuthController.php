<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use PragmaRX\Google2FAQRCode\Google2FA;

class VerifyTwoFaceAuthController extends Controller
{
    public function index()
    {
        return view('2fa.verify.index');
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            "code" => "required|digits:6",
        ]);

        $google2FA = new Google2FA();
        $secretCode = auth()->user()->google2fa_secret;
        $code = $request->input("code");

        if (!$google2FA->verify($code, $secretCode)) {
            $errors= new MessageBag();
            $errors->add("code", "Invalid authentication code");
            return redirect()->back()->withErrors($errors);
        }

        session(["2fa_verified" => true]);
        return redirect("/");
    }
}

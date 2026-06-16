<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('profile.settings');
    }

    public function update(Request $request)
    {
        // General Settings
        if ($request->has('company_name')) set_setting('company_name', $request->company_name);
        if ($request->has('company_email')) set_setting('company_email', $request->company_email);
        if ($request->has('company_phone')) set_setting('company_phone', $request->company_phone);
        if ($request->has('company_address')) set_setting('company_address', $request->company_address);
        if ($request->has('timezone')) set_setting('timezone', $request->timezone);
        if ($request->has('currency')) set_setting('currency', $request->currency);

        // Logo Upload
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->storeOnCloudinary('settings')->getSecurePath();
            set_setting('company_logo', $path);
        }

        // SMTP Settings
        if ($request->has('mail_driver')) set_setting('mail_driver', $request->mail_driver);
        if ($request->has('mail_host')) set_setting('mail_host', $request->mail_host);
        if ($request->has('mail_port')) set_setting('mail_port', $request->mail_port);
        if ($request->has('mail_username')) set_setting('mail_username', $request->mail_username);
        if ($request->has('mail_password')) set_setting('mail_password', $request->mail_password);
        if ($request->has('mail_encryption')) set_setting('mail_encryption', $request->mail_encryption);
        if ($request->has('mail_from_address')) set_setting('mail_from_address', $request->mail_from_address);
        if ($request->has('mail_from_name')) set_setting('mail_from_name', $request->mail_from_name);

        notify()->success('Settings updated successfully!');
        return redirect()->back();
    }
}

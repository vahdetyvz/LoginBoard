<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Mail;
use App\Mail\SendMail;

class TestController extends Controller
{
    public function getTowns() {
		$testMailData = [
            'title' => 'Test Email From AllPHPTricks.com',
            'body' => 'This is the body of test email.'
        ];

        Mail::to('vahdetyvz@gmail.com')->send(new SendMail($testMailData));

        dd('Success! Email has been sent successfully.');
	}
}

<?php

namespace App\helper;

use Mail;
use App\model\Leave_type;
use App\model\Leave;
use Illuminate\Support\Facades\Config;

class MailHelper {

    public static function email($data) {
       

        $smtp = \App\model\Smtp::all();
        Config::set('mail.driver', $smtp[0]->driver);
        Config::set('mail.host', $smtp[0]->host);
        Config::set('mail.port', $smtp[0]->port);
        Config::set('mail.username', $smtp[0]->UserName);
        Config::set('mail.password', $smtp[0]->password);
                
        $emails = ['admin@gmail.com', 'seminavss@wamasoftware.com'];

        Mail::send('leave.leave_mail', $data, function ($message) use ($emails) {
            $message->from('xyz@wamasotware.com', 'wama Software');
            $message->to($emails)->subject('Leave Application');
        });
    }

}

<?php

namespace App\Http\Controllers\general_setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\General_setting;
use App\model\Smtp;
use App\model\Company;
use App\Http\Requests\GeneralSettingRequest;
use App\Http\Requests\SmtpRequest;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Input;

class GeneralController extends Controller {

    public function GeneralSetting() {
    
        $GenSetting = General_setting::findOrFail(1);
        
        $smtp = Smtp::findOrFail(1);
        
        $company = Company::findOrFail(1);
        
        return view('general_setting.general_setting', compact('GenSetting', 'smtp','company'));
    }
    
    public function edit(GeneralSettingRequest $request) {

        $General = General_setting::find(1);
        $all = $request->all();

        if (empty($all->application_title)) {
            $all['application_title'] = $General->application_title;
        }
        if (empty($all->address)) {
            $all['address'] = $General->address;
        }
        if (empty($all->system_mail)) {
            $all['system_mail'] = $General->system_mail;
        }
        if (empty($all->footer_text)) {
            $all['footer_text'] = $General->footer_text;
        }
        if (empty($all->email_getway)) {
            $all['email_getway'] = $General->email_getway;
        }


        $file = Input::file('application_logo');
        if (Input::hasFile('application_logo')) {
            $name = $file->getClientOriginalName();
            $oldFilelogo = public_path('image/logo/') . $General->application_logo;
            if (is_file($oldFilelogo)) {
                unlink($oldFilelogo);
            }
            $file->move('image/logo', $name);
            $all['application_logo'] = $name;
        } else {
            $name = $General->application_logo;
        }

        // application fevicon

        $file2 = Input::file('application_fevicon');
        if (Input::hasFile('application_fevicon')) {
            $name2 = $file2->getClientOriginalName();
            $oldFile = public_path('image/fevicon/') . $General->application_fevicon;
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
            $file2->move('image/fevicon', $name2);
            $all['application_fevicon'] = $name2;
        } else {
            $name2 = $General->application_fevicon;
        }
        $General->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Update',
                    'url' => route('dashboard'),
        ]);
    }

    public function Smtpupdate(SmtpRequest $request) {
        $all = $request->all();
        Smtp::find(1)->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Updated Successfully',
                    'url' => route('general_setting'),
        ]);
    }

    public function Companyupdate(CompanyRequest $request){
        $all = $request->all();
        Company::find(1)->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Updated Successfully',
                    'url' => route('general_setting'),
        ]);
    }
}

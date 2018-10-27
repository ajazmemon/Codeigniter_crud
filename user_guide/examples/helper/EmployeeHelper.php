<?php

namespace App\helper;

use App\model\Employee;
use App\model\Employee_detail;
use App\model\Employee_doc;
use App\model\Department;
use App\model\Designation;
use App\User;
Use App\model\Role;
use App\Http\Requests\EmployeeRequest;

class EmployeeHelper {

    public static function EmployeeAdd($request) {
      
        $EmpPostData = $request->all();
        $role = $request->EmpDetail['user_role'];
        $role_implode = $EmpPostData['EmpDetail']['user_role'] = implode(',', $role);
        $EmpPostData['is_active'] = 1;
        $EmpPostData['EmpDetail']['is_active'] = 1;
        $EmpPostData['password'] = bcrypt($EmpPostData['password']);
        $user = \App\User::create($EmpPostData);
        $Emp_detail = new Employee_detail($EmpPostData['EmpDetail']);
        
        $role_explode = explode(',', $role_implode);
        foreach($role_explode as $rf){
        User::where('id',$user->id)->firstOrFail()->assignRole($rf);
        }
        $user->emp_details()->save($Emp_detail);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Created',
                    'url' =>url('employee')
        ]);
    }

    public static function EmployeeUpdate($request, $id) {
       
       $Employee = User::findOrFail($id);  
        $EmployeeData = $request->all();
        $EmployeeData['password'] = bcrypt($EmployeeData['password']);
        $Employee->update($EmployeeData);
        $EmployeeDetail = $Employee->emp_details;
        $EmpPostData = $request->all();
        
        $EmployeeDetail->update($EmployeeData['EmpDetail']);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Updated',
                    'url' =>url('employee'),
        ]);
    }

    public static function DocumentStore($request, $id) {
        $all = $request->all();
        $all['emp_id'] = $id;
        $file = $request->file('doc');
        $ext = $file->getClientOriginalExtension();
        $nameonly = preg_replace('/\..+$/', '', $file->getClientOriginalName());
        $finalname = $nameonly . '_' . time() . '.' . $ext;
        $file->move('image/document', $finalname);
        $all['doc'] = $finalname;
        Employee_doc::create($all);
    }

    public static function DocumentUpdate($request, $id) {
        
        $doc = Employee_doc::findOrFail($id)->firstOrFail();
        $all = $request->all();
        if (file_exists(public_path('image/document' . $doc->doc))) {
            unlink(public_path('image/document/' . $doc->doc));
        }
        
        $file = $request->file('doc');
        if (!is_null($file)) {
        $ext = $file->getClientOriginalExtension();
        $nameonly = preg_replace('/\..+$/', '', $file->getClientOriginalName());
        $finalname = $nameonly . '_' . time() . '.' . $ext;
        $file->move('image/document', $finalname);
        $oldFile = public_path('image/document/') . $doc->doc;

        if (is_file($oldFile)) {
            unlink($oldFile);
        }
        $all['doc'] = $finalname;
        }
        $doc->update($all);
    }

    public static function EmployeeDD() {
        $data = [];
        $data['department'] = Department::with('id')->pluck('department', 'id');
        $data['department']->prepend('', '');
        $data['designation'] = Designation::with('id')->pluck('designation', 'id');
        $data['designation']->prepend('', '');
        $data['name'] = Role::with('id')->pluck('name', 'name');
    
        return $data;
    }

    public static function profile($request, $id) {

        $profile = Employee_detail::where('emp_id', '=', $id)->firstOrFail();
        $all = $request->all();
        $file = $request->file('profile_pic');
        if (!is_null($file)) {
            $name = $file->getClientOriginalName();
            $file->move('image/profile', $name);
            $oldFile = public_path('/image/profile') . $profile->profile_pic;
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
            $all['profile_pic'] = $name;
            $profile->update($all);
            return response()->json([
                        'status' => 'success',
                        'message' => 'Profile Changed Successfully ',
                        'url' => route('employee'),
            ]);
        }
    }
    
    public static function Active($request, $id)
    {
        $all = $request->all();
        $all['is_active'] = '1';
        User::findOrFail($id)->update($all);
    }
    public static function InActive($request, $id)
    {
        $all = $request->all();
        $all['is_active'] = '0';
        User::findOrFail($id)->update($all);
    }
    public static function EmployeeDelete($id)
    {
            $emp_data = Employee_detail::where('emp_id', $id)->count();
        if ($emp_data > 0) {
            return response()->json(['status' => 'false', 'message' => 'Employee has a ongoing Employee Details Table so User cannot be deleted.']);
        } else {

            User::find($id)->delete();
            return response()->json([
                        'status' => 'success',
                        'message' => 'Successfully Deleted',
            ]);
        }
    }

}

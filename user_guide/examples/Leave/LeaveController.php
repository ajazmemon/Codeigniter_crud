<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DataTables;
use App\model\Leave_type;
use App\model\Leave;
use Carbon\Carbon;
use App\Http\Requests\LeaveRequest;
use Mail;
use App\User;
use App\Notification;
use Illuminate\Support\Facades\Config;
use App\helper\MailHelper;
use App\helper\RoleAuthHelper;

class LeaveController extends Controller {

    public function leave() {
     
       
        $employee = User::all()->pluck('name', 'id');
        $employee->prepend('', '');
        $leave = Leave_type::all()->pluck('leave_type', 'id');
        $leave->prepend('', '');
       return view('leave/leave_application', compact('employee', 'leave'));
    }

    public function leave_create(Request $request) {
        $leave_add = $request->all();
        if ($request->start_time != null) {
            $leave_to = $request->leave_from;
            $leave_add['leave_to'] = $leave_to;
        }
        $id = $leave_add['emp_id'];
        $leave_add['applied_on'] = Carbon::today();
        $leave_add['status'] = 2;

        Leave::create($leave_add);

        $emp_name = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('users.name')->where('users.id', $id)->get()->toArray();
        $emp_email = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('users.email')->where('users.id', $id)->get()->toArray();
        $leave_from = $leave_add['leave_from'];
        $leave_to = $leave_add['leave_to'];
        $leave_reason = $leave_add['reason'];
        $id_leave=Leave::select('id')
		->orderBy('id', 'DESC')
		->limit(1)
		->get();
//        exit($id_leave[0]);
        $data = ['name' => $emp_name[0]->name,
            'email' => $emp_email[0]->email,
            'leave_from' => $leave_from,
            'leave_to' => $leave_to,
            'leave_reason' => $leave_reason
        ];

        $notification = [];
        $notification['name'] = $emp_name[0]->name;
        $notification['title'] = 'Leave Application';
        $notification['discription'] = $leave_reason;
        $notification['status'] = '1';
        $notification['emp_id'] = $id_leave[0]->id;

        Notification::create($notification);

//        MailHelper::email($data);

        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Created and mail sent',
                    'url' => route('leave'),
        ]);
    }

    public function leave_update(Request $request, $id) {

        $leave_update = $request->all();
        $leave = Leave::findOrFail($id);
        $leave->update($leave_update);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Updated',
                    'url' => route('leave'),
        ]);
    }

    public function leave_details(Request $request, $id) {
        $type = Leave_type::all()->pluck('leave_type', 'id');
        $employee = User::all()->pluck('name', 'id');
        $leave_detail = Leave::findOrFail($id);

        // Notification::where('emp_id', $id)->update(['status' => '0']);
//        $notification['status']= '0'; 
         DB::table('notification')
                ->where('emp_id', $id)
                ->update(['status' => "0"]);
        
        return view('leave.leave_details', compact('leave_detail', 'type', 'employee'));
    }

    public function leave_destroy($id) {
        Leave::findOrFail($id)->delete();
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Deleted',
                    'url' => route('leave'),
        ]);
    }

    public function leave_data() {
        $leave = Leave::leave_data();

        return DataTables::of($leave)->addIndexColumn()->addcolumn('action', function($leave) {
                    return '<a href="' . route('leave.details', $leave->id) . '"  title="View" class="btn btn-success fa fa-eye"> View </a>' .
                            '<a href="#delete" id="delete_leave" title="Delete"  data-id="' . $leave->id . '" data-toggle="modal" data-target="#delete" class="btn btn-danger fa fa-trash margin-left-5 delete"> Delete</a>';
                })->make(true);
    }

    public function leaveTypeView() {
        return view('leave/leaveType');
    }

    public function leaveAdd(Request $request) {
        $all = $request->all();
        $all['is_active'] = '1';
        Leave_type::create($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Created',
                    'url' => route('leaveTypeView'),
        ]);
    }

    public function leaveDataTable() {
        $leaveData = Leave_type ::all();
        return Datatables::of($leaveData)->addIndexColumn()->addColumn('action', function ($leaveData) {
                    return '<a  href="#edit"  title="Edit" class="btn btn-info fa fa-pencil edited margin-left-5"  data-target="#edit" data-toggle="modal" data-id=' . $leaveData->id . '> Edit</a>' .
                            '<a href="#delete"  title="Delete" class="btn btn-danger deleted fa fa-trash margin-left-5"  data-target="#delete" data-toggle="modal" data-id=' . $leaveData->id . '> Delete</a>';
                })->make(true);
    }

    public function leaveEdit($id) {
        $leave = Leave_type::find($id);
        return $leave;
    }

    public function leaveTypeUpdate(Request $request, $id) {
        $all = $request->all();
        Leave_type::find($id)->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Updated Successfully',
                    'url' => route('leaveTypeView'),
        ]);
    }

    public function leaveTypeDelete($id) {
        $leve_type = Leave::where('leave_type', $id)->count();
        if ($leve_type > 0) {
            return response()->json(['status' => 'false', 'message' => 'Leave Type has a ongoing Leave Table so Leave Type cannot be deleted.']);
        } else {
            Leave_type::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        }
    }

    public function active(Request $request, $id) {
        $all = $request->all();
        $all['is_active'] = '1';
        Leave_type::find($id)->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Active',
        ]);
    }

    public function inactive(Request $request, $id) {
        $all = $request->all();
        $all['is_active'] = '0';
        Leave_type::find($id)->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Inactive',
        ]);
    }

    public function leave_empdata() {
        $leave = Leave::leave_empdata();

        return DataTables::of($leave)->addIndexColumn()->addcolumn('action', function($leave) {
                    $action = (RoleAuthHelper::hasAccess('leave.details') != true) ? '<a href="javascript:void(0)" class="btn btn-default fa fa-eye" style="cursor:no-drop;"> View</a>' : '<a href="' . route('leave.details', $leave->id) . '"  title="View" class="btn btn-success fa fa-eye"> View </a>';
                    $action .=(RoleAuthHelper::hasAccess('leave.details') != true) ? '<a href="javascript:void(0)" class="btn btn-default fa fa-trash margin-left-5 delete" style="cursor:no-drop;"> Delete</a>' : '<a href="#delete" id="delete_leave" title="Delete"  data-id="' . $leave->id . '" data-toggle="modal" data-target="#delete" class="btn btn-danger fa fa-trash margin-left-5 delete"> Delete</a>';
                    return $action;
                })->make(true);
    }

    
      public function seeAll() {
        $employee = User::all()->pluck('name', 'id');
        $employee->prepend('', '');
        $leave = Leave_type::all()->pluck('leave_type', 'id');
        $leave->prepend('', ''); 
         
      $noti=Notification::all();
       foreach ($noti as $n) {
           Notification::where('status', '=', 1)->update(array('status' => 0));
        }
        return view('leave/leave_application', compact('employee', 'leave'));
        
    }
}

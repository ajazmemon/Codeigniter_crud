<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Leave extends Model {

    protected $fillable = array('emp_id', 'leave_type', 'leave_from', 'leave_to', 'status', 'reason', 'applied_on', 'comments', 'start_time', 'end_time');

    public function user() {
        return $this->belongsTo('App\User', 'emp_id');
    }

    public static function leave_approved() {

        return $data_leave = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.leave_from', 'leaves.leave_to', 'users.name')
                        ->where('leaves.status', '=', '1')->get();
    }

    public static function leave_reject() {

        return $data_leave = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.leave_from', 'leaves.leave_to', 'users.name')
                        ->where('leaves.status', '=', '0')->get();
    }

    public static function leave_pending() {

        return $data_leave = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.leave_from', 'leaves.leave_to', 'users.name')
                        ->where('leaves.status', '=', '2')->get();
    }

    public static function half_leave_pending() {

        return $data_leave = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.leave_from', 'leaves.start_time', 'leaves.end_time', 'users.name')
                        ->where('leaves.start_time', '!=', '')->where('leaves.status', '=', '2')->get();
    }

    public static function half_leave_approved() {

        return $data_leave = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.leave_from', 'leaves.start_time', 'leaves.end_time', 'users.name')
                        ->where('leaves.start_time', '!=', '')->where('leaves.status', '=', '1')->get();
    }

    public static function half_leave_reject() {

        return $data_leave = DB::table('leaves')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.leave_from', 'leaves.start_time', 'leaves.end_time', 'users.name')
                        ->where('leaves.start_time', '!=', '')->where('leaves.status', '=', '0')->get();
    }

    public static function leave_data() {

        return $leave = DB::table('leaves')
                        ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type')
                        ->join('users', 'users.id', '=', 'leaves.emp_id')
                        ->select('leaves.id', 'users.name', 'leave_types.leave_type', 'leaves.leave_from', 'leaves.leave_to', DB::raw("CONCAT(leaves.start_time, ' - ', leaves.end_time) as time"), 'leaves.status')->get();          
    }

    public static function leave_empdata() {
  
        return $leave = DB::table('leaves')
                ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type')
                ->join('users', 'users.id', '=', 'leaves.emp_id')
                ->select('leaves.id', 'users.name', 'leave_types.leave_type', 'leaves.leave_from', 'leaves.leave_to', DB::raw("CONCAT(leaves.start_time, ' - ', leaves.end_time) as time"), 'leaves.status')
                ->where('users.id', '=', Auth::user()->id)
                ->get();
    }

}

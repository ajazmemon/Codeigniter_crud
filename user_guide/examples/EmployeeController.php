<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use App\model\Employee;
use App\model\Designation;
use App\model\Department;
use App\model\Employee_detail;
use App\model\Employee_bank;
use App\model\Employee_doc;
use App\User;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\addBankRequest;
use DB;
use App\helper\BankHelper;
use App\helper\EmployeeHelper;

class EmployeeController extends Controller {

   public function BankData($id) {
      $bank_data = Employee_bank::where('emp_id', '=', $id)->get();
      return Datatables::of($bank_data)->addIndexColumn()->addColumn('action', function ($bank_data) {
                 return '<a href="#myModalBank" id="editbank" title="Edit"  class="btn btn-info fa fa-pencil margin-left-5" data-id="' . $bank_data->id . '"  data-target="#myModalBank" data-toggle="modal" > Edit</a>'
                         . '<a href="#BankDelete"  title="Delete" data-target="#BankDelete"  data-toggle="modal"  data-id="' . $bank_data->id . '" id="deleteBank" class="btn btn-danger fa fa-trash margin-left-5"> Delete</a>';
              })->make(true);
      
   }

   public function employee() {

      $data = EmployeeHelper::EmployeeDD();
      return view('employee.employee_list', $data);
   }

   public function EmployeesList() {

      $employeeList = User::EmployeeList();
      return Datatables::of($employeeList)->addIndexColumn()->addColumn('action', function ($employeeList) {
                 return '<a href="' . route('employee_edit', $employeeList->id) . '" title="Show" class="btn btn-success fa fa-eye margin-left-5"> Show</a>' .
                         '<a href="#delete' . '" title="Delete" data-id="' . $employeeList->id . '" data-toggle="modal" data-target="#delete" class="btn btn-danger fa fa-trash margin-left-5 delete"> Delete</a>';
              })->make(true);
   }

   public function EmployeeAdd() {

      $data = EmployeeHelper::EmployeeDD();
      return view('employee.employee_add', $data);
   }

   public function EmpAdd(Request $request) {


      return EmployeeHelper::EmployeeAdd($request);
   }

   public function EmployeeEdit($id) {

      $department = Department::with('id')->pluck('department', 'id');
      $department->prepend('', '');
      $designation = Designation::with('id')->pluck('designation', 'id');
      $designation->prepend('', '');
      $employee = User::findOrFail($id);

      return view('employee.profile', compact('department', 'designation', 'employee'));
   }

   public function EmployeeUpdate(Request $request, $id) {

      return EmployeeHelper::EmployeeUpdate($request, $id);
   }

   public function EmployeeDelete($id) {
      return EmployeeHelper::EmployeeDelete($id);
   }

   public function profile() {
      return view('employee.profile');
   }

   public function BankAdd(addBankRequest $request) {
      BankHelper::BankAdd($request);
      return response()->json([
                  'status' => 'success',
                  'message' => 'Successfully Created',
                  'url' => url('employee'),
      ]);
   }

   public function active(Request $request, $id) {
      EmployeeHelper::Active($request, $id);
      return response()->json([
                  'status' => 'success',
                  'message' => 'Employee Active',
      ]);
   }

   public function inactive(Request $request, $id) {
      EmployeeHelper::InActive($request, $id);
      return response()->json([
                  'status' => 'success',
                  'message' => 'Employee Inactive',
      ]);
   }

   public function ChangeProfile(Request $request, $id) {
      return EmployeeHelper::profile($request, $id);
   }

   public function DocStore(Request $request, $id) {
      EmployeeHelper::DocumentStore($request, $id);
      return response()->json([
                  'status' => 'success',
                  'message' => 'Document Added Successfully ',
                  'url' => route('employee'),
      ]);
   }

   public function DocumentData(Request $request, $id) {
      $doc_data = Employee_doc::where('emp_id', '=', $id)->get(); 
      return Datatables::of($doc_data)->addIndexColumn()->addColumn('action', function ($doc_data) {
                 return '<a href="#myModal" id="editdocument" title="Edit"  class="btn btn-info fa fa-pencil margin-left-5" data-id="' . $doc_data->id . '"  data-target="#myModal" data-toggle="modal" > Edit</a>'
                         . '<a href="#delete"  title="Delete" data-target="#delete"  data-toggle="modal"  data-id="' . $doc_data->id . '" id="deleteDocument" class="btn btn-danger fa fa-trash margin-left-5"> Delete</a>';
              })->make(true);
   }

   public function DocEdit(Request $request, $id) {
      $doc_data = Employee_doc::findOrFail($id);
      return $doc_data;
   }

   public function DocUpdate(Request $request, $id) {
      EmployeeHelper::DocumentUpdate($request, $id);
      return response()->json([
                  'status' => 'success',
                  'message' => 'Document Updated Successfully ',
                  'url' => route('employee'),
      ]);
   }

   public function DocumentDelete(Request $request, $id) {
      $doc_data = Employee_doc::findOrfail($id);

      if (!file_exists(public_path('image/document/' . $doc_data->doc))) {
         unlink(public_path('image/document/' . $doc_data->doc));
      }
      $doc_data->delete();
      return response()->json([
                  'status' => 'success',
                  'message' => 'Document Deleted Successfully ',
                  'url' => route('employee'),
      ]);
   }

   public function BankEdit(Request $request, $id) {
      $dataBank = Employee_bank::findOrfail($id);
      return $dataBank;
   }

   public function BankUpdate(Request $request, $id) {
        $all = $request->all();
        Employee_bank::find($id)->update($all);
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Updated  ',
                    'url' => route('employee'),
        ]);
      
   }
   
    public function BankDelete(Request $request, $id) {
      Employee_bank::find($id)->delete();
            return response()->json([
                        'status' => 'success',
                        'message' => 'Successfully Deleted',
                         'url' => route('employee'),
            ]);
   }

}

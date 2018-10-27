<?php

namespace App\Http\Controllers\Holiday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayRequest;
use App\model\Holiday;
use App\model\Employee_detail;
use Datatables;
use Calendar;
use DB;
use App\helper\RoleAuthHelper;

class HolidayController extends Controller {

    //
    public function holiday() {
               return view('holiday.add_holiday');
    }

    public function holiday_add(HolidayRequest $request) {
        Holiday::create($request->all());
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Created',
                    'url' => route('holiday'),
        ]);
    }

    public function holiday_data() {
        $holiday = Holiday::all();
        return Datatables::of($holiday)->addIndexColumn()->addColumn('action', function ($holiday) {
                    $action =  (RoleAuthHelper::hasAccess('holiday/edit') != true) ? '<a href="javascript:void(0)" class="btn btn-default fa fa-pencil edited margin-left-5" style="cursor:no-drop;"> Edit</a>' : '<a  href="#edit"  title="Edit" class="btn btn-info fa fa-pencil edited margin-left-5"  data-target="#edit" data-toggle="modal" data-id=' . $holiday->id . '> Edit</a>';
                    $action.=  (RoleAuthHelper::hasAccess('holiday/delete') != true) ? '<a href="javascript:void(0)" class="btn btn-default deleted fa fa-trash margin-left-5" style="cursor:no-drop;"> Delete</a>' : '<a href="#delete"  title="Delete" class="btn btn-danger deleted fa fa-trash margin-left-5"  data-target="#delete" data-toggle="modal" data-id=' . $holiday->id . '> Delete</a>';
                    return $action;
                })->make(true);
    }

    public function holiday_edit($id) {
        $holiday = Holiday::find($id);
        return $holiday;
    }

    public function holiday_update(Request $request, $id) {
        Holiday::find($id)->update($request->all());
        return response()->json([
                    'status' => 'success',
                    'message' => 'Updated Successfully',
                    'url' => route('holiday'),
        ]);
    }

    public function holiday_delete($id) {
        Holiday::find($id)->delete();
        return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Deleted',
                    'url' => route('holiday'),
        ]);
    }

    public function calendar() {
        
        $data_holiday = Holiday::all();
        $holiday = [];
        if ($data_holiday->count()) {
            foreach ($data_holiday as $key => $value) {
                $holiday[] = Calendar::event(
                                $value->occasion, true, new \DateTime($value->date), new \DateTime($value->date . ' +1 day'));
            }
        }
        $calendar_holiday = Calendar::addEvents($holiday, ['className' => 'fc-holiday fa fa-suitcase']);

        $data_birthday = Employee_detail::all();
        $birthday = [];
        if ($data_birthday->count()) {
            foreach ($data_birthday as $key => $value) {
                $birthday[] = Calendar::event(
                                $value->first_name, true, new \DateTime($value->birth_date), new \DateTime($value->birth_date . ' +1 day'));
            }
        }
        $calendar_birthday = Calendar::addEvents($birthday, ['className' => 'fa fa-birthday-cake fc-birthday']);
       
        $data_leave_approved = \App\model\Leave::leave_approved();
        $leaves_approve = [];
        if ($data_leave_approved->count()) {
            foreach ($data_leave_approved as $key => $value) {
                $leaves_approve[] = Calendar::event(
                                $value->name, true, new \DateTime($value->leave_from), new \DateTime($value->leave_to . ' +1 day'));
            }
        }
        $calendar_leave_approve = Calendar::addEvents($leaves_approve, ['className' => 'fc-leave-approved fa fa-bed']);

            
         $data_leave_reject = \App\model\Leave::leave_reject();
        $leaves_reject = [];
        if ($data_leave_reject->count()) {
            foreach ($data_leave_reject as $key => $value) {
                $leaves_reject[] = Calendar::event(
                                $value->name, true, new \DateTime($value->leave_from), new \DateTime($value->leave_to . ' +1 day'));
            }
        }
        $calendar_leave_reject = Calendar::addEvents($leaves_reject, ['className' => 'fc-leave-reject fa fa-bed']);
        
         $data_leave_pending = \App\model\Leave::leave_pending();
        $leaves_pending = [];
        if ($data_leave_pending->count()) {
            foreach ($data_leave_pending as $key => $value) {
                $leaves_pending[] = Calendar::event(
                                $value->name, true, new \DateTime($value->leave_from), new \DateTime($value->leave_to . ' +1 day'));
            }
        }
        $calendar_leave_pending = Calendar::addEvents($leaves_pending, ['className' => 'fc-leave-pending fa fa-bed']);

        $data_halfleave_approved = \App\model\Leave::half_leave_approved();
        $halfleaves_approve = [];
        if ($data_halfleave_approved->count()) {
            foreach ($data_halfleave_approved as $key => $value) {
                $halfleaves_approve[] = Calendar::event(
                                $value->name, true, new \DateTime($value->leave_from), new \DateTime($value->leave_from . ' +1 day'));
            }
        }
        $calendar_halfleave_approve = Calendar::addEvents($halfleaves_approve, ['className' => 'fc-halfleave-approved fa fa-bed']);

            
         $data_halfleave_reject = \App\model\Leave::half_leave_reject();
        $halfleaves_reject = [];
        if ($data_halfleave_reject->count()) {
            foreach ($data_halfleave_reject as $key => $value) {
                $halfleaves_reject[] = Calendar::event(
                                $value->name, true, new \DateTime($value->leave_from), new \DateTime($value->leave_from . ' +1 day'));
            }
        }
        $halfcalendar_leave_reject = Calendar::addEvents($halfleaves_reject, ['className' => 'fc-halfleave-reject fa fa-bed']);
        
         $data_halfleave_pending = \App\model\Leave::half_leave_pending();
        $halfleaves_pending = [];
        if ( $data_halfleave_pending->count()) {
            foreach ( $data_halfleave_pending as $key => $value) {
                $halfleaves_pending[] = Calendar::event(
                                $value->name, true, new \DateTime($value->leave_from), new \DateTime($value->leave_from . ' +1 day'));
            }
        }
        $halfcalendar_leave_pending = Calendar::addEvents($halfleaves_pending, ['className' => 'fc-halfleave-pending fa fa-bed']);
       
        return view('holiday.calendar', compact('calendar_holiday', 'calendar_birthday', 'calendar_leave_approve','calendar_leave_reject','calendar_leave_pending','calendar_halfleave_approve','halfcalendar_leave_reject','halfcalendar_leave_pending'));
    }
}

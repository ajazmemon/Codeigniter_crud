<?php

namespace App\helper;

use DB;
use Datatables;
use App\model\Employee_bank;

class BankHelper {

    public static function BankAdd($request) {
        $all = $request->all();
        Employee_bank::create($all);
    }

}

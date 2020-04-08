<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function import() 
    {
        Excel::import(new UsersImport, request()->file('spreadsheet'));
        return response()->json('Successfully Imported!', 200);
    }
}

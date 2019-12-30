<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use App\User;

class AdminValidationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
      
    public function validateEmail($id) {
        $id = trim($id);
        if (\App\Admin::where('reg_emailid', $id)->exists()) {
            echo "Email Already exists!";
        }
    }
    
    public function validateMobile($id) {
        $id = trim($id);
        if (\App\Admin::where('reg_mobileno', $id)->exists()) {
            echo "Mobile No Already exists!";
        }
    }
   
   
}

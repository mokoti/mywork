<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Debugbar;

class top extends Controller
{
   public function top(){
       print 'Hello, World';
       $input = Input::all();
       Debugbar::info(print_r($input, true));
   }
}

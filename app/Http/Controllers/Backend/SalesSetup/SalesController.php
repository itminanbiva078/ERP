<?php


namespace App\Http\Controllers\Backend\SalesSetup;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SalesController extends Controller
{
  
    public function salespos()
    {
        return view("salespos.salespos");
    }

}

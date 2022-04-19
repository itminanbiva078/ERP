<?php


namespace App\Http\Controllers\Backend\Settings;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
  
    public function invoice()
    {
        return view("invoice.invoice");
    }

}

<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Contact;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InventoryController extends Controller 
{
   public function index()
   {
      return view('admin.index');
   }
   public function invoice($id)
   {
      
      $invoice = Order::where('id', $id)
         ->get();
      return view('admin.invoice', compact('invoice'));
   }
   public function getContactDetail()
   {
      
      $contact=Contact::all();
      return view('admin.contact.contactus',compact('contact'));
   }
}

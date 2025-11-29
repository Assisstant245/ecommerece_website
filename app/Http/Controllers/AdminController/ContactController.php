<?php

namespace App\Http\Controllers\AdminController;
use App\Mail\ContactResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class ContactController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('permission:view category', only: ['index']),
            new Middleware('permission:create category', only: ['create', 'store']),
            new Middleware('permission:edit category', only: ['edit', 'update']),
            new Middleware('permission:delete category', only: ['destroy']),
        ];
    }
    public function showResponseForm($id)
{
    $contact = Contact::findOrFail($id);
    return view('admin.contact.response', compact('contact'));
}

public function sendResponse(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'subject' => 'required|string|max:255',

        'message' => 'required|string',
    ]);

    // Send email (basic example)
    Mail::to($request->email)->send(new ContactResponse($request->subject,$request->message,$request->response));
    return response()->json([
        'success' => true,
        'message' => 'Response sent successfully!'
    ]);

    // return redirect()->route('admin.admin.getContactDetail')->with('success', 'Response sent successfully!');
}
}

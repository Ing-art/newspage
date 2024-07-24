<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

use Illuminate\Http\Request;

class ContactController extends Controller
{
     //
     public function index(){

        return view('contact');
    }

    //Send the message from the contact form
    public function send(Request $request){
        $message = new \stdClass(); // Object with the data. "\" to set root
        $message->subject = $request->subject;
        $message->email= $request->email;
        $message->sender = $request->sender;
        $message->msg = $request->msg;

        // If the form allows file attachments
        // If a file is sent, get the path to the temporary folder
/*         $msg->contactFile = $request->hasFile('contactFile')?
                            $request->file('contactFile')->getRealPath() :
                            NULL; */

        Mail::to('contact@madworldnews.com')->send(new Contact($message));

        return redirect()
            ->route('homepage')
            ->with('success', 'Message successfuly sent');
    }

}

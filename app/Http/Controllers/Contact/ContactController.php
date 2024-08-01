<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // contact controller
    public function contact( Request $request )
    {
        try {
            $name = $request->input('name');
            $email = $request->input('email');
            $message = $request->input('message');

            

        } catch( Exception $e ) {
            return $e->getMessage();
        }
    }
}

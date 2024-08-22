<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function postRecords( Request $request ) {
        $request->validate([
            'user_id' => 'required',
            'action' => 'required',
            'amount' => 'required'
        ]);

        $data = [
            'user_id' => Auth::user()->id,
            'action' => $request->input('action'),
            'amount' => $request->input('')
        ];
    }
}

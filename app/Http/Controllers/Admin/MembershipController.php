<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    // index
    public function memberShipIndex()
    {
        return view('admin.membership.index');
    }

    // create
    public function createMembership()
    {
        return view('admin.membership.create');
    }

    // store
    public function storeMembership()
    {

    }

    // edit
    public function editMembership()
    {
        return view('admin.membership.update');
    }

    // update
    public function updateMembership( Request $request )
    {

    }
}

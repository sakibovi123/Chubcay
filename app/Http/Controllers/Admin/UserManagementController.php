<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->where('is_admin', 0)
            ->orderByDesc('created_at')
            ->get();
        return view('admin.users.index', [
            'users' => $users
        ]);
    }
}

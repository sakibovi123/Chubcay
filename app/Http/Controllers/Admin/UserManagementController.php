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

    public function activateUser( Request $request )
    {
        if ($request->ajax()) {
            $user = User::find($request->input('user_id'));
    
            if ($user) {
                $user->status = $request->input('status');
                $user->save();
    
                return response()->json(['message' => 'User updated successfully!']);
            }
    
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        return response()->json(['message' => 'Invalid request.'], 400);

    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store( Request $request )
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();

        $user = User::create($data);

        return redirect()->back()->with('message', 'User added successfully');
        
    }

    public function edit($userId)
    {
        $user = User::find($userId);
        return view('admin.users.update');
    }

    public function update( Request $request, $userId )
    {
        $user = User::find($userId);

        if( $user )
        {

        }
    }

    public function destroy($userId)
    {
        $user = User::find($userId);
        if( $user )
        {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'user removed',
                'tr' => 'tr_'.$userId
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'something went wrong'
            ]);
        }
    }
}

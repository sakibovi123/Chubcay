<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipType;
use Illuminate\Http\Request;

class AdminMemberShipTypeController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $types = MembershipType::all();

        return view('admin.types.index', [
            'types' => $types
        ]);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('admin.types.create');
    }


    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string'
        ]);

        MembershipType::create($validatedData);

        return redirect()
            ->back()
            ->with('message', 'Created Successfully');
    }


    public function details( $typeId ): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $type = MembershipType::where(
            'id', $typeId
        )->first();

        return view('admin.types.update', [
            'type' => $type
        ]);
    }


    public function update( Request $request, $typeId ): \Illuminate\Http\RedirectResponse
    {
        $type = MembershipType::where(
            'id', $typeId
        )->first();

        $validatedData = $request->validate([
            'name' => 'required|string'
        ]);

        $type->name = $validatedData['name'];

        $type->save();

        return redirect()
            ->back()
            ->with('message', 'Updated successfully');
    }


    public function destroy( $typeId ): \Illuminate\Http\RedirectResponse
    {
        $type = MembershipType::where(
            'id', $typeId
        )->first();

        $type->delete();

        return redirect()
            ->back()
            ->with('message', 'Deleted successfully');

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function users()
    {
        try {
            $users = User::all();

            return view('admin.user.index', compact('users'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function viewUser($id)
    {
        try {
            $user = User::find($id);

            return view('admin.user.view', compact('user'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

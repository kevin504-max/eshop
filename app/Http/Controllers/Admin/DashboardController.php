<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function users()
    {
        try {
            // Seleciona todos os usuários
            $users = DB::select('SELECT * FROM users');

            return view('admin.user.index', compact('users'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function viewUser($id)
    {
        try {
            // Seleciona o usuário com base no ID
            $user = DB::selectOne('SELECT * FROM users WHERE id = ?', [$id]);

            if (!$user) {
                return redirect()->back()->with(['status' => 'error', 'message' => 'User not found!']);
            }

            return view('admin.user.view', compact('user'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}

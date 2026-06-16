<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manajemen User';
        $users = User::latest()->paginate(10);

        confirmDelete(
            'Apakah Anda yakin ingin menghapus akun ini?'
        );

        return view('user.index', compact('pageTitle', 'users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,asisten,laboran,kalab'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        toast()->success('Role berhasil diperbarui');
        return back();
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            toast()->error('Anda tidak dapat menghapus akun sendiri');
            return back();
        }

        $user->delete();

        toast()->success('Akun berhasil dihapus');
        return back();
    }
}
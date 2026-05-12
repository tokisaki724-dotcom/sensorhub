<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');

        $users = User::when($role, fn ($query) => $query->where('role', $role))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $roleCounts = [
            'all' => User::count(),
            'user' => User::where('role', 'user')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
        ];

        return view('super-admin.users.index', compact('users', 'roleCounts', 'role'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'admin', 'super_admin'])],
        ]);

        if ($user->is(auth()->user()) && $validated['role'] !== 'super_admin') {
            return back()->with('error', 'You cannot remove your own super admin access.');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'User role updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Super admin accounts cannot be removed from this screen.');
        }

        $user->delete();

        return back()->with('success', 'Account removed successfully.');
    }
}

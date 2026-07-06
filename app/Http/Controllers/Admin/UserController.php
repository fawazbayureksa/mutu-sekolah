<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 'user',
            'is_active' => $request->has('is_active') ? true : false,
            'bio' => $request->bio,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.created',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Created user: {$user->name}",
            'new_values' => $user->toArray(),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user): View
    {
        $user->load('activityLogs');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $oldValues = $user->toArray();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role ?? $user->role,
            'is_active' => $request->has('is_active') ? true : $user->is_active,
            'bio' => $request->bio ?? $user->bio,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.updated',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Updated user: {$user->name}",
            'old_values' => $oldValues,
            'new_values' => $user->toArray(),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        $userName = $user->name;
        $userId = $user->id;

        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.deleted',
            'model_type' => User::class,
            'model_id' => $userId,
            'description' => "Deleted user: {$userName}",
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['is_active' => true]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.activated',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Activated user: {$user->name}",
        ]);

        return back()->with('success', 'User activated successfully');
    }

    public function deactivate(User $user): RedirectResponse
    {
        $user->update(['is_active' => false]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.deactivated',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Deactivated user: {$user->name}",
        ]);

        return back()->with('success', 'User deactivated successfully');
    }

    public function changePassword(PasswordChangeRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.password_changed',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Changed password for user: {$user->name}",
        ]);

        return back()->with('success', 'Password changed successfully');
    }

    public function resetPassword(User $user): RedirectResponse
    {
        $newPassword = $user->npsn ?? 'Password2026!'; // You can generate a random password or set a default one
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.password_reset',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Reset password for user: {$user->name}",
        ]);

        return back()->with('success', "Password reset successfully. New password: {$newPassword}");
    }

    public function activity(User $user, Request $request): View
    {
        $query = $user->activityLogs();

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $activities = $query->latest()->paginate(20);

        return view('admin.users.activity', compact('user', 'activities'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $action = $request->action;
        $userIds = $request->users ?? [];

        if (empty($userIds)) {
            return back()->with('error', 'No users selected');
        }

        $users = User::whereIn('id', $userIds)->get();

        switch ($action) {
            case 'activate':
                $users->each->update(['is_active' => true]);
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'users.bulk_activated',
                    'description' => "Activated {$users->count()} users",
                    'new_values' => $users->pluck('id')->toArray(),
                ]);
                break;

            case 'deactivate':
                $users->each->update(['is_active' => false]);
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'users.bulk_deactivated',
                    'description' => "Deactivated {$users->count()} users",
                    'new_values' => $users->pluck('id')->toArray(),
                ]);
                break;

            case 'delete':
                $users->each->delete();
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'users.bulk_deleted',
                    'description' => "Deleted {$users->count()} users",
                    'new_values' => $users->pluck('id')->toArray(),
                ]);
                break;
        }

        return back()->with('success', 'Bulk action completed successfully');
    }
}

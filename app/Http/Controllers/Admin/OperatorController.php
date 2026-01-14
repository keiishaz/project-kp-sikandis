<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    public function index()
    {
        $q = request()->query('q');
        $sort = request()->query('sort');
        $dir = request()->query('dir');
        $operatorRole = Role::where('nama_role', 'operator')->first();

        $operatorsQuery = User::query()
            ->when($operatorRole, function ($query) use ($operatorRole) {
                $query->whereHas('roles', function ($q) use ($operatorRole) {
                    $q->where('roles.id', $operatorRole->id);
                });
            })
            ->when(is_string($q) && trim($q) !== '', function ($query) use ($q) {
                $q = trim($q);
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%');
                });
            });

        $allowedSorts = ['created_at', 'name', 'email'];
        $direction = in_array($dir, ['asc', 'desc'], true) ? $dir : 'desc';

        if (is_string($sort) && in_array($sort, $allowedSorts, true)) {
            $operatorsQuery->orderBy($sort, $direction);
        } else {
            $operatorsQuery->latest();
        }

        $operators = $operatorsQuery->paginate(15)->appends(request()->query());

        return view('admin.kelola-operator.index', compact('operators'));
    }

    public function create()
    {
        return view('admin.kelola-operator.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.unique' => 'Username sudah digunakan. Silakan gunakan username yang lain.',
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email yang lain.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $role = Role::firstOrCreate(['nama_role' => 'operator']);
        $user->roles()->syncWithoutDetaching([$role->id]);

        return redirect()->route('admin.kelola-operator.index');
    }

    public function edit(User $kelola_operator)
    {
        return view('admin.kelola-operator.edit', ['operator' => $kelola_operator]);
    }

    public function update(Request $request, User $kelola_operator)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $kelola_operator->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $kelola_operator->id],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'name.unique' => 'Username sudah digunakan. Silakan gunakan username yang lain.',
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email yang lain.',
        ]);

        $kelola_operator->name = $validated['name'];
        $kelola_operator->email = $validated['email'];

        if (!empty($validated['password'])) {
            $kelola_operator->password = Hash::make($validated['password']);
        }

        $kelola_operator->save();

        $role = Role::firstOrCreate(['nama_role' => 'operator']);
        $kelola_operator->roles()->syncWithoutDetaching([$role->id]);

        return redirect()->route('admin.kelola-operator.index');
    }

    public function destroy(User $kelola_operator)
    {
        $kelola_operator->delete();

        return redirect()->route('admin.kelola-operator.index');
    }
}

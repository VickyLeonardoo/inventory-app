<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('superadmin')) {
            $users = User::all();
        } else {
            $users = User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'superadmin');
            })->get();
        }

        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $user->assignRole($data['role']);
        return redirect()->route('user.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $role = $user->getRoleNames();
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user){
        $data = $request->validated();
        
        // Dapatkan semua role lama
        $oldRoles = $user->getRoleNames();
        
        // Update user
        $user->update($data);
        
        // Hapus semua role lama
        foreach ($oldRoles as $oldRole) {
            $user->removeRole($oldRole);
        }
        
        // Assign role baru
        $user->assignRole($data['role']);
        
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $checApp = $user->application;
        if ($checApp) {
            return redirect()->back()->with('error','Cannot delete data if user already have application');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
 
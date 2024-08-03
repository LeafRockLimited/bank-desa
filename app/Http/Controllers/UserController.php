<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => "required",
            'email' => 'required|email',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        $user->assignRole($data['role']);
        return response()->json(['message' => 'Berhasil membuat akun baru.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $length = $request->lengt??10;
        $search = $request->searchQuery??null;
        $user = User::with('roles')->when($search,function($sub) use($search){
            $sub->whereAny(['name','email'],'ilike',"%$search%");
        })->paginate($length);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return Inertia::render('User/Edit',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
        ]);

        $role = $request->validate(['role' => 'required']);
        
        $user = User::find($id);
        $user->update(array_filter($data));

        $user->syncRoles($role['role']);


        return response()->json(['message' => 'Berhasil membuat akun baru.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        User::find($id)->delete();
        return response()->json(['message' => "Berhasil menghapus akun"]);
    }
}

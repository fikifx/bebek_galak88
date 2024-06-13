<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

           $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'akses' => 'required',
            ]);


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->input('password'));
            $user->akses = $request->akses;
            $user->save();
            $user->assignRole($request->akses);

            return redirect()->route('users.index')->with('success', 'Tambah pengguna berasil');
        } catch (QueryException $e) {

            return back()->withInput()->withErrors(['error' => 'Failed to create user. Please try again later.']);
        } catch (\Exception $e) {

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
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
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'akses' => 'required',
            ]);

            // $data = [
            //     'name' => $request->name,
            //     'email' => $request->email,
            // ];

            // $user->update($data);
            // $user->syncRoles($request->roles);
            $user = User::findOrFail($id);
            $user->removeRole($user->akses);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->akses = $request->akses;
            $user->save();
            $user->assignRole($request->akses);

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to update user. Please try again later.']);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

    }






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return redirect()->route('users.index')->with('success', 'User and associated roles deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

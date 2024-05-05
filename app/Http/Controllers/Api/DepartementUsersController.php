<?php

namespace App\Http\Controllers\Api;

use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class DepartementUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Departement $departement)
    {
        $this->authorize('view', $departement);

        $search = $request->get('search', '');

        $users = $departement
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Departement $departement)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'date_naiss' => ['required', 'date'],
            'password' => ['required'],
            'commune_id' => ['required', 'exists:communes,id'],
            'photo' => ['nullable', 'file'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user = $departement->users()->create($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }
}

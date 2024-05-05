<?php

namespace App\Http\Controllers\Api;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class CommuneUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Commune $commune)
    {
        $this->authorize('view', $commune);

        $search = $request->get('search', '');

        $users = $commune
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Commune $commune)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'date_naiss' => ['required', 'date'],
            'password' => ['required'],
            'departement_id' => ['required', 'exists:departements,id'],
            'photo' => ['nullable', 'file'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user = $commune->users()->create($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }
}

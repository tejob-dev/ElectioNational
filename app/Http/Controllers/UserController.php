<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }
    
    public function operateurs(Request $request)
    {
        $this->authorize('operateurs-view', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->userlimit()
            ->with("roles.permissions")->whereHas("roles.permissions", function($q) {
                $q->whereIn("name", ["can-open-section-only"]);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $communes = Commune::pluck('libel', 'id');
        $departements = Departement::pluck('libel', 'id');

        if( Auth::user()->can("can-set-super-admin") ){
            $roles = Role::get();
        }else{
            $roles = Role::where("name", "!=", "super-admin")->get();
        }

        return view(
            'app.users.create',
            compact('communes', 'departements', 'roles')
        );
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $communes = Commune::pluck('libel', 'id');
        $departements = Departement::pluck('libel', 'id');

        if( Auth::user()->can("can-set-super-admin") ){
            $roles = Role::get();
        }else{
            $roles = Role::where("name", "!=", "super-admin")->get();
        }

        return view(
            'app.users.edit',
            compact('user', 'communes', 'departements', 'roles')
        );
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        if ($user->photo) {
            Storage::delete($user->photo);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

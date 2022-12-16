<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'hak_akses' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'hak_akses' => $request->hak_akses,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/account');
        // return redirect(RouteServiceProvider::HOME);
    }

    public function edit_account(User $user)
    {
        return Inertia::render('Auth/Register_user/Edit', [
            'data' =>  $user
        ]);
    }


    public function update_account(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'hak_akses' => 'required',
        ]);

        User::where('id', $id)->update($validated);
        return redirect('/account');
    }

    public function destroy_account($id)
    {
        User::destroy($id);
        return redirect()->back();
    }

    public function index_account_dashboard()
    {
        return Inertia::render('Auth/Register_user/Index', [
            'users' => User::paginate(5)
        ]);
    }

    public function create_account_dashboard()
    {
        return Inertia::render('Auth/Register_user/Create');
    }
}

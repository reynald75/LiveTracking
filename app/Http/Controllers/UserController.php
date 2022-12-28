<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($org_id)
    {
        return view('user.form')->with('org_id', $org_id);
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'initials' => ['required', 'string', 'max:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'org_id' => ['required', 'string'],
            'line_color' => ['required', 'string']
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'initials' => $request->initials,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'organization_id' => $request->org_id,
            'line_color' => $request->line_color
        ]);

        if(isset($request->roles)){
            foreach ($request->roles as $role) {
                $user->assignRole($role);
            }
        }

        //Send email reset link
        //app('App\Http\Controllers\Auth\ForgotPasswordController')->sendResetLinkEmail($request);

        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        return $this->edit($user->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($userId)
    {
        return view('user.form')->with('user', User::find($userId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            '_user_id' => ['required', 'integer', 'exists:users,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'initials' => ['required', 'string', 'max:2'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'org_id' => ['required', 'string'],
            'line_color' => ['required', 'string']
        ]);

        $user = User::find($request->_user_id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->initials = $request->initials;
        $user->email = $request->email;
        $user->organization_id = $request->org_id;
        $user->line_color = $request->line_color;

        if(isset($request->roles)){
            foreach ($request->roles as $role) {
                if (!$user->hasRole($role)) {
                    $user->assignRole($role);
                }
            }
            foreach ($user->getRoleNames() as $role) {
                if (!in_array($role, $request->roles)) {
                    $user->removeRole($role);
                }
            }
        }

        $user->save();
        return $this->redirect();
    }

    /**
     * Show delete confirmation for user
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy($userId)
    {
        $user = User::find($userId);

        return view('user.confirm_destroy')->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $user = Auth::user();
        $userToDelete = User::find($userId);
        if($user->hasRole('siteAdmin') || ($user->hasRole('orgAdmin') && $user->organization_id == $userToDelete->organization_id)){
            $userToDelete->delete();
        }
        return $this->redirect();
    }

    private function redirect(){
        $user = Auth::user();
        $route = 'map';
        if($user->hasRole('siteAdmin')){
            $route = 'site_administration';
        } elseif ($user->hasRole('orgAdmin')) {
            $route = 'org_administration';
        }
        return redirect()->route($route);
    }
}

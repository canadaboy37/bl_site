<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use App\User;

class RelationshipsController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('relationships.index', compact('users'));
    }

    public function user($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function logInAs($id)
    {
        $user = User::findOrFail($id);

        // Remember who the user really is, but only if it's not already saved in the session.
        // We don't want to overwrite it if they've already logged in as someone else!!
        if(!Session::has('whoAmI'))
            Session::put('whoAmI', Auth::user()->id);

        // Login as the selected user
        Auth::login($user);

        return redirect('account');
    }

    public function logInAsMe()
    {
        $user = User::findOrFail(Session::get('whoAmI'));
        Auth::login($user);
        Session::forget('whoAmI');
        return redirect('account');
    }

    public function recentActivity($id)
    {
        $user = User::findOrFail($id);
        $activity = $user->getRecentActivity();
        return $activity;
    }

    public function follow($id)
    {
        if (!Auth::user()->following->contains($id))
            Auth::user()->following()->attach($id);

        return response()->json([ 'id' => $id], 200);
    }

    public function unfollow($id)
    {
        if (Auth::user()->following->contains($id))
            Auth::user()->following()->detach($id);

        return response()->json([ 'id' => $id], 200);
    }

    public function followAll()
    {
        foreach (User::all() as $user)
        {
            $this->follow($user->id);
        }
    }

    public function unfollowAll()
    {
        foreach (User::all() as $user)
        {
            $this->unfollow($user->id);
        }
    }
}
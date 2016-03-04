<?php
namespace App\Http\Controllers;

use App\User;

class DealerAdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('relationships.index', compact('users'));
    }
}
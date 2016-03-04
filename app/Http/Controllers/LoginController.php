<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 8/5/2015
 * Time: 11:15 AM
 */

namespace App\Http\Controllers;


class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login()
    {

    }
}
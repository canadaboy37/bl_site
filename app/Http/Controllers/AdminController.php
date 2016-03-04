<?php namespace App\Http\Controllers;

use App\Lib\Utilities\ImportManager;
use App\Models\Dealer;

class AdminController extends Controller
{
    public function dealers()
    {
        $dealers = Dealer::all();
        return view('admin.dealers', compact('dealers'));
    }

    public function import()
    {
        $importManager = new ImportManager();
        $importManager->runImport();
    }
}
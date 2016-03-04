<?php namespace App\Lib\Utilities;

use App\Models\Dealer;
Use Session;

class ImportManager {

    public function runImport() {
        // Remove dealer_id from the session if it exists
        Session::forget('dealerId');

        foreach (Dealer::all() as $dealer)
        {
            $dealer->runImporter();
        }
    }
}
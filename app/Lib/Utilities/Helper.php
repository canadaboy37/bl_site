<?php namespace App\Lib\Utilities;

use Auth;
use Session;
use App\Models\Dealer;
use App\Repositories\Erp\ErpFactory;

class Helper {
    public static function getDealer() {
        return Dealer::findOrFail(session('dealerId'));
    }

    public static function erpFromAuthenticatedUser() {
        $account = Auth::user()->account;
        $dealer = $dealer = Dealer::findOrFail(session('dealerId'));
        return ErpFactory::createErpRepository($dealer, $account);
    }

    /**
     * Sort Statements primarily by date and secondarily by transaction number
     */
    protected static function sortStatements($a ,$b) {
        // Order statements

        if ($a['transactionDate'] > $b['transactionDate']) {
            return -1;
        } elseif  ($a['transactionDate'] < $b['transactionDate']) {
            return 1;
        } else {
            return strcmp($b['transactionNumber'], $a['transactionNumber']);
        }
    }
}
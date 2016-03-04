<?php namespace App\Repositories\Erp;

class ErpFactory {

    public static function createErpRepository($dealer, $account = null) {
        $settings = unserialize($dealer->erp_settings);

        switch($dealer->type)
        {
            case 'Epicor':
            default:
                if ($account) {
                    return new EpicorErp ($settings['socket_host'], $settings['socket_port'], $account->name, $account->password, $account->code);
                }
                else {
                    // TODO: move dealer API account credentials to dealer settings
                    return new EpicorErp ($settings['socket_host'], $settings['socket_port'], "BrightonHomes", "builderlinksn", "1BRIGH");
                }

                break;
        }

    }

}
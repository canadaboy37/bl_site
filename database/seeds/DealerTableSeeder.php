<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dealer;

class DealerTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('dealers')->delete();

        // Franklin Building Supply
        $erpSettings = array(
            'socket_host'=>'ssl://209.63.122.132',
            'socket_port'=>19500
        );

        /*if (\App::isLocal()) {
            $socketHost = 'ssl://209.63.122.132'; // TODO: find out dev server ip if there is one still
            $socketPort = 19500;
        } else {
            $socketHost = 'ssl://209.63.122.132';
            $socketPort = 19500;
        }*/

        $dealer1 = new Dealer;
        $dealer1->name = 'Franklin Building Supply';
        $dealer1->short_name = 'angela';
        $dealer1->color1 = '#007cc2';
        $dealer1->color2 = '#005b8f';
        $dealer1->product_folder_name = 'Products';
        $dealer1->erp_type = 'Epicor';
        $dealer1->erp_settings = serialize($erpSettings);
        $dealer1->save();

        /*$dealer2 = new Dealer;
        $dealer2->name = 'Franklin Building Supply';
        $dealer2->short_name = 'franklin';
        $dealer2->color1 = '#007cc2';
        $dealer2->color2 = '#005b8f';
        $dealer2->product_folder_name = 'Products';
        $dealer2->erp_type = 'Epicor';
        $dealer2->erp_settings = serialize($erpSettings);
        $dealer2->save();*/

        $dealer3 = new Dealer;
        $dealer3->name = 'Franklin Building Supply';
        $dealer3->short_name = 'newdev';
        $dealer3->color1 = '#007cc2';
        $dealer3->color2 = '#005b8f';
        $dealer3->product_folder_name = 'Products';
        $dealer3->erp_type = 'Epicor';
        $dealer3->erp_settings = serialize($erpSettings);
        $dealer3->save();

        $dealer4 = new Dealer;
        $dealer4->name = 'Franklin Building Supply';
        $dealer4->short_name = 'steve';
        $dealer4->color1 = '#007cc2';
        $dealer4->color2 = '#005b8f';
        $dealer4->product_folder_name = 'Products';
        $dealer4->erp_type = 'Epicor';
        $dealer4->erp_settings = serialize($erpSettings);
        $dealer4->save();

        // Yuma Lumber
        /*$erpSettings = array(
            'categories_import_file'=>'/some/path/id/categories.csv',
            'products_import_file'=>'/some/path/id/products.csv'
        );

        $dealer5 = new Dealer;
        $dealer5->name = 'Yuma Lumber';
        $dealer5->short_name = 'yuma';
        $dealer5->color1 = '#007cc2';
        $dealer5->color2 = '#005b8f';
        $dealer5->product_folder_name = 'Products';
        $dealer5->erp_type = 'None';
        $dealer5->erp_settings = serialize($erpSettings);
        $dealer5->save();*/
    }

}

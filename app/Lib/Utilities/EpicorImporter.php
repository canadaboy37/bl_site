<?php  namespace App\Lib\Utilities;

use App\Repositories\Erp\ErpFactory;
use App\Lib\Utilities;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use App\Lib\Enums\PriceTypes;

class EpicorImporter {

    protected $dealer;
    protected $epicorErp;
    protected $majorCatInsertCount = 0;
    protected $minorCatInsertCount = 0;
    protected $productInsertCount = 0;
    protected $categoryCodes = array();
    protected $productCodes = array();

    function __construct($dealer) {
        $this->dealer = $dealer;
        $this->epicorErp = ErpFactory::createErpRepository($dealer);
    }

    public function run() {
        set_time_limit(180); // 3 minutes

        // test the connection to the Epicor server
        if ($this->epicorErp->testConnection() != true) {
            // TODO: log failure
            echo "Can't connect to the Epicor server";
            return;
        }

        $data = $this->getData();
        $this->purgeStaleData();
        $this->insertCategories($data['majorCategories'], $data['minorCategories'], $data['treeCategories']);
        $this->insertProducts($data['products']);
        $this->deleteEmptyCategories();
        $this->sendEmail();

        echo '<br />$this->majorCatInsertCount: ' . "$this->majorCatInsertCount<br />";
        echo '$this->minorCatInsertCount: ' . "$this->minorCatInsertCount<br />";
        echo '$this->productInsertCount: ' . "$this->productInsertCount<br />";
    }

    protected function getData() {
        $data = $this->epicorErp->dataDump();

        // separate the data into each data type
        $majorCategories = array();
        $minorCategories = array();
        $treeCategories = array();
        $products = array();

        foreach ($data as $key => $value) {
            $recordTypeCode = $value[0];

            if($recordTypeCode == "A") {
                $majorCategories[$key] = $value;
            }
            else if($recordTypeCode == "C") {
                $minorCategories[$key] = $value;
            }
            else if($recordTypeCode == "P") {
                $products[$key] = $value;
            }
            else if($recordTypeCode == "T") {
                $treeCategories[$key] = $value;
            }
        }

        return array(
            'majorCategories' => $majorCategories,
            'minorCategories' => $minorCategories,
            'treeCategories' => $treeCategories,
            'products' => $products
        );
    }

    private function purgeStaleData() {
        Product::where('dealer_id', '=', $this->dealer->id)->whereNotIn('sku', $this->productCodes)->delete();
        Category::where('dealer_id', '=', $this->dealer->id)->whereNotIn('code', $this->categoryCodes)->delete();
    }

    private function insertCategories($majorCategories, $minorCategories, $treeCategories) {
        //if A or C records are not available, use T records
        /*if(count($majorCategories) == 0 || count($minorCategories) == 0)
        {
            foreach($treeCategories as $key => $value)
            {
                $category = new Category;

                $category->dealer_id = $this->dealer->id;
                $category->name = $value[4];

                if($value[2] === 'TOP') //major category
                {
                    // add 1 to all imported ids to get around zero id
                    $category->id = $value[1] + 1;
                    // top level categories are assigned a parent id of 0
                    $category->parent_code = 0;

                    $this->majorCatInsertCount++;
                }
                else  //minor category
                {
                    // add 1 to all imported ids to get around zero id
                    $id = $value[1] + 1;
                    $category->parent_code = $value[2] + 1;

                    // since the major and minor id's can be the same,
                    // the minor category will have this format:
                    // 1|$parentId|$id (without pipes)
                    $category->id = "1" . $category->parent_code . $id;

                    $this->minorCatInsertCount++;
                }

                $category->save();
            }
        }
        else
        {*/
            foreach($majorCategories as $key => $value)
            {
                // add 1 to all imported ids to get around zero id
                $code = $value[1] + 1;

                //echo "<br />Major category: $code<br />";

                $category = Category::firstOrNew(array('code' => $code, 'dealer_id' => $this->dealer->id));
                $category->code = $code;
                $category->parent_code = 0;
                $category->dealer_id = $this->dealer->id;
                $category->name = $value[2];
                $category->save();

                $this->categoryCodes[] = $code;
                $this->majorCatInsertCount++;
            }

            foreach($minorCategories as $key => $value)
            {
                // add 1 to all imported ids to get around zero id
                $code = str_replace("'","",$value[1]) + 1; // why do these have an apostrophe?

                //echo "<br />Minor category: $code<br />";

                $category = Category::firstOrNew(array('code' => $code, 'dealer_id' => $this->dealer->id));
                $category->code = $code;
                $category->parent_code = $value[2] + 1;
                $category->dealer_id = $this->dealer->id;
                $category->name = $value[3];

                // since the major and minor id's can be the same,
                // the minor category will have this format:
                // 1|$parentid|$id (without pipes)
                //$category->id = "1". $category->parent_code . $code;

                $category->save();

                $this->categoryCodes[] = $code;
                $this->minorCatInsertCount++;
            }
        /*}*/
    }

    protected function insertProducts($products) {
        foreach($products as $key => $value)
        {
            if ($value[1] == 'FIRST' || $value[1] == 'LASTCODE')
                continue;

            $pum = $value[6];   // pricing unit of measure
            $sum = $value[7];   // selling unit of measure
            $suf = $value[8];   // selling unit factor which converts selling unit into pricing units
            $up = $value[9];    // scaling unit used to extend the item in pricing units

            $product = Product::firstOrNew(array('sku' => $value[1], 'dealer_id' => $this->dealer->id));
            $product->dealer_id = $this->dealer->id;
            $product->sku = $value[1];
            $product->name = $value[2];
            $product->unit = $sum;

            // calculate the extended price
            // extension calculation: (QTY x PRC x SUF) / UP
            // for product import, QTY = 1
            $product->list_price = ($value[4] * $suf) / $up;

            $category = Category::where('name', $value[5])->where('dealer_id', $this->dealer->id)->first();
            if (!$category)
            {
                echo "<br />Couldn't find the category for $product->name<br />";
                continue;
            }
            $category->products()->save($product);

            $this->productCodes[] = $product->sku;
            $this->productInsertCount++;
        }
    }

    protected function deleteEmptyCategories() {
        // TODO: delete records not found in the import
        echo "<br />deleteEmptyCategories not yet implemented<br />";
    }

    protected function sendEmail() {
        echo "<br />sendEmail not yet implemented<br />";
    }
}
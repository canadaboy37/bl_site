<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 8/5/2015
 * Time: 8:23 AM
 */

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $term = $request->term;
        $sort = preg_replace('/\s+/', '_', trim(strtolower($request->sort)));
        $order = trim(strtolower($request->order));

        if ($term)
            $products = Product::where('name', 'LIKE', "%{$term}%");
        else
            $products = Product::limit(30);

        if ($request->category) {
            $category = $request->category;
            if ($category <> "All") {
                $products = $products->whereHas('category', function ($catQuery) use ($category) {
                    $catQuery->where('name', $category);
                });
            }
        }

        if ($sort && $order) {
            $products->orderBy($sort, $order);
        }

        $products = $products->get();

        $dcategories = Category::distinct()->select('parent_code')->get();
        $categories = Category::select('id', 'name')->whereIn('id', $dcategories)->orderBy('name')->get();

        return view('products.index', compact('products'))->with('categories', $categories);
    }

    public function categories() {
        $categories = Category::where('id', 'in' ,'select distinct parent_code from categories');
        return $categories;
    }

    public function product($id)
    {
        $product = Product::findOrFail($id);
        return $product;
        //return view('products.product', compact('product'));
    }

    public function productSearch(Request $request)
    {
        $term = $request->term;
        $products = array();

        $search = Product::select('id', 'name')->where('sku', 'like', "%$term%")
            ->orwhere('name', 'like', "%$term%")
            ->orwhere('description', 'like', "%$term%")
            ->get();

        foreach($search as $results => $product)
        {
            $products[] = array(
                'id' => $product->id,
                'value' => $product->name,
            );
        }

        return json_encode($products);
    }

    public function testDB()
    {
        if(DB::connection()->getDatabaseName())
        {
            echo "connected";
            $results = Category::select('id','name')->get();
           foreach ($results as $result)
               echo ($result->name . "<br>");

            //echo "connected successfully to database ".DB::connection()->getDatabaseName();
        }
    }

    public function displayProducts()
    {

    }
}
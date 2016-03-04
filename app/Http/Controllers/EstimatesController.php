<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 8/5/2015
 * Time: 8:22 AM
 */

namespace App\Http\Controllers;

use Session;
use Auth;
use Illuminate\Http\Request;
use App\Models\Estimate;
use App\Models\EstimateSection;
use App\Models\EstimateDetail;
use App\Models\Product;
use Excel;

class EstimatesController extends Controller
{
    public function index()
    {
        $estimates = $this->getEstimates();
        $estimateDetails = array();
        return view('estimates.index', compact('estimates', 'estimateDetails'));
    }

    public function create(Request $request) {
        $estimate = new Estimate;
        if (empty($request->name)) {
            $data = 'error';
        }
        else {
            $estimate->dealer_id = Session::get('dealerId');
            $estimate->name = $request->name;

            Auth::user()->estimates()->save($estimate);

            $data = 'success';
        }
        return response()->json([ 'success' => true, 'status' => $data, 'estimateId' => $estimate->id ], 200);
    }

    public function createSection(Request $request) {
        $section = new EstimateSection();
        if (empty($request->name)) {
            $data = 'error';
        }
        else {
            $estimate = Estimate::findOrFail($request->estimate);
            $section->dealer_id = Session::get('dealerId');
            $section->name = $request->name;

            $estimate->sections()->save($section);

            $data = 'success';
        }

        return response()->json([ 'success' => true, 'status' => $data, 'sectionId' => $section->id], 200);
    }

    public function getEstimates()
    {
        $estimates = Auth::user()->estimates()->orderBy('name')->get();
        return $estimates;
    }

    public function getSections(Request $request)
    {
        $estimate = Estimate::findOrFail($request->estimateId);
        $sections = $estimate->sections()->orderBy('name')->get();
        return $sections;
    }

    public function addProduct(Request $request)
    {
        // Check that quantity is an integer
        if ((string)(int)$request->quantity !== (string)$request->quantity) {
            $data = 'qtyNonInt';
        }
        else {
            $product = Product::findOrFail($request->productId);

            $estimateDetail = new EstimateDetail();
            $estimateDetail->dealer_id = Session::get('dealerId');
            $estimateDetail->sku = $product->sku;
            $estimateDetail->name = $product->name;
            $estimateDetail->description = $product->description;
            $estimateDetail->unit = $product->unit;
            $estimateDetail->list_price = $product->list_price;
            $estimateDetail->ext_price = $product->list_price * $request->quantity; // TODO: get ext price?
            $estimateDetail->quantity = $request->quantity;
            $estimateDetail->part_class = $request->partClass;

            // Link to estimate
            $estimate = Estimate::findOrFail($request->estimateId);
            $estimateCheck = $estimate->details()->get();
            foreach ($estimateCheck as $result)
            if ($result->sku = $estimateDetail->sku) {

            }

            $estimate->details()->save($estimateDetail);

            // Link to section if selected
            if (!empty($request->sectionId)) {
                $section = EstimateSection::findOrFail($request->sectionId);
                $section->details()->save($estimateDetail);
            }

            $data = 'success';
        }

        return response()->json([ 'success' => true, 'status' => $data], 200);
    }

    public function getEstimateDetails(Request $request) {
        $estimateId = ($request->estimateId) ? $request->estimateId : ' ';
        $estimateTotal = 0;
        if (!empty($request->sectionId) && $request->sectionId != 'all') {
            $section = EstimateSection::findOrFail($request->sectionId);
            $estimateDetails = $section->details()->get();
        }
        else {
            $estimate = Estimate::findOrFail($request->estimateId);
            $estimateDetails = $estimate->details()->get();
        }
        foreach($estimateDetails as $key => $row) {
            $estimateTotal += $row->ext_price;
        }

        return view('estimates.view', compact('estimateDetails'))->with('estimateId', $estimateId)->with('estimateTotal', $estimateTotal);
    }

    public function updateEstimate(Request $request)
    {
        $estimate = Estimate::findOrFail($request->estimateId);
        $estimateDetails = $estimate->details()->get();
        $sku = $request->sku;
        $qty = $request->qty;

        foreach($sku as $key => $value) {
            foreach($estimateDetails as $row => $item) {
                if ($value == $item->sku) {
                    if ($qty[$key] == 0){
                        EstimateDetail::destroy($item->id);
                    } else {
                        $item->quantity = $qty[$key];
                        $item->ext_price = $qty[$key] * $item->list_price;
                    }
                }
            }
            $estimate->details()->saveMany($estimateDetails);
        }
    }

    public function exportEstimate(Request $request)
    {
        $estimate = Estimate::findOrFail($request->id);
        $estimateDetails = $estimate->details()->get();
        Excel::create('export', function($excel) use($estimateDetails) {
            $excel->sheet('Export', function($sheet) use($estimateDetails) {
                $sheet->row(11, array(
                   '', 'SKU', 'Item', 'Qty', 'Unit', 'Price', 'Ext Price'
                ));

                $sheet->setCellValue('E10', 'Estimate Date: ' . Date('m/d/y'));
                $sheet->mergeCells('E10:G10');

                $sheet->cells('B11:G11', function($cells) {
                   $cells->setBackground('#DDDDDD');
                });
                $dataRow = 12;

                foreach($estimateDetails as $key=>$row) {
                    $sheet->setCellValue('B'.$dataRow, $row->sku);
                    $sheet->setCellValue('C'.$dataRow, $row->name);
                    $sheet->setCellValue('D'.$dataRow, $row->quantity);
                    $sheet->setCellValue('E'.$dataRow, $row->unit);
                    $sheet->setCellValue('F'.$dataRow, $row->list_price);
                    $sheet->setCellValue('G'.$dataRow, $row->ext_price);
                    $dataRow++;
                }

                $sheet->setCellValue('F'.($dataRow+1), 'Total');
                $sheet->setCellValue('G'.($dataRow+1), '=sum(G12:G'.($dataRow-1).')');
            });

        })->download('xlsx');

    }

    public function submitEstimate()
    {

    }

    public function deleteEstimate(Request $request)
    {
        if(isset($request->estimateId))
            Estimate::destroy($request->estimateId);
    }
}
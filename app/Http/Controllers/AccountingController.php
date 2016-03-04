<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 8/7/2015
 * Time: 8:52 AM
 */

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Lib\Utilities\Helper;
use PDF;

class AccountingController extends Controller
{
    protected $erp;

    public function __construct()
    {
        $this->erp = Helper::erpFromAuthenticatedUser();
    }

    public function index() {
        return view('index');
    }

    public function invoices()
    {
        return view('transactions');
    }

    public function getDoc(Request $request)
    {
        $jobCode = (isset($request->jobCode) ? $request->jobCode : Auth::user()->account->code);
        $startDate = (isset($request->start) ? $request->start : ' ');
        $endDate = (isset($request->end) ? $request->end : ' ');
        $transactionNumber = (isset($request->transactionNumber) ? trim($request->transactionNumber) : ' ');
        $transactionType = null;
        $filename = "";

        if (isset($request->type))
        {
            switch ($request->type)
            {
                case 'Invoice':
                case 'INV':
                    $transactionType = 'INV';
                    $filename = $jobCode . "-Invoice-" . $transactionNumber . ".pdf";
                    break;
                case 'Order':
                case 'ORD':
                    $transactionType = 'ORD';
                    $filename = $jobCode . "-Order" . ".pdf";
                    break;
                case 'Quote':
                case 'QTE':
                    $transactionType = 'QTE';
                    $filename = $jobCode ."-Quote" . ".pdf";
                    break;
                case 'Statement':
                case 'STM':
                    $transactionType = 'STM';
                    $filename = $jobCode . "-Statement-" . $startDate . ".pdf";
                    break;
                default:
                    $transactionType = null;
                    $filename = "downloaded.pdf";
                    break;
            }
        }
        $data = $this->erp->getImage($jobCode, $transactionType, $startDate, $endDate, $transactionNumber);

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename='.$filename);

        foreach($data as $key=>$value) {
            if ($key != 'Main')
                echo convert_uudecode($value[0]);
        }

    }

    public function statements(Request $request)
    {
        // Get statement periods
        $statementPeriods = $this->erp->ARPeriods();

        if (isset($statementPeriods['Main']))
            unset($statementPeriods['Main']);

        // Remove extra data
        foreach ($statementPeriods as $key => $statementPeriod)
        {
            if ($key !== "Main") //skip Main
            {
                $statementPeriods[$key] = $statementPeriod[0];
            }
        }

        // Get jobs
        $jobs = array();
        $jobsArray = $this->erp->getJobs(Auth::user()->account->code);
        foreach ($jobsArray as $job)
        {
            if(isset($job[2]))
                $jobs[$job[0]] = $job[2];
        }

        // Get statements
        if (isset($request->statementPeriod))
            $usePeriod = $request->statementPeriod;
        else {
            //$usePeriod = $statementPeriods[0];
            $statements = array();
            return view('statements.index', compact('statementPeriods', 'statements'));
        }

        $statementArray =  $this->erp->NewAccountStatement(Auth::user()->account->code, ' ', ' ', $usePeriod);

        // Clean up data
        $statements = array();
        foreach($statementArray as $key => $value)
        {
            if($value[0] == 'HEADER') {
                $jobCode = $value[2];
            }
            else if($key !== 'Main' && $value[0] == 'LINE')
            {
                $statement = array();

                if(isset($jobs[$jobCode]))
                    $statement['job']  = $jobs[$jobCode]; // Match the job code to a job name
                else
                    $statement['job']  = $jobCode; // If a job name is not found, use the job code

                $statement['transactionNumber'] =  $value[2];
                $statement['transactionDate'] =  $value[3];
                $statement['transactionType'] =  $value[4];
                $statement['transactionAmount'] =  $value[5];
                $statement['DiscountDate'] =  $value[6];
                $statement['PaidAmount'] =  $value[7];

                array_push($statements, $statement);
            }
        }

        usort($statements, array($this, 'sortStatements'));

        return view('statements.index', compact('statementPeriods', 'statements'));
    }

    public function statementPrint(Request $request)
    {
        $transaction = $request->selectedStatement;

    }

    public function transactions(Request $request)
    {
        // Quotes, orders, or invoices are selected by the buttons on the Transactions page
        // Use the accountTransaction ERP method for invoices
        // Use ? for quotes
        // Use ? for orders

        // TODO:
        //  Filter by selected transaction type
        //  Data retrieval should be exported to a repository
        //  Sort by transaction date
        //  Quotes, orders, and invoices are all transactions

        $past = date("m/d/Y", strtotime('-1 month'));
        $today = date("m/d/Y");

        if(isset($request->term)) {
            $accountTransactionArray = $this->erp->accountTransaction(Auth::user()->account->code, $request->term, ' ', $past, $today);
        } else {
            $accountTransactionArray = $this->erp->accountTransaction(Auth::user()->account->code, ' ', ' ', $past, $today);
        }

        $transactions = array();

        foreach($accountTransactionArray as $key => $transaction)
        {
            if($key !== "Main" && trim($transaction[0]) != "") //skip Main and empties
            {
                if($transaction[3] !== "Payment") {
                    $data = array();
                    $data['transactionNumber'] = $transaction[4];
                    $data['itemType'] = $transaction[3];
                    $data['transactionDate'] = $transaction[5];
                    $data['orderAmount'] = $transaction[6];
                    $data['jobCode'] = $transaction[2];
                    $data['jobName'] = $transaction[2];
                    array_push($transactions, $data);
                }
            }
        }

        usort($transactions, array($this, 'sortStatements'));

        return view('transactions.index', compact('transactions'));
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

    public function getDetails(Request $request)
    {
        $transaction = $request->id;
        $jobCode = $request->jobcode;
        $customerCode = Auth::user()->account->code;
        $detailsArray = $this->erp->transactionStatusDetail($customerCode, $jobCode, '850', $transaction, " ", null);
        $data = array();
        $data["rows"] = array();
        foreach($detailsArray as $key => $childArray) {
            if($key === "Main")
            {
                $data["companyName"] =  $childArray[22];
                $data["billingAddress"] = $childArray[25];
                $data["jobCode"] = $childArray[23];
                $data["jobName"] = $childArray[24];
                $data["shipToAddress1"] = $childArray[37];
                $data["shipToAddress2"] = $childArray[38];
                $data["shipToCity"] = $childArray[39]; //this is how the spec is, but sample data had city, state, zip all on 39
                $data["shipToState"] = $childArray[40];
                $data["shipToZip"] = $childArray[41];
                $data["tranType"] = $childArray[3];
                $data["tranNum"] = $childArray[2];
                $data["tranDate"] = $childArray[11];
                $data["poNum"] = $childArray[29];
                $data["sales"] = $childArray[28];
                $data["netAmount"] = $childArray[19];
                $data["taxes"] = $childArray[20];
                $data["totalAmount"] = $childArray[16];
            }
            else
            {
                //parse detail rows

                if (count($childArray) > 1) {
                    $rows = array();
                    $rows["sku"] = $childArray[1];
                    $rows["description"] = $childArray[2];
                    $rows["orderQty"] = $childArray[8];
                    $rows["invoiceQty"] = $childArray[10];
                    //list price is ext price / qty
                    $listPrice = ($childArray[10] == 0 ? 0 : ($childArray[17] / $childArray[10]));
                    $rows["price"] = $listPrice;
                    $rows["um"] = $childArray[11];
                    $rows["ext"] = $childArray[17];
                    //$data["rows"] =  $rows;
                    array_push($data["rows"], $rows);
                }
            }
        }

        $returnValue = array("success"=> true, 'main'=>array($data));
        echo json_encode($returnValue);

    }
}
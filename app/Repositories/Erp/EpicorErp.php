<?php namespace App\Repositories\Erp;

// TODO: remove after confirming that memory_limit was set to 512MB in php.ini
ini_set('memory_limit', 512000000);

class EpicorErp implements ErpInterface {

    protected $socketHost;
    protected $socketPort;
    protected $username;
    protected $iNetProUsername;
    protected $iNetProPassword;
    protected $customerCode;

    public function __construct($socketHost, $socketPort, $iNetProUsername, $iNetProPassword, $customerCode) {
        $this->socketHost = $socketHost;
        $this->socketPort = $socketPort;
        $this->iNetProUsername = $iNetProUsername;
        $this->iNetProPassword = $iNetProPassword;
        $this->customerCode = $customerCode;
    }

    public function accountStatus($customerCode, $jobCode) {
        $socketCommand = "AccountStatus|$customerCode| |$jobCode| | ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function accountTransaction($customerCode, $jobCode, $transactionType, $startDate, $endDate) {
        $socketCommand = "AccountTransaction|$customerCode | |$jobCode | | |$transactionType |$startDate |$endDate | | | ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function arPeriods() {
        $socketCommand = "ARPeriods|";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function availableStock($customerCode, $storeNumber, $jobCode, $itemCode) {
        $socketCommand = "AvailableStock|$customerCode|$storeNumber|$jobCode| | |$itemCode| | ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->getSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function createOrderFromEstimate($jobCode,$customerCode,$poNumber,$username,$phone,$shippingCompany,$shippingAddress1,$shippingAddress2,$shippingCity,$shippingState,$shippingZip,$billingCompany,$billingAddress1,$billingAddress2,$billingCity,$billingState,$billingZip,$lines) {
        $socketCommand = ""; // TODO: To be completed when we have a test account or Epicor dev server
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function createOrderFromTransaction($customerCode, $jobCode, $option, $transactionNumber, $username, $phone) {
        $socketCommand = ""; // TODO: To be completed when we have a test account or Epicor dev server
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function creditCheck($customerCode, $jobCode, $orderAmount, $storeNumber) {
        $socketCommand = "CreditCheck|$customerCode|$jobCode|$orderAmount|$storeNumber| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function dataDump() {
        $socketCommand = "DataDump|";
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function deleteUser($customerName, $password, $customerCode) {
        $socketCommand = "DeleteUser|$customerName|$password|$customerCode| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function getImage($customerCode, $transactionType, $startDate, $endDate, $transactionNumber) {
        $socketCommand = "GetImage|$customerCode|$transactionType|$startDate|$endDate|$transactionNumber| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function getJobs($customerCode) {
        $socketCommand = "GetJobs|$customerCode| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function getPrice($jobCode, $customerCode, $items) {
        $socket_command = "";

        foreach($items as $item)
        {
            $socket_command .= "\nGetPrice|$jobCode|$customerCode| | | |".$item['itemCode']."|".$item['qty']."| | | |".$item['orderDate']."|".$item['storeNumber']."|".$item['uom']."|".$item['site'];
        }

        $socketCommand = "AccountStatus|$customerCode| |$jobCode| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->getSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function getType() {
        return "Epicor";
    }

    public function newAccountStatement($customerCode, $jobCode, $storeNumber, $flag) {
        $socketCommand = "NewAccountStatement|$customerCode| |$jobCode|$storeNumber| |$flag| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->getSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function testConnection() {
        $connection = fsockopen($this->socketHost, $this->socketPort, $errno, $errstr, 30);
        if(!$connection){
            Log::info("($errno) $errstr");
            return false;
        } else {
            return true;
        }
    }

    public function transactionStatusDetail($customerCode, $jobCode, $option, $transactionNumber, $transactionType, $storeNumber) {
        $socketCommand = "TransactionStatusDetail|$customerCode| |$jobCode| | |$option|$transactionNumber| |$transactionType|$storeNumber";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function transactionStatusSummary($customerCode, $site, $jobCode, $storeNumber, $transactionNumber, $type, $poNumber, $startDate, $endDate) {
        $socketCommand = "TransactionStatusSummary|$customerCode|$site|$jobCode|$storeNumber| | |$transactionNumber| |$type| |$poNumber| |$startDate| |$endDate| ";
        $socketCommand .= $this->getLoginCommand();
        $output = $this->GetSocketData($socketCommand);
        return $this->parseMultiLineOutput($output);
    }

    public function verifyAccount($user) {
        $results = $this->getJobs(null, null);
        var_dump($results);
    }

    //protected function getLoginCommand($username = null, $password = null, $code = null)
    protected function getLoginCommand()
    {
        /*if (empty($username))
            $username = $this->iNetProUsername;
        if (empty($password))
            $username = $this->iNetProPassword;
        if (empty($code))
            $username = $this->customerCode;*/

        //return "\n\nLogin|$username|$password|$code|";
        return "\n\nLogin|$this->iNetProUsername|$this->iNetProPassword|$this->customerCode|";
    }

    protected function getSocketData($socketCommand) {
        $output = "";
        $connection = fsockopen($this->socketHost, $this->socketPort, $errno, $errstr, 30);

        if(!$connection){
            Log::info("($errno) $errstr");
        } else {
            fwrite($connection, $socketCommand);
            while (!feof($connection))
            {
                $output = $output.fgets($connection, 4096);
            }
            fclose($connection);
        }

        return $output;
    }

    protected function parseMultiLineOutput($output) {
        $rawOutputArray = explode("\n", $output);
        $rawOutputArrayCount = count($rawOutputArray);

        //handle no data
        if($rawOutputArrayCount == 0) {
            return null;
        }

        $outputArray = array("Main" => explode("|", $rawOutputArray[0]));

        //loop through each line item and add it to the array
        for ($i=1; $i<$rawOutputArrayCount; $i++)
        {
            $rowArray = explode("|", $rawOutputArray[$i]);

            if(trim($rowArray[0]) != "") //skip end of file character
            {
                array_push($outputArray, $rowArray);
            }
        }

        return $outputArray;
    }
}
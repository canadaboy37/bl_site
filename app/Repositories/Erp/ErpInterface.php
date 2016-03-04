<?php namespace App\Repositories\Erp;

interface ErpInterface {

    public function accountStatus($customerCode, $jobCode);

    public function accountTransaction($customerCode, $jobCode, $transactionType, $startDate, $endDate);

    public function arPeriods();

    public function availableStock($customerCode, $storeNumber, $jobCode, $itemCode);

    public function createOrderFromEstimate($jobCode,$customerCode,$poNumber,$username,$phone,$shippingCompany,$shippingAddress1,$shippingAddress2,$shippingCity,$shippingState,$shippingZip,$billingCompany,$billingAddress1,$billingAddress2,$billingCity,$billingState,$billingZip,$lines);

    public function createOrderFromTransaction($customerCode, $jobCode, $option, $transactionNumber, $username, $phone);

    public function creditCheck($customerCode, $jobCode, $orderAmount, $storeNumber);

    public function dataDump();

    public function deleteUser($customerName, $password, $customerCode);

    public function getImage($customerCode, $transactionType, $startDate, $endDate, $transactionNumber);

    public function getJobs($customerCode);

    public function getPrice($jobCode, $customerCode, $items);

    public function getType();

    public function newAccountStatement($customerCode, $jobCode, $storeNumber, $flag);

    public function testConnection();

    public function transactionStatusDetail($customerCode, $jobCode, $option, $transactionNumber, $transactionType, $storeNumber);

    public function transactionStatusSummary($customerCode, $site, $jobCode, $storeNumber, $transactionNumber, $type, $poNumber, $startDate, $endDate);

    public function verifyAccount($user);
}
@extends('app')

@section('content')

<main id="main" role="main">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- setting-block -->
                    <section class="invoice-block">
                        <h1> <span class="icon-arrow-left"></span>  invoice 1</h1>
                        <div class="holder">
                            <div class="wrap">
                                <h2>Company </h2>
                                <div class="w">
                                    <div class="col">
                                        <ul class="list">
                                            <li>Date:</li>
                                            <li>Job Code:</li>
                                            <li>Job Name:</li>
                                            <li>Ship To:</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul class="list">
                                            <li>Type:</li>
                                            <li>Trans #:</li>
                                            <li>PO Number:</li>
                                            <li>Sales:</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="wrap">
                                <div class="w">
                                    <div class="col">
                                        <ul class="list">
                                            <li>SKU:</li>
                                            <li>Description:</li>
                                            <li>Order:</li>
                                            <li>Invoiced:</li>
                                            <li>Price:</li>
                                            <li>UM:</li>
                                            <li>Extended:</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul class="list add">
                                            <li>Net Amount:</li>
                                            <li>Taxes:</li>
                                        </ul>
                                        <hr>
                                        <ul class="list">
                                            <li>Total:</li>
                                            <li>Amount:</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-wrap">
                            <a href="#" class="btn btn-default">view</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</main>

@stop

@extends('app')

@section('content')

<main id="main" role="main">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="buttons-holder1">
                        <strong class="title">TRANSACTIONS</strong>

                        <!-- Filter buttons -->
                        <!-- <a href="#" class="btn btn-default">Quotes</a>
                        <a href="#" class="btn btn-primary">Orders</a>
                        <a href="#" class="btn btn-primary">Invoices</a> -->
                    </div>
                    <!-- search-form -->
                    <form action="/transactions" method="GET" class="search-form add">
                        <fieldset>
                            <div class="input-group">
                                <input type="text" name="term" class="form-control" aria-label="..." placeholder="Enter Job Code">
                                <span class="input-group-btn">
                                    <button class="btn btn-default search" type="submit"><span class="icon-ico-search"></span></button>
                                </span>
                            </div><!-- /input-group -->
                        </fieldset>
                    </form>
                    <!-- transactions-quotes-block --><!-- TODO: "change to "transactions-block" -->
                    <section class="transactions-quotes"><!-- TODO: "change to "transactions" -->
                        <h1>Transactions</h1>
                        <div class="head">
                            <div class="job-name">Job Code <i class="icon-triangle-down"></i></div>
                            <div class="number">Transaction Number <i class="icon-triangle-down"></i></div>
                            <div class="date">Date <i class="icon-triangle-down"></i></div>
                            <div class="type">Type <i class="icon-triangle-down"></i></div>
                            <div class="amount">Amount <i class="icon-triangle-down"></i></div>
                        </div>
                        <div class="block">
                            <div class="wrapper jcf-scrollable">

                                @forelse($transactions as $transaction)
                                    <div class="wrap">
                                        <div class="job-name">{{ $transaction['jobCode'] }}</div>
                                        <div class="number" data-label="Transaction Number :">{{ $transaction['transactionNumber'] }}</div>
                                        <div class="date" data-label="Date :">{{ $transaction['transactionDate'] }}</div>
                                        <div class="type" data-label="Type :">{{ $transaction['itemType'] }}</div>
                                        <div class="amount" data-label="Amount :">{{ money_format('%.2n', $transaction['orderAmount']) }}</div>
                                        <a href="#" class="view"><span class="icon-uniE600"></span></a>
                                    </div>
                                @empty
                                    <div class="wrap">No results found</div>
                                @endforelse

                            </div>
                        </div>
                        <input type="hidden" name="selectedTransaction" id="selectedTransaction">
                        <input type="hidden" name="jobCode" id="jobCode">
                    </section>
                    <div class="button-holder">
                        <div class="button-wrap">
                            <a href="#" class="btn btn-default details">View Details</a>
                            <!--<a href="#" class="btn btn-default print">Print List</a>-->
                            <a href="#" class="btn btn-default document">View Document</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@stop

@section('modals')
    <div id="detailsModal" class="fade" style="display: none; position: fixed; top: 50%; left: 25%;">
        <div class="modal-details" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="x-dlg-hd">View Detail</div>
                    <div class="x-dlg-bd">
                        <p id="details-dlg-text" class="document">
                            <div class="left" style="float:left; width: 49%;">
                                <table cellpadding="0" cellspacing="5" border="0">
                                    <tr>
                                        <td class="bold" valign="top">Company:</td>
                                        <td id="detailCompany"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="bold" valign="top">Job Code:</td>
                                        <td id="detailJobCode"></td>
                                    </tr>
                                    <tr>
                                        <td class="bold" valign="top">Job Name:</td>
                                        <td id="detailJobName"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="bold" valign="top">Ship To:</td>
                                        <td id="detailShipTo"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="left" style="float:left; width: 49%;">
                                <table cellpadding="0" cellspacing="5" border="0">
                                    <tr>
                                        <td class="bold" style="width:80px;">Type:</td>
                                        <td id="detailType"></td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Trans #:</td>
                                        <td id="detailTransactionNumber"></td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Date:</td>
                                        <td id="detailTransactionDate"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">PO Number:</td>
                                        <td id="detailPONum"></td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Sales:</td>
                                        <td id="detailSales"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Net Amount:</td>
                                        <td align="right" id="detailNetAmount"></td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Taxes:</td>
                                        <td align="right" style="border-bottom:1px solid Black;" id="detailTaxes"></td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Total Amount:</td>
                                        <td align="right" id="detailTotalAmount"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="clear"></div><br /><br />

                            <table cellpadding="0" cellspacing="5" border="0" width="100%" style="padding-top: 25px;padding-right:15px;">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="bold" colspan="2" align="center" style="border-bottom:1px solid Black">Quantity</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="10%" class="bold">SKU</td>
                                    <td width="30%" class="bold">Description</td>
                                    <td width="10%" class="bold" align="center">Ordered</td>
                                    <td width="10%" class="bold" align="center">Invoiced</td>
                                    <td width="10%" class="bold">Price</td>
                                    <td width="10%" class="bold">UM</td>
                                    <td width="10%" class="bold">Extended</td>
                                </tr>
                            </table>
                            <div style="height:100px;overflow-y:auto;">
                                <table cellpadding="0" cellspacing="5" border="0" width="100%">
                                    <tbody id="tableRows"></tbody>
                                </table>
                            </div>
                        </p>
                    </div>


                    <br/>
                    <div align="right">
                        <a href="#" class="btn btn-default document">View Invoice Image</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> OK </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


@stop

@section('scripts')

    <script type="text/javascript">
        $('.wrap').click(function(event){
            event.preventDefault();
            $('.wrap').css("background-color","").css("color","");
            $(this).css("background-color","#007cc2").css("color","#fff");
            var transactionNumber = $(this).find('.number').text();
            $('#selectedTransaction').val(transactionNumber);
            var jobCode = $(this).find('.job-name').text();
            $('#jobCode').val(jobCode);
        });

        $('.details').click(function(event){
            event.preventDefault();
            var transaction = $('#selectedTransaction').val();
            var jobCode = $('#jobCode').val();
            var url = "/transactions/getDetails?id="+transaction+"&jobcode="+jobCode;
            $.ajax({
               url: url,
               success: function(data) {
                   var obj = $.parseJSON(data || '[]');
                   var details = obj.main[0];

                   $("#detailCompany").html(details.companyName + "<br/>");
                   //should company address really be billing address?
                   var formattedBillingAddress = details.billingAddress.replace(/,/g, "<br/>");
                   $("#detailCompany").append(formattedBillingAddress + "<br/>");
                   $("#detailJobCode").html(details.jobCode);
                   $("#detailJobName").html(details.jobName);
                   var formattedShippingAddress = details.shipToAddress1 + "<br/>";
                   if(details.shipToAddress2 != "")
                   {
                       formattedShippingAddress += details.shipToAddress2 + "<br/>";
                   }
                   formattedShippingAddress += details.shipToCity + ", " + details.shipToState + " " + details.shipToZip;
                   $("#detailShipTo").html(formattedShippingAddress);
                   $("#detailType").html(details.tranType);
                   $("#detailTransactionNumber").html(details.tranNum);
                   $("#detailTransactionDate").html(details.tranDate);
                   $("#detailPONum").html(details.poNum);
                   $("#detailSales").html(details.sales);
                   $("#detailNetAmount").html("$" + details.netAmount);
                   $("#detailTaxes").html("$" + details.taxes);
                   $("#detailTotalAmount").html("$" + details.totalAmount);

                   var itemRows = details.rows;
                   var rowsHtml = "";
                   for (var i = 0; i < itemRows.length; i++)
                   {
                       rowsHtml += "<tr>";

                       var sku = $.trim(itemRows[i]["sku"]);
                       rowsHtml += "<td width='10%'>" + (sku == "DESCRPTN" ? "&nbsp;" : sku) + "</td>";

                       var description = $.trim(itemRows[i]["description"]);
                       rowsHtml += "<td width='30%'>"+description+"</td>";

                       if(sku != '')
                       {
                           var orderQty = $.trim(itemRows[i]["orderQty"]);
                           rowsHtml += "<td width='10%' align='center'>"+orderQty+"</td>";

                           var invoiceQty = $.trim(itemRows[i]["invoiceQty"]);
                           rowsHtml += "<td width='10%' align='center'>"+invoiceQty+"</td>";

                           var price = $.trim(itemRows[i]["price"]);
                           rowsHtml += "<td width='10%'>$"+parseFloat(price).toFixed(2)+"</td>";

                           var um = $.trim(itemRows[i]["um"]);
                           rowsHtml += "<td width='10%'>"+um+"</td>";

                           var ext = $.trim(itemRows[i]["ext"]);
                           rowsHtml += "<td width='10%'>$"+parseFloat(ext).toFixed(2)+"</td>";
                       }
                       else
                       {
                           rowsHtml += "<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>";
                       }


                       rowsHtml += "</tr>";
                   }

                   $("#tableRows").html(rowsHtml);

                   $('#detailsModal').modal('toggle');

               }
            });

        });

        $('.print').click(function(event){
            event.preventDefault();
            var transaction = $('#selectedTransaction');
            if (transaction.val() == "")
                alert('Please select a transaction.');
            else
                alert(transaction.val());
        });

        $('.document').click(function(event){
            event.preventDefault();
            var transaction = $('#selectedTransaction');
            var jobCode = $('#jobCode').val();
            if (transaction.val() == "")
                alert('Please select a transaction.');
            else
                window.location.href = '/transactions/getDoc?jobCode='+jobCode+'&type=INV&transactionNumber='+transaction.val();
        });
    </script>

@stop

@extends('app')

@section('content')

<main id="main" role="main" xmlns="http://www.w3.org/1999/html">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form class="filter" action="#">
                        <fieldset>
                            {{ csrf_field() }}
                            <div class="select-holder">
                                <strong class="title" style="max-width: none;">Choose a Statement Period</strong> <!-- TODO: Move style to a stylesheet -->
                                <div class="col hidden-xs">
                                    <select name="statementPeriod" id="statementPeriod" title="Statement Periods" class="selectStatementPeriod">
                                        <option>Choose...</option>
                                        @foreach($statementPeriods as $statementPeriod)
                                            @if(isset($_REQUEST['statementPeriod']) && ($statementPeriod == $_REQUEST['statementPeriod']))
                                                <option selected>{{ $statementPeriod }}</option>
                                            @else
                                                <option>{{ $statementPeriod }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <div class="button-wrap">
                                        <a href="#" class="btn btn-default period">View</a>
                                        <a href="#" class="btn btn-default statement">View Statement Image</a>
                                    </div>
                                </div>
                            </div>
                            <!-- transactions-quotes-block --><!-- TODO: change to statements-block -->
                            <section class="statement-quotes"><!-- TODO: change to statements -->
                                <div class="head">
                                    <!-- TODO: add a gear symbol column for info dialog and the Print Details and View Document Image buttons -->
                                    <div class="job-name">Job Name <i class="icon-triangle-down"></i></div>
                                    <div class="number">Transaction Number <i class="icon-triangle-down"></i></div>
                                    <div class="date">Date <i class="icon-triangle-down"></i></div>
                                    <div class="type">Type <i class="icon-triangle-down"></i></div>
                                    <div class="amount">Amount <i class="icon-triangle-down"></i></div>
                                    <div class="discount-date">Discount date <i class="icon-triangle-down"></i></div>
                                </div>
                                <div class="block">
                                    <div class="wrapper jcf-scrollable">
                                        @forelse($statements as $statement)
                                            <div class="wrap">
                                                <div class="job-name">{{ $statement['job'] }}</div>
                                                <div class="number" data-label="Transaction Number :">{{ $statement['transactionNumber'] }}</div>
                                                <div class="date" data-label="Date :">{{ $statement['transactionDate'] }}</div>
                                                <div class="type" data-label="Type :">{{ $statement['transactionType'] }}</div>
                                                <div class="amount" data-label="Amount :">{{ money_format('%.2n', $statement['transactionAmount']) }}</div>
                                                <div class="discount-date" data-label="Discount date :">{{ $statement['DiscountDate'] }}</div>
                                                <a href="#" class="view"><span class="icon-uniE600"></span></a>
                                            </div>
                                        @empty
                                            <div class="wrap">No results found</div>
                                        @endforelse
                                    </div>
                                </div>
                            </section>
                            <input type="hidden" name="selectedStatement" id="selectedStatement" value="">
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="button-holder">
                <div class="button-wrap">
                    <a href="#" class="btn btn-default print">Print Details</a>
                    <a href="#" class="btn btn-default document">View Document Image</a>
                </div>
            </div>
        </div>
    </section>
</main>

@stop

@section('scripts')

    <script type="text/javascript">
        $('.wrap').click(function(event){
           event.preventDefault();
            $('.wrap').css("background-color","").css("color","");
            $(this).css("background-color","#007cc2").css("color","#fff");
           var transactionNumber = $(this).find('.number').text();
            $('#selectedStatement').val(transactionNumber);
        });

        $('.period').click(function(event){
           event.preventDefault();
            $('form').attr('action', '/statements').attr('method', 'post').submit();

        });

        $('.print').click(function(event){
           event.preventDefault();
            if ($('#selectedStatement').val() == "")
                alert('Please select a transaction.');
            else
                alert($('#selectedStatement').val());
        });

        $('.statement').click(function(event){
           event.preventDefault();
            var selectedDate = $('#statementPeriod :selected').text();
            window.location.href = '/statements/getDoc?type=STM&start='+selectedDate+'&end='+selectedDate;
        });

        $('.document').click(function(event){
           event.preventDefault();
            if ($('#selectedStatement').val() == "")
                alert('Please select a transaction.');
            else
                window.location.href = '/statements/getDoc?type=INV&transactionNumber='+$('#selectedStatement').val();
        });
    </script>

@stop

@extends('app')

@section('content')

<main id="main" role="main">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <h1 class="hidden-xs">MY ACCOUNT </h1>
                <div class="col-md-6">
                    @if(Session::get('erpType') != 'None')
                        <!-- account-block -->
                        @include('account.balance')

                        <!-- statement-block -->
                        @include('account.statements')
                    @endif

                    <!-- estimates-block -->
                    @include('account.estimates')

                </div>
                <div class="col-md-6">
                    @if(Session::get('erpType') != 'None')
                        <!-- chart-block -->
                        @include('account.credit')
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@stop

@extends('app')

@section('content')
    <!-- contain main informative part of the site -->
    <main id="main" role="main">
        <section class="maincontent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <!-- search-form -->
                        @include('products.search')

                        <!-- product-block -->
                        @include('products.results')

                    </div>
                </div>
            </div>
        </section>
    </main>
@stop

@section('modals')
    @include('includes.modals.addProduct')
    @include('includes.modals.createEstimate')
    @include('includes.modals.createSection')
@stop

@section('scripts')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.autocomplete.js"></script>
    <script type="text/javascript" src="/js/products.js"></script>
@stop

@extends('app')

@section('content')
    <main id="main" role="main">
        <section class="maincontent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- filter -->
                        <form class="filter" action="#">
                            <fieldset>

                                @include('estimates.selectors')

                                <!-- transactions-quotes-block -->

                                <div class="estimate-results">
                                @include('estimates.view')
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop

@section('modals')
    @include('includes.modals.createSection')
@stop

@section('scripts')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.autocomplete.js"></script>
    <script type="text/javascript" src="/js/estimates.js"></script>
@stop

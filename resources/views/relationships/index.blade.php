
@extends('app')

@section('content')

    <main id="main" role="main">
        <section class="maincontent">
            <div class="container">
                <div class="row">
                    <h1>TOOLS FOR MANAGING CUSTOMERS</h1>
                    <div class="col-sm-12">
                        @include('relationships.buttons')

                        @include('relationships.users')
                    </div>
                </div>
            </div>
        </section>
    </main>

@stop

@section('scripts')
    <script type="text/javascript" src="/js/tables.js"></script>
    <script type="text/javascript" src="/js/relationships.js"></script>
@stop




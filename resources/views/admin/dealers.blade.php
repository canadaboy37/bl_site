
@extends('app')

@section('content')

<main id="main" role="main">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <!-- buttons-block -->


                    <!-- dealers-block -->
                    @include('admin.dealers_list')

                </div>
            </div>
        </div>
    </section>
</main>

@stop
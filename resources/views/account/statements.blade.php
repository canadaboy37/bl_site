<div class="statement-block">
    <h2>STATEMENTS</h2>
    <ul class="statementes">
        @foreach (array_slice($statements, 0, 3) as $statement)
            <li>
                <ul>
                    <li>#{{ $statement['transactionNumber'] }}</li>
                    <li class="date"><time datetime="{{ date('d/m/Y', strtotime( $statement['transactionDate'])) }}">{{ date('d/m/Y', strtotime( $statement['transactionDate'])) }}</time></li>
                    <li class="price">{{ money_format('%.2n', $statement['transactionAmount']) }}</li>
                </ul>
            </li>
        @endforeach
    </ul>
    <a href="/statements" class="button-holder"> <span class="btn btn-default">VIEW ALL STATEMENTS <span class="icon-arrow"></span></span><i class="icon-uniE600"></i></a>
</div>

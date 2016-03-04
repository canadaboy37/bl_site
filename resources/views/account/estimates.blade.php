<div class="estimates-block">
    <h2>ESTIMATES</h2>
    <ul class="estimates">
        @foreach ($estimates as $estimate)
            <li>
                <ul>
                    <li>{{ $estimate->name }}</li>
                    <li class="date"><time datetime="{{ date('d/m/Y', strtotime($estimate->created_at)) }}">{{ date('d/m/Y', strtotime($estimate->created_at)) }}</time></li> <!-- TODO: what is the date for? -->
                    <li class="action">open</li> <!-- TODO: keep track of status (open, submitted) -->
                </ul>
            </li>
            @endforeach
    </ul>
    <a href="/estimates" class="button-holder"> <span class="btn btn-default">VIEW ALL ESTIMATES <span class="icon-arrow"></span></span><i class="icon-uniE600"></i></a>
</div>

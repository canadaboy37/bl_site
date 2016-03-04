<section class="dealer-block">
    <h1>DEALERS</h1>
    <div class="head">
        <div class="setting">&nbsp;</div>
        <div class="name">Name <i class="icon-triangle-down"></i></div>
        <div class="short-name">Subdomain <i class="icon-triangle-down"></i></div>
        <div class="erp-type">ERP Type <i class="icon-triangle-down"></i></div>
    </div>
    <div class="block">
    <div class="wrapper jcf-scrollable">
        <ul class="dealer-listing">
            @forelse($dealers as $dealer)
                <li data-label="Dealer">
                    <div class="setting">
                        <a href="#" data-toggle="modal" data-target="#myModal">
                            <i class="icon-setting"></i>
                        </a>
                    </div>
                    <div class="name" data-label="Name :">{{ $dealer->name }}</div>
                    <div class="short-name" data-label="Subdomain :">{{ $dealer->short_name }}</div>
                    <div class="erp-type" data-label="ERP Type :"> {{ $dealer->erp_type  }} </div>
                </li>
            @empty
                <li>No results found</li>
            @endforelse
        </ul>
    </div>
</div>
</section>

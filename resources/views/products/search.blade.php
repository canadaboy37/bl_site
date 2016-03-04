
<form action="/products" method="GET" class="search-form">
    <fieldset>
        <div class="input-group">
            <div class="input-group-btn">
                <button type="button" id="catButton" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">All <span class="icon-triangle-down"></span></button>
                <ul class="dropdown-menu" id="category" role="menu">
                    <li><a href="#" class="catSelect">All</a></li>
                    @foreach ($categories as $category)
                        <li><a href="#" class="catSelect">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
                <input type="hidden" name="category" id="catValue" value="All">
            </div><!-- /btn-group -->
            <input type="text" id="searchBar" name="term" class="form-control" aria-label="...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><span class="icon-ico-search"></span></button>
            </span>
        </div><!-- /input-group -->
    </fieldset>
</form>


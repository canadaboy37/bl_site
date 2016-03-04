<section class="product-block">
    <h1>{{ isset($_REQUEST['category']) ? $_REQUEST['category'] : "ALL PRODUCTS" }}   <small>SHOWING ({{ count($products) }} Result{{ (count($products) > 1 ? "s" : "") }})</small></h1>
    <div class="head">
        <div class="setting">&nbsp;</div>
        <div class="sort sku">SKU <i class="icon-triangle-down"></i></div>
        <div class="sort name">Name <i class="icon-triangle-down"></i></div>
        <div class="sort categories">Category <i class="icon-triangle-down"></i></div>
        <div class="sort price">List Price <i class="icon-triangle-down"></i></div>
        <div class="sort your-price"> Your Price <i class="icon-triangle-down"></i> </div>
        <div class="sort unit">Unit of Measurement <i class="icon-triangle-down"></i></div>
    </div>
    <div class="block">
        <div class="wrapper jcf-scrollable">
            <ul class="product-listing">
                @forelse($products as $product)
                    <li data-label="Product">
                        <div class="setting">
                            <a href="#" class="openModal" data-para1="{{ $product->id }}">
                                <i class="icon-add"></i>
                            </a>
                        </div>
                        <div class="sku" data-label="SKU :">{{ $product->sku }}</div>
                        <div class="name" data-label="Name :">{{ $product->name }}</div>
                        <div class="categories" data-label="Category :">{{ $product->category->name }}</div>
                        <div class="price" data-label="List Price :">{{ money_format('%.2n', $product->list_price) }}</div>
                        <div class="your-price" data-label="Your Price :">{{ money_format('%.2n', $product->yourPrice()) }}</div>
                        <div class="unit" data-label="Unit of Measurement :">{{ $product->unit }}</div>
                    </li>
                @empty
                    <li>No results found</li>
                    @endforelse
            </ul>
        </div>
    </div>
</section>


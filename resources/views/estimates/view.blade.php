<section class="estimate-block">
    <div class="head">
        <div class="qty">QTY <i class="icon-triangle-down"></i></div>
        <div class="sku">SKU <i class="icon-triangle-down"></i></div>
        <div class="name">Name <i class="icon-triangle-down"></i></div>
        <div class="section">Section <i class="icon-triangle-down"></i></div>
        <div class="class">Part Class <i class="icon-triangle-down"></i></div>
        <div class="price">Price <i class="icon-triangle-down"></i></div>
        <div class="ext-price">Ext Price <i class="icon-triangle-down"></i></div>
        <div class="measurement">Unit of Measurement <i class="icon-triangle-down"></i></div>
    </div>
    <div class="block">
        <div class="wrapper jcf-scrollable">
            @if(isset($estimateId))
                <input type="hidden" name="estimateId" id="estimateId" value="{{ $estimateId }}">
            @endif
            @forelse ($estimateDetails as $row)
                <div class="wrap" data-label="Name">
                    <input type="hidden" name="sku[]" value="{{ $row->sku }}">
                    <div class="qty" data-label="QTY :"><input name="qty[]" type="text" value="{{ $row->quantity }}"></div>
                    <div class="sku" data-label="SKU :">{{ $row->sku }}</div>
                    <div class="name" data-label="Name :">{{ $row->name }}</div>
                    <div class="section" data-label="Section :">{{ $row->section_name }}<a href="#" class="edit"><span>edit</span><i class="icon-setting"></i></a></div>
                    <div class="class" data-label="Part Class :">{{ $row->part_class }}</div>
                    <div class="price" data-label="Price :">{{ money_format('%.2n', $row->list_price) }}</div>
                    <div class="ext-price" data-label="Ext Price :">{{ money_format('%.2n', $row->ext_price) }}</div>
                    <div class="measurement"  data-label="Unit of Measurement :">{{ $row->unit }}</div>
                </div>
            @empty
                <div class="wrap template" data-label="Name">
                    <div class="qty" data-label="QTY :"></div>
                    <div class="sku" data-label="SKU :"></div>
                    <div class="name" data-label="Name :"></div>
                    <div class="section" data-label="Section :"></div>
                    <div class="class" data-label="Part Class :"></div>
                    <div class="price" data-label="Price :"></div>
                    <div class="ext-price" data-label="Ext Price :"></div>
                    <div class="measurement"  data-label="Unit of Measurement :"></div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<footer class="estimate-footer">
    @if(isset($estimateTotal))
        <span class="total-cost">ESTIMATE TOTAL   <span>{{ money_format('%.2n', $estimateTotal) }}</span></span>
    @else
        <span class="total-cost">ESTIMATE TOTAL   <span>$0.00</span></span>
    @endif
    <div class="button-group">
        <button id="updateButton" type="button" class="btn btn-default" disabled="disabled">Update</button>
        <button id="exportButton" type="button" class="btn btn-default" disabled="disabled">Export</button>
        <button id="submitToSalespersonButton" type="button" class="btn btn-default" disabled="disabled">Submit to salesperson</button>
        <button id="deleteEstimateButton" type="button" class="btn btn-default" disabled="disabled">Delete estimate</button>
    </div>
</footer>

<div class="select-holder">
    <strong class="title">view</strong>
    <div class="col hidden-xs">
        <select title="Estimate Title" class="select-estimate-or-section" id="estimateSelect">
            <option class="hideme">Estimate Title</option>
            @foreach($estimates as $estimate)
                <option value="{{ $estimate->id }}">{{ $estimate->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <select title="Estimate Section" class="select-estimate-or-section" id="sectionSelect" disabled="disabled">
            <option class="hideme" value="">Estimate Section</option>
            <option value="new">CREATE NEW SECTION</option>
            <option class="hideme" id="showAllSections" value="all">All</option>
        </select>
    </div>
    <button type="reset" class="btn btn-default btn-delete">delete</button>
</div>

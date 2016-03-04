<section class="relationships-block">
    <div class="head">
        <div  class="name">Customer Name <i class="icon-triangle-down"></i></div>
        <div class="company">Company <i class="icon-triangle-down"></i></div>
        <div class="username">Username <i class="icon-triangle-down"></i></div>
        <div class="email">Email <i class="icon-triangle-down"></i></div>
        <div class="phone">Phone <i class="icon-triangle-down"></i></div>
        <div class="following">Following <i class="icon-triangle-down"></i></div>
    </div>
    <div class="block">
        <div class="wrapper jcf-scrollable">

            @forelse($users as $user)
                <div class="wrap" data-id="{{ $user->id }}">
                    <div  class="name" data-label="Customer Name :">{{ $user->name }}</div>
                    <div  class="company" data-label="Company :">Company Name</div>
                    <div  class="username" data-label="Username :">{{ $user->username }}</div>
                    <div  class="email" data-label="Email :">{{ $user->email }}</div>
                    <div  class="phone" data-label="Phone :">{{ $user->phone }}</div>
                    <div  class="following"  data-label="Following :">
                        @if ($user->followed)
                            Yes
                        @else
                            No
                        @endif
                    </div>
                </div>
            @empty
                <li>No results found</li>
            @endforelse
        </div>
    </div>
</section>
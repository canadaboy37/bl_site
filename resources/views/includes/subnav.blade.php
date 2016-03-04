

<nav class="navbar navbar-default">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <a href="#" class="nav-opener"><span>menu</span></a>
    <div class="nav-drop">
        <!-- page logo -->
        <div class="logo"><a href="/"><img src="/images/logo02.png" height="96" width="373" alt="franklin building supply service is our specialty"></a></div>
        <!-- main navigation of the page -->
        <ul class="nav navbar-nav">
            <li><a href="/products">PRODUCTS</a></li>
            <li><a href="/estimates">ESTIMATES</a></li>

            @if(Session::get('erpType') != 'None')
                <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ACCOUNTING</a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="active"><a href="/transactions">TRANSACTIONS</a></li>
                        <li><a href="/statements">STATEMENTS</a></li>
                    </ul>
                </li>
            @endif

            <li><a href="relationships">RELATIONSHIPS</a></li>
        </ul>
    </div>
</nav>

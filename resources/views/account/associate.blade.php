
@extends('app')

@section('content')

<main id="main">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <h1 class="hidden-xs">MY ACCOUNT </h1>
                <div class="col-md-6">
                    <!-- mostactive-block -->
                    <div class="mostactive-block">
                        <h2>MOST ACTIVE</h2>
                        <ul class="active-list">
                            <li>
                                <ul>
                                    <li><strong class="name">User Name</strong>
                                        <span class="company">Company</span>
                                    </li>
                                    <li class="email"><a href="mailto:Name.last@company.com">Name.last@company.com</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li><strong class="name">User Name</strong>
                                        <span class="company">Company</span>
                                    </li>
                                    <li class="email"><a href="mailto:Name.last@company.com">Name.last@company.com</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li><strong class="name">User Name</strong>
                                        <span class="company">Company</span>
                                    </li>
                                    <li class="email"><a href="mailto:Name.last@company.com">Name.last@company.com</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li><strong class="name">User Name</strong>
                                        <span class="company">Company</span>
                                    </li>
                                    <li class="email"><a href="mailto:Name.last@company.com">Name.last@company.com</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li><strong class="name">User Name</strong>
                                        <span class="company">Company</span>
                                    </li>
                                    <li class="email"><a href="mailto:Name.last@company.com">Name.last@company.com</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li><strong class="name">User Name</strong>
                                        <span class="company">Company</span>
                                    </li>
                                    <li class="email"><a href="mailto:Name.last@company.com">Name.last@company.com</a></li>
                                </ul>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-default">VIEW ALL RELATIONSHIPS <span class="icon-arrow"></span></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- activity-block -->
                    <div class="activity-block">
                        <h2>RECENT ACTIVITY</h2>
                        <ul class="activities-list">
                            <li>
                                <ul>
                                    <li>Estimate #1</li>
                                    <li class="date"><time datetime="2015-11-05">05/11/2015</time></li>
                                    <li class="action">open</li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li>Estimate #2</li>
                                    <li class="date"><time datetime="2015-11-05">05/11/2015</time></li>
                                    <li class="action">Submitted</li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li>Estimate #3</li>
                                    <li class="date"><time datetime="2015-11-05">05/11/2015</time></li>
                                    <li class="action">Submitted</li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li>Estimate #4</li>
                                    <li class="date"><time datetime="2015-11-05">05/11/2015</time></li>
                                    <li class="action">Submitted</li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li>Estimate #5</li>
                                    <li class="date"><time datetime="2015-11-05">05/11/2015</time></li>
                                    <li class="action">Submitted</li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li>Estimate #6</li>
                                    <li class="date"><time datetime="2015-11-05">05/11/2015</time></li>
                                    <li class="action">Open</li>
                                </ul>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-default">VIEW ALL INVOICES <span class="icon-arrow"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@stop
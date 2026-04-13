<section class="trade_detais_sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="trade_details_result">
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>
<section class="header_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar_section">
                    <nav class="navbar navbar-expand-lg p-0">

                        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/Logo_v2-03.png')); ?>" />
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ph-list-light"></i>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                            
                            <div class="navbar-nav">
                                <!---<a class="nav-link active" aria-current="page" href="/monthly-ranking">Monthly Ranking</a>--->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Portfolio
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/fund-portfolio">Fund Portfolio</a></li>
                                        <li><a class="dropdown-item" href="/composition-snapshot">Composition Snapshot</a></li>
										<li><a class="dropdown-item" href="/corpus-details">Corpus Details</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Snapshot Report
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/monthly-snapshot">Monthly Snapshot</a></li>
                                        <li><a class="dropdown-item" href="/weekly-snapshot">Weekly Snapshot</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Paathshaala
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/mutual-fund-taxation">Mutual Fund Taxation</a></li>
                                        <li><a class="dropdown-item" href="/mutual-fund-classifications">Mutual Fund Classifications</a></li>
                                        <li><a class="dropdown-item" href="/know-the-ratio">Know The Ratio</a></li>
                                        <li><a class="dropdown-item" href="/thoughts-and-opinion-on-funds">Thoughts and Opinion on Funds</a></li>
                                        <li><a class="dropdown-item" href="/mutual-fund-dictionary">Mutual Fund Dictionary</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Calculator
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/calctest?cal=sip">SIP Planner</a></li>
                                        <li><a class="dropdown-item" href="/calctest?cal=lump">Lumpsum Planner</a></li>
                                        <li><a class="dropdown-item" href="/calctest?cal=retire">Retirement Planner</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('web.calculators')); ?>?tab=risk-tol-eval">Risk Tolerance Evaluator</a></li>
                                        <li><a class="dropdown-item" href="/calctest?cal=inflation">Inflation Calculator</a></li>
										 <li><a class="dropdown-item" href="/calctest?cal=pills-goal1">Goal Planner</a></li>
                                    </ul>
                                </li>
                                <!-----<a class="nav-link" href="/fund-watch">Fund Watch</a>------>
                                <a class="nav-link" href="https://blog.myplexus.com">Money Seriously</a>
								
								<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                       About Us
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/about">About Us</a></li>
                                        <li><a class="dropdown-item" href="/contact">Contact Us</a></li>
                                    </ul>
                                </li>
                                <a class="cta_header_link" href="#askExpert">Ask Experts</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/layout/includes/header.blade.php ENDPATH**/ ?>
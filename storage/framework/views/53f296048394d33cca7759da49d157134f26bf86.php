<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery-validate'); ?> <?php $__env->stopSection(); ?>
<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
	.custom-banner {
		background-image: url('<?php echo e($dataArr['image_path']); ?>');
	}
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>FAQ</h4>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="faq_section section">
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="faq_left_filter">
                    <div class="nav nav-tabs flex-column vertical-tab" id="nav-tab" role="tablist">
                        <button class="nav-link active faq-dot-1" id="nav-living-tab" data-bs-toggle="tab" data-bs-target="#nav-living" type="button" role="tab" aria-controls="nav-living" aria-selected="true">Diversify risk, for potential rewards</button>
                        <button class="nav-link faq-dot-2" id="nav-wardrobe-tab" data-bs-toggle="tab" data-bs-target="#nav-wardrobe" type="button" role="tab" aria-controls="nav-wardrobe" aria-selected="false">Money doesn’t get locked up.It gets invested!</button>
                        <button class="nav-link faq-dot-3" id="nav-modular-tab" data-bs-toggle="tab" data-bs-target="#nav-modular" type="button" role="tab" aria-controls="nav-modular" aria-selected="false">Don’t let money go. Let it grow!</button>
                        <button class="nav-link faq-dot-4" id="nav-bedroom-tab" data-bs-toggle="tab" data-bs-target="#nav-bedroom" type="button" role="tab" aria-controls="nav-bedroom" aria-selected="false">₹ 500 se toh sirf shuruwaat hai</button>
                    </div>
                </div>


                <!-- <div class="faq_left_filter">
                    <li class="single_radio">
                        <input type="radio" id="faq1" />
                        <label for="faq1">Diversify risk, for potential rewards</label>
                    </li>
                    <li class="single_radio">
                        <input type="radio" id="faq2" />
                        <label for="faq2">Money doesn’t get locked up.It gets invested!</label>
                    </li>
                    <li class="single_radio">
                        <input type="radio" id="faq3" />
                        <label for="faq3">Don’t let money go. Let it grow!</label>
                    </li>
                    <li class="single_radio">
                        <input type="radio" id="faq4" />
                        <label for="faq4">₹ 500 se toh sirf shuruwaat hai</label>
                    </li>
                </div> -->
            </div>
            <div class="col-md-12 col-lg-8">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-living" role="tabpanel" aria-labelledby="nav-living-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            What types of mutual funds can I invest in to diversify my risk?
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Investing in a variety of mutual fund schemes is the key to diversifying
                                            your risk. Equity, debt and hybrid funds all offer different levels of risk
                                            and reward. Index funds and sector-specific funds also present opportunities
                                            for diversification.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            How can I diversify my investments for greater rewards?
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Diversifying your investments is the key to achieving greater rewards.
                                            Investing in a variety of mutual funds, such as equity, debt, hybrid and
                                            index funds, will help spread out your risk. You may also consider investing
                                            in sector-specific funds to gain exposure to particular industries or
                                            markets.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            What other factors should I consider when diversifying my investments?
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            When diversifying your investments, it is important to consider the risk associated with each type of fund. Some funds may be more volatile than others, so you need to understand the potential risks and rewards associated with each investment before making a decision.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-wardrobe" role="tabpanel" aria-labelledby="nav-wardrobe-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                            What should be considered when selecting a mutual fund?

                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            When selecting a mutual fund, you should consider the following factors:
                                            past performance, fees and expenses, investment objectives, risks involved,
                                            fund manager's track record and experience, available services and the
                                            fund’s current portfolio.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            What are some of the benefits of investing in mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            One of the biggest benefits of investing in mutual funds is that they
                                            provide diversification. By investing in a variety of stocks, bonds and
                                            other securities, you can spread out risk and increase your chances of
                                            earning a return on your investment.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                            How can i get the best returns with mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            In order to get the best returns with mutual funds, you need to research and
                                            select a fund that is well-suited for your risk tolerance and investment
                                            goals using tools such as our Compare Tool to assess the fund's
                                            performance and risk profile.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-modular" role="tabpanel" aria-labelledby="nav-modular-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                                            What factors should I consider when selecting a mutual fund?
                                        </button>
                                    </h2>
                                    <div id="collapse7" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            When selecting a mutual fund, you should consider the quality of information and material provided by the fund manager, whether the fund has an active or passively managed strategy, and its tax efficiency. It is also important to research past returns and understand how fees can affect your return over time.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                            How does diversification help reduce risk when investing in mutual funds?

                                        </button>
                                    </h2>
                                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Diversification helps to reduce risk by spreading investments among different types of assets, such as stocks and bonds. This strategy can limit losses if one type of asset performs poorly, since the losses are limited to just that sector.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                            What are the tax benefits in mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            The tax benefits of mutual funds depend on the type of fund you invest in. Generally, investments in stocks and bonds are taxed differently depending on the type of security, duration of the investment, and other factors.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-bedroom" role="tabpanel" aria-labelledby="nav-bedroom-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true" aria-controls="collapse10">
                                             Is it a good time to invest in mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse10" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            It depends on multiple factors, such as your current financial situation, the amount of risk you are willing to take, and your long-term goals. Mutual fund investments can be a great option for those who want to diversify their portfolios and seek potential growth opportunities in the stock market.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                           What are the different types of mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual funds are typically categorized into three main categories: equity, bond and money market. Equity funds invest primarily in stocks, while bond funds invest in bonds or other fixed income securities. Money market funds invest in short-term debt instruments such as treasury bills and certificates of deposit (CDs).
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                            How do mutual funds work?
                                        </button>
                                    </h2>
                                    <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual funds pool together money from many investors and use it to purchase a portfolio of assets. The portfolio manager uses the assets to meet the fund's investment objectives, such as growth or income.


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
</section>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/faq.blade.php ENDPATH**/ ?>
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
        .login-banner {
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
                    <h4 class="f-b"><?php echo e($dataArr['title']); ?></h4>
                  
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="sc-team-details-area sc-pt-100 sc-md-pt-80 sc-pb-200 sc-md-pb-150">
    <div class="container">
        <div class="row clearfix">
            <!-- sc-details-social -->
            <div class="sc-details-social col-lg-5 md-mb-50 sal-animate" data-sal="slide-right" data-sal-duration="800">
                <div class="inner-column">
                    <div class="image">
                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/vihangNaik.jpg')); ?>"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >																	

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color">Vihang Naik Fund Manager</h3>
                        <div class="text">quity Investments L&T Investment Management Limited</div>
                    </div>
                    <!-- <div class="social-box">
                        <a href="#"><i class="icon-linkedin-2"></i></a>
                        <a href="#"><i class="icon-twiter"></i></a>
                        <a href="#"><i class="icon-intragram"></i></a>
                        <a href="#"><i class="icon-facebook-2"></i></a>
                    </div> -->
                </div>
            </div>
            <!-- Content Section -->
            <div class="sc-team-content sc-pl-50 sc-md-pl-0 col-lg-7 sc-md-mt-45 sal-animate" data-sal="slide-left" data-sal-duration="800">
                <div class="inner-column">
                    <h2 class="sc-mb-30">Meet The Fund Expert</h2>
                    

                    <div class="team-skill">
                        <h3 class="skill-title sc-mb-45">Interview</h3>
                        
                                <!-- <div class="row">
                                    <div class="col-md-8 offset-md-2 mb-4">
                                        <div class="faq_title text-center">
                                            <h4 data-aos="fade-down" data-aos-duration="1500">Frequently Asked Question</h4>
                                            <p data-aos="fade-down" data-aos-duration="1500">The mutual fund  industry is rife with different types of funds, strategies, and terminology.<br> We are here to help you make sense of it all.</p>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-12  col-lg-12 ">
                                        <div class="faq_inner">
                                            <div class="accordion" id="accordionExample">
                                                
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading1">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                                Were you always interested in fund management or did you have any other aspirations?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        I always liked investing. Deferred gratification comes naturally to me and is quite indispensable in investing.
    
                                                                Experience etc. with past companies:
                                                                    </p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading2">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                Were you always interested in fund management or did you have any other aspirations?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        I started my journey as a sell-side analyst tracking the technology sector. I joined L&T Asset Management in 2012 after it acquired Fidelity’s India business. It had been almost four years since the GFC and equities were not a particularly exciting asset class. Most people were excited about real estate back then as high inflation favored that asset class and people were sitting on huge gains. It was a time when small and midcaps were completely ignored and you could find good companies at single digit PEs. Market leaders in a sector traded at a fraction of their sales and nobody would look at them. We were lucky to invest in a few of those ‘multibaggers’ and create good wealth for our unit holders over the next few years.
                                                                    </p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading3">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                You are a young fund manager. And there are a lot of very young people who want to become fund managers. What would you advise them on their life goals?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Charlie Munger had once remarked, "If Warren Buffett had gone into ballet, no one would have heard of him”. The two pieces of advice I can give young people are:</p>
                                                                        <ul>
                                                                            <li>Figure out your own aptitudes, and</li>
                                                                            <li>Play games where those aptitudes matter</li>
                                                                            <li>These are the simplest ways to enjoy the game and be good at it.</li>
                                                                        </ul> 
                                                                   
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                Honesty and success!!! Are these diametric opposites? How do you reconcile them in your life?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Over the long term, I believe honesty and success go hand in hand. Unless you are honest with yourself and others I don’t think you can have the credibility to be successful.
    
                                                                        On the schemes and markets
                                                                    </p>
                                                                   
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading5">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                                Going forward, are you more hopeful of better days or do you think there are blips in between? And what are the probable causes of the blips?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        I am an optimist and always believe that there will be better days ahead. Markets, however, follow their own pattern of euphoria and depression. The last 13 months have seen Midcap indices rise continuously without a meaningful correction. I believe there are pockets of froth and there are pockets of opportunities. Past experiences have taught us that one can find multibaggers even while indices look expensive.
                                                                    </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading6">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                                                What will be the economic path that we take as a population? Meaning if you were to paint a one year’s picture of the path to normalcy, how will that play?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Over the last year and a half, we have had a difficult situation that necessitated hard choices. We have seen two lockdowns in two years which could have second order effects especially at the bottom of the pyramid. However, history teaches us that human beings are extraordinarily resilient, so we will come out strongly.
                                                                    </p>
                                                                    <p>
                                                                        On the positive front, vaccinations picking up pace could slow down a third wave, if we have one. I am positive on the exports front with the PLI incentives and labor arbitrage, India could become a manufacturing hub for select goods
                                                                    </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading7">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                                What will be the economic path that we take as a population? Meaning if you were to paint a one year’s picture of the path to normalcy, how will that play?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Over the last year and a half, we have had a difficult situation that necessitated hard choices. We have seen two lockdowns in two years which could have second order effects especially at the bottom of the pyramid. However, history teaches us that human beings are extraordinarily resilient, so we will come out strongly.
                                                                    </p>
                                                                    <p>
                                                                        On the positive front, vaccinations picking up pace could slow down a third wave, if we have one. I am positive on the exports front with the PLI incentives and labor arbitrage, India could become a manufacturing hub for select goods
                                                                    </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading8">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                                                When you move from handling one scheme and then move to another, do you wear a different thinking cap or is the process the determinant?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        We have tried to build a process driven organization. Every fund follows its own mandate and chooses the best stocks from our coverage universe which adhere to the fund’s mandate.
                                                                    </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading9">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                                                You are the primary and co fund manager with a number of schemes. Which is the most interesting one and why?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        We have a strategy of having a primary and co-fund manager for each of our schemes. Each of my schemes has a different mandate and hence has different portfolios. So that makes all the schemes interesting to me.
                                                                    </p>
                                                                    <p>
                                                                        One scheme I want to talk about is the L&amp;T Focused Equity Fund. The mandate is to hold less than 30 stocks and take a focused approach. We have chosen to differentiate this fund with its sector exposure. In a market where most of the top stocks today are banks, the fund has chosen not to have banking exposure. The core thesis is that after a prolonged period of market cap creation, every sector attracts excess competition which lowers the sector’s future RoEs. The fund gives a good diversification option for investors to participate in a multicap fund which has differentiated positioning.
                                                                    </p>
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
        </div>
    </div>
</section>
<section class="compare_section section">
    <div class="container">
        <div class="row">
            <div class="single-features-style1-box mb-4">
                <div class="col-md-12 aos-init" data-aos="fade-up" data-aos-duration="1000">
                    <div class="text-box d-block d-sm-flex align-items-center">
                        <h4>Experts Interviews</h4>					
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">		
			
						
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="<?php echo e(asset('themes/frontend/assets/v1/img/sanjayChawla.jpg')); ?>" class="img-fluid">
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="/fund-man-details/sanjay-chawla"><h4>Sanjay Chawla</h4></a>				
					<p>
                        Chief Investment Officer <br>
                        Baroda Asset Management India Limited
                    </p>
                 
                </div>
            </div> 
            			
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="<?php echo e(asset('themes/frontend/assets/v1/img/shridattaBhandwaldar.jpg')); ?>" class="img-fluid">
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="/fund-man-details/shridatta-bhandwaldar"><h4>Shridatta Bhandwaldar</h4></a>				
					<p>
                        Head Equities <br>
                        Canara Robeco Mutual Fund
                    </p>
                 
                </div>
            </div> 
            			
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="<?php echo e(asset('themes/frontend/assets/v1/img/aniruddhaNaha.jpg')); ?>" class="img-fluid">
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="/fund-man-details/aniruddha-naha"><h4>Aniruddha Naha</h4></a>				
					<p>
                        Director & Senior Fund Manager <br>
                        PGIM Investments
                    </p>
                 
                </div>
            </div>  
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="https://www.myplexus.com/storage/media/1645102018-Shreyas-Devalkar.jpg" class="img-fluid">
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="/fund-man-details/shreyas-devalkar"><h4>Shreyas Devalkar</h4></a>				
					<p>
                        Fund Manager <br>
                        Axis Mutual Fund
                    </p>
                 
                </div>
            </div> 
			
               
        </div>
       
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund-man-details.blade.php ENDPATH**/ ?>
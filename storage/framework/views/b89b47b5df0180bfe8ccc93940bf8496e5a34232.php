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
                    <h4 class="f-b">Shreyas Devalkar</h4>
                  
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
                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/shreyasDevalkar.jpg')); ?>"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >																	

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color">Shreyas Devalkar</h3>
                        <div class="text">Fund Manager</div>
                        <div class="text">Axis Mutual Fund</div>
                        
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

                    <p> Shreyas is a Mumbai person through and through with his education and sensibilities totally forged inthe Mumbai milieu.except one major aspect he is an average cricket follower but more of a squash,tennis fan and plays both these when possible.</p>
                    
                    <p> A Graduate degree in Chemical Engineering from UDCT (University of Bombay) and a post graduate in business studies from Jamnalal Bajaj Institute of Management Studies (University of Mumbai), he is a person who knows the train stations very well. </p>
                    
                    <p> A family man he would like to take a vacation more often than he has so far but a vacation that offersopportunities to chill and do nothing and maybe a little bit of adventure. But so far his holidays have been meshed with the days when the markets are closed for a longer span. And on his holiday, he would much rather read a book than watch a movie. And munching on some of his favourite guilty pleasures like chocolates and mithais.</p>

                    <div class="team-skill">
                        <h3 class="skill-title sc-mb-45">Interview</h3>

                                <div class="row">
                                    <div class="col-md-12  col-lg-12 ">
                                        <div class="faq_inner">
                                            <div class="accordion" id="accordionExample">
                                                
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading1">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                                Your evaluation of the economic consequences of the COVID 19 pandemic and how long do you think we would need to get back to normal?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        The crux of the current issue is Social Distancing. Both in terms of the problem as well as the solution.The problem persists because of a disregard for SOCIAL DISTANCING and it will mitigate with more awareness and with SOCIAL DISTANCING. As of now it is a bigger health crisis than an economic crisis but there is every chance, if this persists and takes the upper hand, there will be an economic crisis.The pandemic has remained manageable because of social distancing but the caution made so far should not be thrown away. As the country opens up gradually, we should maintain social distancing asour first and foremost defence.
                                                                    </p>
                                                                   
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading2">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                How and where all do you see the effect of COVID 19 panning out?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        The effects of the pandemic will be in capacity utilization, and I am speaking as an observer and not an expert. Capacity utilization will not only be there in factories and offices but also in many other different places. Primarily, capacity utilization in public places will be constrained. Parks, markets, public amenities all these will have limited usage. Added of course are the other obvious ones like malls,restaurants, movie halls, offices and so on. Commercial real estate would be hit and so also would the individual real estate.
                                                                    </p>
                                                                    <p>
                                                                        There will be a significant impact on consumption. Not only would absolute consumption get affected,but also would the pattern of consumption. The content of consumption would see a high change. And what many people dont talk about the frequency of consumption would be seeing a substantial change.
                                                                    </p>
                                                                    <p>
                                                                        An obvious first casualty is the leisure sector, consisting of hotels, resorts, airlines and other travel options and all entertainment options.As far as the markets are concerned, there would be some sectors taking a big hit while some others will be doing much better. Telecom is the biggest beneficiary and will show improved results. Some others like OTT platforms are also big beneficiaries but there are not many listed entities in the space.
                                                                    </p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading3">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                What is the road to normalcy?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">

                                                                    <p>
                                                                        Nobody can predict the time or the route to normalcy and there are experts looking into it and analyzing trends regularly. There has been and will be disruptions to our lives. Job losses, salary cuts for people and earnings losses for companies. The problem will not go away till a vaccine is made available. The longer the duration the more lasting the consequences there will be.
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
                 	<img src="<?php echo e(asset('themes/frontend/assets/v1/img/vihangNaik.jpg')); ?>" class="img-fluid">
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="/fund-man-details"><h4>Vihang Naik</h4></a>				
					<p>
                        Fund Manager - Equity Investments <br>
                        L&T Investment Management Limited
                    </p>
                 
                </div>
            </div> 
            			
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
			
               
        </div>
       
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/shreyas-devalkar.blade.php ENDPATH**/ ?>
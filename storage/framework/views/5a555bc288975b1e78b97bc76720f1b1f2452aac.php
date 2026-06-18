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
                    <h4 class="f-b">Shridatta Bhandwaldar</h4>
                  
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
                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/shridattaBhandwaldar.jpg')); ?>"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >																	

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color">Shridatta Bhandwaldar</h3>
                        <div class="text">Head Equities</div>
                        <div class="text">Canara Robeco Mutual Fund</div>
                        
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
                    <p>Shridatta Bhandwaldar, popularly called Shri, though not a dyed in the wool Aamchi Mubaikar, has struck deep roots in the city of his choice. But like all, not from the city, he looks for every opportunity to get back to his hometown Aurangabad. A qualified Engineer and a finance professional, he has the company of the charming Suhasini and the lovable kids Ananya and Manas to keep him grounded. The kids share a sporty bond with the money manager dad, who, when he gets the time delves into reading and music.</p>
                    
                    <p>Reading takes precedence (but not the thrillers) but largely books that talk about money management and investment ideas (Why am I not surprised??) and the obvious preference for authors remains the Warren Buffets and Nassim Talebs (why am I not surprised?). Shridatta’s curiosity in human psychology and behavioral dynamics is met by Daniel Kahnemann and options for sharing wealth and charity also line his bookshelf in large numbers. Our man knows his way around the kitchen too and if you drop by, he might rustle you a mean Alu sabji, Aurangabad style. Be nice and he might give you some roti too!!! Cricket was a passion growing up but now it’s Tennis and Roger Federer that he watches and idolizes.</p>
                    
                    <p>A person not in the habit of micro managing or going looking for issues, he is a person who thinks about crossing a bridge once he reaches it and doing so, he has taken some holiday destinations off the usual track. But the one quality that draws him to Shillong, his fave holiday destination, is the serenity and the sublime beauty of the place. Although taking holidays are important, they don’t happen as much as he would wish them.</p>
                    
                    <div class="team-skill">
                        <h3 class="skill-title sc-mb-45">Interview</h3>

                                <div class="row">
                                    <div class="col-md-12  col-lg-12 ">
                                        <div class="faq_inner">
                                            <div class="accordion" id="accordionExample">
                                                
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading1">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                                Were you always interested in fund management or did you have any other aspiration?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>Yes. Started with Equity Research and so it was natural progression in career.</p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading2">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                Can you please tell us a bit about your journey to your current position in Canara Robeco?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>I started as a FM in July’2016, managing three key funds for the organization Viz. Canara Robeco Bluechip, Diversified and Balance Fund. These three funds have done well over last 3-4 years. When there was a possibility, the organization decided to give me this opportunity as a Head of Equity.</p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading3">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                The Canara Robeco Equity schemes overall have shown marked improvement over the last few years. What are you doing differently that has made the improvements?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">

                                                                    <p>
                                                                        The key thing at Canara Robeco has been focus on underlying businesses. Our consistent focus on Business, Management and Valuation (BMV) has helped us to be in relatively good position over period.
                                                                    </p>
                                                                        
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                What is your outlook on gold as an investment?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Gold still has some steam left and the growth in prices is likely to continue for the next two years, till economic activity picks up steam.
                                                                    </p>
                                                                   
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                What is your opinion of Index funds? How are they likely to impact the index components in case of sudden surge of money into them or redemptions out of them?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        I think from Indian perspective there is still long way for Index funds to become meaningful. The core reason why active fund managers have lot of scope to generate alpha in India is, the continuous changes that are happening in the index itself. I think until we reach ~5000 dollar per capita country, this economy, sectors and thus indices will keep evolving and this churn is good for ability to generate active returns against index. Flows will clearly create sudden dislocations in index weights for individual securities.
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

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/shridatta-bhandwaldar.blade.php ENDPATH**/ ?>
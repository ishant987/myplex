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
                    <h4 class="f-b">Sanjay Chawla</h4>
                  
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
                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/sanjayChawla.jpg')); ?>"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >																	

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color">Sanjay Chawla</h3>
                        <div class="text">Chief Investment Officer</div>
                        <div class="text">Baroda Asset Management India Limited</div>
                        
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
                    <p>Sanjay is an out and out Mumbai born and raised person and had his school and college days merrily spent in the city of his birth. Initial school days were full of sports and outdoorsy activities, of which, all I am told, should not be shared here. Suffice to say that if and when his children play hooky and attempt to pull a fast one over the dad, Sanjay would probably first smile to himself before reacting. Having put himself through the rigours of studies growing up with hostel life at BITS Pilani and then again with serious academics while completing his MMS from the University of Bombay, surely he must have gone through it all. A workaholic and in his own words, disturbingly so, he is obsessed with the investments thoughts and ideas even out of the working hours.</p>
                    <p>An ideal Sunday is spent rustling up some goodies in the kitchen and perhaps follow up with a fun outing or a movie. Understandably the rigours of the job does not allow the luxury of quick getaways, which is compounded by the children’s study schedules and co-curricular commitments. However the vacation spent in New Zealand has left a deep impression. Obviously, the pristine landscape and breathtaking beauty of the place ticked all the right boxes. He suggests a drive around holiday with no particular plan to maximize the vacation vibes. Himachal Pradesh has left a similar mark. As for upcoming holidays, “We usually plan our long trip. It is usually well researched. We like to soak up the local culture, local cuisine, read about the people and try to pick up couple of words to converse in local dialect. People debate about whether the destination is more fun or the process of planning is? I say both are important. Even more important is the company that you have!”</p>

                    <div class="team-skill">
                        <h3 class="skill-title sc-mb-45">Interview</h3>

                                <div class="row">
                                    <div class="col-md-12  col-lg-12 ">
                                        <div class="faq_inner">
                                            <div class="accordion" id="accordionExample">
                                                
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading1">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                                How good are you with planning such outings? Or are you more likely to give the job to a professional?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        All our trips are have been planned and executed by us. Usually we divide entire researching and planning amongst ourselves. Then we discuss and take the common factors and execute it ourselves. This way we know what we want. We also leave enough room for unplanned, spur of the moment kind of things.
                                                                    </p>
                                                                    <p>A handy person to have in the kitchen who loves his cake and eating it and making it too, Sanjay loves any food made with care and love. Obviously Thai cuisine that he favours. Who can find fault with that.</p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading2">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                What genre of books do you like and who is your fave author?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>I am voracious reader -work related (investment), fiction and non-fiction. Topics fascinate me now-a-days is: Psychology of Investments and Behavioral Finance. These are topics which was not covered during my college days and I believe they play a very critical part in Investments. I believe Investments is Science and Art. Science part is demand-supply, pricing and number crunching. Art part is how you assimilate that information and assess how they would be interpreted by people at large.</p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading3">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                You have been influenced by:
                                                            </button>
                                                        </h2>
                                                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Two people who have truly inspired me and rounded my personality are Helen Keller and Mother Theresa. Despite all her handicaps, Helen Keller achieved many things which a normal person could not. It is the same in investments- you may not have all resources, but you can still excel through sheer dint of hard work and determination.
                                                                    </p>
                                                                    <p>
                                                                        Mother Theresa inspires me with her caring. The way she went about it doing good, ethically and built a legacy which continues after her also is truly outstanding. That is something that I would like to emulate, build a system that lasts.
                                                                    </p>
                                                                        
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                A truly interesting nugget about the man!!!
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Besides my first love of updating myself on investment world, I have started planting trees. Idea is not just to plant a sapling but to see it grow. So whatever it takes in terms of ensuring adequate nutrients, water and proper care. It has been 3 years now and in next couple of years it should have an impact on the local surrounding.
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

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/sanjay-chawla.blade.php ENDPATH**/ ?>
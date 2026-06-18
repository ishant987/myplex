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
                    <h4 class="f-b">Aniruddha Naha</h4>
                  
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
                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/aniruddhaNaha.jpg')); ?>"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >																	

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color">Aniruddha Naha</h3>
                        <div class="text"> Director & Senior Fund Manager </div>
                        <div class="text">PGIM Investments</div>
                        
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
                    <p> Aniruddha Naha is a Kolkata boy dealing in big money today with the hallowed PGIM India outfit. Living with his wife and two children and mother, his is a story of ticking all the right boxes at the right time. Coming across as a serious person, as most fund managers do, it is only when you start talking out of the books, pun fully intended, that the twinkle in his eyes get you and the little naughty boy growing up emerges. With his student days spent in St. Xaviers Kolkata and followed up with the Delhi University stint, pursuing a Masters in Finance, could it be any different!!</p>
                    
                    <p> I loved the way and I am sure you will too, with the way he answers the candid questions and realize he could be a fun person around when he is not buying/selling his way around. </p>
                    
                    <div class="team-skill">
                        <h3 class="skill-title sc-mb-45">Interview</h3>

                                <div class="row">
                                    <div class="col-md-12  col-lg-12 ">
                                        <div class="faq_inner">
                                            <div class="accordion" id="accordionExample">
                                                
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading1">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                                Can you tell us something crazy stupid you did growing up but that brings a smile many years hence
                                                            </button>
                                                        </h2>
                                                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Quite a few but worth sharing only in person.
                                                                    </p>
                                                                    <p>
                                                                        He loves to spend a Sunday maybe going out for a long drive or maybe cooking up some magic in the kitchen.and why am I not surprised.As for the rest, I am sure you will have a better insight into the man apart from the fund manager person.
                                                                    </p>
                                                                    <p>
                                                                        Are you a micro manager outside of work? Or you let issues reach you before you act on them?
                                                                    </p>
                                                                    <p>
                                                                        I am pretty laid back. Incase I dont need to interfere, very happy to lay back and see things moving on without any interventions.
                                                                    </p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading2">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                What is your best holiday so far? And why?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Kenya and Tanzania. It gave me an opportunity to feel mother Earth in its most primate form. Roam through the safaris in a vehicle with absolutely no connection with modern world, zero Wi-Fi signals over a fortnight is an experience to cherish.
                                                                    </p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading3">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                Do you take frequent holidays or do you wait for taking a long one (both job permitting of course). are they planned or on the spur of the moment?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">

                                                                    <p>
                                                                        We love to travel, so its usually one long holiday and I plan holidays over the weekend, whenever possible
                                                                    </p>
                                                                        
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                Between books-movies.what would you choose? Which hero did or do you worship?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Movies. More than an actor, I look forward to any new film by Quentin Tarantino, which unfortunately are far and few.
                                                                    </p>
                                                                   
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                What genre of books do you like and who is your fave author?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Thrillers.John Grisham
                                                                   </p>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                Top cuisines you prefer and how familiar are you with the kitchen?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Middle Eastern and Continental. You will find me often in the kitchen in my free time
                                                                    </p>
                                                                   
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                Are you a sports buff? What is your favourite sport? Sportsperson?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Like watching Cricket, football and UFC (my response seriously?? UFC And football..wow)
                                                                    </p>
                                                                   
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                What are your other interests and hobbies?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        Travelling, films, cooking
                                                                    </p>
                                                                    <p>
                                                                        Dispensing off with the personal, delving into his investment worldview:
                                                                    </p>                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                As the world (apart from the US) SLOWLY SETTLES DOWN INTO A POST Covid Era where do you think the world has changed from then and now and going forward how do you think the old normal will return?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        The Post Covid scenario is still evolving. The hope of a vaccine in the next 6-18 months will determine the final outcome of the post Covid scenario. It will be fair to assume that, some businesses will take far longer to return back to normal like businesses related to travel, tourism and hospitality.
                                                                    </p>
                                                                    <p>
                                                                        The longer the world works from home, the more comfortable the new normal becomes. This will have an impact on real estate and the office rental space. This space, due to the higher ticket size, will most likely face a lot of disruptions and will lead to a pressure on pricing. The slowdown in the economy creates uncertainty in the job market and will impact the wallets of consumers. In the near future, we foresee an impact on discretionary consumption and the impact will be higher on larger ticket items. Hence, people may continue to buy a TV or AC but the there would be impact on holiday budgets, purchase of personal mobility items.
                                                                    </p>  
                                                                    <p>
                                                                        A large part of normalcy will start happening, once a reasonably priced vaccine is discovered, which could be 12-24 months.
                                                                    </p>                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                What are the biggest learnings in the last 4 months for you?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        As a philosophy, we have always tried to protect the downside by focusing on good businesses with strong operating cashflows (OCF) and strong balance sheets. The last few months in the extreme volatility, we have seen the strength of strong cashflows and balance sheets playing out, where such good businesses continue to outperform. There is no substitute to buying good businesses at reasonable valuations.
                                                                    </p>                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                What are the significant pluses and minuses of the India economy? And what do you think needs immediate intervention and improvement?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        The Indian economy has the demographic dividend curve on its side along with the fact that it is young population which speaks English. Growing incomes can fuel a strong consumption cycle over the next decade. The economy has a strong captive customer base within the country, which would take of the demand side for any business. Whether it is the consumption side or the investment side, there is a large under penetration and lot needs to be done, which itself could drive both the investment cycle and the consumption cycle. The biggest shortfall for the Indian economy happens to be the lack of adequate capital to grow. The financial system is going through a consolidation phase and funding is reaching the overall businesses, which is aggravating the pain in the balance sheets of the SME businesses.
                                                                    </p>
                                                                    <p>
                                                                        India has also lacked investments on the technology front and this is a space where corporates and the government need to focus on, in terms of building self-reliance on indigenous technology.
                                                                    </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                If you were to make one suggestion for the Indian economy, what would it be?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        The government has incentivized setting up new businesses by bringing down the tax rate for new manufacturing units. Easing of the processes of approvals for setting up of new businesses both at a state and central level with regards to approvals can go a long way in converting business plans from the drawing boards to reality.
                                                                    </p>
                                                                    <p>
                                                                        And I ask this question of everyone I meet/talk to for an interview
                                                                    </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading4">
                                                            <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                You have spent close to two decades in the fund management space. What will you advice aspiring fund managers (college kids)?
                                                            </button>
                                                        </h2>
                                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                               
                                                                    <p>
                                                                        There is clearly no set formula for become an aspiring fund manager. The interest must be in studying macro trends, understanding businesses, and looking at their financials. Other than the academics, which is of utmost importance, with a proficiency of reading annual reports and deciphering numbers, students need to build a knack of understanding businesses.
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
                    <a href="https://www.myplexus.com/meet-the-fund-man/shridatta-bhandwaldar"><h4>Shridatta Bhandwaldar</h4></a>				
					<p>
                        Head Equities <br>
                        Canara Robeco Mutual Fund
                    </p>
                 
                </div>
            </div> 
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="<?php echo e(asset('themes/frontend/assets/v1/img/shreyasDevalkar.jpg')); ?>" class="img-fluid">
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

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/aniruddha-naha.blade.php ENDPATH**/ ?>
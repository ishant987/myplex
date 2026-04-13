<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
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
                                            <h4>About myplexus</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <section class="abt_page_section pb-0 pb-md-5 chkr">
                            <div class="container">
                                <div class="row">
									<div class="col-lg-6 order-md-1 col-md-12 mb-md-3">
                                        <div class="abt_right_img_wrapper" data-aos="fade-up" data-aos-duration="1500">
											
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/abt-right-img.jpg')); ?>" class="img-fluid " />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 order-md-2 col-md-12">
                                        <div class="page_abt_inner" data-aos="fade-down" data-aos-duration="1000">
											<h4>The meaning of <span>plexus</span></h4>
                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels
                                                may be blood vessels (veins, apillaries) or lymphatic vessels. The nerves are typically axons
                                                outside the central nervous system.</p>
                                            <p>The financial systems today are a close copy of the network of nerves. Equally complex and
                                                confounding. But myplexus.com is the ordering of this complex into a largely simplified and
                                                understandable one, in the context of the saving and investment instruments.</p>
                                            <p>Source: Wikipedia</p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </section>

                        <section class="page_abt_second_sec"
                            style="background: url(<?php echo e(asset('themes/frontend/assets/v1/img/graph.jpg')); ?>) #010800; background-repeat: no-repeat; background-position: left; background-size: cover">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="second_abt_cont" data-aos="fade-down" data-aos-duration="1000">
                                            <h4>The Various Metrics of Performance is Synthesised into Numbers</h4>
                                            <p>Product life cycles will compress. Variations in performances will manifest itself more
                                                frequently. Risk evaluation will take centre-stage for marking the success or failure of every
                                                financial product or solution.</p>
                                            <p>Unbiased, user defined statistical tools will be the bedrock for understanding performance and
                                                evaluating efficacy of funds and fund managers in delivering returns quantum, providing it
                                                consistently and most specifically managing its various risk factors within manageable levels.
                                            </p>
                                            <p>But where will the technically able as well as the lay person converge to find out all this??
                                                myplexus.com aims to be this platform. Over time, myplexus should be the most preferred option
                                                for the individual, the corporate investor, the fund professional for checking out the fund’s
                                                overview as well as technical details. In a manner that is easy, simple, structured. And
                                                UNBIASED. And USER DEFINED.</p>
                                            <p>And myplexus.com will continue to evolve. With more evaluation tools. Continuously contemporize.
                                                And remain the most relevant.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

<!-- 
                        <section class="our_vision_sec">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2 col-md-12">
                                        <div class="vision_title mb-4 text-center">
                                            <h4 data-aos="fade-down" data-aos-duration="1000">Our Vision</h4>
                                            <p data-aos="fade-down" data-aos-duration="1500">
                                                To be the one-stop platform for the technically able as well as the lay person to have a
                                                comprehensive view of all their financial options, in an easily understandable manner, so that
                                                they can take informed decisions about your finances.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-3" data-aos="fade-down" data-aos-duration="500">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="<?php echo e(asset('themes/frontend/assets/v1/img/vision1.png')); ?>" />
                                            </div>
                                            <h4>Return</h4>
                                            <p>
                                                We help our clients to get the best returns by providing detailed analysis of all investment
                                                opportunities and risk factors involved.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3" data-aos="fade-down" data-aos-duration="1000">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="<?php echo e(asset('themes/frontend/assets/v1/img/vision2.png')); ?>" />
                                            </div>
                                            <h4>Portfolio Allocation</h4>
                                            <p>Over time, as your investment goals change, so should your asset allocation. We can provide you with a personalized asset allocation that is in line with your risk tolerance and investment objectives.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3" data-aos="fade-down" data-aos-duration="1500">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="<?php echo e(asset('themes/frontend/assets/v1/img/vision3.png')); ?>" />
                                            </div>
                                            <h4>Peer Comparison</h4>
                                            <p>
                                                We give you the ability to compare your performance against similar investors and find out where you stand by assessing your investment strategies and making necessary changes.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3" data-aos="fade-down" data-aos-duration="2000">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="<?php echo e(asset('themes/frontend/assets/v1/img/vision4.png')); ?>" />
                                            </div>
                                            <h4>Risk Ratios</h4>
                                            <p>
                                                We provide customized risk ratios for different types of investments, so that you can make
                                                informed decisions about the level of risk you are comfortable with.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> -->

                        <section class="mission_section"
                            style="background-image: url(<?php echo e(asset('themes/frontend/assets/v1/img/mission-bg.jpg')); ?>); background-position: center; background-size: cover; background-repeat: no-repeat">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-lg-5">
                                        <div class="mission_content mission" data-aos="fade-down" data-aos-duration="1500">
                                            <h4>Our Mission</h4>
                                                                                        <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most
                                                of us. However, selections and preferences are still locked in the antiquated time period
                                                returns only.</p>
                                            <p>At myplexus.com we provide multiple statistical parameters, portfolio components and
                                                construction, and time frames to choose to evaluate fund performance. A better understanding
                                                leads to better product choice twhich increases our prosperity and improves our well-being.</p>
                                            <p>In essence, therefore, it is our goal to provide current tools for fund performance evaluation
                                                that will help us in choosing the right savings and investment product in the mutual fund space
                                                to increase our happiness and live a more profound life.</p>
                                            <p>Live better, through research!!!</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-5">
                                        <div class="mission_content" data-aos="fade-down" data-aos-duration="1500">
                                            <h4>Our Vision</h4>
											<p>We, at myplexus.com believe the financial intermediation and personal finance industry in India is going through the fastest evolutionary stage and in the coming days this is only going to become more hectic. Product life cycles will compress. Variations in performances will manifest itself more frequently. Risk evaluation will take centre-stage for marking the success or failure of every financial product or solution.</p>
                                            <p>Unbiased, user defined statistical tools will be the bedrock for understanding performance and evaluating efficacy of funds and fund managers in delivering returns quantum, providing it consistently and most specifically managing its various risk factors within manageable levels.</p>
                                            <p>But where will the technically able as well as the lay person converge to find out all this?? myplexus.com aims to be this platform. Over time, myplexus should be the most preferred option for the individual, the corporate investor, the fund professional for checking out the fund's overview as well as technical details. In a manner that is easy, simple, structured. And UNBIASED. And USER DEFINED.</p>
											<p>And myplexus.com will continue to evolve. With more evaluation tools. Continuously contemporize. And remain the most relevant.</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="abt_meet_our_section section">
                            <div class="container">
                                <div class="row justify-content-center text-center">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="vision_title mb-5">
                                            <h4 data-aos="fade-down" data-aos-duration="1000" class="aos-init aos-animate">Meet Our <span>Team</span></h4>
                                            <p data-aos="fade-down" data-aos-duration="1500" class="aos-init aos-animate">We, at myplexus.com
                                                believe the financial intermediation and personal finance industry in India is going through the
                                                fastest evolutionary stage.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
										
										<div class="meet_team_slider">
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder.jpg')); ?>"/>
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4>Prasunjit</h4>
                                <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                            </div>
                        </div>
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder.jpg')); ?>"/>
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4>Prasunjit</h4>
                                <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                            </div>
                        </div>
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder.jpg')); ?>"/>
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4>Prasunjit</h4>
                                <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                            </div>
                        </div>
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder.jpg')); ?>"/>
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4>Prasunjit</h4>
                                <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                            </div>
                        </div>
                        <div class="single_team">
                            <div class="single_team_wrapper">
                                <div class="single_team_img">
                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder.jpg')); ?>"/>
                                </div>
                                <ul>
                                    <li><a href="#"><i class="ph-facebook-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-twitter-logo"></i></a></li>
                                    <li><a href="#"><i class="ph-instagram-logo"></i></a></li>
                                </ul>
                            </div>
                            <div class="single_team_content">
                                <h4>Prasunjit</h4>
                                <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves.</p>
                            </div>
                        </div>
                    </div>
										
										
                                        
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/about.blade.php ENDPATH**/ ?>
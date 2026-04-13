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
<div class="custom-banner no-bg fund-managers-banner">
	<div class="container">
		<?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
		<h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
		<?php endif; ?>
	</div>
</div>
<section class="inner_banner_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="inner_section_banner">
					<h4>Meet The Fund Man</h4>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="abt_page_section founder_about pb-0">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-12 col-lg-6">
				<div class="abt_right_img_wrapper" data-aos="fade-up" data-aos-duration="1500">
					<img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder.jpg')); ?>" class="img-fluid"/>
				</div>
			</div>
			<div class="col-md-12 col-lg-6">
				<div class="page_abt_inner" data-aos="fade-down" data-aos-duration="1000">
					<h4>Vihang Naik, Fund Manager</h4>
					<h5>Equity Investments,L&T Investment Management Limited</h5>
					<p>Given to enjoying his Sundays with friends, a game of badminton and a book perhaps, he truly looks forward to his vacations and outings. A long one every year and a few short breaks in between, he is best suited for a “where the heart leads, the road follows” kind of vacation where new experiences, people and food are the highlights. Most of these are “off the beaten track and self designed”. A partial book lover with a predictable bias towards Yuval Harari, Tinkle and Suppandi comics and musings of Charlie Munger provides the sustenance for the hunger of his grey cells. He would much rather eat than cook and that too East Asian street food, and watch Lin Dan in tournament playing a delectable game of badminton for it to qualify as a great day spent. Playing poker also figures as a pastime and helping around the house is an avoidable chore.</p>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="interview_sec">
	<div class="container">
		<h4>Interview</h4>
		<div class="interview_text">
			<h5>Q:: Were you always interested in fund management or did you have any other aspirations?</h5>
			<p>I always liked investing. Deferred gratification comes naturally to me and is quite indispensable in investing.</p>
		</div>
		<h6>Experience etc. with past companies:</h6>
		<div class="interview_text">
			<h5>Q:: Were you always interested in fund management or did you have any other aspirations?</h5>
			<p>I started my journey as a sell-side analyst tracking the technology sector. I joined L&T Asset Management in 2012 after it acquired Fidelity’s India business. It had been almost four years since the GFC and equities were not a particularly exciting asset class. Most people were excited about real estate back then as high inflation favored that asset class and people were sitting on huge gains. It was a time when small and midcaps were completely ignored and you could find good companies at single digit PEs. Market leaders in a sector traded at a fraction of their sales and nobody would look at them. We were lucky to invest in a few of those ‘multibaggers’ and create good wealth for our unit holders over the next few years. </p>
		</div>
		<div class="interview_text">
			<h5>Q:: You are a young fund manager. And there are a lot of very young people who want to become
				fund managers. What would you advise them on their life goals?</h5>
			<p>Charlie Munger had once remarked, "If Warren Buffett had gone into ballet, no one would have heard of him”. The two pieces of advice I can give young people are: </p>                
			<p>1) Figure out your own aptitudes, and</p>
			<p>2) Play games where those aptitudes matter </p>                
			<p>These are the simplest ways to enjoy the game and be good at it.</p>
		</div>
		<div class="interview_text">
			<h5>Q:: Honesty and success!!! Are these diametric opposites? How do you reconcile them in your life?</h5>
			<p>Over the long term, I believe honesty and success go hand in hand. Unless you are honest with yourself and others I don’t think you can have the credibility to be successful.</p>
		</div>
		<h6>On the schemes and markets</h6>
		<div class="interview_text">
			<h5>Q:: Going forward, are you more hopeful of better days or do you think there are blips in between? And what are the probable causes of the blips?</h5>
			<p>I am an optimist and always believe that there will be better days ahead. Markets, however, follow their own pattern of euphoria and depression. The last 13 months have seen Midcap indices rise continuously without a meaningful correction. I believe there are pockets of froth and there are pockets of opportunities. Past experiences have taught us that one can find multibaggers even while indices look expensive.</p>
		</div>
		<div class="interview_text">
			<h5>Q: What will be the economic path that we take as a population? Meaning if you were to paint a one year’s picture of the path to normalcy, how will that play</h5>
			<p>Over the last year and a half, we have had a difficult situation that necessitated hard choices. We have seen two lockdowns in two years which could have second order effects especially at the bottom of the pyramid. However, history teaches us that human beings are extraordinarily resilient, so we will come out strongly.</p>
			<p>On the positive front, vaccinations picking up pace could slow down a third wave, if we have one. I am positive on the exports front with the PLI incentives and labor arbitrage, India could become a manufacturing hub for select goods.</p>
		</div>
		<div class="interview_text">
			<h5>Q: When you move from handling one scheme and then move to another, do you wear a different thinking cap or is the process the determinant?</h5>
			<p>We have tried to build a process driven organization. Every fund follows its own mandate and chooses the best stocks from our coverage universe which adhere to the fund’s mandate.</p>
		</div>
		<div class="interview_text">
			<h5>Q: You are the primary and co fund manager with a number of schemes. Which is the most interesting one and why?</h5>
			<p>We have a strategy of having a primary and co-fund manager for each of our schemes. Each of my schemes has a different mandate and hence has different portfolios. So that makes all the schemes interesting to me.</p>
			<p>One scheme I want to talk about is the L&T Focused Equity Fund. The mandate is to hold less than 30 stocks and take a focused approach. We have chosen to differentiate this fund with its sector exposure. In a market where most of the top stocks today are banks, the fund has chosen not to have banking exposure. The core thesis is that after a prolonged period of market cap creation, every sector attracts excess competition which lowers the sector’s future RoEs. The fund gives a good diversification option for investors to participate in a multicap fund which has differentiated positioning.</p>
		</div>
		<p><b>Disclaimer:</b>*Investors should consult their financial advisers if in doubt about whether the product is suitable for them.</p>
		<p><b>Disclaimer:</b>The article (including market views expressed herein) is for general information only and does not have regard to specific investment objectives, financial situation and the particular needs of any specific person who may receive this information. The article provides general information and comparisons made (if any) are only for illustration purposes. Investments in mutual funds and secondary markets inherently involve risks and recipients should consult their legal, tax and financial advisors before investing. Recipients of this document should understand that statements made herein regarding future prospects may not be realized. Recipients should also understand that any reference to the indices/ sectors/ securities/ schemes etc. in the article is only for illustration purpose and are NOT stock recommendation(s) from the author or L&T Investment Management Limited, the asset management company of L&T Mutual Fund (“the Fund”) or any of its associates. Any performance information shown refers to the past and should not be seen as an indication of future returns. The value of investments and any income from them can go down as well as up. The distribution of the article in certain jurisdictions may be restricted or totally prohibited and accordingly, persons who come into possession of the article are required to inform themselves about, and to observe, any such restrictions.</p>
		<h6>Mutual Fund investments are subject to market risks, read all scheme related documents carefully.</h6>            
	</div>
</section>
<section class="recent_interview">
	<div class="container">
		<h4>Recent Interviews</h4>                 
		<div class="recent_interview_slider">
			<div class="slider_inerr">
				<div class="inter_seen">
					<div class="inter_seen_img">
					<img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder_1.jpg')); ?>" alt=""/>
						</div>
					<h5>Sanjay Chawla</h5>
					<p>Fund Manager - Equity Investments</p>
					<p>L&T Investment Management Limited</p>
				</div>
			</div>
			<div class="slider_inerr">
				<div class="inter_seen">
					<div class="inter_seen_img">
					<img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder_2.jpg')); ?>" alt=""/>
					</div>
					<h5>Shridatta Bhandwaldar</h5>
					<p>Head Equities</p>
					<p>Canara Robeco Mutual Fund</p>
				</div>
			</div>
			<div class="slider_inerr">
				<div class="inter_seen">
					<div class="inter_seen_img">
					<img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder_3.jpg')); ?>" alt=""/>
					</div>
					<h5>Aniruddha Naha</h5>
					<p>Director & Senior Fund Manager</p>
					<p>PGIM Investments</p>
				</div>
			</div>
			<div class="slider_inerr">
				<div class="inter_seen">
					<div class="inter_seen_img">
					<img src="<?php echo e(asset('themes/frontend/assets/v1/img/founder_4.jpg')); ?>" alt=""/>
					</div>
					<h5>Shreyas Devalkar</h5>
					<p>Fund Manager</p>
					<p>Axis Mutual Fund</p>
				</div>
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/founder.blade.php ENDPATH**/ ?>
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
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/jquery-bar-rating-master/dist/themes/fontawesome-stars.css')); ?>">
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
                    <h4 class="f-b"><?php echo e($dataArr['title']); ?></h4>
                  
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="pentatech_section section">
    <div class="custom-banner no-bg the-news-banner">
        <div class="container">
            <div class="col-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="pentatech_filter_title m-3">
                        <h4>Stay Updated With MyPlexus Insights</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="news-listing">
        <div class="container">
            <div class="row" id="news">                
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
	
$(document).ready(function() {

	showNews();

});
	
	async function showNews()
	{			
		const url = 'https://myplexus.com/api/v1/news';
		
		const data = await $.ajax({			
		  type: 'GET',
          url: url,          
          dataType: "JSON"		
		});
		
		if(data.success)
		{
			let html = "";
			
			for(var i=0; i<data.data.length; i++)
			{
				html += '<div class="col-lg-4 col-md-6 col-sm-12">';
                html += '<div class="new-listing-wrapper">';
                html += '<div class="news-listing-img">';
				html += '<a href="'+data.data[i].news_source_link+'" target="_blank">';
			html +=  '<img src="https://myplexus.com/storage/news/'+data.data[i].image+'" alt="'+data.data[i].title+'" class="img-fluid" />';
				html += '</a>';				
				html += '</div>';
				html += '<div class="new-lisiting-title">';
				html += '<a href="'+data.data[i].news_source_link+'" target="_blank">';
				html +=  data.data[i].title;
				html += '</a>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
			}
			
			$('#news').html();
			$('#news').html(html);
			
			console.log(html);
			
		} else {
			
		}
	}

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/in-the-news.blade.php ENDPATH**/ ?>
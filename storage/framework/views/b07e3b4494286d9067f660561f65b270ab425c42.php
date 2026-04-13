<?php $__env->startSection('select2'); ?> <?php $__env->stopSection(); ?>
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
<div class="custom-banner no-bg ask-question-banner">
  <div class="container">
    <?php if($dataArr['descp']): ?>
    <h1 class="f-b"><?php echo $dataArr['descp']; ?></h1>
    <?php endif; ?>
  </div>
</div>

<div class="ask-expert-main">
  <div class="ask-expert-sec">
    <div class="container">
      <h3><?php echo $dataArr['title']; ?></h3>
      <div class="ask-expert-cols">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_60'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_60']['value']).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_60']['value']).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if(isset($dataArr['custom_fields']['text_61'])): ?>
            <p><?php echo nl2br($dataArr['custom_fields']['text_61']['value']); ?></p>
            <?php endif; ?>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_62'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_62']['value']).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_62']['value']).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if(isset($dataArr['custom_fields']['text_63'])): ?>
            <p><?php echo nl2br($dataArr['custom_fields']['text_63']['value']); ?></p>
            <?php endif; ?>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_64'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_64']['value']).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_64']['value']).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if(isset($dataArr['custom_fields']['text_65'])): ?>
            <p><?php echo nl2br($dataArr['custom_fields']['text_65']['value']); ?></p>
            <?php endif; ?>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <?php if(isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_66'])): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_66']['value']).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'] . $dataArr['custom_fields']['image_66']['value']).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if(isset($dataArr['custom_fields']['text_67'])): ?>
            <p><?php echo nl2br($dataArr['custom_fields']['text_67']['value']); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="ask-expert-form select2-styles">
        <form name="quesForm" id="quesForm" action="<?php echo e(route('web.ask-question.save')); ?>" method="post" class="quesForm" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.hidden','data' => ['name' => 'recaptcha_v3','id' => 'recaptcha_v3']]); ?>
<?php $component->withName('form.field.hidden'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'recaptcha_v3','id' => 'recaptcha_v3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

          <div class="ask-expert-topic common-top<?php echo e($errors->first('aet_id')?' has-danger':''); ?>">
            <label><?php echo e(__('askexpert.topic_txt')); ?><sup class="asterisk">*</sup></label>
            <div class="col-12 px-0">
              <select class="js-example-placeholder-single js-states form-control" name="aet_id" id="aet_id">
                <option value=""><?php echo e(__('web.def_drop_optn_txt')); ?></option>
                <?php $__currentLoopData = $topicsModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->aet_id); ?>"><?php echo e($value->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>
          <div class="ask-expert-question common-top other_title<?php echo e($errors->first('title')?' has-danger':''); ?>">
            <div class="col-12 px-0">
              <label><?php echo e(__('askexpert.topic_other_txt')); ?><sup class="asterisk">*</sup></label>
              <input type="text" id="title" name="title" class="br-5 box-shadow" value="<?php echo e(old('title')); ?>">
            </div>
          </div>

          <div class="ask-expert-question common-top<?php echo e($errors->first('question')?' has-danger':''); ?>">
            <div class="col-12 px-0">
              <label><?php echo e(__('askexpert.question_txt')); ?><sup class="asterisk">*</sup></label>
              <textarea id="question" name="question" rows="10" class="br-5 box-shadow"><?php echo e(old('question')); ?></textarea>
            </div>
          </div>

          <div class="ask-expert-picture">

            <div class="col-12 px-0 common-top<?php echo e($errors->first('question')?' has-danger':''); ?>">
              <h6><?php echo e(__('askexpert.pictures_txt')); ?></h6>
              <label><?php echo e(__('askexpert.picture1_txt')); ?></label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-2 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-2">No file chosen...</div>
                      <input type="file" name="picture1" id="picture1" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <span class="message"><?php echo e(__('askexpert.picture_info_txt')); ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 px-0 common-top<?php echo e($errors->first('question')?' has-danger':''); ?>">
              <label><?php echo e(__('askexpert.picture2_txt')); ?></label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-3 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-3">No file chosen...</div>
                      <input type="file" name="picture2" id="picture2" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <span class="message"><?php echo e(__('askexpert.picture_info_txt')); ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 px-0 common-top<?php echo e($errors->first('question')?' has-danger':''); ?>">
              <label><?php echo e(__('askexpert.picture3_txt')); ?></label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-4 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-4">No file chosen...</div>
                      <input type="file" name="picture3" id="picture3" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <span class="message"><?php echo e(__('askexpert.picture_info_txt')); ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="ask-expert-picture ask-expert-video<?php echo e($errors->first('video_type')?' has-danger':''); ?>">
              <div class="col-12 px-0 common-top">
                <h6><?php echo e(__('askexpert.video_txt')); ?></h6>
                <label><?php echo e(__('askexpert.video_type_txt')); ?></label>
                <div class="register-analysis-bottom">
                  <div class="col-12 px-0">
                    <select class="js-example-placeholder-single js-states form-control" name="video_type" id="video_type">
                      <option value=""><?php echo e(__('web.def_drop_optn_txt')); ?></option>
                      <option value="<?php echo e($defDataArr['video_types']['value']['0']); ?>"><?php echo e($defDataArr['video_types']['text']['l']); ?></option>
                      <option value="<?php echo e($defDataArr['video_types']['value']['1']); ?>"><?php echo e($defDataArr['video_types']['text']['y']); ?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 px-0 common-top video_type local_video<?php echo e($errors->first('local_video')?' has-danger':''); ?>">
              <label><?php echo e(__('askexpert.local_file_txt')); ?><sup class="asterisk">*</sup></label>
              <div class="register-analysis-bottom">
                <div class="col-12 register-analysis-file px-0">
                  <div class="file-upload">
                    <div class="file-upload-select-cm file-upload-select-5 box-shadow br-5">
                      <div class="file-select-button">Browse</div>
                      <div class="file-select-name-5">No file chosen...</div>
                      <input type="file" name="local_video" id="local_video" accept="video/mp4">
                    </div>
                    <span class="message"><?php echo e(__('askexpert.local_video_info_txt')); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="ask-expert-question common-top video_type yt_video<?php echo e($errors->first('yt_video')?' has-danger':''); ?>">
              <div class="col-12 px-0">
                <label><?php echo e(__('askexpert.yt_share_link_text')); ?><sup class="asterisk">*</sup></label>
                <input type="text" id="yt_video" name="yt_video" class="br-5 box-shadow" value="<?php echo e(old('yt_video')); ?>">
                <span class="message"><?php echo e(__('askexpert.yt_share_info_txt')); ?></span>
              </div>
            </div>

          </div>

          <div class="ask-expert-submit">
            <input type="submit" id="ask-expert-submit" name="askQstBtn" value="<?php echo e(__('askexpert.ask_question_txt')); ?>" id="ask-expert-submit" />
          </div>

        </form>
        
        <?php if(session()->has('alert')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
        
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  $('#aet_id').select2({
    placeholder: "Please Select"
  });

  let fileInput2 = document.getElementById("picture1");
  let fileSelect2 = document.getElementsByClassName("file-upload-select-2")[0];
  fileSelect2.onclick = function() {
    fileInput2.click();
  }
  fileInput2.onchange = function() {
    let filename2 = fileInput2.files[0].name;
    let selectName2 = document.getElementsByClassName("file-select-name-2")[0];
    selectName2.innerText = filename2;
  }

  let fileInput3 = document.getElementById("picture2");
  let fileSelect3 = document.getElementsByClassName("file-upload-select-3")[0];
  fileSelect3.onclick = function() {
    fileInput3.click();
  }
  fileInput3.onchange = function() {
    let filename3 = fileInput3.files[0].name;
    let selectName3 = document.getElementsByClassName("file-select-name-3")[0];
    selectName3.innerText = filename3;
  }

  let fileInput4 = document.getElementById("picture3");
  let fileSelect4 = document.getElementsByClassName("file-upload-select-4")[0];
  fileSelect4.onclick = function() {
    fileInput4.click();
  }
  fileInput4.onchange = function() {
    let filename4 = fileInput4.files[0].name;
    let selectName4 = document.getElementsByClassName("file-select-name-4")[0];
    selectName4.innerText = filename4;
  }

  let fileInput5 = document.getElementById("local_video");
  let fileSelect5 = document.getElementsByClassName("file-upload-select-5")[0];
  fileSelect5.onclick = function() {
    fileInput5.click();
  }
  fileInput5.onchange = function() {
    let filename5 = fileInput5.files[0].name;
    let selectName5 = document.getElementsByClassName("file-select-name-5")[0];
    selectName5.innerText = filename5;
  }

  $(function() {
    $('.other_title').hide();
    $('.video_type').hide();

    $("#aet_id").change(function() {
      var val = $(this).val();
      if (val != "" && val == "<?php echo e($defDataArr['other_aet_id']); ?>") {
        $('.other_title').show();
      } else {
        $('.other_title').hide();
      }
    });

    $("#video_type").change(function() {
      var val = $(this).val();
      $('.video_type').hide();
      if (val != "" && val == "<?php echo e($defDataArr['video_types']['value']['0']); ?>") {
        $('.local_video').show();
      }
      if (val != "" && val == "<?php echo e($defDataArr['video_types']['value']['1']); ?>") {
        $('.yt_video').show();
      }
    });

    $("#quesForm").validate({
        rules: {
          aet_id: {
            required: true
          },
          title: {
            required: true
          },
          question: {
            required: true
          },
          picture1: {
            accept: "image/*",
            extension: "jpg|jpeg|png"
          },
          picture2: {
            accept: "image/*",
            extension: "jpg|jpeg|png"
          },
          picture3: {
            accept: "image/*",
            extension: "jpg|jpeg|png"
          },
          local_video: {
            required: true,
            accept: "video/*",
            extension: "mp4"
          },
          yt_video: {
            required: true,
            url: true
          }
        },
        messages: {
          aet_id: "<?php echo e(__('web.jq_validate.select_a_txt').strtolower(__('askexpert.topic_txt'))); ?>",
          title: "<?php echo e(__('web.jq_validate.enter_a_txt').strtolower(__('askexpert.topic_txt'))); ?>.",
          question: "<?php echo e(__('web.jq_validate.enter_a_txt').strtolower(__('askexpert.question_txt'))); ?>.",
          picture1: {
            accept: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.picture1_txt'))); ?>",
            extension: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('front.error.img_ext'))); ?>"
          },
          picture2: {
            accept: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.picture2_txt'))); ?>",
            extension: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('front.error.img_ext'))); ?>"
          },
          picture3: {
            accept: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.picture3_txt'))); ?>",
            extension: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('front.error.img_ext'))); ?>"
          },
          local_video: {
            required: "<?php echo e(__('web.jq_validate.enter_a_txt').strtolower(__('askexpert.local_file_txt'))); ?>.",
            accept: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('front.error.vid_ext'))); ?>",
            extension: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('front.error.vid_ext'))); ?>"
          },
          yt_video: {
            required: "<?php echo e(__('web.jq_validate.enter_a_txt').strtolower(__('askexpert.yt_share_link_text'))); ?>.",
            url: "<?php echo e(__('web.jq_validate.enter_valid_txt').strtolower(__('askexpert.yt_share_link_text'))); ?>"
          },
        }
      }),
      $("#ask-expert-submit").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("<?php echo e(Config('commonconstants.recaptcha.site_key')); ?>", {
            action: 'askquestionpage'
          }).then(function(token) {
            var a = $("#quesForm");
            if (1 == a.valid()) {
              // alert(token);
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                $("#quesForm").submit();
              }
            }
          });
        });
      })
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/frontend/pages/ask-question.blade.php ENDPATH**/ ?>
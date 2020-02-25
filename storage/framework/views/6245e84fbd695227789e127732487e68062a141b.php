<?php $__env->startSection('style'); ?>
<link href="<?php echo e(asset('frontend-assets/css/dropzone.css')); ?>" rel="stylesheet">
<style>
.dropzone .dz-preview {
    margin-left: -100px;
}
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
  // print_r($post->id); die;
 ?>
<div class="wrapper">
  <div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
      <div class="container-fluid">
        <div class="navbar-wrapper">
          <div class="navbar-toggle">
            <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
            </button>
          </div>
          <a class="navbar-brand" href="#pablo" style="text-transform:uppercase;"><strong>Edit Post</strong></a><br>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
          <ul class="navbar-nav">
            <li class="nav-item btn-rotate dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <p>
                  <span class="d-lg-none d-md-block">Some Actions</span>
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="<?php echo e(url('dashboard/logout')); ?>">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- <div class="panel-header panel-header-sm">
    </div> -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card" style="width:70%;">
            <!-- <div class="card-header">
              <h4 class="card-title"> Add User</h4>
            </div> -->
            <div class="row" style="margin: 0;">
              <div class="col-md-12">

                <div role="tabpanel">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs nav-justified" role="tablist">

                    <li role="presentation" class="active">
                      <a href="#image" aria-controls="image" role="tab" data-toggle="tab"> <i class="material-icons">add_photo_alternate</i><span>Image & Video</span> </a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="image">
                      <form method="post" action="" enctype="multipart/form-data" id="freelistingForm">
                      <?php echo e(csrf_field()); ?>

                       <div class="form-group">
                          <select name="team" id="teams" class="form-control required" required="required">
                            <?php $__currentLoopData = Feed::teams(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>"<?php if(!empty($post->t_name)) echo ($team->name == $post->t_name) ? 'Selected' : '' ?> ><?php echo e($team->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                          <span class="asterisk"  style="display:none; color:#63c6bd">* Field Required</span>

                      </div>
                       <div class="form-group">
                          <select name="role" id="roles" class="form-control required" required="required">
                            <?php $__currentLoopData = Feed::roles(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->id); ?>"<?php if(!empty($post->p_name)) echo ($post->p_name == $role->name) ? 'Selected' : '' ?> ><?php echo e($role->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                          <span class="asterisk"  style="display:none; color:#63c6bd">* Field Required</span>

                      </div>
                        <div class="form-group">
                          <input type="text" name="post_title" id="title" class="form-control required" placeholder="Title" value="<?php echo e($post->title); ?>">
                          <span class="asterisk"  style="display:none; color:#63c6bd">* Field Required</span>
                        </div>
                        <div class="input-field">
                          <label class="active">Photos & Videos</label>

                        </div>
                        <div class="form-group pull-left" style="margin-top: 211px;">
                            <input type="text" name="file_name_image" class="select-img" id="file_name_image" placeholder="Insert a cover image (mandatory)">
                            <label for="insert-cover">
                              <button class="btn btn-default image-btn">Insert</button>
                            <input type="file" name="cover_image" id="insert-image" onchange="document.getElementById('file_name_image').value = this.value.split('\\').pop().split('/').pop()">
                            </label>
                        </div>

                      </form>
                       <div class="formbody">
                          <img src="<?php echo e(asset('/frontend-assets/gif/loader.gif')); ?>" style="display:none; width: 13%;left: 43%;" class="loader" id="gifid">
                          <div class="form-group">
                            <div class="row" style="display: block;flex-wrap: wrap; margin-right: -15px;margin-left: -15px;">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="dorgz" style="position: relative;height: 300px;">
                                  <form id='frmTarget' name='dropzone' action="<?php echo e(url('/dashboard/edit-post-image/'.$post->id)); ?>" class="dropzone" ><?php echo e(csrf_field()); ?>

                                  </form>
                                  <button type="button " class="btn btn-primary background-blue" id="buttonfree" style="float: right;margin-top: 58px;">Submit</button>
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
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('/frontend-assets/js/dropzone.js')); ?>"></script>
<script>

var post_id = "<?php echo e($post->id); ?>";
// alert(post_id);
Dropzone.options.frmTarget = {
autoProcessQueue: false,
acceptedFiles: ".jpg,.png,.mp4,.mkv,.avi",
parallelUploads: 1,
addRemoveLinks: true,
url: "<?php echo e(url('/dashboard/edit-post-image/')); ?>/"+post_id,
init: function () {

  var myDropzone = this;
  this.on("addedfile", function(file) {

    // Create the remove button
    var removeButton = Dropzone.createElement('<a  href="javascript:undefined;" style="margin-left: 22px;">Remove file</a>');
    var _this = this;

  });
  var proimage=  "<?php echo e($post->image_url); ?>";
  console.log(proimage);

    //  console.log(imgurl);

    //  alert(imgpath);
    var mockFile = { name: proimage, size: 12345 };

    myDropzone.emit("addedfile", mockFile);

    myDropzone.emit("thumbnail", mockFile, proimage);

    myDropzone.createThumbnailFromUrl(
      mockFile,
      function(thumbnail) {


      }
    )



  $("#buttonfree").click(function (e) {
    //alert('hello');

    e.preventDefault();

    $(".asterisk").hide();
    var empty = $(".required").filter(function() { return !this.value; })
    .next(".asterisk").show();
    if(empty.length != 0){
      $("#empty_error").show();
      setTimeout(function () {
        $("#empty_error").hide();
      },5000);
    }
    // var data = $('form#freelistingForm').serializeArray();
    var team = $('#teams').val();
    var role = $('#roles').val();
    var title = $('#title').val();
    console.log(team+'/'+role);
    var frm = $('form#freelistingForm');
    form = new FormData(frm[0]);
    form.append('cover_image', $('#insert-image')[0].files[0]);
    form.append('team', team);
    form.append('role', role);
    form.append('title', title);
    // data.append('cover_image', $('#insert-image')[0].files[0]);
    // data.push({ name: "cover_image", value: $('#insert-image')[0].files[0] });
    console.log(form);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      // url: actionUrl,
      url: "<?php echo e(url('/dashboard/edit-post-image/')); ?>/"+post_id,
      data: form,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
     myDropzone.on('sending', function(file, xhr, formData){
       // for (var i=0; i<form.length; i++){
       //     formData.append(form[i].name, form[i].value);
       // }
       formData.append('cover_image', $('#insert-image')[0].files[0]);
       formData.append('team', team);
       formData.append('role', role);
       formData.append('title', title);
    //formData.append('userName', 'bob');
    console.log(formData);
   });

  myDropzone.processQueue();

  }
  });
  });
  this.on("complete", function (file) {
      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

        window.location.href = "<?php echo e(url('/dashboard')); ?>";

      }
    });

 }
}


  $('.nav-tabs').on('click', 'li', function() {
      $('.nav-tabs li.active').removeClass('active');
      $(this).addClass('active');
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
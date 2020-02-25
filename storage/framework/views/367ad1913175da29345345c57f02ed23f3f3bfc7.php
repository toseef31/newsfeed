
<!DOCTYPE html>
    <html lang="en">
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <head>
      <meta charset="utf-8" />
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('/frontend-assets/dashboard/img/apple-icon.png')); ?>">
      <link rel="icon" type="image/png" href="<?php echo e(asset('/frontend-assets/dashboard/img/favicon.png')); ?>">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>
        Newsfeed Dashboard
      </title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
      <!--     Fonts and icons     -->
      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
      <!-- CSS Files -->

      <link href="<?php echo e(asset('/frontend-assets/dashboard/css/bootstrap.min.css')); ?>" rel="stylesheet" />
      <link href="<?php echo e(asset('/frontend-assets/dashboard/css/paper-dashboard.css?v=2.0.0')); ?>" rel="stylesheet" />
      <!-- CSS Just for demo purpose, don't include it in your project -->
       <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
      <link href="<?php echo e(asset('/frontend-assets/dashboard/css/custom.css')); ?>" rel="stylesheet" />
      <link href="<?php echo e(asset('/frontend-assets/dashboard/css/style.css')); ?>" rel="stylesheet" />
      <link href="<?php echo e(asset('/frontend-assets/dashboard/css/notify.css')); ?>" rel="stylesheet" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
      <link href="http://allfont.net/allfont.css?fonts=roboto-regular" rel="stylesheet" type="text/css" />
      <script src="<?php echo e(asset('/frontend-assets/dashboard/js/core/jquery.min.js')); ?>"></script>
      <script src="<?php echo e(asset('/frontend-assets/dashboard/js/notify.js')); ?>"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <style>
        body {
          font-family: 'Roboto Regular', arial;
        }

      </style>
       <?php echo $__env->yieldContent('style'); ?>
    </head>
  <body>
    <?php echo $__env->make('admin.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- <?php echo $__env->yieldContent('inner-header'); ?> -->

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('admin.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <!--Scroll to top Button-->

    <?php echo $__env->yieldContent('page-footer'); ?>



    <!--   Core JS Files   -->

    <script src="<?php echo e(asset('/frontend-assets/dashboard/js/core/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/frontend-assets/dashboard/js/core/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/frontend-assets/dashboard/js/plugins/perfect-scrollbar.jquery.min.js')); ?>"></script>
    <!--  Google Maps Plugin    -->

    <!-- Chart JS -->
    <script src="<?php echo e(asset('/frontend-assets/dashboard/js/plugins/chartjs.min.js')); ?>"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo e(asset('/frontend-assets/dashboard/js/plugins/bootstrap-notify.js')); ?>"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo e(asset('/frontend-assets/dashboard/js/paper-dashboard.min.js?v=2.0.0')); ?>" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?php echo e(asset('/frontend-assets/dashboard/demo/demo.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
      $(document).ready(function() {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        demo.initChartsPages();
      });
    </script>
    <?php echo $__env->yieldContent('script'); ?>
  </body>
</html>

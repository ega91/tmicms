<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=(!empty($title))?$title .' - ':''?>CMSRiver</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/resources/font-awesome/css/font-awesome.min.css" type="text/css">
    <!-- Font Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo site_url('resources/vendors/nprogress/nprogress.css')?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo site_url('resources/vendors/animate.css/animate.min.css')?>" rel="stylesheet">

    <!-- PNotify -->
    <link href="<?php echo site_url('resources/css/pnotify.custom.min.css')?>" rel="stylesheet">
    <link href="<?php echo site_url('resources/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo site_url('resources/css/custom.css')?>" rel="stylesheet">
    <link href="<?php echo site_url('resources/css/gg.css')?>" rel="stylesheet">

    <?php if (!empty($css)): foreach ($css as $key => $value) {
        echo '<link href="'. $value .'" rel="stylesheet">'; 
    } endif; ?>

  </head>

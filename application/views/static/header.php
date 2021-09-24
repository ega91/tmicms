<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="/resources/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/resources/lightslider/css/lightslider.min.css" rel="stylesheet" type="text/css">

    <?php if( !empty($css)){ foreach ($css as $key => $value){
        echo '<link rel="stylesheet" href="'. $value .'" type="text/css">';
    }} ?>

    <link rel="stylesheet" href="/resources/style/style.css" type="text/css">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#00529e">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <title><?=(!empty($title))?$title .' - ':''?>TMLife - Untuk Layanan Kenyamanan Aktifitas Anda</title>

    <!-- for Google -->
    <meta name="description" 
        content="<?=(!empty($description))?$description:'TMLife - Untuk Layanan Kenyamanan Aktifitas Anda'?>" />
    <meta name="keywords"   content="tmlife, asuransi kesehatan, asuransi jiwa, asuransi, tugu mandiri, asuransi online, <?=(!empty($tags))?', '.$tags:''?>" />
    <meta name="author"     content="TMLife" />
    <meta name="copyright"  content="TMLife" />
    <meta name="application-name" 
        content="TMLife" />


    <!-- for Facebook -->          
    <meta property="og:title"
        content="<?=(!empty($title))?$title.' - ':''?>TMLife" />
    <meta property="og:type"
        content="website" />
    <meta property="og:description"
        content="<?=(!empty($description))?$description:'TMLife - Untuk Layanan Kenyamanan Aktifitas Anda'?>" />
    <meta property="og:url"
        content="https://tmlife.co.id" />
    <meta property="og:image"
        content="<?=(!empty($shareImg))?$shareImg:''?>" />


    <!-- for Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@TMLife">
    <meta name="twitter:title"
        content="<?=(!empty($title))?$title.' - ':''?>TMLife" />
    <meta name="twitter:description"
        content="<?=(!empty($description))?$description:'TMLife - Untuk Layanan Kenyamanan Aktifitas Anda'?>" />
    <meta name="twitter:url"
        content="https://tmlife.co.id" />
    <meta name="twitter:image"
        content="<?=(!empty($shareImg))?$shareImg:''?>" />
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="/"><img src="/resources/img/logo-white.png"></a>
        </div>
        <div class="menu-toggle"><i class="fa fa-bars"></i></div>
        <div class="menu-container">
            <ul>
                <li><a href="header" class="go-section">Home</a></li>
                <li><a href="#info" class="go-section">About</a></li>
                <li><a href="#new-1" class="go-section">Info</a></li>
            </ul>
        </div>
        <div class="social-footer">
            <a href="https://www.facebook.com/tugumandiri" target="_blank" class="sf sf-fb"><i class="fa fa-facebook"></i> <span>Tugu Mandiri</span></a>
            <a href="https://twitter.com/Tugu_Mandiri" target="_blank" class="sf sf-ig"><i class="fa fa-twitter"></i> <span>@Tugu_Mandiri</span></a>
            <a href="https://www.youtube.com/channel/UCsKbw383LyKr3x1NbO4EDbw" target="_blank" class="sf sf-yt"><i class="fa fa-youtube"></i> <span>Official Tugu Mandiri</span></a>
            <a href="http://instagram.com/tugumandiri" target="_blank" class="sf sf-ig"><i class="fa fa-instagram"></i> <span>tugumandiri </span></a>
        </div>
        <div class="clearfix"></div>
    </header>
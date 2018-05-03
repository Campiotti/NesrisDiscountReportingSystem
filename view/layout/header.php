<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.01.2018
 * Time: 17:47
 */
?>
<?php $icoArray = ['w.ico','lego.ico','media.ico','fb.ico','envelope.ico']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>IC System Consumer Help</title>
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo$this->image?><?php echo $icoArray[array_rand($icoArray)]?>">
    <link rel="shortcut icon" href="<?php echo$this->image?><?php echo $icoArray[array_rand($icoArray)]?>" />
    <link rel="stylesheet" href="<?php echo$this->assets?>css/main.css">
    <link rel="stylesheet" href="<?php echo$this->assets?>css/style.css">
    <link rel="stylesheet" href="<?php echo$this->assets?>css/camera.css">
    <link rel="stylesheet" href="<?php echo$this->assets?>css/form.css">
    <script src="<?php echo$this->assets?>js/jquery.js"></script>
    <script src="<?php echo$this->assets?>js/jquery-migrate-1.1.1.js"></script>
    <script src="<?php echo$this->assets?>js/superfish.js"></script>
    <script src="<?php echo$this->assets?>js/jquery.equalheights.js"></script>
    <script src="<?php echo$this->assets?>js/jquery.easing.1.3.js"></script>
    <script src="<?php echo$this->assets?>js/camera.js"></script>
    <script src="<?php echo$this->assets?>js/forms.js"></script>
    <script src="<?php echo$this->assets?>javascript/main.js"></script>
    <script src="<?php echo$this->assets?>javascript/video.js"></script>
    <script src="<?php echo$this->assets?>javascript/general.js"></script>
    <!-- Products Page -->
    <link rel="stylesheet" href="<?php echo$this->assets?>css/touchTouch.css">
    <script src="<?php echo$this->assets?>js/touchTouch.jquery.js"></script>
    <!--\Products Page/-->
    <!--Image Input Dynamic-->
    <!--link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" /-->
    <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></--script-->
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <!--\Image Input Dynamic-->

</head>
<body  style="" class="">
<div id="alertContainer" class="customMessageContainer cNon zLow" style="">
    <div class="customMessageBackground" id="alertBackground"></div>
    <div class="customMessageBox" id="alertBox">
        <div id="alertBoxTitle" class="customMessageTitle"></div><a class="customMessageClose" id="alertBoxClose" onclick="closeMessage()"><img src="https://png.icons8.com/metro/32/000000/close-window.png"></a>
        <div id="alertBoxContent" class="customMessageContent"></div>

    </div>
</div>
<!--==============================header=================================-->
<header>
    <div class="container_12">
        <div class="grid_12">
            <h1><a href="/base/index"><img src="<?php echo$this->image?>ICSystem_Logo.png" alt="Logo" class="logo"></a> </h1>
            <div class="menu_block">
                <nav  class="" >
                    <ul class="sf-menu">
                        <li class="<?php if ($this->headerIndex == 0) echo'current'?>"><a href="/base/index">Home</a></li>
                        <li class="<?php if ($this->headerIndex == 1) echo'current'?>"><a href="/base/about">About</a></li>
                        <!--<li class="<?php if ($this->headerIndex == 2) echo'current'?>"><a href="/video/videos">Videos</a></li>-->
                        <li class="<?php if ($this->headerIndex == 3) echo'current'?>"><a href="/base/partners">Our Partners</a></li>
                        <li class="<?php if ($this->headerIndex == 4) echo'current'?>"><a href="/base/contact">Contact Us</a></li>
                        <li class="<?php if ($this->headerIndex == 5) echo'current'?>"><a href="/user/user">You</a></li>
                        <?php if($this->sessionManager->isSet('User')){ ?>
                        <li class="<?php if ($this->headerIndex == 6) echo'current'?>"><a href="/report/submit">Submit Report</a></li>
                        <!--<li class="<?php if ($this->headerIndex == 7) echo'current'?>"><a href="/video/favourites">Favorites</a></li>-->
                        <?php }?>
                    </ul>
                </nav>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</header>

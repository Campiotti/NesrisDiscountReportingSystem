<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 14.03.2018
 * Time: 19:18
 */
?>
<?php $video =$this->video;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo$video['productname']?></title>
    <link href="<?php echo$this->assets?>css/main.css" rel="stylesheet"/>
    <script src="<?php echo$this->assets?>javascript/video-player.js"></script>
</head>
<?php
$arr = explode(".",$video['video']);
$videoName="";
for($i=0;$i<count($arr) - 1;$i++)
    $videoName .=$arr[$i];
?>
<body>
<div id="video-player">
    <video controls id="video-video">
        <?php //This checks if there are any other versions of the video available and adds them as sources if there are.
        if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."movies/".$videoName.".mp4"))
            echo'<source src="'.$moviePath.$videoName.".mp4".'" type="video/mp4">';
        if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."movies/".$videoName.".ogg"))
            echo'<source src="'.$moviePath.$videoName.".ogg".'" type="video/ogg">';
        if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."movies/".$videoName.".webm"))
            echo'<source src="'.$moviePath.$videoName.".webm".'" type="video/webm">'?>
        Sorry, your browser does not support and of our available video types.
    </video>
    <div id="video-controls"></div>
</div>
</body>
</html>


<!--==============================Content=================================-->
<?php
$videoSourceAvailable=false;
$product = $this->product[0];
$tags = ($this->tag[0]['tagname'] != null) ? $this->tag : null;
$image="https://i.imgur.com/72xjDmY.jpg";
$videoNotAvailable="http://www.techsmyway.com/wp-content/uploads/2018/01/Fix-This-Video-is-not-available-in-your-Country-Error-on-YouTube.png";
$path="$this->image"."products/";
$faved="favourite";
if($this->faved)
    $faved="unfavourite";
if($product['image']!=null)
    $image=$path.$product['image'];
    $video = $this->assets."movies/".$product['video'];
    $moviePath=$this->assets."movies/";
$target_dir =__Dir__."\\..\\..\\..\\".$this->images;
//echo($target_dir);
if(!file_exists($target_dir.$image))
    $image=$target_dir.$image;
$loggedIn=$this->sessionManager->isSet('User');
?>
<?php $view=$product['id'].",0,'".$this->key."'"?>
<?php $arr = explode(".",$product['video']);
$end = $arr[count($arr) - 1];
$videoName="";
//for($i=0;$i<count($arr) - 1;$i++)
$videoName =substr($product['video'],0,(strlen($product['video'])-strlen($end)-1));
?>
<script>
    function dothestuffthing(){
        var video = document.getElementById('video');
        //video.onplay=remVideoInfo('singleVideo','singleVideoInfo','altVideoInfo');
        video.setAttribute("onplay","");
        setTimeout(function () {
            addView(<?php echo$view?>)
        },(video.duration>1200)?600*1000 : video.duration*500);
        //if it's over 20minutes long, it adds the view after 10minutes anyways.
    }
</script>
<div class="content">
  <div class="container_12">
    <div class="grid_12">
      <h3 class="pb1"><span><?php echo($end=="mp3")?'Audio Listening':'Video Viewing'?></span></h3>
        <div class="grid_8" id="singleVideo">
        <?php if($end!="mp3"){?>
            <video controls controlsList="nodownload" poster="<?php echo$image?>" class="img_inner fleft" style="max-height: 100%; max-width: 100%; z-index: 125;"
                   onclick='videoMagic(this);' id="video" onended=""
                   <?php //Notes [onplay:remVideoInfo('singleVideo','singleVideoInfo','altVideoInfo');] [onpause:addVideoInfo('singleVideo','singleVideoInfo','altVideoInfo')]?>
                   ondblclick="fullScreenVideo(this)" onpause="" onplay="dothestuffthing();">
                <?php //This checks if there are any other versions of the video available and adds them as sources if there are.
            if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."movies/".$videoName.".mp4")){
                echo'<source src="'.$moviePath.$videoName.".mp4".'" type="video/mp4">';
                $videoSourceAvailable=true;
            }
            if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."movies/".$videoName.".ogg")){
                echo'<source src="'.$moviePath.$videoName.".ogg".'" type="video/ogg">';
                $videoSourceAvailable=true;
            }
            if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."movies/".$videoName.".webm")){
                echo'<source src="'.$moviePath.$videoName.".webm".'" type="video/webm">';
                $videoSourceAvailable=true;
                }?>
                Sorry, your browser does not support and of our available video types.
            </video>
            <?php }else{?>
                <?php echo'<img src="'.$image.'" alt="audio_thumbnail" class="img_inner fleft">';?>
                <?php if(file_exists(__DIR__."\\..\\..\\..\\".$this->assets."audio/".$videoName.".mp3")){?>
            <audio id="video" controls controlsList="nodownload" class="audio" onplay="dothestuffthing()" style="width: 100%;">
                    <?php
                    echo'<source src="'.$this->assets.'audio/'.$videoName.'.mp3" type="audio/mp3">';
                    $videoSourceAvailable=true;
                    ?>            </audio><?php
                }?>

            <?php }?>
        </div>
      <div class="extra_wrapper" id="singleVideoInfo">
        <div class="title"><?php echo$product['productname']?></div>
      <ul class="list l1">
          <li>Video Uploader: <?php echo$product['username']?></li>
          <li>Views: <span id="views"><?php echo$product['views']?></span></li>
          <li id="favCount">Favourites: <?php echo($product['rating']==null)? "none so far" : $product['rating']?></li>
          <li>
              <div class="sectionTitle">Tags</div>
              <?php if($tags){foreach($tags as $tag){?>
              <div class="tag"><?php echo$tag['tagname'];?></div>
              <?php }}?>
          </li>
          <li>
              <div class="btns">
                  <?php if($loggedIn && $this->owner){?>
                      <button class="btn" onclick="location.href='/video/update/<?php echo$product['id']?>'">Edit Media</button>
                      <button class="btn" onclick="favourite(<?php echo$product['id']?>,this,500);"><?php echo$faved?></button><?php
                  }elseif($loggedIn){?>
                    <button class="btn" onclick="favourite(<?php echo$product['id']?>,this,500);"><?php echo$faved?></button>
                  <?php }else{?>
                  <button class="btn" onclick="location.href='/user/user'">Log in to Favourite</button>
                  <?php }?>
              </div>

          </li>
      </ul>
      </div>
        <div id="altVideoInfo" style="display: none; padding: 0; margin: 0;">
            <h3 class="title"><span><?php echo$product['productname']?></span></h3>
            <h4>Video Uploader: <?php echo$product['username']?></h4>
            <h4>Views: <?php echo$product['views']?></h4>
        </div>
    </div>
      <div class="clear"></div>
      <div class="grid_12">
          <h3 class="head3"><span>Description</span></h3>
      </div>
      <div class="grid_12">
          <p class="description"><?php echo$product['description'];?></p>
      </div>
  </div>
</div>
<div id="darkOverlay" style="display: none; height: 100%;"></div>
<div class="dontLook">
    <script>$(window).ready(function(){
            getFavourites(<?php echo$product['id']?>,"favCount")
        });
    </script>
    <?php if(!$videoSourceAvailable) {?>
    <script>
        videoNotAvailable('video',"<?php echo$videoNotAvailable?>");
    </script>
    <?php }?>
</div>

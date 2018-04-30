<div class="dontLook">
    <script>
        $(document).ready(function(){
            jQuery('#camera_wrap').camera({
                loader: true,
                pagination: false ,
                thumbnails: false,
                height: '32.92857142857143%',
                minHeight: '300',
                caption: false,
                navigation: true,
                fx: 'mosaic'
            });
        });

    </script>
</div>
<?php $arr=[]; $base="$this->image";
//array_push($arr,$base."BlocherTV_White.png");
array_push($arr,$base."Trump.jpg");
array_push($arr,$base."Maintenance[1].png");
array_push($arr,$base."Finesse.jpg")
?>
<div class="slider_wrapper">
    <div id="camera_wrap" class="">
        <?php
            for($camI=0; $camI<count($arr);$camI++){
        ?>
        <div data-src="<?php echo $arr[$camI]?>">
        </div>
        <?php }?>
    </div>
</div>

<!--==============================Content=================================-->

<div class="content">
  <div class="container_12">
    <div class="grid_12">
      <h2>WELCOME TO blocher tv WHERE YOU CAN FIND<span>A RANGE OF HIGH-QUALITY <span class="col1">VIDEOS</span> THAT CAN HELP YOUR LIFE
FLOURISH.</span></h2>
<h3><span>SERVICES</span></h3>
    </div>
    <div class="grid_4">
      <div class="icon">
        <img src="<?php echo$this->images?>icon1.png" alt="">
        <div class="title">WATCHING</div>Here you can watch a wide range of uncensored videos all provided by our userbase!
      </div>
    </div>
    <div class="grid_4">
      <div class="icon">
        <img src="<?php echo$this->images?>icon2.png" alt="">
        <div class="title">SWAGGING</div><span class="col1"><a href="https://ifunny.co" rel="dofollow"> Find </a></span>
          more dank memes than you could ever imagine.
      </div>
    </div>
    <div class="grid_4">
      <div class="icon">
        <img src="<?php echo$this->images?>icon3.png" alt="">
        <div class="title">UPLOADING</div>You can upload your own videos here with no liability whatsoever!!!
      </div>
    </div>
    <div class="grid_12">
      <h3><span>Trending</span></h3>
    </div>
    <div class="clear"></div>
    <div class="works">
        <?php
        if(isset($this->products[0]['ID'])){
            $products=$this->products;
            $count=6; //6 Products max, no more should be displayed on the main index page.
            if(count($products)<6)
                $count=count($products);
            $noImg="https://i.imgur.com/72xjDmY.jpg";
            $path=$this->image."products/";
            $dir=__DIR__."/../../../";
            for ($i=0; $i<$count;$i++){
                $image=$noImg;
                if($products[$i]['Image']!=null&&file_exists($dir.$path.$products[$i]['Image']))
                    $image=$path.$products[$i]['Image']
                ?>
      <!--<div class="grid_4"><a href="#"><img src="https://i.imgur.com/72xjDmY.jpg" alt=""></a></div>-->
                <div class="grid_4">
                    <a href="/video/view/<?php echo$products[$i]['ID']?>" class="gal"><img src="<?php echo$image?>" alt=""></a>
                    <div class="text1 col1 wordBreak"><?php echo$products[$i]['Productname']?></div>
                    <div class="wordBreak"><?php echo$products[$i]['Views']?> Views</div><br>
                    <a href="/video/view/<?php echo$products[$i]['ID']?>">Go to Video</a>
                </div>
        <?php if($i>1 && ($i+1)%3==0)echo"<div class='clear'></div>
";}}else{?>
        <div class="center text1">There are no discount offers available at this moment.</div>
        <?php }?>
    </div>
    <div class="clear"></div>
    <div class="grid_12">
      <h3><span>Testimonials</span></h3></div>
      <div class="grid_6">
        <blockquote>
          <img src="https://png.icons8.com/dotty/128/000000/user-male.png" alt="" class="img_inner fleft">
          <div class="extra_wrapper">
            <p>“I was very disappointed with this site's service, especially when i heard that I had to download something called "XAMPP" to be able to reach their website localhost.”</p>
            <span class="col2 upp">Lisa Smith  </span> - almost a customer
          </div>
        </blockquote>
      </div>
      <div class="grid_6">
        <blockquote>
          <img src="https://png.icons8.com/dotty/128/000000/user-male.png" alt="" class="img_inner fleft">
          <div class="extra_wrapper">
            <p>“I was considering buying stakes in this company's video but once I saw the background code chaos I decided not to go through with it.”</p>
            <span class="col2 upp">James Bond  </span> - potential investor
          </div>
        </blockquote>
      </div>

    
  </div>
</div>

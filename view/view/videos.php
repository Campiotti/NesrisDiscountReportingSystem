<div class="dontLook">
    <script>
        $(function(){
            // Initialize the gallery
            $('.port a.gal').touchTouch();
        });
    </script>
</div>
<!--==============================Content=================================-->

<div class="content">
  <div class="container_12">
      <div class="grid_12">
          <h3><span>Filter</span></h3>
          <?php echo$this->formHelper->createForm('filter', "", "", "", "filterForm");?>
          <input class="fleft" id="searchInput" type="text" value="" placeholder="Filter search ..." onkeyup="filterResults(this.value);" onkeypress="return event.keyCode !== 13;">
          <label><input type="radio" name="radio1" value="1" onclick="changeFilterMode(this.value);" checked>Filter by Tags</label>
          <label><input type="radio" name="radio1" value="2" onclick="changeFilterMode(this.value);">Filter by Username</label>
          <label><input type="radio" name="radio1" value="3" onclick="changeFilterMode(this.value);">Filter by Video name</label>
          <?php echo$this->formHelper->endForm();?>
      </div>
      <div class="clear"></div>
    <div class="grid_12">
      <h3><span>Our Videos</span></h3>
    </div>
    <div class="clear"></div>
    <div class="port" id="productContainer">
        <?php
        $products=$this->products;
        $target_dir = __DIR__."/../../../";
        $noImg="https://i.imgur.com/72xjDmY.jpg";
        $path=$this->image."products/";
        for ($i=0; $i<count($products); $i++) {
            $image=$noImg;
            if($products[$i]['Image']!=null)
                if(file_exists($target_dir.$path.$products[$i]['Image']))
                $image=$path.$products[$i]['Image'];
            $products[$i]['Description']=(strlen($products[$i]['Description'])>150)? substr($products[$i]['Description'],0,147)."...": $products[$i]['Description'];
            ?>
            <div class="grid_4">
                <a href="<?php echo$image?>" class="gal"><img src="<?php echo$image?>" alt=""></a>
                <div class="text1 col1 wordBreak"><?php echo$products[$i]['Productname']?></div>
                <div class="wordBreak"><?php echo$products[$i]["Description"]?></div><br>
                <a href="/video/view/<?php echo$products[$i]['ID']?>">Go to Video</a>
            </div>
            <?php if($i>1 && ($i+1)%3==0)echo"<div class='clear'></div>
";} ?>

    </div>
  </div>
</div>

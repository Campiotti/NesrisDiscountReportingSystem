<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 31.01.2018
 * Time: 09:08
 */
$favourites = $this->favourites;
$amount=0;
?>
<?php $datBoi=$this;
if($datBoi->sessionManager->isSet('alert')){
    ?>
    <script>customMessage("<?php echo$datBoi->sessionManager->getSessionItem('alert','title')?>","<?php echo$datBoi->sessionManager->getSessionItem('alert','content')?>",<?php echo$datBoi->sessionManager->getSessionItem('alert','good')?>)</script>
<?php } $datBoi->sessionManager->unsetSessionArray('alert');
?>
<div class="content">
    <div class="container_12">
        <h3 class="pb1"><span>Your Favourites</span></h3>
        <div id="holder">
        <?php if (count($favourites)>0){ foreach($favourites as $fave){$amount++;?>
        <div class="grid_12 split" id="<?php echo"fave".$fave['ID']?>">
            <div class="grid_2"></div>
            <div class="grid_4"><img src="<?php echo($fave['Image']) ? $this->image."products/".$fave['Image'] :"https://i.imgur.com/72xjDmY.jpg";?>" alt="product_image" class="img_inner fleft" id="img_<?php echo$fave['ID']?>" draggable="true" ondragstart="startHover(event,this,<?php echo$fave['ID']?>)"></div>
            <div class="grid_4 extra_wrapper">
                <div class="title"><?php echo$fave['Productname']?></div>
                <ul class="list2" id="favourites">
                    <li>Views: <?php echo$fave['Views']?></li>
                    <li><a href="/video/view/<?php echo$fave['ID']?>">Go to Video</a></li>
                    <li><button class="btn" onClick="favouriteList(<?php echo$fave['ID']?>)">Remove from Favourites</button></li>
                </ul>
            </div>
        </div>
            <?php }?>
        </div>
        <div class="clear" id="remove2"></div>
        <div class="btns" id="remove3">
            <button class="btn" onClick="location.href='/video/removeAllFaves'">Remove all Favourites</button>
        </div>
        <div class="grid_12 text1 center" id="show1" style="display:none">You have no favourites yet.</div>
            <div class="trashcan" id="remove4"><img src="<?php echo$this->image."DannyDevito.png"?>" alt="TrashCan" ondragover="prevDef(event)" ondrop="delHover(event)" ></div>
        <?php }else {?>
            <div class="grid_12 text1 center" id="show1">You have no favourites yet.</div>
        <?php }?>
        </div>
    </div>
<div id="dontLook" class="dontLook"><?php echo$amount?></div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 27.01.2018
 * Time: 16:13
 */
?>

<?php $product = $this->product?>
<?php
$image="https://i.imgur.com/72xjDmY.jpg";
if(file_exists(__DIR__."/../../assets/images/products/".$product['image']) && strlen($product['image'])>0)
    $image=$this->image."products/".$product['image'];
?>
<div class="content">
    <div class="container_12">
        <div class="grid_12">
            <h3><span>Edit your Video</span></h3>
            <?php echo $this->formHelper->createForm("video","/video/edit/".$this->productID,"POST","Edit"); ?>
            <div class="success_wrapper">
                <div class="success">Data submitted!<br>
                    <strong>Your article can now be bought in the store.</strong>
                </div>
            </div>
            <fieldset>
                <input type="hidden" name="id" value="<?php echo$product['id']?>">
                <label class="Productname">
                    <input type="text" name="productname" placeholder="Video name" value="<?php echo$product['productname']?>">
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="Description">
                    <textarea name="description" placeholder="Description of Video"><?php echo$product['description']?></textarea>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid phone number.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="Image">
                    Thumbnail
                    <input type="file" name="image" onchange="readURL(this,'imeg');" placeholder="Product-Image.jpeg" accept="image/gif, image/jpeg, image/png image/jpg"/>
                    <div class="imeg"><img id="imeg" src="<?php echo$image?>" alt="your image" style=""></div>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid image.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="Video">
                    <input hidden name="video" value="<?php echo$product['video']?>">
                    <div class="imeg"><video controlsList="nodownload" autoplay muted controls style="visibility: visible; max-height: 100%; max-width: 100%;" id="vide" src="<?php echo$this->assets."movies/".$product['video']?>">
                        </video></div>
                <input type="hidden" name="originalImage" value="<?php echo($image=='https://i.imgur.com/72xjDmY.jpg')? 'null' : $product['image']?>">
                <div class="btns">
                    <!--<button type="reset" class="btn">Clear</button>-->
                    <button type="submit" class="btn">Edit Video</button>
                </div>
            </fieldset>
            <?php echo $this->formHelper->endForm(); ?>
        </div>
    </div>
</div>

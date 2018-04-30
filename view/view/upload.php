<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 27.01.2018
 * Time: 16:13
 */
?>

<div class="content">
    <div class="container_12">
        <div class="grid_12">
            <h3><span>Upload your <strike>Video</strike> Media!</span></h3>
            <?php echo $this->formHelper->createForm("video","/video/upload","POST","Sell"); ?>
            <div class="success_wrapper">
                <div class="success">Data submitted!<br>
                    <strong>Your article can now be bought in the store.</strong>
                </div>
            </div>
            <fieldset>
                <label class="Productname">
                    <input type="text" name="productname" placeholder="Video name" maxlength="50" required>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="Description">
                    <textarea name="description" placeholder="Description of Video" required maxlength="500"></textarea>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid phone number.</span><span class="empty error-empty">*This field is required.</span> </label>
                    Thumbnail
                <label class="Image">
                    <input type="file" name="image" onchange="readURL(this,'imeg');" placeholder="Thubmnail.jpeg" accept="image/gif, image/jpeg, image/png image/jpg">
                    <div class="imeg"><img id="imeg" src="#" alt="your image" style="visibility: hidden; max-height: 50%; max-width: 75%;"></div>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid image.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="Video">
                    Video or Audio
                    <input type="file" name="video" onchange="readURLVideo(event,'vide');" accept="video/mp4, video/ogg, video/webm, audio/mp3" required>
                    <div class="imeg"><video autoplay muted controls style="visibility: hidden; max-height: 100%; max-width: 100%;" id="vide" onplay="uploadVidDur('vide','TakeThisL');">
                        </video></div>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid image.</span><span class="empty error-empty">*This field is required.</span> </label>
                    <input name="videoLength" id="TakeThisL" hidden>

                <div id="tags">
                    <label class="tag1">
                        <input type="text" name="tag1" placeholder="Tag" maxlength="16" required>
                        <br class="clear">
                        <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span> </label>
                </div>
                <div class="btns">
                    <!--<button type="reset" class="btn">Clear</button>-->
                    <button style="" onclick="addTag();return false;" id="addTags" class="btn" >Add Tag</button>
                </div>
                <div class="btns">
                    <!--<button type="reset" class="btn">Clear</button>-->
                    <button type="submit" class="btn">Upload Video</button>
                </div>
            </fieldset>
            <?php echo $this->formHelper->endForm(); ?>
        </div>
    </div>
</div>

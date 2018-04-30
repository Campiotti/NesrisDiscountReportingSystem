<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.12.2017
 * Time: 16:08
 */
?>
<?php
//var_dump($this->blog);
//var_dump($this->comments);
//var_dump($this->likes);

$blog = $this->blog[0];
$likes = [];

if (isset($this->likes[0])) {
    $likes = $this->likes[0];
}
$blog['Image'] = str_replace("'", "", $blog['Image']);
$blog['Title'] = str_replace("'", "", $blog['Title']);
$blog['Content'] = str_replace("'", "", $blog['Content']);

?>

<div class="dontLook">
    <script>
        onload = function () {
            checkLike(<?php echo $_GET['blog'];?>)
        }
    </script>


</div>
<div class="BlogSingleRoot">
    <div class="blogSingle">
        <div class="blogSingleTitle"><?php echo $blog['Title']; ?></div>
        <div class="blogSingleImage"><img
                    src="/151/assets/images/blog/<?php echo($blog['Image'] ? $blog['Image'] : 'Trump.jpg') ?>"
                    alt="Imegggg"></div>
        <div class="blogSingleContent"><?php echo $blog['Content']; ?></div>
        <div class="likes"><p id="likes"><?php echo $likes['Likes']; ?></p><img src="/151/assets/images/fidget.png" alt="" class="likeImg" id="likeImg" onclick="like(<?php echo $_GET['blog']; ?>)">
        </div>
    </div>
</div>
<div class="comments">
    <?php if ($this->comments == []) {
        echo "<div class='noComment' id='temp'>no comments</div>";
    } else {
        foreach ($this->comments as $comment):?>
            <div class="commentSingle">
                <a href="/user/viewUser?user="<?php echo $comment['DBUser.ID']; ?>>
                    <div class="commentAuthor"><?php echo $comment['Username']; ?>`</div>
                </a>
                <div class="commentContent"><?php echo $comment['Content']; ?></div>
            </div>
        <?php endforeach;
    } ?>
</div>

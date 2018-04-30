<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 15.12.2017
 * Time: 09:43
 */
?>
<div class="blogs">

<?php $a=0; $RowDiv=false; foreach($this->blogs as $blog):?>
    <?php $a++; $blog['Image']=str_replace("'","",$blog['Image']); $textWithoutLastWord = preg_replace('/\W\w+\s*(\W*)$/', '$1', substr($blog['Content'],0,(64-strlen($blog['Content']))));
    if(($a-1)%3==0 || $a==1){
        echo'<div class="blogRow">';
        $RowDiv=true;
    }?>
    <a href="/BonziBlog/blogView?blog=<?php echo$blog['ID']?>" class="blogLink">
        <div class="blog<?php if(count($this->blogs)%3==1 && $a==count($this->blogs)){}else{echo" blogMarginLast";} ?>">
            <div class="blogTitle"><?php echo$blog['Title']?></div>
            <div class="blogDescription"><?php echo(strlen($blog['Content'])>32 ? /*substr($blog['Content'],0,(32-strlen($blog['Content'])))*/$textWithoutLastWord : $blog['Content'] ) ?></div>
            <div class="blogImage"><img src="/151/assets/images/blog/<?php echo($blog['Image']? $blog['Image'] : 'Trump.jpg')?>" alt="/151/assets/images/blog/Trump.jpg"></div>
        </div>
    </a>
    <?php if($RowDiv && $a%3==0){
       echo"</div>";
       $RowDiv=false;
    }?>
<?php endforeach;?>
    <?php while($a%3!=0){ $a++; ?>
    <a href="/BonziBlog/blogView?blog=" class="blogLink">
        <div class="blog">
            <div class="blogTitle"></div>
            <div class="blogDescription"></div>
            <div class="blogImage"></div>
        </div>
    </a>
    <?php } if($a==0){echo"header('Location: localhost/BonziBlog/Index')"; die();}?>
</div>

<?php
/*
<!--div class="blogs">
    <div class="blogRow">
        <a href="#" class="blogLink">
        <div class="blog">
            <div class="blogTitle">Trump Journey 2020</div>
            <div class="blogDescription">GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG </div>
            <div class="blogImage"><img src="/151/assets/images/blog/Trump.jpg"></div>
        </div>
        </a>
        <a href="#" class="blogLink">
        <div class="blog">
            <div class="blogTitle">Trump Journey 2020</div>
            <div class="blogDescription">GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG </div>
            <div class="blogImage"><img src="/151/assets/images/blog/Trump.jpg"></div>
        </div>
        </a>
        <a href="#" class="blogLink">
        <div class="blog">
            <div class="blogTitle">Trump Journey 2020</div>
            <div class="blogDescription">GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG GUCCI GANG </div>
            <div class="blogImage"><img src="/151/assets/images/blog/Trump.jpg"></div>
        </div>
        </a>
    </div>
</div-->
*/?>
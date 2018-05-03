<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 03.05.2018
 * Time: 11:52
 */
?>
<div class="content">
    <div class="container_12">
<?php $customer=$this->customer?>
<h3><span><?php echo$customer->firstname." ".$customer->lastname?>'s Info</span></h3>
<?php $reports=$this->reports; $amount=0;?>
    <div class="grid_12">
        <div class="grid_8">
        <ul>
            <li>email: <?php echo$customer->email?></li>
            <li>tel: <?php echo$customer->tel?></li>
        </ul></div>
    </div>
    <div class="grid_12">
        <h3><span>Customer's Reports</span></h3>
        <div class="text1 center" id="show1" style="display: none">No reports yet.</div>
        <?php if (count($reports)>0){ foreach($reports as $report){$amount++?>
            <div class="grid_12 split" id="<?php echo"vid".$report['id']?>">
                <div class="grid_4 extra_wrapper">
                    <div class="title"><?php echo$report['title']?></div>
                    <ul class="list2" id="favourites">
                        <li>Employee: <?php echo$report['firstname']." ".$report['lastname']?></li>
                    </ul>
                </div>
            </div>
        <?php }?>
        <?php }else{?>
            <div class="text1 center" id="show1">No reports yet.</div>
        <?php }?>
    </div>
    <div class="dontLook" id="dontLook"><?php echo$amount?></div>
    </div>
</div>

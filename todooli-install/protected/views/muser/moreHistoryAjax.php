<?php if(count($history) > 0){?>
<div class="title">##_MOBILE_COMMENT_PAGE_##</div>
<div class="profile">
	<p><b><?php echo $list['name'];?></b> -<?php echo $title;?></p>
</div>
<ul class="list2">
    <?php $i = 0;  foreach($history as $row) {  
        $generalObj = new General();
        $time = $generalObj->rel_time($row['createdAt']);?>
        <li <?php if(($i % 2) == 0){ ?>  class="odd" <?php }else{?> class="even" <?php }?> ><label><?php echo $time .' &nbsp;&nbsp; <b>' .$row['action'].'</b> by <b>'.$row['firstName'] . '&nbsp;' . $row['lastName']; ?></b></label></li>
        <?php $i++;
    }?>
</ul>

	<?php  
    if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
        <div class="pagination" align="left">
            <?php
			 $this->widget('application.extensions.MobilePager',
					 array('cssFile'=>true,
							'pages' => $pagination,
							'id'=>'link_pager',
				));
            ?>
        </div> 
	<?php
    }
    ?>
</div>

<?php }else { ?>##_MOBILE_COMMENT_NO_FOUND_##
<?php } ?>

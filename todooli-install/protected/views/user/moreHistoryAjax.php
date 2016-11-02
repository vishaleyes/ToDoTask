<div class="commentHistory">
    <?php
	if(count($history) > 0) {?>
    	<h5>##_COMMENT_HISTORY_##</h5>
    <?php
	}?>
    <div>
		<?php
        $i = 0;
        foreach($history as $row) {  
            $generalObj = new General();
            $time = $generalObj->rel_time($row['createdAt']);?>
            <label><?php echo $time .' &nbsp;&nbsp; <b>' .$row['action'].'</b> by <b>'.$row['firstName'] . '&nbsp;' . $row['lastName']; ?></b></label>
            <?php
            $i++;
            if($i==5) {
                break;
            }
        }?>
    </div>
    <div class="clear"></div>
    <?php
    if(count($history) > 5){?>
    <div class="moreComment">
    	<a href="#" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/moreItemHistory/id/<?php echo $history[0]['itemId'];?>');">##_DESCRIPTION_MORE_##</a>
    </div>
    <?php
	}?>
</div>
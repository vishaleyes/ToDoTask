<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<div class="title">##_ITEMS_AJAX_TODO_##</div>
</div>
    <div align="left">
        <h3 class="heading">##_MOBILE_USER_MY_TODO_##</h3>
        <ul class="listView">
            <?php
            if(count($mytodoitems) > 0){
                $iteration	=	1;
                 foreach($mytodoitems as $row) {  ?>
                    <li>
                        <?php echo $row['assignedByFname'] ."". $row['assignedByLname'];?>
                        <span><?php echo "<b>".$row['total']."</b>"; ?></span>
                    </li>
                <?php
                $iteration++;	
                }
            } else { ?>
                <li class="nodata">##_MOBILE_USER_MY_LISTS_NO_LIST_##</li>
            <?php
            }?>
        </ul>
        <h3 class="heading">##_MOBILE_USER_ASSIGN_BY_ME_TODO_##</h3>
        <ul class="listView">
            <?php
            if(count($assingByMeItems) > 0){
                $iteration	=	1;
                 foreach($assingByMeItems as $row) {  ?>
                    <li>
                        <?php echo $row['assignedByFname'] ."". $row['assignedByLname'];?>
                        <span><?php echo "<b>".$row['total']."</b>"; ?></span>
                    </li>
                <?php
                $iteration++;	
                }
            } else { ?>
                <li class="nodata">##_MOBILE_USER_MY_LISTS_NO_LIST_##</li>
            <?php
            }?>
        </ul>
        <h3 class="heading">##_MOBILE_USER_OTHERS_TODO_##</h3>
        <ul class="listView">
            <?php
            if(count($othersTodoItems) > 0){
                $iteration	=	1;
                 foreach($othersTodoItems as $row) {  ?>
                    <li>
                        <?php echo $row['assignedByFname'] ."". $row['assignedByLname'];?>
                        <span><?php echo "<b>".$row['total']."</b>"; ?></span>
                    </li>
                <?php
                $iteration++;	
                }
            } else { ?>
                <li class="nodata">##_MOBILE_USER_MY_LISTS_NO_LIST_##</li>
            <?php
            }?>
        </ul>
    </div>		
</div>
  
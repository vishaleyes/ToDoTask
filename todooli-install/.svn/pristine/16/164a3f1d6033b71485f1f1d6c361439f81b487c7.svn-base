<div class="title">##_MOBILE_USER_MY_LISTS_MY_TODO_##</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

<div class="add-link" align="left"><a href="<?php echo Yii::app()->params->base_path;?>muser/AddTodoList">##_MOBILE_USER_MY_LISTS_CLICK_ADD_##</a></div>
<div align="left">

<ul class="listView">
	<?php
		if(count($data) > 0){
			$iteration	=	1;
			foreach($data as $row){ ?>
                <li>
                    <div class="arrow" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>muser/listDescription/id/<?php echo $row['id_encrypt'];?>'">
                        <p><b><?php echo $row['name']; ?> - <?php if($row['createdBy']==Yii::app()->session['loginId']){ echo "Me";}else { echo $row['firstName'].' '. $row['lastName'];} ?></b></p>
                        <p class="date">##_MY_LISTS_TOTAL_##: <?php echo $row['totalItems'];?>, ##_MY_LISTS_PENDING_##: <?php echo $row['pendingItems'];?></p>
                        <div class="date"> 
                            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/deleteConfirm','post',array('id' => 'deleteLocation_'.$row['id'],'name' => 'deleteLocation_'.$row['id'],'style' => 'display:inline;')) ?>
                                <input type="hidden" name="deleteId" value="<?php echo $row['id_encrypt'];?>" />
                                <input type="hidden" name="functionname" value="removeList" />
                                <input type="hidden" name="itemname" value="record" />
                               
                            <?php echo CHtml::endForm();?>
                        </div>
                    </div>
                </li>
                
			<?php
            $iteration++;	
            }
            } else { ?>
            	<li class="nodata">##_MOBILE_USER_MY_LISTS_NO_LIST_##</li>
            <?php
            }?>
</ul>

   
	<?php 
	 if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
     
    <div class="pagination" align="left">
    	<?php   
            $this->widget('application.extensions.MobilePager', array('cssFile'=>true,'pages' => $pagination,'id'=>'link_pager'));
        }
        ?>
   </div>		
   <div class="clear"></div>
</div>
  
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<div class="title">##_MOBILE_USER_MY_NETWORK_LISTS_##</div>
<!--<div class="add-link" align="left"><a href="<?php echo Yii::app()->params->base_path;?>muser/addnetwork">##_MOBILE_USER_MY_NETWORK_CLICK_ADD_##</a></div>-->
<div align="left">
	<ul class="listView">
	<?php
		if($networks['pagination']->getItemCount() > 0){			
			$iteration	=	1;
			foreach($networks['networks'] as $row){ ?> 
                <li>
                   
                        <div class="networkname">
                        	<b><?php 
								if(isset($row['user']['firstName']) && isset($row['user']['lastName'])){
									echo $row['user']['firstName'] . ' ' . $row['user']['lastName'];
								}?>
                            </b> (<?php echo $row['user']['loginId']; ?>)
                            <span>  
								<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/deleteConfirm','post',array('id' => 'deleteLocation_'.$row['networkId'],'name' => 'deleteLocation_'.$row['netId'],'style' => 'display:inline;')) ?>
								<input type="hidden" name="deleteId" value="<?php echo $row['netId'];?>" />
								<input type="hidden" name="functionname" value="removeFrommyNetwork" />
								<input type="hidden" name="itemname" value="record" />
								<a href="javascript:;" onclick="document.deleteLocation_<?php echo $row['netId'];?>.submit();" >##_MOBILE_USER_MY_NETWORK_DELETE_##</a>
								<?php echo CHtml::endForm();?>
                            </span>
                        </div>
                        <p class="date">##_LIST_DESC_SINCE_## <?php echo date('Y-m-d',strtotime($row['created'])); ?></p>
                        
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
        if(!empty($networks['pagination']) && $networks['pagination']->getItemCount()  > $networks['pagination']->getLimit()){?>
        <div class="pagination" align="left">
        <?php   
                $this->widget('application.extensions.MobilePager', array('cssFile'=>true,'pages' => $networks['pagination'],'id'=>'link_pager'));
            }
            ?>
   		</div>		
   <div class="clear"></div>
</div>
  
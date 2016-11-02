<div class="title">
<?php echo $data['listDetails']['name']; ?> ##_INVITE_DETAIL_##
</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

    <ul class="infoList">
        <li>##_INVITES_TODO_LIST_##:<span><?php echo $data['listDetails']['name']; ?></span></li>
        <li>##_INVITES_ROLE_##:<span><?php echo ($data['role']==0) ? '##_INVITES_MEMBER_##' : '##_INVITES_MANAGER_##'?></span></li>
        <li>##_INVITE_DESCRIPTION_##:<span><?php echo $data['listDetails']['description']; ?></span></li>
        <li>##_INVITE_CREATED_##:<span><?php echo $data['createdByDetails']['firstName'].' '.$data['createdByDetails']['lastName']; ?></span></li>
        <li>##_INVITES_INVITED_TIME_##:<span><?php echo $data['time']; ?></span></li>
        <li>##_INVITES_INVITED_BY_##:<span><?php echo $data['invitedBy']['firstName'].' '.$data['invitedBy']['lastName']; ?></span></li>
      
    </ul>

	
<div class="profile">
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/deleteConfirm','post',array('id' => 'deleteLocation_'.$data['id_encrypt'],'name' => 'deleteLocation_'.$data['id_encrypt'],'style' => 'display:inline;')) ?>
	<input type="hidden" name="deleteId" value="<?php echo $data['id_encrypt'];?>" />
	<input type="hidden" name="functionname" value="deleteInvite" />
	<input type="hidden" name="itemname" value="record" />
    <div class="links">
	<?php
	if($data['status'] == 2){ ?><a href="<?php echo Yii::app()->params->base_path;?>muser/changeStatus/id/<?php echo $data['id_encrypt'];?>/status/1">##_MOBILE_USER_INVITES_ACCEPT_##</a> |<?php
	} ?> <a href="javascript:;" onclick="document.deleteLocation_<?php echo $data['id_encrypt'];?>.submit();">##_MOBILE_USER_INVITES_DELETE_##</a>
    </div>
<?php echo CHtml::endForm();?>    
</div>

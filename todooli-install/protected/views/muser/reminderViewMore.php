<div class="title"><?php echo $data[0]['listName']; ?></div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php
if( $data['listId'] == 0 ) {
	$listName	=	'All lists';
} else {
	$listName	=	$data[0]['listName'];
}

if($data['duration']==0){
	$duration	=	'Daily';
} else if($data['duration']==1) {
	$duration	=	'Sunday';
} else if($data['duration']==2) {
	$duration	=	'Monday';
} else if($data['duration']==3) {
	$duration	=	'Tuesday';
} else if($data['duration']==4) {
	$duration	=	'Wednesday';
} else if($data['duration']==5) {
	$duration	=	'Thursday';
} else if($data['duration']==6) {
	$duration	=	'Friday';
} else if($data['duration']==7) {
	$duration	=	'Saturday';
} else if($data['duration']==8) {
	$duration	=	'Monthly';
} else if($data['duration']==9) {
	$duration	=	'Yearly';
}

if ($data['dueDate'] == 0) {
	$dueDate	=	'Any';
} elseif ($data['dueDate'] == 1) {
	$dueDate	=	'Today';
} else {
	$dueDate	=	'This week';
}

if($data['itemStatus'] == 0) {
	$status	=	'ANY';
} elseif ($data['itemStatus'] == 1) {
	$status	=	'OPEN';
} else {
	$status	=	'CLOSE';
}
?>
<ul class="infoList">
    <li>##_REMINDERS_TODO_LIST_##:<span><?php echo $listName; ?></span></li>
    <li>##_REMINDER_LIST_NAME_##:<span><?php echo $data['name']; ?></span></li>
    <li>##_REMINDERS_STATUS_##:<span><?php echo $status; ?></span></li>
    <li>##_REM_VIEW_DURATION_##:<span><?php echo $duration; ?></span></li>
    <li>##_REMINDERS_DUE_DATE_##:<span><?php echo $dueDate; ?></span></li>
	<li>##_REMINDERS_TIME_##:<span><?php echo date('h:i:s a', strtotime($data['time'])); ?></span></li>
    <li>##_REM_VIEW_CREATED_##:<span><?php echo $data['reminderTime']; ?></span></li>
</ul>
<div class="field-area">
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/deleteConfirm','post',array('id' => 'deleteLocation_'.$data['id_encrypt'],'name' => 'deleteLocation_'.$data['id_encrypt'],'style' => 'display:inline;')) ?>
    	<div class="links">
            <a href="<?php echo Yii::app()->params->base_path;?>muser/addReminder/id/<?php echo $data['id_encrypt'];?>">##_MOBILE_USER_REM_EDIT_##</a> | 
            <a class="remindMe" href="<?php echo Yii::app()->params->base_path.'muser/reminders/id/'.$data['id_encrypt'];?>">##_MOBILE_USER_REM_EMAIL_##</a> | 
            <a href="javascript:;" onclick="document.deleteLocation_<?php echo $data['id_encrypt'];?>.submit();">##_MOBILE_USER_REM_DELETE_##</a>
        </div>
        <input type="hidden" name="deleteId" value="<?php echo $data['id'];?>" />
        <input type="hidden" name="functionname" value="deletereminder" />
        <input type="hidden" name="itemname" value="record" />	
    <?php echo CHtml::endForm();?>
</div>
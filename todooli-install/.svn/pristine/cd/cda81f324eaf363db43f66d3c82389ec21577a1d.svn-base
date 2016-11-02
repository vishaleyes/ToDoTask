<div class="title">##_MOBILE_USER_REM_LIST_##</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

<div class="add-link" align="left"><a href="<?php echo Yii::app()->params->base_path;?>muser/AddReminder">##_MOBILE_USER_REM_CLICK_ADD_##</a></div>
<div align="left">
<ul class="listView todoList">
   <?php
		if(count($data) > 0) {
			for($i=0;$i<count($data);$i++){ ?>
            <li onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>muser/reminderViewMore/id/<?php echo $data[$i]['id_encrypt'];?>'">
                <div class="arrow">
                    <p>
						<?php echo $data[$i]['listName']; ?> - <?php
							if($data[$i]['duration']==0){
								echo 'Daily';
							} else if($data[$i]['duration']==1) {
								echo 'Sunday';
							} else if($data[$i]['duration']==2) {
								echo 'Monday';
							} else if($data[$i]['duration']==3) {
								echo 'Tuesday';
							} else if($data[$i]['duration']==4) {
								echo 'Wednesday';
							} else if($data[$i]['duration']==5) {
								echo 'Thursday';
							} else if($data[$i]['duration']==6) {
								echo 'Friday';
							} else if($data[$i]['duration']==7) {
								echo 'Saturday';
							} else if($data[$i]['duration']==8) {
								echo 'Monthly';
							} else if($data[$i]['duration']==9) {
								echo 'Yearly';
							}
						?>
						 : <?php echo date('h:i:s a', strtotime($data[$i]['time'])); ?>
						</p>
                    <p>
						
                            <a href="<?php echo Yii::app()->params->base_path;?>muser/addReminder/id/<?php echo $data[$i]['id_encrypt'];?>">##_MOBILE_USER_REM_EDIT_##</a> | <a class="remindMe" href="<?php echo Yii::app()->params->base_path.'muser/reminders/id/'.$data[$i]['id_encrypt'];?>">##_MOBILE_USER_REM_EMAIL_##</a> |  <a href="<?php echo Yii::app()->params->base_path.'muser/deleteConfirm/deleteId/'.$data[$i]['id_encrypt'].'/functionname/deletereminder/itemname/record';?>">##_MOBILE_USER_REM_DELETE_##</a>
                           	
                    </p>
                </div>
            </li>
        <?php
        }
   	} else { ?>
    <li class="nodata"> ##_MOBILE_USER_REM_NO_ACTIVE_##<li>
    <?php
    }?>
</ul>
   
   
			
   <div class="clear"></div>
</div>
  
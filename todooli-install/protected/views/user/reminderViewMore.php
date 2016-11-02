<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>

<div>
	<?php
	if( $data['listId'] == 0 ) {
		$listName	=	'All lists';
	} else {
		$listName	=	$data[0]['listName'];
	}?>
	<h1><?php echo $listName; ?> ##_REM_VIEW_REMINDER_## </h1>
    
    <?php if(!empty($data)) { ?>
    <ul class="titleList popupTitleList">
    	<li><label>##_REM_VIEW_PROJECT_NAME_##</label><span><?php echo $listName; ?></span><p class="clear"></p></li>
        
        <?php 
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
		?>
        <li><label>##_REM_VIEW_DURATION_##</label><span><?php echo $duration; ?></span><p class="clear"></p></li>
        
        <?php 
		if ($data['dueDate'] == 0) {
			$dueDate	=	'Any';
		} elseif ($data['dueDate'] == 1) {
			$dueDate	=	'Today';
		} else {
			$dueDate	=	'This week';
		}
		?>
        <li class="even"><label>##_REM_VIEW_CREATED_##</label><span><?php echo $data['reminderTime']; ?></span><p class="clear"></p></li>
    </ul>
    <?php
	} else { ?> 
    	<p>##_REM_VIEW_NO_INVITES_##</p>
	<?php } ?>
    
</div>
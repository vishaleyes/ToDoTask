<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/style.css" type="text/css" />
<div>

	<h1><?php echo $data['listDetails']['name']; ?> ##_INVITE_VIEW_DETAILS_##</h1>
    
    <?php if(!empty($data)) { ?>
    <ul class="titleList popupTitleList">
    	<li><label>##_INVITE_VIEW_PROJECT_NAME_##</label><span><?php echo $data['listDetails']['name']; ?></span><p class="clear"></p></li>
        <li><label>##_INVITE_VIEW_DESC_##</label><span><?php echo $data['listDetails']['description']; ?></span><p class="clear"></p></li>
        <li class="even"><label>##_INVITE_VIEW_CREATED_BY_##</label><span><?php echo $data['createdByDetails']['firstName'] . ' ' . $data['createdByDetails']['lastName']; ?></span><p class="clear"></p></li>
        <li><label>##_INVITE_VIEW_ROLE_##</label><span>
			<?php 
            if($data['role'] == 0){
                echo '##_INVITE_VIEW_MEMBER_##';
            } else {
                echo '##_INVITE_VIEW_MANAGER_##';
            }
            ?></span><p class="clear"></p>
        </li>
        <li class="even"><label>##_INVITE_VIEW_INVITED_TIME_##</label><span><?php echo $data['time']; ?></span><p class="clear"></p></li>
    </ul>
    <?php
	} else { ?> 
    	<p>##_INVITE_VIEW_NO_INVITE_##</p>
	<?php } ?>
    
</div>
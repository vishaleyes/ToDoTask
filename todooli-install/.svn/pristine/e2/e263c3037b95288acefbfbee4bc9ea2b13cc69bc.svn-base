<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	$j('#backButton').click(function(){
		$j('#update-message').removeClass().html('');
		$j('#mainContainer')
			.html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show()
			.load('<?php echo Yii::app()->params->base_path;?>user/invites');
	});
});
</script>
<div class="RightSide">
    <div align="center">
    <?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    </div>
	<h1><?php echo $data['listDetails']['name']; ?>##_INVITE_VIEW_DETAILS_##</h1>
    <?php if(!empty($data)) { ?>
    <ul class="titleList popupTitleList">
    	<li><label>##_INVITE_VIEW_PROJECT_NAME_##</label><span><?php echo $data['listDetails']['name']; ?> - <?php if( $data['listDetails']['createdBy']==Yii::app()->session['loginId']){ echo "Me";}else { echo  $data['createdByDetails']['firstName'].' '.$data['createdByDetails']['lastName'];} ?></span><p class="clear"></p></li>
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
    
    <div class="fieldBtn">
    	<a href="javascript:;" lang="<?php echo Yii::app()->params->base_path;?>user/invites"><input type="button" class="btn" name="" value="##_BTN_BACK_##" id="backButton" /></a>
    </div>
</div>
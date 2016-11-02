<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

<div class="RightSide">
    <h1>##_NETWORK_DETAIL_##</h1>
    <?php $row	=	$dataProvider->getData();?> 
    <ul class="titleList">
        <li><label>##_NETWORK_DETAIL_F_NAME_##:</label>
        <span><?php echo $row['firstName']; ?></span><p class="clear"></p></li>
        
        <li><label>##_NETWORK_DETAIL_L_NAME_##:</label>
        <span><?php echo $row['lastName']; ?></span><p class="clear"></p></li>
        
        <li><label>##_NETWORK_DETAIL_EMAIL_##:</label>
        <span><?php echo $row['loginId']; ?></span><p class="clear"></p></li>
        
        <li><label>##_NETWORK_DETAIL_CREATED_##:</label>
        <span><?php echo $row['time']; ?></span><p class="clear"></p></li>
        
    </ul>
    <div class="fieldBtn">
        <a href="javascript:;" class="btn" onclick="$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/myNetwork');">##_NETWORK_DETAIL_BACK_##</a>
    </div>
</div>

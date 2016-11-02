
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language'];?>/global.js" type="text/javascript"></script>


<div class="wrapper-big">
    <div class="logo-wrap1">
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
    </div>
    <div class="right-text">
        <h1>##_VERIFY_PHONE_HEADER_##</h1>
        <div>
        <?php if(Yii::app()->user->hasFlash('success')): ?>								   
            <div class="error-msg-area">
                <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
            </div>
        <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div class="error-msg-area">
                <div class="clearmsg errormsg">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            </div>
        <?php endif; ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>             
</div>
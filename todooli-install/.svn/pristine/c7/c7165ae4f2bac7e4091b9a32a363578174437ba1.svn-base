
<div class="main">
    	<div class="content">
             <div class="title">##_MOBILE_USER_ACCOUNT_ACTIVATION_TITLE_##</div>
            <?php if(Yii::app()->user->hasFlash('success')): ?>
                <div class="error-msg-area">
                    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
                </div>
            <?php endif; ?>
            <?php if(Yii::app()->user->hasFlash('error')): ?>
                <div class="error-msg-area">
                    <div class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                </div>
            <?php endif; ?>
             
         </div>
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/activate','post',array('id' => 'helpForm','name' => 'helpForm')) ?>
         <div class="field-area">
         	<div class="sub-title">##_MOBILE_USER_ACCOUNT_ACTIVATION_EMAIL_ACTIVATION_##.</div>
            <div class="field">
                <label>##_MOBILE_USER_ACCOUNT_ACTIVATION_EMAIL_##<span id="emailerror"></span></label>
                <input type="text" name="activation_email" id="activation_email" class="textbox"  />
            </div>
            <div class="field">
                <label>##_MOBILE_CAPTCHA_##*<span id="captchaerror" style="margin-right:-20px !important;"></span></label>
            </div>
            <div class="captcha1">
				<?php $this->widget('CCaptcha'); ?>
            </div>  
            <div class="clear"></div>
            <div class="field">
                <?php echo Chtml::textField('verifyCode',''); ?>
            </div>
              
            <div>
                <input type="submit" name="" value="##_BTN_OK_##" class="btn" /> 
            	<input type="button" value="##_BTN_CANCEL_##" class="btn" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>msite/index'" /> 
            </div>
            <?php echo CHtml::endForm();?>
            
            <div>
                <div class="sub-title">##_MOBILE_USER_ACCOUNT_ACTIVATION_PHONE_ACTIVATION_##.</div>
            </div>
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/activate','post',array('id' => 'helpphoneForm','name' => 'helpphoneForm')) ?>
            <div class="field">
                <label>##_MOBILE_USER_ACCOUNT_ACTIVATION_PHONE_##<span id="phoneerror" ></span><span id="emailerror"></span></label>
                <input type="text" name="phone"  id="activation_phone" class="textbox" />
            </div>
            <div>
                <input type="submit" name="" value="##_BTN_OK_##" class="btn" /> 
            	<input type="button" value="##_BTN_CANCEL_##" class="btn" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>msite/index'" />
            </div>
            <?php echo CHtml::endForm();?>
        </div>
       
        <div class="clear"></div>
        
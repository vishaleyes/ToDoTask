<div class="main">
    <div class="content">
         <div class="title">##_MOBILE_USER_HELP_TITLE_##</div>
         <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/HelpType','post',array('id' => 'helpForm','name' => 'helpForm')) ?>
             <div class="field-area">
                  <div class="login-option">
                      <p>##_MOBILE_USER_HELP_SOLUTION_##.</p>
                      <div class="option"><input type="radio" name="help" value="forgot_password" checked="checked"/> ##_MOBILE_USER_HELP_FORGOT_##</div> 
                      <div class="option"><input type="radio" name="help" value="activate"/> ##_MOBILE_USER_HELP_INACTIVE_##</div> 
                      <div class="option"><input type="radio" name="help" value="contactus"/> ##_MOBILE_USER_HELP_CONTACT_##</div> 
                  </div>
                  <div class="login-option">
                      <input type="submit" name="submit" value="##_BTN_OK_##" class="btn" />
            <input type="button" value="##_BTN_CANCEL_##" class="btn" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>msite/index'" /> 
                  </div>
              </div>
          <?php echo CHtml::endForm();?>
         <div class="clear"></div>
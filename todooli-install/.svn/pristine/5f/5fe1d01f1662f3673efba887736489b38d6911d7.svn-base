<div class="wrapper-big">
    <div class="logo-wrap1">
        <?php if(!isset(Yii::app()->session['userId'])){ ?>
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
        <?php } ?>
    </div>
    <div class="right-text">
        <h2>##_HELP_NEED_HELP_##</h2>
        <div class="field-area">
            <div><label>##_HELP_FIND_SOLUTION_##</label></div>
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/HelpType','post',array('id' => 'helpForm','name' => 'helpForm')) ?>
                <div class="">
                    <div class="field">
                        <div class="checkbox1"><input type="radio" name="help" value="forgot_password" checked="checked"/> <span>##_HELP_FORGOT_PASSWORD_##</span></div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="field">
                        <div class="checkbox1"><input type="radio" name="help" value="activate" /> <span>##_HELP_ACCOUNT_INACTIVE_##</span></div>
                    </div>
                    <div class="clear"></div>
        
                    <div class="field">
                        <div class="checkbox1"><input type="radio" name="help" value="contactus" /> <span>##_HELP_CONTACT_US_##</span></div>
                    </div>
                    <div class="clear"></div>
                    
                    
                    <div class="fieldBtn">
                        <div>&nbsp;</div>
                        <input type="submit" class="btn" name="" value="##_BTN_OK_##" /> <input type="button" class="btn" name="" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>';" value="##_BTN_CANCEL_##" />
                    </div>
                    <div class="clear"></div>
                </div>
           <?php echo CHtml::endForm(); ?>
        </div>
    </div> 
    <div class="clear"></div>             
</div>

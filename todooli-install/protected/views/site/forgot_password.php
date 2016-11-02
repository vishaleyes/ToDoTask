<script type="text/javascript">
function validateform()
{
	$j("#btnSubmitforgotpassword").attr("disabled","disabled");
	var reg = msg['EMAIL_REG'];
	
	if(!validateEmail())
	{
		$j("#btnSubmitforgotpassword").attr("disabled",false);
		return false;
	}
		
	return true;	

}
function validateEmail()
{
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	var VAL1=document.getElementById('loginId').value;
	
	if(VAL1=='' || VAL1=='##_FORGOT_EMAIL_PHONE_VAL_##')
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['EMAIL_PHONE']);
		return false;	
	
	}
	
	var reg = msg['EMAIL_REG'];
	var phoneReg = msg['PHONE_REG'];
 
	if (reg.test(VAL1) || phoneReg.test(VAL1)) 
	{
			$j('#emailerror').removeClass();
			$j('#emailerror').addClass('true');
			$j('#emailerror').html('ok.');
			return true;
	}	
	else
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['VEMAIL_PHONE']);
		return false;
					
	}
}

</script>

<div class="wrapper-big">
    <div class="logo-wrap1">
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
    </div>
    <div class="right-text">        
        <div>
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
        <div class="clear"></div>
        
        <h2>##_FORGOT_PASSWORD_##</h2>
		<?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/forgotPassword','post',array('id' => 'forgotpassform','name' => 'forgotpassform','onsubmit'=>'return validateform()')) ?>
            <div>
                <div class="field">
                    <label>##_FORGOT_EMAIL_PHONE_##<span id="emailerror"></span></label>
                        <input type="text" id="loginId" name="loginId" class="textbox" onfocus="this.style.color='black';"  maxlength="256" value="<?php echo $loginId;?>" />
                </div>
                <div class="clear"></div>
                
                <div class="field">
                   <label>##_CAPTCHA_##<span class="star">*</span></label>
                   <div class="captcha1">
                        <?php $this->widget('CCaptcha'); ?>
                        <div class="clear"></div>
                        <?php echo Chtml::textField('verifyCode',''); ?>
                    </div>                        
                </div> 
                <div class="clear"></div>
                
                <div class="fieldBtn"> 
                    <input type="submit" id="btnSubmitforgotpassword" style="margin:8px 42px 0 0 !important;" class="btn signup-btn" value="##_BTN_SUBMIT_##" />
                </div>
                <div class="clear"></div>
            </div>
        <?php echo CHtml::endForm(); ?> 
        <div class="clear"></div>
    </div> 
    <div class="clear"></div>             
</div>
<script type="text/javascript">
$j(document).ready(function () {
	if( $j('.errormsg').html() != '' ) {
		setTimeout(function() {
			$j('.errormsg').fadeOut();
		}, 10000 );
	}
});
</script>
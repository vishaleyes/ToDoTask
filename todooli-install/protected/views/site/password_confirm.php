<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language'];?>/global.js" type="text/javascript"></script>
<script type="text/javascript">
function validateresetform()
{
	$j('#tokenerror').removeClass(); 
	$j('#tokenerror').html(''); 
	$j('#passwordreseterror').removeClass(); 
	$j('#passwordreseterror').html(''); 
	$j('#cpasswordreseterror').removeClass(); 
	$j('#cpasswordreseterror').html('');	
	if($j('#token').val() == "")
	{		
		$j('#tokenerror').removeClass().addClass('false');
		$j('#tokenerror').html(msg['VALIDATE_TOKEN']);
		$j('#token').focus();
		return false;
	}
	
	if($j('#new_password').val() == "" || $j('#new_password').val().length < 6)
	{
		$j('#passwordreseterror').removeClass().addClass('false');
		$j('#passwordreseterror').html(msg['VPASSWORD_VALIDATE']);
		$j('#new_password').focus();
		return false;
	}
	
	if($j('#new_password').val() != $j('#new_password_confirm').val())
	{
		$j('#cpasswordreseterror').removeClass().addClass('false');
		$j('#cpasswordreseterror').html(msg['MPASSWORD_VALIDATE']);
		$j('#new_password_confirm').focus();
		return false;
	}
	
	return true;
}
</script>

<div class="wrapper-big">
    <div class="logo-wrap1">
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
    </div>
    <div class="about-content">
        <h1>##_PASSWORD_CONFIRM_HEADER_##</h1>
		<h5>##_FORGOT_PASSWORD_VERIFICATION_DESC_##</h5> 
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
            <div class="clear"></div>
        </div>
		<div class="text">
        	<div class="signin-form" align="left">
			<?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/resetpassword','post',array('id' => 'employerform','name' => 'employerform','onsubmit'=>'return validateresetform()')) ?>
                <table cellpadding="2" cellspacing="2" align="left" border="0" class="signin-table" width="700">
                    <tr class="field-area">
                        <td width="150"><label>##_PASSWORD_CONFIRM_TOKEN_## </label></td>
                        <td width="260"><input type="text" name="token" id="token" class="textbox" onfocus="this.style.color='black';" <?php if( isset($token) ) {?>value="<?php echo $token;?>"<?php }?> /></td>
                        <td><div id="tokenerror"></div></td>
                    </tr>
                    <tr class="field-area">
                        <td><label>##_PASSWORD_CONFIRM_NEW_PASSWORD_## </label></td>
                        <td><input type="password" maxlength="20" name="new_password" id="new_password" onfocus="this.style.color='black';"  class="textbox" /></td>
                        <td><div id="passwordreseterror"></div></td>
                    </tr>
                    <tr class="field-area">
                        <td><label>##_PASSWORD_CONFIRM_CONFIRM_PASSWORD_## </label></td>
                        <td><input type="password" maxlength="20" name="new_password_confirm" id="new_password_confirm" onfocus="this.style.color='black';"  class="textbox" /></td>
                        <td><div id="cpasswordreseterror"></div></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td class="signin-btn" colspan="2"><input type="submit" name="submit_reset_password_btn" value="##_BTN_SUBMIT_##"  class="btn" />##_PASSWORD_CONFIRM_OR_## <a href="<?php echo Yii::app()->params->base_path; ?>site/signup">##_PASSWORD_CONFIRM_JOIN_##</a></td>
                    </tr>
                </table>
            <?php echo CHtml::endForm(); ?> 
        	</div>
        </div>
    </div> 
    <div class="clear"></div>             
</div>
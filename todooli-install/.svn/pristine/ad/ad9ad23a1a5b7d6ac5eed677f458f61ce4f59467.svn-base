<?php
if( isset($data) ) {
	$value	=	$data;
} else if( isset($_COOKIE['email_login']) && $_COOKIE['email_login']!='' ) {
	$value	=	$_COOKIE['email_login'];
} else {
	$value	=	'';
}?>
<div class="wrapper-big">
    <div class="logo-wrap1">
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
    </div>
    <div class="right-text">
        <h2>##_PASSWORD_CONFIRM_SIGN_IN_##</h2>
        <div class="signin-form">
			<?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/login','post',array('id' => 'loginform','name' => 'loginorm',)) ?>
			<div>            
				<?php if(Yii::app()->user->hasFlash('success')): ?>								   
            		<div class="error-msg-area">
                       <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
                    </div>
                <?php endif; ?>
                <?php if(Yii::app()->user->hasFlash('error')): ?>
                	<div class="error-msg-area">
                        <div class="error-msg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                    </div>
                <?php endif; ?>
            </div>
			<div class="clear"></div>
            <table cellpadding="2" cellspacing="2" border="0" class="signin-table" style="margin:0px;">
                <tr class="field-area">
                    <td width="150"><label style="font-weight:bold;">##_SIGNIN_EMAIL_PHONE_## </label></td>
                    <td width="265"><input type="text" maxlength="256" name="email_login" style="color:black;" value="<?php echo $value;?>"class="textbox" onfocus="this.style.color='black';" /></td>
                    <td></td>
                </tr>
                <tr class="field-area">
                    <td><label style="font-weight:bold;">##_SIGNIN_PASSWORD_##</label></td>
                    <td><input type="password" maxlength="20" name="password_login" style="color:black;" class="textbox" onfocus="this.style.color='black';" /></td>
                    <td><b><a href="<?php echo Yii::app()->params->base_path; ?>site/support">##_SIGNIN_CANT_ACCESS_##</a></b></td>
                </tr>
                <tr>
                    <td></td>
                    <td><div class="floatLeft"><input type="checkbox" checked="checked" name="remenber" value="1" /></div> <div class="chk-box">##_SIGNIN_REMEMBER_##</div></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="signin-btn" colspan="2"><input type="submit" name="submit_login" value="##_SIGNIN_SIGNIN_##" class="btn" /> 
                    ##_SIGNIN_OR_## <b><a href="<?php echo Yii::app()->params->base_path; ?>site/signup">##_SIGNIN_JOIN_##</a></b></td>
                </tr>
            </table>
          	<?php echo CHtml::endForm(); ?>  
        </div>
    </div> 
    <div class="clear"></div>             
</div>
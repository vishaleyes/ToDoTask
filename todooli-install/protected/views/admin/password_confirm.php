<script type="text/javascript">
	 function validateresetform()
	 {
		if($j('#token').val() == "")
		{
			$j('#passwordreseterror').removeClass().addClass('false');
			$j('#passwordreseterror').html(msg['VALIDATE_TOKEN']);
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
			$j('#passwordreseterror').removeClass().addClass('false');
			$j('#passwordreseterror').html(msg['MPASSWORD_VALIDATE']);
			$j('#new_password_confirm').focus();
			return false;
		}
		return true;
	 }
</script>
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
<div class="clear"></div>

<div align="center">
    <h5>##_PASSWORD_CONFIRM_HEADER_##</h5>
    <div class="login-box">
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/resetpassword','post',array('id' => 'resetpasswordform','name' => 'resetpasswordform','onsubmit' => 'return validateresetform();')) ?>
        <table cellpadding="1" cellspacing="1" border="0" class="login-table">
            <span id="passwordreseterror"></span>
            <tr>
                <td><label>##_PASSWORD_CONFIRM_TOKEN_##</label></td>
                <td><input type="text" name="token" id="token" class="textbox"  /></td>
            </tr>
            <tr>
                <td><label>##_PASSWORD_CONFIRM_NEW_PASSWORD_##</label></td>
                <td>
                	<input type="password" maxlength="20" name="new_password" id="new_password"  class="textbox" />
                </td>
            </tr>
            <tr>
                <td><label>##_PASSWORD_CONFIRM_CONFIRM_PASSWORD_##</label></td>
                <td>
                	<input type="password" maxlength="20" name="new_password_confirm" id="new_password_confirm"  class="textbox" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="left">
                    <div class="floatLeft">
                        <input type="submit" name="submit_reset_password_btn" class="btn" value="##_BTN_SUBMIT_##" />
                    </div>
                </td>
            </tr>
        </table>
    <?php echo CHtml::endForm();?>
    </div>
</div>
</div>
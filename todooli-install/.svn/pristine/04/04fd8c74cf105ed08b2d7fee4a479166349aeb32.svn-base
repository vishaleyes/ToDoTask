<script type="text/javascript">
	function validateform()
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(!validateEmail())
		{
			return false;
		}
		
		if(!validateCaptcha())
		{
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
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (reg.test(VAL1)) 
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
      <h5>##_FORGOT_PASSWORD_##</h5>
      <div class="login-box">
      	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/forgotPassword','post',array('id' => 'forgotpassform','name' => 'forgotpassform','onsubmit' => 'return validateform();')) ?>
            <table cellpadding="1" cellspacing="1" border="0" class="login-table" width="96%">
                <span id="emailerror"></span>
                <tr>
                    <td><label>##_FORGOT_EMAIL_PHONE_##</label></td>
                    <td>
                    	<input type="text" id="loginId" name="loginId" class="textbox" onfocus="this.style.color='black';" onblur="this.style.color='';" maxlength="256" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="captcha1">
						<?php $this->widget('CCaptcha'); echo Chtml::textField('verifyCode',''); ?> 
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="left">
                        <div class="floatLeft">
                        	<input type="submit" name="submit_login" class="btn" value="##_BTN_SUBMIT_##" />
                        </div>
                    </td>
                </tr>
            </table>
        <?php echo CHtml::endForm();?>
      </div>
  </div>
</div>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
</script> 
 
<!-- Login -->
 <div class="error-msg-area" style="padding:10px auto; width:960px;">
     	 <?php if(Yii::app()->user->hasFlash('success')): ?>								   
               <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
               <div class="clear"></div>
        <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('error')): ?>
                <table width="100%" cellspacing="0" cellpadding="2" border="0" align="left" class="messageBoxTable" >
                    <tbody>
                        <tr>
                            <td class="errormsg"> 
                            <?php echo Yii::app()->user->getFlash('error'); ?></td>
                        </tr>
                    </tbody>
                </table>
        <?php endif; ?>
    </div>
  <div class="clear"></div>
  
  <?php if(isset(Yii::app()->session['adminUser'])){
  	 if(Yii::app()->session['UserType'] == '4'){?>
  <script type="text/javascript">
  			window.location="<?php echo Yii::app()->params->base_path;?>admin/apiModules";
  </script> 
  <?php }else{ ?>
  <script type="text/javascript">
		window.location="<?php echo Yii::app()->params->base_path;?>admin/statistics";
  </script> 
  <?php } ?>
 <?php } else { ?>
  <div align="center">
      <h5 class="heading">API Admin Login</h5>
      <div class="mojone-loginbox">
          <div class="login-box">
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'api/adminLogin','post',array('id' => 'frm_adminLogin','name' => 'frm_adminLogin')) ?>
                <table cellpadding="1" cellspacing="1" border="0" class="login-table">
                    <tr>
                        <td><label>User Name :</label></td>
                        <td><input type="text" name="email_admin" class="textbox" tabindex="1" /></td>
                    </tr>
                    <tr>
                        <td><label>Password :</label></td>
                        <td><input type="password" name="password_admin" class="textbox" tabindex="2" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="captcha1"><?php $this->widget('CCaptcha'); echo Chtml::textField('verifyCode',''); ?> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="left">
                            <div class="floatLeft"><input type="submit" name="submit_login" class="btn" value="Login" />
                            <input type="button" name="cancel_login" class="btn" value="Cancel" onclick="location.href='<?php echo Yii::app()->params->base_path;?>admin';" /></div>
                            <div class="forgot-link"><a href="<?php echo Yii::app()->params->base_path;?>admin/forgotPassword" title="Forget password">I can't access my account</a></div>
                        </td>
                    </tr>
                </table>
            <?php echo CHtml::endForm();?>
          </div>
      </div>
  </div>
    <?php } ?> 
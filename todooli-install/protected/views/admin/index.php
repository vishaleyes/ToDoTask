<!-- Login -->
  <div class="clear"></div>
 
  <div align="center">
      <h5>Admin Login</h5>
      <div class="mojone-loginbox">
          <div class="login-box">
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/adminLogin','post',array('id' => 'frm_adminLogin','name' => 'frm_adminLogin')) ?>
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
                        <td class="captcha1">
                        	<?php $this->widget('CCaptcha'); ?>
                            <div class="clear"></div>
                            <?php echo Chtml::textField('verifyCode',''); ?> 
                        </td>
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
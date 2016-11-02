
    <div selected="true" align="center" class="main">
    	<div class="content">
    		    <div class="title">##_MOBILE_USER_PASS_CONFIRM_TITLE_##</div>
				<div class="error-msg-area" style=" margin:10px auto;">
					<?php if(Yii::app()->user->hasFlash('success')): ?>								   
                           <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
                           <div class="clear"></div>
                    <?php endif; ?>
                    <?php if(Yii::app()->user->hasFlash('error')): ?>
                                    
                            <table width="100%" cellspacing="0" cellpadding="2" border="0" align="left" class="messageBoxTable" >
                                <tbody>
                                    <tr>
                                        <td class="clearmsg errormsg"> 
                                        
                                        <?php echo Yii::app()->user->getFlash('error'); ?></td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>
                </div>	
          <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/resetpassword','post',array('id' => 'resetpasswordform','name' => 'resetpasswordform')) ?>
           <div class="field-area">
                <div class="field">
					<label>##_MOBILE_USER_PASS_CONFIRM_TOKEN_## : </label>
					<input type="text" name="token" id="token" class="textbox" />
				</div>
				
				<div class="field">
					<label>##_MOBILE_USER_PASS_CONFIRM_NEW_PASSWORD_## : </label>
					<input type="password" maxlength="20" name="new_password" id="new_password"  class="textbox" />
					
				</div>
				
				<div class="field">
					<label>##_MOBILE_USER_PASS_CONFIRM_CONFIRM_PASSWORD_##: </label>
					<input type="password" maxlength="20" name="new_password_confirm" id="new_password_confirm"  class="textbox" />
				</div>
                               
                <div align="left"><input type="submit" name="submit_reset_password_btn" value="##_BTN_SUBMIT_##" class="btn" /></div>               
        	</div>
		   <?php echo CHtml::endForm();?>
            <div class="clear"></div>                  
    	</div>
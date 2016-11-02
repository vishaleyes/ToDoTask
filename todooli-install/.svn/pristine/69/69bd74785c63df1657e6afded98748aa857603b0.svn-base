    <div class="main">
    	<div class="content">
           <div class="title">##_MOBILE_USER_FORGOT_PASSWORD_##</div>  
           <div class="blank-area">
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
			</div> 
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/forgotPassword','post',array('id' => 'forgotpassform','name' => 'forgotpassform')) ?>
           <div class="field-area">
                <div class="field">
					<label>##_MOBILE_USER_FORGOT_PASSWORD_ENTER_##<span id="emailerror" ></span></label>
					<input type="text" maxlength="256" id="loginId" name="loginId" class="textbox" value="" onfocus="this.style.color='black';" />
					
				</div>
               <div class="field"><label>##_MOBILE_CAPTCHA_##*</label></div> 
                <div class="captcha1">
					<?php $this->widget('CCaptcha'); ?>
                </div>
                <div class="clear"></div>
                <div class="field">
					<?php echo Chtml::textField('verifyCode',''); ?>
                </div>        
                
                <div><input type="submit" name="submit" value="##_BTN_SUBMIT_##" class="btn" /></div>               
        	</div>
		   <?php echo CHtml::endForm();?>
            <div class="clear"></div>
			 
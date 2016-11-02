<div class="main">
    <div class="content">
       
       <!-- Login -->
     
       <div class="title">##_MOBILE_USER_CONTACT_TITLE_##</div>
       		<div class="error-msg-area">
            
            <tr>
            	<td align="center" colspan="3" class="signin-error">
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
                </td>
            </tr>
       <div class="field-area">
            <div class="info-text">##_MOBILE_USER_CONTACT_MANDATORY_##</div>
            <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/Contactus','post',array('id' => 'contactusform','name' => 'contactusform')) ?>
            <div class="field">
                <label>##_MOBILE_USER_CONTACT_NAME_## *<span id="nameerror"></span></label>
                <input type="text" name="name" id="name" class="textbox" value="<?php echo $name; ?>"  onfocus="this.style.color='black';"  />
                
            </div>
            <div class="field">
                <label>##_MOBILE_USER_CONTACT_EMAIL_## *<span id="emailerror"></span></label>
                <input type="text" maxlength="256" name="email" id="email" class="textbox" value="<?php echo $email; ?>" onfocus="this.style.color='black';"/>
                
            </div>
            <div class="field">
                <label>##_MOBILE_USER_CONTACT_COMMENT_## *<span id="commenterror"></span></label>
                <textarea name="comment" id="comment"  cols="40" class="textarea" rows="5" onfocus="this.style.color='black';"><?php echo $comment; ?></textarea>
                
            </div> 
            <!--<div class="field"><label>##_MOBILE_USER_CONTACT_SPAM_##*</label></div> -->
            <div class="field"><label>##_MOBILE_CAPTCHA_##*</label></div>
            <div class="captcha1">
				<?php $this->widget('CCaptcha'); ?>
            </div>
            <div class="clear"></div>
            <div class="field">
                <?php echo Chtml::textField('verifyCode',''); ?>
            </div>            
            
            <div><input type="submit" name="FormSubmit" id="FormSubmit" value="##_BTN_SUBMIT_##" class="btn" /></div>
            <?php echo CHtml::endForm();?>
        </div>
        <div class="clear"></div>
        
        
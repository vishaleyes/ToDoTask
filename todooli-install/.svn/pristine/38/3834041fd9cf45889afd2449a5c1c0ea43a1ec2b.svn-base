<div class="main">
	<div class="content">
    <div class="title">##_MOBILE_USER_SIGNUP_CREATE_ACCOUNT_##</div>
    <div class="msg">  
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
<input type="hidden" id="errorGmapApi" value="false" />
<input type="hidden" id="errorGmapApiid" value="secondaryPreLocation0" />
<input type="hidden" id="countRef" value="0" />
<input type="hidden" id="lastadded" value="0" />
<input type="hidden" id="lastdeleted" value="0" />
<input type="hidden" value="1" id="count_location"/>
<input type="hidden" value="true" id="rds"/>
<input type="hidden" value="0" id="rdsid"/>
<input type="hidden" value="0" id="countopenlocation"/>
<!-- Middle Part -->

		<?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/signUp','post',array('id' => 'employerform','name' => 'employerform')) ?>
			<div class="field-area">
            	<div class="info-text">##_MOBILE_USER_SIGNUP_MANDATORY_##</div>
               	<div class="field">
               		<div class="info-text">##_MOBILE_USER_SIGNUP_ABOUT_YOURSELF_##</div>
			   		<label>##_MOBILE_USER_SIGNUP_FULLNAME_##*<span id="fullnameerror"></span></label>
			   	</div>
                <div class="field">
				   <div class="contactname-textbox">
				   		<input type="text" name="fName" id="fName" value="<?php if(isset($_POST['fName'])) { echo $_POST['fName']; }?>"  class="textbox" />
				   </div> 
				   <div class="contactname-textbox2">
				   		<input type="text" name="lName" id="lName" value="<?php if(isset($_POST['lName'])) { echo $_POST['lName']; }?>"  class="textbox"   />
				   </div>
				   
				   <div class="clear"></div>
			   </div>
                
               <div class="info-text">##_MOBILE_USER_SIGNUP_EMAIL_PHONE_##</div>
			   
              
			   <div style="display:none" id="eml">false</div>
               <div class="field">
			   		<label>##_MOBILE_USER_SIGNUP_PHONE_##*<span id="phoneerror"></span></label>
					<span class="signin-link">
						<a style="display:none;" id="verify_now" href="javascript:;" onclick="boxOpen('verify_box')" >##_MOBILE_USER_SIGNUP_VERIFY_NOW_##</a>
					</span>
					<input type="text" name="phoneNumber"  id="phoneNumber" class="textbox" value="<?php if(isset($_POST['phoneNumber'])) {echo $_POST['phoneNumber'];}?>" />
			   </div>
               
                <div class="field">
                    <div class="option">
                        <input type="checkbox" name="smsOk" checked="checked" value="1" /> ##_MOBILE_USER_SIGNUP_SMS_## 
                    </div>
                </div>
				
                <div style="display:none" id="phn">false</div>
                <div class="field">
                    <label>##_MOBILE_USER_SIGNUP_EMAIL_##<span id="emailerror" ></span></label>
                    <input type="text" name="email"  id="email" maxlength="256" class="textbox" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];}elseif(isset($_GET['email'])){ echo $_GET['email'];} ?>" />
                </div>
               
                <div class="field">
                    <label>##_MOBILE_USER_SIGNUP_PASSWORD_##*<span id="passworderror" ></span></label>
                    <input type="password" maxlength="20" name="password" <?php if(isset(Yii::app()->session['seeker']['password']) && Yii::app()->session['seeker']['password']!=''){ ?> value="<?php echo Yii::app()->session['seeker']['password'];?>" <?php }?> id="password" class="textbox" />
                </div>
			   
                <div class="field">
                    <label>##_MOBILE_USER_SIGNUP_CONFIRM_PASSWORD_##*<span id="cpassworderror" ></span></label>
                    <input type="password" maxlength="20" name="cpassword" id="cpassword" <?php if(isset(Yii::app()->session['seeker']['cpassword']) && Yii::app()->session['seeker']['cpassword']!=''){ ?> value="<?php echo Yii::app()->session['seeker']['cpassword'];?>" <?php }?> class="textbox" />
                </div>
               
               
               	<div class="field">
                <label>##_MOBILE_USER_TIMEZONE_##<span class="star">*</span></label>
                <select class="select-box" name="timezone">
                   <?php
					foreach($timezone as $key => $val){
						echo '<optgroup label="'.$key.'">';
						foreach($val as $key => $val){
							echo '<option value='.$key.'>'.$val.'</option>';
						}
						echo '</optgroup>';
					}
					?>
                </select>
                </div>
               
               	<div class="field"><label>##_MOBILE_CAPTCHA_##*</label></div> 
				<div>##_CAPTCHA_DESC_##</div> 
                <div class="captcha1">
                    <?php $this->widget('CCaptcha'); ?>
                </div>
                <div class="clear"></div>
                <div class="field">
                    <?php echo Chtml::textField('verifyCode',''); ?>
                </div> 
               	<div class="login-option" >
                	<input type="submit" name="FormSubmit" id="FormSubmit" value="##_BTN_SUBMIT_##" class="btn" />
                    <span id="submitFormLoader"></span>
                </div>
			</div>
            <input type="hidden" value="1" id="count" name="count"/>
			<input type="hidden" value="<?php if(isset($_POST['admin'])){echo $_POST['admin'];} ?>" id="admin" name="admin"/>
	 <?php echo CHtml::endForm(); ?> 

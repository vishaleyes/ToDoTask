<script type="text/javascript">

var bas_path = "<?php echo Yii::app()->params->base_path; ?>";
var imgPath = "<?php echo Yii::app()->params->base_url; ?>images";
var csrfToken	=	'<?php echo Yii::app()->request->csrfTokenName;?>'+'='+'<?php echo Yii::app()->request->csrfToken;?>';
var csrfTokenVal	=	'<?php echo Yii::app()->request->csrfToken;?>';

</script>

<script src="<?php echo Yii::app()->params->base_url; ?>js/signup.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js" type="text/javascript"></script>

<div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>	
        <div class="error-msg-area">							   
           <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div class="error-msg">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
			
<!--GoogleAddressApi confirmation-->
<div style="display:none;" id="popupcontent"> 
		<div id="googleapialertcontent" >
		<?php echo CHtml::beginForm('#','post',array('id' => 'frm_delreq','name' => 'frm_delreq','class' => 'location-box')) ?>
			<input type="hidden" id="ReqId" value="" />	
				<div id="RequestContentRef"></div>
				
				<input type="hidden" id="NoContent" value="" />	
				<div align="center" >
					<span id="responceContent">test</span>
				<br />
				<div id="btnyes"></div>
				</div>
			<?php echo CHtml::endForm(); ?> 
		</div> 
</div> 		
<a class="googleapialert" href="#googleapialertcontent" ></a>       
<!-- Middle Part -->

<div class="wrapper-big">
<a href="<?php echo Yii::app()->params->base_path;?>user/index">
            	<img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/signUp','post',array('id' => 'employerform','name' => 'employerform','onsubmit'=>'return validateAll()')) ?>
        <div class="signupForm">
            
            <div class="tabs">
                <div class="clear"></div>
            </div>
            
            <div class="leftContents" style="margin-bottom:10px;">
                <div class="signupBox"> 
                    <div style="float:left;"><img src="<?php echo Yii::app()->params->base_url; ?>images/1.png" alt="icon" /></div>
                    <div class="innerBox">
                    <h1>##_SIGNUP_CREATE_ACCOUNT_##</h1>
                    ##_SIGNUP_REG_ABOUT_YOURSELF_##
                    <div class="field-area">
                        <div><label>##_SIGNUP_REG_FULL_NAME_##<span class="star">*</span><span id="fullnameerror"></span></label></div>
                        <div>
                            <input type="text" name="fName" maxlength="18" id="fName" class="textbox width147 floatLeft"  value="<?php if(isset($_POST['fName'])) { echo $_POST['fName']; }?>" onfocus="if(this.value=='First Name')this.value=''; this.style.color='black';" onblur="if(this.value==''){ this.value = 'First Name'; this.style.color='#a0a0a0';}" onkeyup="validatefName()" <?php if(!isset($_POST['fName'])) {?>style="color:#a0a0a0;"<?php }?> />
                            
                            <input type="text" name="lName" maxlength="18" id="lName" class="textbox width147 floatLeft"  value="<?php if(isset($_POST['lName'])) { echo $_POST['lName']; }?>" onkeyup="validatelName()"  onfocus="if(this.value=='Last Name')this.value=''; this.style.color='black';" onblur="if(this.value==''){ this.value = 'Last Name'; this.style.color='#a0a0a0';}" <?php if(!isset($_POST['lName'])) {?>style="color:#a0a0a0; margin-left:8px;"<?php }?>  />
                            
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="field-area">
                        <div><label>##_SIGNUP_REG_EMAIL_##<span id="emailerror" ></span></label></div>
                        <div>
                            <input  type="text" style="color:black;" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];}elseif(isset($_GET['email'])){ echo $_GET['email'];} ?>" class="textbox1" name="email" onblur="validateEmail()" onkeyup="validateEmail()"  id="email" maxlength="256" onfocus="if(this.value=='##_SEEKER_REG_EMAIL_##')this.value=''; this.style.color='black'; validateEmail();"/>
                            
                        </div>
                    </div>
                    <div style="display:none" id="eml">false</div>
                    
                    <div class="field-area">
                        <div>
                            <label>##_SIGNUP_REG_PHONE_##<span class="star" id="phone_star">*</span>         <span id="phoneerror"></span></label>
                            <span class="signin-link">
                                <a style="display:none;" id="verify_now" href="javascript:;" onclick="boxOpen('verify_box')" >##_SIGNUP_REG_VERIFY_NOW_##</a>
                            </span>
                        </div>
                        <div>
                            <input id="phoneNumber" style="color:black;" type="text" value="<?php if(isset($_POST['phoneNumber'])) {echo $_POST['phoneNumber'];}?>" name="phoneNumber"  onfocus="if(this.value=='##_SEEKER_REG_PHONE_##')this.value=''; this.style.color='black'; validatePhone();"    onkeyup="validatePhone()" onblur="validatePhone()" class="textbox1" />						
                        </div>
                        <div>
                            <div class="checkbox1"><input type="checkbox" name="smsOk" value="1" class="styled" checked="checked" /><span>##_SIGNUP_REG_SMS_##</span></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div id="verify_box" class="phone-box" style="width:400px; text-align:center; display:none;">
                        <div class="location-box">
                            <div>
                                <label>##_SIGNUP_REG_VERIFY_PHONE_## &nbsp;</label>
                                <label id="vfcationCode"></label>
                                <label>" ##_SIGNUP_REG_VERIFY_NUMBER_## </label>
                            </div>
                            <a href="javascript:;" onclick="boxClose('verify_box<?php if(isset(Yii::app()->session['loginId'])){echo Yii::app()->session['loginId'];}?>')" class="btn" >
                                ##_SIGNUP_REG_OK_##
                            </a>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div style="display:none" id="phn">false</div>
                                
                    <div class="field-area">
                        <div><label>##_SIGNUP_REG_PASSWORD_##<span class="star">*</span><span id="passworderror" ></span></label></div>
                        <div>
                        <input style="color:black;"  type="password" maxlength="20" <?php if(isset(Yii::app()->session['seeker']['password']) && Yii::app()->session['seeker']['password']!=''){ ?> value="<?php echo Yii::app()->session['seeker']['password'];?>" <?php }?> name="password" id="password" onkeyup="validatePassword()" onblur="validatePassword()" class="textbox1" onfocus="this.style.color='black'" />
                            
                        </div>
                    </div>
                    
                    <div class="field-area">
                        <div><label>##_SIGNUP_REG_CONFIRM_PASSWORD_##<span class="star">*</span><span id="cpassworderror" ></span></label></div>
                        <div>
                            <input type="password" maxlength="20" name="cpassword" id="cpassword" <?php if(isset(Yii::app()->session['seeker']['cpassword']) && Yii::app()->session['seeker']['cpassword']!=''){ ?> value="<?php echo Yii::app()->session['seeker']['cpassword'];?>" <?php }?> onkeyup="validateCPassword()" class="textbox1" onfocus="this.style.color='black'" />
                                
                        </div>
                    </div>
                    
                    <div class="field-area">
                        <div><label>##_TIMEZONE_##<span class="star">*</span><span id="timezoneerror" ></span></label></div>
                        <div>
                            <select name='timezone'>
                            <?php
                           
							foreach($timezone as $key => $val){
                                echo '<optgroup label="'.$key.'">';
                                foreach($val as $key => $val){
									if( isset($_POST['timezone']) && $key == $_POST['timezone'] ) {
										$selected	=	'selected="selected"';
									} else {
										$selected	=	'';
									}
                                    echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                                }
                                echo '</optgroup>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="signupBox">
                    <div style="float:left;"><img src="<?php echo Yii::app()->params->base_url; ?>images/7.png" alt="icon" /></div>
                    <div class="innerBox">
                        <h1>##_CAPTCHA_##<span class="star">*</span></h1>
                        ##_CAPTCHA_DESC_## 
                        <div class="field-area">
                             <div class="captcha1">
                                <?php $this->widget('CCaptcha'); ?>
                                <div class="clear"></div>
                                <?php echo Chtml::textField('verifyCode',''); ?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div align="center">
                    <div align="center" style="padding-left:120px;">
                        <table cellpadding="2" cellspacing="2" border="0">
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td width="200"><input type="submit"  name="FormSubmit"  id="FormSubmit" onclick="chkemailphone()" class="button-big" value="##_BTN_SUBMIT_##" /></td>
                                <td width="120" class="text">&nbsp;</td>
                            </tr>
                        </table>
                    </div>				
                </div>
            </div>
            <div class="" id="sidebar">
                <div class="isSecure">
                    <ul style="padding-top:0px; padding-left:10px; margin:12px 0 10px 0;">
                        <li>##_SIGNUP_REG_SAFE_##</li>
                        <li>##_SIGNUP_REG_QUICK_##</li>
                        <li>##_SIGNUP_REG_CLEAR_##</li>
                    </ul>
                </div>
                <div class="requiredFields">##_SIGNUP_REG_REQUIRED_##</div>        
            </div>
            <div class="clear"></div>
        </div>
	<?php echo CHtml::endForm(); ?>    
	<div style="clear:both;"></div>
</div>
<script type="text/javascript">
$j(document).ready(function () {
	if( $j('.error-msg').html() != '' ) {
		setTimeout(function() {
			$j('.error-msg').fadeOut();
		}, 10000 );
	}
});
</script>
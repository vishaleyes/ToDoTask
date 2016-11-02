<script type="text/javascript">
var imgPath = "<?php echo Yii::app()->params->base_url; ?>images";
var $j = jQuery.noConflict();
$j(document).ready(function() { 
 $j("#verificationPhone").fancybox({	
	'titlePosition'	 : 'inside',
	'transitionIn'	 : 'none',
	'transitionOut'	 : 'none',
	'width' : '900'
	});
});	

function validateAll()
{
	var flag=0;
	
	if(!validateEmail())
	{
		return false;
	}
	return true;
}	
function validateEmail()
{
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	var VAL1=document.getElementById('activation_email').value;
	if(VAL1=='')
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['ACTIVE_EMAIL_VALIDATE']);
		return false;	
	}
	var reg = msg['EMAIL_REG'];
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
		$j('#emailerror').html(msg['ACTIVE_VEMAIL_VALIDATE']);
		return false;
	}
}

function verifyPhone()
{
	$j('#phoneerror').removeClass();
	$j('#phoneerror').html('');
	phone=document.getElementById('activation_phone').value;
		
	if(phone=='')
	{
		$j('#phoneerror').addClass('false');
		$j('#phoneerror').html(msg['ONLY_PHONE_VALIDATE']);
		return false;
	}
	
	if(!isPhoneNumber(phone))
	{	
		$j('#phoneerror').addClass('false');
		$j('#phoneerror').html(phone+' '+msg['VPHONE_VALIDATE']);
		return false;		
	}
	//$j("#activemail").attr("disabled","disabled");
	$j('#phoneerror').html('<img src="<?php echo Yii::app()->params->base_url; ?>images/spinner-small.gif" alt="" />');
	$j.ajax({  
		type: "POST",  
		url: '<?php echo Yii::app()->params->base_path; ?>site/getActiveVerifyCode' ,  
		data: "phone="+phone+"&"+csrfToken,  
		success: function(response) 
		{ 
			data=response.split('**');
			if(data[0]=='false')
			{
				$j('#phoneerror').addClass('false');
				$j('#phoneerror').html(data[1]);
				return false;	
			}
			else
			{
				
				$j('#phoneerror').removeClass();
				$j('#phoneerror').html('');
				$j("#verificationcontentbox").html(data[1]);
				$j("#verificationPhone").trigger('click');
				return true;	
			}
			//$j("#activemail").attr("disabled",false);
		}	
	})	
}
// returns true if the string is a US phone number formatted as...
// (000)000-0000, (000) 000-0000, 000-000-0000, 000.000.0000, 000 000 0000, 0000000000
function isPhoneNumber(str){
  var re = msg['PHONE_REG'];
  return re.test(str);
}
</script>
<div class="wrapper-big">
    <div class="logo-wrap1">
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
    </div>
    <div class="right-text">
        <div>
<?php if(isset($message) && $message!='') {?>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="error-msg-area">
            <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
        </div>
    <?php endif; ?>
<?php } ?>
</div>
        <div class="clear"></div>
        
        <h2>##_ACTIVATE_HEADER_##</h2>
        
        <div class="activation">
            <div class="activationType">
                <p><b>##_ACTIVATE_EMAIL_ACTIVATION_##</b></p>
                <?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/activate','post',array('id' => 'helpForm','name' => 'helpForm','onsubmit' => 'return validateAll();')) ?>
                    <div class="field">
                        <label>##_ACTIVATE_EMAIL_##<span>*</span><span id="emailerror"></span></label>
                        <input type="text" class="textbox"  name="activation_email" onkeyup="validateEmail()" id="activation_email" onfocus="this.style.color='black';" />
                    </div>
                    <div class="clear"></div>
                    
                    <div class="field">
                        <label>##_ACTIVATE_CAPTCHA_##<span>*</span><span id="captchaerror"></span></label>
                        <div class="captcha1">
                            <?php $this->widget('CCaptcha'); ?>
                            <div class="clear"></div>
                            <?php echo Chtml::textField('verifyCode',''); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="btnfield">
                        <input type="submit" class="btn" id="activemail" name="" value="##_BTN_OK_##" /> 
                        <input type="button" class="btn" name="" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>';" value="##_BTN_CANCEL_##" />
                    </div>
                <?php echo CHtml::endForm(); ?> 
            </div>
            <div class="activationType">
                <p><b>##_ACTIVATE_PHONE_ACTIVATION_##</b></p>
                <?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/activate','post',array('id' => 'helpphoneForm','name' => 'helpphoneForm','onsubmit'=>'return validateAllPhone()')) ?>
                    <div class="field">
                        <label>##_ACTIVATE_PHONE_##<span>*</span><span id="phoneerror"></span></label>
                        <input type="text" class="textbox" name="activation_phone" id="activation_phone" onfocus="this.style.color='black';" />
                    </div>
                    <div class="clear"></div>
                    
                    <div class="btnfield">
                        <input type="button" onclick="verifyPhone()" class="btn" name="" value="##_BTN_OK_##" /> 
                        <input type="button" class="btn" name="" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>';" value="##_BTN_CANCEL_##" />
                    </div>
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        
        <!--Verification code popup-->
        <a id="verificationPhone" href="#verification_content_box"></a>
        <div style="display:none;"> 
            <div id="verification_content_box" class="popup" style="width:600px; height:auto; overflow:auto;">
                <form name="frm_delreq" id="frm_delreq" method="post" action="#" >	
                    <input type="hidden" id="deleteRequestId" value="" />	
                    <div class="varify-phone">
                        <div><span id="verificationcontentbox"></span></div>
                        <div>
                            <input type="button" name="btn_delReq" id="btn_delReq2" value="##_BTN_OK_##" class="btn" onclick="javascript:$j.fancybox.close();" />
                            <input type="button" name="btn_delReq" value="##_BTN_CANCEL_##" class="btn" onclick="javascript:$j.fancybox.close();" />
                        </div>
                    </div>
                </form>
            </div> 
        </div>
        <br />

    </div> 
    <div class="clear"></div>             
</div>
<script type="text/javascript">
$j(document).ready(function () {
	if( $j('.errormsg').html() != '' ) {
		setTimeout(function() {
			$j('.errormsg').fadeOut();
		}, 10000 );
	}
});
</script>
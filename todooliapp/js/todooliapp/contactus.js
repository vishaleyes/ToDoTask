var $j = jQuery.noConflict();
function validateAll()
{
	var flag=0;
	if(!validateName())
	{
		return false;
	}
	
	if(!validateEmail())
	{
		return false;
	}
	
	if(!validateComment())
	{
		return false;
	}
	
	return true;
}
function validateName()
{
	$j('#nameerror').removeClass();
	$j('#nameerror').html('');
	var businessName=document.getElementById('name').value;
	
	if(businessName=='')
	{
		$j('#nameerror').addClass('false');
		$j('#nameerror').html(msg['CONTACT_US_NAME_VALIDATE']);
		return false;
	}
	if(businessName.length > 25)
	{
		$j('#nameerror').addClass('false');
		$j('#nameerror').html(msg['LABEL_VALIDATE_ERROR_MAXLEN']);
		return false;
	}
	var reg = msg["FULL_NAME_REG"];
	if(reg.test(businessName))
	{
		$j('#nameerror').removeClass();
		$j('#nameerror').addClass('true');
		$j('#nameerror').html(msg['_BTN_OK_']);
		return true;
	}
	else
	{
		$j('#nameerror').addClass('false');
		$j('#nameerror').html(msg['FIRST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
	}
}
function validateEmail()
{
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	var VAL1=document.getElementById('email').value;
	if(VAL1=='')
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['CONTACT_US_EMAIL_VALIDATE']);
		return false;	
	}
	var reg = msg['EMAIL_REG'];
	if (reg.test(VAL1)) 
	{
		$j('#emailerror').removeClass();
		$j('#emailerror').addClass('true');
		$j('#emailerror').html(msg['_BTN_OK_']);
		return true;
	}	
	else
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['CONTACT_US_VEMAIL_VALIDATE']);
		return false;
	}
}
function validateComment()
{
	$j('#commenterror').removeClass();
	$j('#commenterror').html('');
	var comment=document.getElementById('comment').value;
	var reg = msg['COMMENT_REG'];
	
	if(comment=='')
	{
		$j('#commenterror').addClass('false');
		$j('#commenterror').html(msg['CONTACT_US_COMMENT_VALIDATE']);
		return false;
	}
	else if(comment.length<20)
	{
		$j('#commenterror').addClass('false');
		$j('#commenterror').html(msg['CONTACT_US_VCOMMENT_VALIDATE']);
		return false;
	}
	else if(!reg.test(comment))
	{
		$j('#commenterror').addClass('false');
		$j('#commenterror').html(msg['BUSINESS_NAME_REG_SPECIAL_CHARACTER']);
		return false;
	}
	else
	{
		$j('#commenterror').removeClass();
		$j('#commenterror').addClass('true');
		$j('#commenterror').html('Ok');
		return true;
	}
}
function validateCaptcha()
{
		$j('#captchaerror').removeClass();
		$j('#captchaerror').html('');
		var VAL2=document.getElementById('captcha').value;
		if(VAL2=='')
		{
				$j('#captchaerror').addClass('false');
				$j('#captchaerror').html(msg['CONTACT_US_CAPTCHA_VALIDATE']);
				$j('#cpt').html('false');
				return false;
		}
		return true;		
}
function displaycaptcha()
{
	document.getElementById('mycaptcha').src=bas_path+'captcha?'+Math.random();	
}
function submitContactUs()
{
	if(!validateAll())
	{
		return false;	
	}
	var scrpos=$j("update-message").scrollTop();
	smoothScroll('update-message');
	$j.ajax({
		url:bas_path+'user/contactClassic',
		type: "POST",
		data:$j("#contactusform").serialize(),
		success: function(data){
			data=trim(data);
			result=data.split('**');
			
			if(result[0]==0)
			{
				$j("#update-message").removeClass().addClass('msg_success');
				$j("#update-message").html(result[1]);
				$j("#update-message").fadeIn();
				$j('#contactusform').each (function(){
					this.reset();
				});	
			}
			else
			{
				$j("#update-message").removeClass().addClass('error-msg');
				$j("#update-message").html(result[1]);
				$j("#update-message").fadeIn();
				//initLoad();
			}
			setTimeout(function() 
			{
				$j('#update-message').fadeOut();
			}, 10000 );

		}

	});	
}
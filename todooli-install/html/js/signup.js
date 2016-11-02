var $j = jQuery.noConflict();
addressList=new Array();
	
var emailValid;		
var phoneValid;		
$j(document).ready(function()
{

//googlemap alert box
$j(".googleapialert").fancybox({	
'titlePosition'	 : 'inside',
'transitionIn'	 : 'none',
'transitionOut'	 : 'none',
'width' : '900'
});

$j("#verifycode").fancybox({	
	'titlePosition'	 : 'inside',
	'transitionIn'	 : 'none',
	'transitionOut'	 : 'none',
	'width' : '900'
	});

chkemailphone();


$j("#comm_tab input[type='checkbox']").click(function(){
	validateCommType();
	});
	
	$j("#jobTypeselected input[type='checkbox']").click(function(){
	validateJobType();
	});
	
	$j("#workShiftselected input[type='checkbox']").click(function(){
	validateWorkShift();
	});
	
	$j("#languagesselected input[type='checkbox']").click(function(){
	validateLanguages();
	});	
	
var currDate = new Date();
var year = currDate.getFullYear();
year = "1910:"+year;
$j( "#birthdate" ).datepicker({
	changeYear: true,
	yearRange: year,
	minDate: "-70Y",
	maxDate: "-16Y",
	dateFormat: 'yy-mm-dd',
	defaultDate: new Date('1 January 1990')
});

$j("#verify_now").click(function(){
	$j.ajax({			
		type: 'POST',
		url: bas_path+'user/verifyNow',
		data: "phoneNumber="+$j("#phoneNumber").val()+"&"+csrfToken,
		cache: false,
		success: function(data)
		{
			$j('#phoneerror').removeClass();
			$j('#phoneerror').html('');
			$j('#vfcationCode').html(data);	
		}
	});
});

});

var $j = jQuery.noConflict();
function chkemailphone()
{
	validateEmail();
	validatePhone();
	

}	
function setcookiesarray()
{
	var cookieValue=getCookie("listjobs");	
	document.getElementById('businessTypeId').value=cookieValue;
	deleteCookie("listjobs","/","");	
	return true;

}
function openSelectedOcupation(id)
{
			
	//for business type selected 
	$j('.business-tab-heading').removeClass('current-business-heading');
	$j('#parent_type_name_'+id).addClass('current-business-heading');
			
	//for occupation get	
	$j('.childcat').removeClass('showchild');
	$j('.childcat').addClass('hidechild');
	$j('#child_type_'+id).removeClass('hidechild');
	$j('#child_type_'+id).addClass('showchild');
			
				
}   
function chkcategory(id)
{
	setCookie("listjobs",fStack.toString(delimiter),expiredDays,"/","","");						
} 
function fetch_object(idname)
{
	if (document.getElementById)
	{
		return document.getElementById(idname);
	}
	else if (document.all)
	{
		return document.all[idname];
	}
	else if (document.layers)
	{
		return document.layers[idname];
	}
	else
	{
		return null;
	}

}	
function inArray(anArray,value)
{
	var i;
	for (i=0; i < anArray.length; i++) 
	{
		if (anArray[i] == value) {
			return true;
		}
	}
	return false;
}
function unionArray(arr1,arr2)
{
for (i=0;i<arr2.length;i++)
{
	if (!inArray(arr1,arr2[i]))
	{
		arr1[arr1.length]=arr2[i];
	}
}
return arr1;
}
function updateCheckboxall(object,id)
{


	var rows=document.getElementsByTagName('input');
	var parentflag=document.getElementById('pt_'+id).checked;
	if(parentflag)
	{
		for (f=0;f<rows.length;f++){
			checkbox=rows[f];
			if (checkbox && checkbox.type=='checkbox'){	
				if(checkbox.title=='childtag_'+id)
				{		
					if (checkbox.id.charAt(0)==prefix_char){
						checkbox.checked=true;
						if(!updateCheckbox(checkbox)){//can not update any more, cause exeed the 
							return;
						}
			
					}
				}	
			}
		}	
	}
	else
	{
		for (f=0;f<rows.length;f++){
			checkbox=rows[f];
			if (checkbox && checkbox.type=='checkbox'){	
				if(checkbox.title=='childtag_'+id)
				{		
					if (checkbox.id.charAt(0)==prefix_char){
						checkbox.checked=false;
						if(!updateCheckbox(checkbox)){//can not update any more, cause exeed the 
							return;
						}
					}
				 }	
			}
		}	
	}

//updateCounter();

}
function validateAll()
{
	  var flag=0;
	  var validPhoneFlag=validatePhone();
	  var validEmailFlag=validateEmail();
		  
	  if(!validatefName())
	  {
		  var scrpos=$j("fullnameerror").scrollTop();
		  smoothScroll('fullnameerror');
		  return false;
	  }
	  if(!validatelName())
	  {
		  var scrpos=$j("fullnameerror").scrollTop();
		  smoothScroll('fullnameerror');
		  return false;
	  }
	  
	  
	  if(validEmailFlag!=1 && validPhoneFlag!=1)
	  {
		  validateEmail();
		  $j('#phoneerror').removeClass();
		  $j('#phoneerror').html('');
		  var scrpos=$j("emailerror").scrollTop();
		  smoothScroll('emailerror');
		  return false;
	  }
	  
	  var VAL1=document.getElementById('phoneNumber').value;
	  if(VAL1!="" && VAL1!=msg["_SEEKER_REG_PHONE_"])
	  {
		 validPhoneFlag=validatePhone();
		  
		  if(validPhoneFlag!=1)
		  {
			 
			  $j('#phn').html('false');
			  $j('#phoneerror').addClass('false');	
			  $j('#phoneerror').html(VAL1+' '+msg['VPHONE_VALIDATE']);
			  var scrpos=$j("phoneerror").scrollTop();
			  smoothScroll('phoneerror');
			  return false;
		  }
	  }
	  
	  var VAL2=document.getElementById('email').value;
	  if(VAL2!="" && VAL2!=msg["_SEEKER_REG_EMAIL_"])
	  {
		  if(validEmailFlag!=1)
		  {
		  $j('#phn').html('false');
		  $j('#emailerror').addClass('false');	
		  $j('#emailerror').html(msg['EMAIL_VALIDATE']);
		  var scrpos=$j("emailerror").scrollTop();
		  smoothScroll('emailerror');
		  return false;
		  }
	  }
	  
	  if(!validatePassword())
	  {
		  var scrpos=$j("passworderror").scrollTop();
		  smoothScroll('passworderror');
		  return false;
	  }
	  
	  if(!validateCPassword())
	  {
		  var scrpos=$j("cpassworderror").scrollTop();
		  smoothScroll('cpassworderror');
		  return false;
	  }
	  
	  if(!validateLanguages())
	  {
		  var scrpos=$j("languageserror").scrollTop();
		  smoothScroll('languageserror');
		  return false;		
	  }
	  
	  if(!validateBusinessType())
	  {
		  var scrpos=$j("businesstypeerror").scrollTop();
		  smoothScroll('businesstypeerror');
		  return false;
	  }
	  
	  if(!validateJobType())
	  {
		  var scrpos=$j("jobTypeselected").scrollTop();
		  smoothScroll('jobTypeselected');
		  return false;
	  }
	  if(!validateWorkShift())
	  {
		  var scrpos=$j("workShiftselected").scrollTop();
		  smoothScroll('workShiftselected');
		  return false;
	  }
	  if(!validateLanguages())
	  {
	  	var scrpos=$j("languagesselected").scrollTop();
		smoothScroll('languagesselected');
		return false;
	  }
		  
	  locationList=new Array();
	  
	  totalLocation=$j('#main .field-area').length;
	  for(i=0;i<=parseInt(totalLocation)-1;i++)
	  {
		  var flag=0;
		  if($j('#gmapchksecondaryPreLocation'+i).html()=='false')
		  {	
			  $j('#secondaryPreLocation'+i+'_error').removeClass();
			  $j('#secondaryPreLocation'+i+'_error').addClass('false');
			  $j('#secondaryPreLocation'+i+'_error').html(msg['_LOCATION_ON_SUBMIT_VALIDATE_']);
			  flag=1;
		  }
		  
		  if($j('#radiussecondaryPreLocation'+i).html()=='false')
		  {	
			  $j('#secondaryPreLocation'+i+'_error').removeClass();
			  $j('#secondaryPreLocation'+i+'_error').addClass('false');
			  $j('#secondaryPreLocation'+i+'_error').html(msg['VRADIUS_VALIDATE_LIMIT']);
			  flag=1;
		  }
		  if(flag==1)
		  {
			  return false;
		  }
		  
		  if($j('#secondaryPreLocation'+i).val()!="undefined" && $j('#secondaryPreLocation'+i).val()!='')
		  {
				  locationList.push($j('#secondaryPreLocation'+i).val().toLowerCase());
		  }
	  } 
	  
	  if(getarrayduplicates(locationList).length>0)
	  {
		  $j('#errorGmapApi').val('false');
		  $j('#locationerror').removeClass();
		  $j('#locationerror').html(msg["_GOOGLE_ADDRESS_SAME_VALIDATE_"]);
		  $j('#locationerror').addClass('false');
		  var scrpos=$j("locationerror").scrollTop();
		  smoothScroll('locationerror');
		  return false;	
	  }
	  
	  if(!validateCommType())
	  {
		  return false;
	  }
	  if(document.getElementById('agreementAccepted').checked==false)
	  {
		  $j('#accepted_missing').removeClass();
		  $j('#accepted_missing').addClass('false');
		  $j('#accepted_missing').html(msg['_VALIDATE_ACCEPTED_MISSING_']);
		  return false;
		  
	  }
	  
	  setcookiesarray();
	  var $jdialog = $j('<div></div>')
	.html('<img src="'+imgPath+'/ajax-loader.gif" alt="Loading" />')
	.dialog({
	autoOpen: false,
	modal: true
	});
    $j('.ui-dialog-titlebar').hide();
	$j('.ui-dialog .ui-dialog-content').css('overflow','hidden');
	$j('.ui-widget-content').css('background','none');
	$j('.ui-widget-content').css('border','none');
	$j('.ui-icon-grip-diagonal-se').removeClass();
  	$jdialog.dialog('open');
	  return true;
}
function chkAccepted()
{
	if(document.getElementById('agreementAccepted').checked==false)
	{
		$j('#accepted_missing').removeClass();
		$j('#accepted_missing').addClass('false');
		$j('#accepted_missing').html(msg['_VALIDATE_ACCEPTED_MISSING_']);
		return false;
	}
	else
	{
		$j('#accepted_missing').removeClass();
		$j('#accepted_missing').html('');
	}	
}
function validatefName()
{
	$j('#fullnameerror').removeClass();
	$j('#fullnameerror').html('');
	var fName=document.getElementById('fName').value;
	if(fName=='' || fName==msg["_SEEKER_REG_FIRST_NAME_"])
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['FNAME_VALIDATE']);
		return false;
	}
	var reg = msg["FIRST_NAME_REG"];
	if(reg.test(fName))
	{
		$j('#fullnameerror').removeClass();
		$j('#fullnameerror').addClass('true');
		$j('#fullnameerror').html(msg['_BTN_OK_']);
		return true;
	}
	else
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['FIRST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
	}
}
function validatelName()
{
	$j('#fullnameerror').removeClass();
	$j('#fullnameerror').html('');
	var lName=document.getElementById('lName').value;
	if(lName=='' || lName==msg['_SEEKER_REG_LAST_NAME_'])
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['LNAME_VALIDATE']);
		return false;
	}
	var reg = msg["LAST_NAME_REG"];
	if(reg.test(lName))
	{
		$j('#fullnameerror').removeClass();
		$j('#fullnameerror').addClass('true');
		$j('#fullnameerror').html(msg['_BTN_OK_']);
		return true;
	}
	else
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['LAST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
	}
}
function validateEmailFlag()
{
	$j('#emailerror').html('');
	var VAL1=document.getElementById('email').value;
	var reg = msg['EMAIL_REG'];
	if (reg.test(VAL1)) 
	{
		$j('#emailerror').removeClass();
		$j('#emailerror').addClass('true');
		$j('#emailerror').html(msg['SUCCESS_EMAIL_VALIDATE']);
		$j('#phoneerror').removeClass();
		$j('#phoneerror').html('');
		$j('#eml').html('true');
		return true;
	}
	else
	{
		$j('#emailerror').removeClass();
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['EMAIL_VALIDATE']);
		$j('#eml').html('false');
		return false;
	}
}
function validateEmail()
{
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	var VAL1=document.getElementById('email').value;
	if(!VAL1 || VAL1==msg["_SEEKER_REG_EMAIL_"])
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html(msg['EMAIL_VALIDATE']);
		$j('#eml').html('false');
		
		if($j('#phn').html()=='true')
		{
			$j('#emailerror').removeClass();
			$j('#emailerror').html('');
		}
		return false;	
	}
	var reg = msg['EMAIL_REG'];
	if (reg.test(VAL1)) 
	{
		$j('#emailerror').html('<img src="'+imgPath+'/spinner-small.gif" alt="Loading" />');
		$j.ajax({  
			type: "POST",  
			url: bas_path+'site/chkemail/type/user' ,  
			data: "email="+VAL1+"&"+csrfToken,  
			success: function(response) 
			{ 
				if(response==false)
				{
					$j('#emailerror').removeClass();
					$j('#emailerror').addClass('true');
					$j('#phone_star').html('');
					$j('#emailerror').html(msg['SUCCESS_EMAIL_VALIDATE']);
					$j('#eml').html('true');
					$j('#phoneerror').removeClass();
					$j('#phoneerror').html('');
					$j('#phn').html('');
					setemailValue(1);
				}
				else
				{
					$j('#emailerror').removeClass().addClass('false');
					$j('#emailerror').html(msg['ERROR_EMAIL_VALIDATE']);
					setemailValue(0);
				}
			}
		})		
	}
	else
	{
		$j('#emailerror').addClass('false');
		$j('#phone_star').html('*');
		$j('#emailerror').html(msg['EMAIL_VALIDATE']);
		$j('#eml').html('false');
		return false;
	}
	return getemailValue();			 				
}
function validatePhone()
{
	$j('#verify_now').fadeOut(0);
	$j('#phoneerror').removeClass();
	$j('#phoneerror').html('');
	var VAL1=document.getElementById('phoneNumber').value;
	
	if(!VAL1 || VAL1==msg["_SEEKER_REG_PHONE_"])
	{
		$j('#phoneerror').addClass('false');
		$j('#phoneerror').html(msg['EMAIL_VALIDATE']);
		$j('#phn').html('false');
		
		if($j('#eml').html()=='true')
		{
			$j('#phoneerror').removeClass();
			$j('#phoneerror').html('');
		}
		return false;	
	}
	if(!isPhoneNumber(VAL1))
	{	
		$j('#phn').html('false');
		$j('#phoneerror').addClass('false');
		$j('#phone_star').html('*');
		$j('#phoneerror').html(VAL1+' '+msg['VPHONE_VALIDATE']);
		
		return false;		
	}
	$j('#phoneerror').removeClass();
	$j('#phone_star').html('');
	$j('#phoneerror').addClass('true');
	$j('#phoneerror').html(msg['APHONE_VALIDATE']);
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	$j('#phn').html('true');
	setphoneValue(1);
	return true;
	
}
function setemailValue(v)
{
    emailValid = v;
}
function getemailValue()
{
    return window.emailValid; 
}
function setphoneValue(v)
{
    phoneValid = v;
}
function getphoneValue()
{
    return window.phoneValid; 
}


// returns true if the string is a US phone number formatted as...
// (000)000-0000, (000) 000-0000, 000-000-0000, 000.000.0000, 000 000 0000, 0000000000
function isPhoneNumber(str){
	var re = msg['PHONE_REG'];
	return re.test(str);
}

function validateSecondaryAddress(id)
{	
	$j('#secondaryPreLocation'+id+'_error').removeClass();
	$j('#secondaryPreLocation'+id+'_error').html('');
	
	var address=document.getElementById('secondaryPreLocation'+id).value;
	var reg = msg["ADDRESS_REG"];
	if(address=='')
	{
		$j('#secondaryPreLocation'+id+'_error').addClass('false');
		$j('#secondaryPreLocation'+id+'_error').html(msg['LOCATION_VALIDATE']);
		return false;
	}
	if(address.length < 4)
	{
		$j('#secondaryPreLocation'+id+'_error').addClass('false');
		$j('#secondaryPreLocation'+id+'_error').html(msg['VLOCATION_VALIDATE']);
		return false;
	}
	if(!reg.test(address))
	{
		$j('#secondaryPreLocation'+id+'_error').addClass('false');
		$j('#secondaryPreLocation'+id+'_error').html(msg['FIRST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
		
	}
	else
	{
		$j('#secondaryPreLocation'+id+'_error').removeClass();
		$j('#secondaryPreLocation'+id+'_error').addClass('true');
		$j('#secondaryPreLocation'+id+'_error').html(msg['_BTN_OK_']);
		return true;
	}
}
function chkisArray(value,arrayObj)
{
	for(i=0;i<arrayObj.length;i++)
	{
		if(arrayObj[i]==value)
		{
			return false;
		}
	}
	return true;
} 
function popElement(value,arrayObj)
{
	addressList.splice(addressList.indexOf(value.toLowerCase()), 1);
} 
function chkAddressGoogle(id)
{
	var id1=id.slice(-1);
	
	var address=document.getElementById('secondaryPreLocation'+id1).value;
	var reg = msg["ADDRESS_REG"];
	if(!reg.test(address))
	{
		$j('#secondaryPreLocation'+id1+'_error').addClass('false');
		$j('#secondaryPreLocation'+id1+'_error').html(msg['FIRST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
		
	}
	
	address=document.getElementById(id).value;
	$j('#locationerror').removeClass();
	$j('#locationerror').html('');
	if(address.length<4)
	{
		return false;	
	}
	if(!chkisArray(address.toLowerCase(), addressList))
	{
		$j('#gmapchk'+id).html('false');
		$j('#errorGmapApi').val('false');
		$j('#errorGmapApiid').val(id);	
		$j('#locationerror').removeClass();
		$j('#locationerror').html(msg["_GOOGLE_ADDRESS_SAME_VALIDATE_"]);
		$j('#locationerror').addClass('false');
		return false;	
		
	}
	if($j('#'+id+'_inlinepopup_reference').html().length > 100)
	{
		return false;
	}
	var $jdialog = $j('<div></div>')
	.html('<img src="'+imgPath+'/ajax-loader.gif" alt="Loading" />')
	.dialog({
		autoOpen: false,
		modal: true
	});
	$j('.ui-dialog-titlebar').hide();
	$j('.ui-dialog .ui-dialog-content').css('overflow','hidden');
	$j('.ui-widget-content').css('background','none');
	$j('.ui-widget-content').css('border','none');
	$j('.ui-icon-grip-diagonal-se').removeClass();
	$jdialog.dialog('open');
	$j.ajax({  
	type: "POST",  
	url: bas_path+'user/googleLocationChk' ,  
	data: "location="+address+"&"+csrfToken,  
	success: function(response) 
	{
		$jdialog.dialog('close');
			
		var jsonresponse=eval('(' + response + ')');
		$j('#ReqId').val(id);	
		if(jsonresponse.status==true)
		{
			if(jsonresponse.need_retry==true)
			{
			
				altaddress=jsonresponse.alternate_address;
				altraddressref=altaddress.toLowerCase();
				inputaddressref=address.toLowerCase()
				if(altraddressref!=inputaddressref)
				{
					$j('#gmapchk'+id).html('false');
					$j('#errorGmapApi').val('false');
					$j('#errorGmapApiid').val(id);
					
				var cont='<div class="location-box"><form name="frm_delreq"  method="post" action="#" ><input type="hidden" id="ReqId" value="" /><input type="hidden" id="RequestContent" value="'+jsonresponse.alternate_address+'" /><input type="hidden" id="NoContent" value="'+address+'" /><div align="center" ><span id="responceContent">'+msg["GOOGLE_ADDRESS_VALIDATE"]+jsonresponse.alternate_address+'</span><br /><div id="btnyes"><input type="button" name="btn_delReq" id="btn_delReq1" value="'+msg["YES"]+'" class="btn" onclick=gapichk("yes","'+id+'") /> <input type="button" name="btn_delReq" id="btn_delReq2" value="'+msg["NO"]+'" class="btn" onclick=gapichk("no","'+id+'") /></div></div></form></div>';						
					$j('#'+id+'_inlinepopup_reference').html(cont);
					var clocation=$j('#countopenlocation').val();
					$j('#countopenlocation').val(parseInt(clocation)+1);
				}
				else
				{
					$j('#gmapchk'+id).html('true');
					$j('#errorGmapApi').val('true');
					$j('#errorGmapApiid').val(id);
				}
			}
			else
			{
				$j('#gmapchk'+id).html('true');
				$j('#errorGmapApi').val('true');
				$j('#errorGmapApiid').val(id);
				if((id.match('addressLine1')))
				{
				$j('#addresserror').removeClass();
				$j('#addresserror').addClass('true');
				$j('#addresserror').html('Ok');
				}
				
				$j('#'+id+'_error').removeClass();
				$j('#'+id+'_error').addClass('true');
				$j('#'+id+'_error').html('Ok');								
				
			}							
		}
		else
		{
			$j('#gmapchk'+id).html('false');
			$j('#errorGmapApi').val('false');
			$j('#errorGmapApiid').val(id);
			var clocation=$j('#countopenlocation').val();
			$j('#countopenlocation').val(parseInt(clocation)+1);
															
			$j('#'+id+'_error').removeClass();
			$j('#'+id+'_error').addClass('false');
			$j('#'+id+'_error').html(msg["GOOGLE_ADDRESS_ADD_VALIDATE"]);
		}
		
	}
	})	
}
function gapichk(response,curid)
{
	id=$j('#ReqId').val();
	var clocation=$j('#countopenlocation').val();
	if(parseInt(clocation)==0)
	{
		$j('#countopenlocation').val(parseInt(clocation)-1);
	}
	else
	{
		$j('#countopenlocation').val(parseInt(clocation)-1);
	}
	if(response=='yes')
	{
		address=$j('#RequestContent').val();
		$j('#'+curid).val(address);
		$j('#errorGmapApi').val('true');
		$j('#errorGmapApiid').val(curid);
		
		if((curid.match('addressLine1')))
		{
		$j('#addresserror').removeClass();
		$j('#addresserror').addClass('true');
		$j('#addresserror').html('Ok');
		}
		
		$j('#'+curid+'_error').removeClass();
		$j('#'+curid+'_error').addClass('true');
		$j('#'+curid+'_error').html('Ok');
		$j('#gmapchk'+curid).html('true');
	}
	else
	{
		$j('#'+curid).val('');
		$j('#gmapchk'+curid).html('false');
	}
	
	$j('#businessaddrerror').addClass('true');
	$j('#businessaddrerror').html('');
	$j('#'+curid+'_inlinepopup_reference').html('');
					
}
function isArray(obj) 
{
	//returns true is it is an array
	if (obj.constructor.toString().indexOf(addressList) == -1)
	return false;
	else
	return true;
}
function validatePassword()
{
	$j('#passworderror').removeClass();
	$j('#passworderror').html('');
	var password=document.getElementById('password').value;
	var reg_num = msg['NUMBERS_REG'];
	var reg_upper = msg['UPPERCASE_LETTER_REG'];
	var reg_lower = msg['LOWERCASE_LETTER_REG'];
	var reg_special = msg['SPECIAL_CHARACTERS_REG'];
	
	if(password=='')
	{
		$j('#passworderror').addClass('false');
		$j('#passworderror').html(msg['PASSWORD_VALIDATE']);
		return false;
	}
	else if(password.length < 6)
	{
		$j('#passworderror').addClass('false');
		$j('#passworderror').html(msg['VPASSWORD_VALIDATE']);
		return false;
	}
	else if(password.length > 6 && reg_num.test(password) && reg_upper.test(password) && reg_lower.test(password) && reg_special.test(password))
	{
		$j('#passworderror').addClass('true');
		$j('#passworderror').html(msg['STRONG_PASSWORD']);
		return true;
	}
	else if(password.length > 6 && (reg_upper.test(password) && (reg_num.test(password) || reg_special.test(password)) || reg_lower.test(password) && (reg_num.test(password) || reg_special.test(password))) )
	{
		$j('#passworderror').addClass('true');
		$j('#passworderror').html(msg['MEDIUM_PASSWORD']);
		return true;
	}
	else
	{
		$j('#passworderror').removeClass();
		$j('#passworderror').addClass('true');
		$j('#passworderror').html(msg['WEAK_PASSWORD']);
		return true;
	}
}
function validateCPassword()
{
	$j('#cpassworderror').removeClass();
	$j('#cpassworderror').html('');
	var cpassword=document.getElementById('cpassword').value;
	var password=document.getElementById('password').value;
	
	if(password=='')
	{
		$j('#cpassworderror').addClass('false');
		$j('#cpassworderror').html(msg['CPASSWORD_VALIDATE']);
		return false;
	}
	else if(password!=cpassword)
	{
		$j('#cpassworderror').addClass('false');
		$j('#cpassworderror').html(msg['MPASSWORD_VALIDATE']);
		return false;
	}
	else
	{
		$j('#cpassworderror').removeClass();
		$j('#cpassworderror').addClass('true');
		$j('#cpassworderror').html('Ok');
		return true;
	}
}
function validateBusinessType()
{	
	if($j("#chosenBusiness option").length>0)
	{
		$j('#businesstypeerror').removeClass();
		$j('#businesstypeerror').html('');
		return true;
	}
	else
	{
		$j('#businesstypeerror').addClass('false');
		$j('#businesstypeerror').html(msg['OCCUPATION_VALIDATE']);
		return false;
	}	
	
}
function validateJobType()
{	
	var flag = false;
	$j("#jobTypeselected input[type='checkbox']").each(function(){
		if($j(this).attr('checked') == true)
		{
			flag = true;
		} 
	});
	if(flag)
	{
		$j('#jobtypeerror').removeClass();
	
		$j('#jobtypeerror').html('');
		return true;
	}
	else
	{
		$j('#jobtypeerror').addClass('false');
		$j('#jobtypeerror').html(msg['JOBTYPE_VALIDATE']);
		return false;
	}	
}
function validateWorkShift()
{	
	var flag = false;
	$j("#workShiftselected input[type='checkbox']").each(function(){
		if($j(this).attr('checked') == true)
		{
			flag = true;
		} 
	});
	if(flag)
	{
		$j('#workshifterror').removeClass();
		$j('#workshifterror').html('');
		return true;
	}
	else
	{
		$j('#workshifterror').removeClass();
		$j('#workshifterror').addClass('false');
		$j('#workshifterror').html(msg['WORK_SHIFT_VALIDATE']);
		return false;
	}	
}
function validateCommType()
{	
	var flag = false;
	$j("#comm_tab input[type='checkbox']").each(function(){
		if($j(this).attr('checked') == true)
		{
			flag = true;
		} 
	});
	if(flag)
	{
		$j('#communicationerror').removeClass();
	
		$j('#communicationerror').html('');
		return true;
	}
	else
	{
		$j('#communicationerror').addClass('false');
		$j('#communicationerror').html(msg['CONTACT_VALIDATE']);
		return false;
	}	
}
function validateEqualPhone()
{
	var phone = new Array();
	phone[0] = $j('#phoneNumber').val();
	$j("#other_phone input[type='text']").each(function(i,value){
		phone[i+1] = $j(this).val();
	});
	for(i=0 ; i<phone.length ; i++)
	{
		for(j=0 ; j<phone.length ; j++)
		{
			if(i != j)
			{
				if(phone[i] != "" && phone[j] != "")
				{
					if(phone[i] == phone[j])
					{
						alert("Two Of any phone numbers are same please enter unique phone number");
						return false;
					}
				}
			}	
		}	
	}
	return true;
}
function validateLanguages()
{	
	var flag = false;
	$j("#languagesselected input[type='checkbox']").each(function(){
		if($j(this).attr('checked') == true)
		{
			flag = true;
		} 
	});
	if(flag)
	{
		$j('#languageserror').removeClass();
	
		$j('#languageserror').html('');
		return true;
	}
	else
	{
		$j('#languageserror').addClass('false');
		$j('#languageserror').html(msg['LANGUAGE_VALIDATE']);
		return false;
	}	
}
function isInt(id)
{
	$j('#secondaryPreLocation'+id+'_error').removeClass();
	$j('#secondaryPreLocation'+id+'_error').html('');
	var radius=document.getElementById('distance'+id).value;
	if(radius=='')
	{
		$j('#secondaryPreLocation'+id+'_error').addClass('false');
		$j('#secondaryPreLocation'+id+'_error').html(msg['RADIUS_VALIDATE']);
			
		$j('#radiussecondaryPreLocation'+id).html('false');
		$j('#rds').val('false');
		$j('#rdsid').val(id);
		return false;
	}
	else if(isNaN(radius))
	{
		$j('#secondaryPreLocation'+id+'_error').addClass('false');
		$j('#secondaryPreLocation'+id+'_error').html(msg['VRADIUS_VALIDATE']);
		$j('#radiussecondaryPreLocation'+id).html('false');
		$j('#rds').val('false');
		$j('#rdsid').val(id);
		return false;
	}
	else if(radius<0 || radius>50)
	{
		$j('#secondaryPreLocation'+id+'_error').addClass('false');
		$j('#secondaryPreLocation'+id+'_error').html(msg['VRADIUS_VALIDATE_LIMIT']);
		$j('#radiussecondaryPreLocation'+id).html('false');
		$j('#rds').val('false');
		$j('#rdsid').val(id);
		return false;
	}
	else
	{
		$j('#secondaryPreLocation'+id+'_error').removeClass();
		$j('#radiussecondaryPreLocation'+id).html('true');
		$j('#rds').val('true');
		$j('#rdsid').val(id);
	}
}
//chk if any is checked or not	
function chkanyjobtype(obj)
{
	if(obj.checked==true)
	{
		$j('.jobtypesotherany').attr('disabled','disabled');
	}
	else
	{
		$j('.jobtypesotherany').removeAttr('disabled');
	}
}
function testboth()
{
	if($j('#phn').html() == 'false' && $j('#eml').html() == 'false')
	{
		$j("#phoneerror").removeClass();
		$j("#phoneerror").html('');
		return false;
	}
}
function chkanyworkshedule(obj)
{
	if(obj.checked==true)
	{
		$j('.workScheduleotherany').attr('disabled','disabled');
	}
	else
	{
		$j('.workScheduleotherany').removeAttr('disabled');
	}
}
function boxOpen(id)
{
	$j('#'+id).show();
}
function boxClose(id)
{
	$j('#'+id).hide();
}


//For the new occupation selection
function addOption(optiontext,optionvalue,chosenSelectId )
{
	var flag=false;
	var chosenSelect=document.getElementById(chosenSelectId);
	for (var i = chosenSelect.options.length-1; i>=0; i--) 
	{
		var option=chosenSelect.options[i];
		if(option.value==optionvalue)
		{
			flag=true;
			break;
		}
	}
	if(!flag && addItem(optionvalue))
	{
		var optn = document.createElement("OPTION");
		optn.text = optiontext;
		optn.value = optionvalue;
		document.getElementById(chosenSelectId).options.add(optn);
	}
}
function checkAllGroup(option,chosenSelectId)
{
	var children=option.parentNode.children;
	for(var i=0;i<children.length;i++)
	{
		child=children[i];
		if(child.innerHTML!="any")
		{
			addOption(child.innerHTML,child.value,chosenSelectId);
		}
		child.style.display="none";
	}
}
function selectOptions(srcSelectId,chosenSelectId) 
{
	$j('#businesstypeerror').removeClass();
	$j('#businesstypeerror').html('');
	srcSelect=document.getElementById(srcSelectId);
	
	for (var i = srcSelect.options.length-1; i>=0; i--) 
	{
		var option=srcSelect.options[i];
		if (option.selected) 
		{
			if(option.innerHTML!="any")
			{
				option.style.display="none";
				addOption(option.innerHTML,option.value,chosenSelectId);										
				srcSelect.focus();
			}
			else
			{
				checkAllGroup(option,chosenSelectId);
			}
		}
	}
	saveStringItems();
	updateCounter();
}
function removeOption(chosenSelectID,srcSelectId)
{
	var selectedValue;
	var chosenSelect=document.getElementById(chosenSelectID);
	for (var i = chosenSelect.options.length-1; i>=0; i--) 
	{
		var option=chosenSelect.options[i];
		if (option.selected) 
		{
			selectedValue=option.value;
			chosenSelect.remove(i);	
			removeItem(option.value);
			break;								
		}
	}
	var selectbox=document.getElementById(srcSelectId);
	for (var i = selectbox.length-1; i>=0; i--) 
	{
		var option=selectbox.options[i];
		if(option.value==selectedValue || option.innerHTML=='any')
		{
			option.style.display="block";
			option.selected=false;
		}
	}
	saveStringItems();
	updateCounter();
}

var cnt=0;
function addLocation()
{
	$j('#locationerror').removeClass();
	$j('#locationerror').html('');
	if(document.getElementById('errorGmapApi').value=='false')
	{
		id=$j('#errorGmapApiid').val();
		$j('#secondaryPreLocation'+cnt+'_error').removeClass();
		$j('#secondaryPreLocation'+cnt+'_error').addClass('false');
		$j('#secondaryPreLocation'+cnt+'_error').html(msg['ADDRESS_NEED TO_COMPLETE_ERROR']);
		return false;
	}
	if($j('#rds').val()=='false')
	{
		id=$j('#rdsid').val();
		$j('#secondaryPreLocation'+cnt+'_error').removeClass();
		$j('#secondaryPreLocation'+cnt+'_error').addClass('false');
		$j('#secondaryPreLocation'+cnt+'_error').html(msg['VRADIUS_VALIDATE_LIMIT']);
		return false;
	}

	document.getElementById('errorGmapApi').value='false';
	$j('#rds').val('true');	
	var cnttemp=cnt;
	$j('#errorGmapApiid').val('secondaryPreLocation'+cnttemp);
	$j('#rdsid').val(cnttemp);

	if(document.getElementById('secondaryPreLocation'+cnttemp).value=='' )
	{
		$j('#'+cnttemp+'_error').removeClass();
		$j('#'+cnttemp+'_error').addClass('false');
		$j('#'+cnttemp+'_error').html(msg['ADDRESS_NEED TO_COMPLETE_ERROR']);
		return false;
	} 
	
	if(document.getElementById('distance'+cnttemp).value=='' )
	{
		$j('#secondaryPreLocation'+cnttemp+'_error').removeClass();
		$j('#secondaryPreLocation'+cnttemp+'_error').addClass('false');
		$j('#secondaryPreLocation'+cnttemp+'_error').html(msg['VRADIUS_VALIDATE_LIMIT']);
		return false;
	} 
 
 	if(cnt!=4)
	{
		var createBlock="";
		for(var i=0;i<=cnt;i++)
		{
			var textValue1=document.getElementById("secondaryPreLocation"+i).value;
			var textValue2=document.getElementById("distance"+i).value;
			var gmapchkvalue=$j("gmapchksecondaryPreLocation"+i).html();
			gmapchkvalueassign='false';
			if(gmapchkvalue!=null || gmapchkvalue!='' )
			{
				gmapchkvalueassign=gmapchkvalue;
			}
			if(cnt==0 || i==0)
			{
				createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><div class="control-img1" id="controlimg1'+i+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+i+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><div class="location-link-msg"><span class="errorall true" id="secondaryPreLocation'+i+'_error">Ok</span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
			}
			else
			{
				
				createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><div class="control-img1" id="controlimg1'+i+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+i+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><div class="location-link-msg"><span class="errorall true" id="secondaryPreLocation'+i+'_error">Ok</span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
		   
		   }
		  
		}
		cnt++;
		if(cnt==4){
			createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+cnt+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+cnt+'") id="secondaryPreLocation'+cnt+'" onblur=chkAddressGoogle("secondaryPreLocation'+cnt+'")  cols="40" class="textarea" rows="2" ></textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+cnt+'" onkeyup=isInt("'+cnt+'") value="5"/></div><div id="refcheckboth'+cnt+'"><div class="control-img1" id="controlimg1'+cnt+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+cnt+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><div class="location-link-msg"><div class="errorall" id="secondaryPreLocation'+cnt+'_error" ></div></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+cnt+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+cnt+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+cnt+'" style="display:none">true</div>';
		}
		else
		{
			createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+cnt+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+cnt+'") id="secondaryPreLocation'+cnt+'" onblur=chkAddressGoogle("secondaryPreLocation'+cnt+'")  cols="40" class="textarea" rows="2" ></textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+cnt+'" onkeyup=isInt("'+cnt+'") value="5"/></div><div id="refcheckboth'+cnt+'"><div class="control-img1" id="controlimg1'+cnt+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+cnt+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><p class="control-img2" id="controlimg2'+cnt+'" ><img id="add_location" alt="Add" onclick="addLocation()" style="cursor:pointer;" src="'+imgPath+'/addmore.png"/></p><div class="location-link-msg"><div class="errorall" id="secondaryPreLocation'+cnt+'_error" ></div></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+cnt+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+cnt+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+cnt+'" style="display:none">true</div>';
		}
		$j("#main").html(createBlock);
	}  
} 
function removeLocation(id)
{
	document.getElementById('errorGmapApi').value='true';
	$j('#rds').val('true');	
	var createBlock="";
	var arrSize=cnt+1;
	arr=new Array(arrSize);
	var tmpCnt=0;
	if(id==cnt)
	{
	   var putAdd=cnt-1;
	}
	var addressin=document.getElementById('secondaryPreLocation'+id).value;
	if(addressin!='')
	{
		
	}
	for(var j=0;j<=cnt;j++)
	{	
		if(j==id )
		{
		   
		}//if
		else
		{
			var i=tmpCnt;
			var textValue1=document.getElementById("secondaryPreLocation"+j).value;
			var textValue2=document.getElementById("distance"+j).value;
			  
			var gmapchkvalue=$j("gmapchksecondaryPreLocation"+j).html();
			gmapchkvalueassign='false';
			if(gmapchkvalue!=null || gmapchkvalue!='' )
			{
				gmapchkvalueassign=gmapchkvalue;
			}
			if(j==putAdd )
			{
				if(j==0)
				{
					
					createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><p class="control-img2" id="controlimg2'+i+'" ><img id="add_location" alt="Add" onclick="addLocation()" style="cursor:pointer;" src="'+imgPath+'/addmore.png"/></p><div class="location-link-msg"><span class="errorall" id="secondaryPreLocation'+i+'_error" ></span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
				 }
				 else
				 {
					createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><div class="control-img1" id="controlimg1'+i+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+i+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><p class="control-img2" id="controlimg2'+i+'" ><img id="add_location" alt="Add" onclick="addLocation()" style="cursor:pointer;" src="'+imgPath+'/addmore.png"/></p><div class="location-link-msg"><span class="errorall" id="secondaryPreLocation'+i+'_error"></span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
				 }
			}//else if
			else
			{
			   
			   if(tmpCnt==0)
			   {
					if(cnt==1)
					{
			   
								createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'">		<p class="control-img2" id="controlimg2'+i+'" ><img id="add_location" alt="Add" onclick="addLocation()" style="cursor:pointer;" src="'+imgPath+'/addmore.png"/></p><div class="location-link-msg"><span class="errorall" id="secondaryPreLocation'+i+'_error"></span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
					}
					else
					{
					
						createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><div class="control-img1" id="controlimg1'+i+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+i+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><div class="location-link-msg"><span class="errorall" id="secondaryPreLocation'+i+'_error"></span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
					}
				  
			   }// else if
			   else
			   {
					if(j==cnt)
					{
					
						createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><div class="control-img1" id="controlimg1'+i+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+i+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><p class="control-img2" id="controlimg2'+i+'" ><img id="add_location" alt="Add" onclick="addLocation()" style="cursor:pointer;" src="'+imgPath+'/addmore.png"/></p><div class="location-link-msg"><span class="errorall" id="secondaryPreLocation'+i+'_error"></span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
					  
					   
				   }
				   else
				   {
						createBlock += ' <div class="field-area locationfields"><div id="seclocation_'+i+'" class="field-areacount"><div class="floatLeft"><textarea  name="secondaryPreLocation[]" onkeyup=validateSecondaryAddress("'+i+'") id="secondaryPreLocation'+i+'" onblur=chkAddressGoogle("secondaryPreLocation'+i+'")  cols="40" class="textarea" rows="2" >'+textValue1+'</textarea></div><div class="radius-box" style="margin:0px 0px 0px 10px !important;"><input type="text" name="distance[]" class="textbox width60" style="color:#000000;" id="distance'+i+'" onkeyup=isInt("'+i+'") value="'+textValue2+'"/></div><div id="refcheckboth'+i+'"><div class="control-img1" id="controlimg1'+i+'" ><img id="remove_location" alt="Remove" onclick="removeLocation('+i+')" style="cursor:pointer;" src="'+imgPath+'/trash.png" /></div><div class="location-link-msg"><span class="errorall" id="secondaryPreLocation'+i+'_error"></span></div><div class="clear"></div></div></div></div><div id="secondaryPreLocation'+i+'_inlinepopup_reference"></div><div id="gmapchksecondaryPreLocation'+i+'" style="display:none">'+gmapchkvalueassign+'</div><div id="radiussecondaryPreLocation'+i+'" style="display:none">true</div>';
						
				   }
			   } //else else
			}
		    tmpCnt++;
		}//else
	}//for
	cnt--;
	$j("#main").html(createBlock);
	
} //function

function getarrayduplicates(arg){
    var itm, A= arg.slice(0, arg.length), dups= [];
    while(A.length){
        itm= A.shift();
		if (!Array.prototype.indexOf) {  
			Array.prototype.indexOf = function (searchElement /*, fromIndex */ ) {  
				"use strict";  
				if (this === void 0 || this === null) {  
					throw new TypeError();  
				}  
				var t = Object(this);  
				var len = t.length >>> 0;  
				if (len === 0) {  
					return -1;  
				}  
				var n = 0;  
				if (arguments.length > 0) {  
					n = Number(arguments[1]);  
					if (n !== n) { // shortcut for verifying if it's NaN  
						n = 0;  
					} else if (n !== 0 && n !== Infinity && n !== -Infinity) {  
						n = (n > 0 || -1) * Math.floor(Math.abs(n));  
					}  
				}  
				if (n >= len) {  
					return -1;  
				}  
				var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);  
				for (; k < len; k++) {  
					if (k in t && t[k] === searchElement) {  
						return k;  
					}  
				}  
				return -1;  
			}  
		}  
        if(A.indexOf(itm)!= -1 && dups.indexOf(itm)== -1){
                dups[dups.length]= itm;
        }
    }
    return dups;
}


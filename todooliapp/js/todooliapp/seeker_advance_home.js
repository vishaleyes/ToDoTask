$j(document).ready(function() {

	//googlemap alert box
	$j("#verifycode").fancybox({	
	'titlePosition'	 : 'inside',
	'transitionIn'	 : 'none',
	'transitionOut'	 : 'none',
	'width' : '900'
	});

	$j(".verify_now").click(function(){
		tempPhoneNo = $j(this).attr('title');	
		$j.ajax({			
			type: 'POST',
			url: base_path+'user/getVerifyCode',
			data: "phone="+$j(this).attr("lang")+"&"+csrfToken,
			cache: false,
			success: function(data)
			{
				$j('#vfcationCode' + tempPhoneNo).html(data);	
			}
		});
	});


	$j("#avatar_link").click(function(){
		$j("#apply_avatar").attr('disabled','disabled');
	});
	
	$j("#avatar_link").fancybox({
	'titlePosition'	 : 'inside',
	'transitionIn'	 : 'none',
	'transitionOut'	 : 'none'
	});
	
	var height="{if $smarty.session.prefferd_language eq 'spn'}510{else}435{/if}";
	$j("#edit_profile").fancybox({
		'width' : 860,
		'height' : parseInt(height), 		
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',
		'type':'iframe',
		'onClosed' : function(){
			if($j("#update-message").hasClass('show'))
			{
				$j("#update-message").fadeIn();
				setTimeout(function(){
					$j('#update-message').fadeOut();
					$j('#update-message').removeClass();
				}, 10000 );
			}
		}
	});
	
	
	$j("#change_password").fancybox({
	'titlePosition'	 : 'inside',
	'transitionIn'	 : 'none',
	'transitionOut'	 : 'none'
	});
	
	$j(".viewmorehirenow").fancybox({
	'width' : 370,
	'height' : 260,
	'transitionIn' : 'none',
	'transitionOut' : 'none',
	'type':'iframe'
	});
	
	$j(".iframe_new").fancybox({
	'height' : 250,
	'onClosed'   : function(){ 
	window.location.href=base_path+"seeker";
	},
	'transitionIn' : 'none',		
	'transitionOut' : 'none',
	'type':'iframe'
	});
	
	$j('.various3').click(function(){
		$j("#deleteRequestId").val($j(this).attr('lang'));
		$j("#tempRequestId").val($j(this).attr('temp_id'));
	
		jConfirm('##_EMPLOYER_INDEX_PENDING_REQUEST_DELETE_##', '##_SEEKER_ADVANCED_PHONE_CONFIRMATION_DIALOG_##', function(response){
		if(response==true)
		{
			deleteReuqest($j(this).attr('lang'),$j(this).attr('temp_id'));
		}
	});
	}); 

/* link */
$j(".ltf_button").click(function() {
	var id = $j(this).attr("lang");
	id = '#'+id;
	var title = $j(this).attr("title");
	var value = $j(id).val();
	var name = $j(id).attr("name");
	var boxId = $j(this).parent().parent().attr("id");
	var fToken = $j('#fToken').val();
	var post_data = "link_value="+value+"&link_name="+name+"&"+csrfToken;
	var post_url = base_path+'seeker/updateLink';
	
	$j.ajax({			
		type: 'POST',
		url: post_url,
		data: post_data,
		cache: false,
		success: function(data)
		{
			if(trim(data) == "success")
			{	
				if(value=='')
				{
					$j("#"+name).html(title);
				}
				else
				{
					$j("#"+name).html(value);
				}
				$j('#'+boxId).hide();
			}
			else if(trim(data) == "error")
			{
				$j('#update-message').removeClass().addClass('error-msg');
				$j('#update-message').html(msg['_VALIDATE_ID_']+' '+name);
				$j('#update-message').fadeIn();
				setTimeout(function() {
				$j('#update-message').fadeOut();
				}, 10000 );
			}
			else if(trim(data) == "Invalid_token")
			{
				$j('#update-message').removeClass().addClass('error-msg');
				$j('#update-message').html('Invalid token');
				$j('#update-message').fadeIn();
				setTimeout(function() {
				$j('#update-message').fadeOut();
				}, 10000 );
			}
			else
			{
				//window.location.href = base_path+"seeker";
			}
		}
	});
});
/* end link */	

	$j(".box_open").click(function(){
		if(trim($j(this).attr("title")) != trim($j(this).html()))
		{
			var id = $j(this).attr("rel");
			id = '#'+id;
			$j(id).val(trim($j(this).html()));
			$j(id).focus().select();
		}
	})
	
	/* change Password*/
	
	$j("#fancybox-close").click(function(){
		clearPasswordPopup();
	});
	
	$j("#paswordCancel").click(function(){
		clearPasswordPopup();
	});
	
	$j("#btn_change_password").click(function(){
		if($j('#old_password').val() == "")
		{	
			$j('#passwordreseterror').removeClass().addClass('false');
			$j('#passwordreseterror').html(msg['PASSWORD_VALIDATE']);
			
			$j('#old_password').focus();
			return false;
		}
	
		if($j('#new_password').val() == "" || $j('#new_password').val().length < 6)
		{	
			$j('#passwordreseterror').removeClass().addClass('false');
			$j('#passwordreseterror').html(msg['VPASSWORD_VALIDATE']);
			$j('#new_password').focus();
			return false;
		}
		
		if($j('#new_password').val() != $j('#c_password').val())
		{	
			$j('#passwordreseterror').removeClass().addClass('false');
			$j('#passwordreseterror').html(msg['MPASSWORD_VALIDATE']);
			$j('#c_password').focus();
			return false;
		}
		$j('#passwordreseterror').removeClass();
		$j('#passwordreseterror').html('');
		
		var post_data = $j("#frm_change_password").serialize();
		$j("#btn_change_password").attr("disabled","disabled");
		$j("#loader_change_password").css('display','block');
		$j.ajax({			
			type: 'POST',
			url: base_path+'seeker/changePassword',
			data: post_data,
			cache: false,
			success: function(data)
			{
				if(trim(data) == "logout")
				{
					window.location.href = base_path;
				}
				else if(trim(data) == "success")
				{
					$j('#update-message').removeClass();
					$j('#update-message').addClass('msg_success');
					$j("#update-message").html(msg['FP_SUCCESS']);
					$j("#update-message").fadeIn();
					$j("#btn_change_password").attr("disabled",false);
					$j("#loader_change_password").css('display','none');
					clearPasswordPopup();
					$j.fancybox.close();
				}	
				else
				{
					$j("#btn_change_password").attr("disabled",false);
					$j("#loader_change_password").css('display','none');
					$j('#passwordreseterror').removeClass().addClass('false');
					$j('#passwordreseterror').html(data);
				}
				
				setTimeout(function() {
					$j('#update-message').fadeOut();
				}, 10000 );
			}
		});
	});
	/*End Change Password*/	
	
	//Make avatar entry in database
	$j('#apply_avatar').click(function(){
		$j('#loading_text').html(msg['_AVATAR_UPLOADING_']);
		$j('#loading_segment').fadeIn('fast');
		var action = base_path+'seeker/avatar/stat/update';
		$j.ajax({			
			type: 'POST',
			url: action,
			dataType: 'json',
			data: {file_name:$j("#file_name").val(),YII_CSRF_TOKEN:csrfTokenVal},
			cache: false,
			success: function(data)
			{
				if(data['status'] == 600)
				{
					window.location.href = base_path;
				}
				else if(data['status']==0)
				{
					$j(".main_image_preview").attr('src',base_path+'upload/getAvatar/dir/'+data['dir']+'/fileName/'+data['result']).css("height","90px").css("width","90px");
					$j('#loading_segment').css('display','none');
					$j("#avatar").val('');
					$j.fancybox.close();
				}
				else
				{
					$j('#loading_segment').css('display','none');
					$j("#avatar").val('');
					$j.fancybox.close();
				}
			}
		});
	});
	//end
});

function checkPassword()
{
	$j.ajax({
		type: "POST",
		url: base_path+'seeker/checkPassword',
		data: "old_password="+$j("#old_password").val()+"&user_id="+$j("#user_id").val()+"&"+csrfToken,
		cache: false,
		success: function(data)
		{
			if(trim(data) == "logout")
			{
				window.location.href = base_path;
			}
			else
			{
				if(trim(data) == "success"){
					$j("#old_password").attr("lang","true");
					$j('#passwordreseterror').removeClass();
					$j('#passwordreseterror').html('');
				}
				else{
					$j("#old_password").attr("lang","false");
					$j("#btn_change_password").attr("disabled",false);
					$j("#loader_change_password").css('display','none');
					$j('#passwordreseterror').removeClass().addClass('false');
					$j('#passwordreseterror').html(msg['PASSWORD_VALIDATE']);
				}
			}
		}
	});
}

function clearPasswordPopup()
{
	$j("#passwordreseterror").removeClass().html('');
	$j("#old_password").val('');
	$j("#new_password").val('');
	$j("#c_password").val('');
}

function addFiles()
{
	$j('#loading_text').html(msg['_AVATAR_UPLOADING_']);
	$j('#loading_segment').fadeIn('fast');
	var action = base_path+'seeker/avatar';
	$j.ajaxFileUpload({
		url:action,
		secureuri:false,
		fileElementId:'avatar',
		dataType: 'json',
		data: {id:$j("#id").val(),YII_CSRF_TOKEN:csrfTokenVal},
		success: function (data, status){
			if(data['status']==0)
			{
				$j("#avatarPreview").attr('src',base_path+'upload/getAvatar/dir/'+data['dir']+'/fileName/'+data['result']);
				$j("#avatarPreview").load(function(){
					$j("#apply_avatar").removeAttr('disabled');
					$j('#loading_segment').css('display','none');
				});
				
				$j("#file_name").val(data['result']);
			}
			else
			{
				alert(data['message']);
				$j('#loading_segment').css('display','none');
			}
		},
		error: function (data, status, e)
		{
			$j.fancybox.close();
			$j('#update-message').removeClass().addClass('error-msg');
			$j("#update-message").html(msg['INVALID_FILE_EXTENSION']);
			$j("#update-message").fadeIn();
			setTimeout(function() {
				$j('#update-message').fadeOut();
			}, 10000 );
			
			// alert(e);
		}
	});
}

function dr(val)
{	
	if(val=='yes')
	{
		deleteReuqest(document.getElementById('deleteRequestId').value,document.getElementById('tempRequestId').value);
	}
	else
	{
		$j.fancybox.close();
		return false;	
	}
}
/* Delete Reuqest*/	
function deleteReuqest(id,temp_id)
{	
	var name = $j(this).attr('name');		
	$j.ajax({			
		type: 'POST',
		url: base_path+'seeker/deleteReuqest',
		data: "id="+id+"&name="+document.getElementById('hire_request_name_'+id).innerHTML+"&"+csrfToken,
		contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
		dataType: 'json',
		cache: false,
		success: function(data)
		{
			if(data.message == "logout")
			{
				window.location.href = base_path;
			}
			else if(data.message == "success")
			{
				$j("#deleteRefresh").trigger('click');
				
				$j("#hire_request_"+deletedId).fadeIn();	
				$j('#update-message').removeClass().addClass('msg_success');
				$j("#update-message").html(msg['EMPLOYER_HR_DELETE_SUCCESS']);
				$j("#hire_request_"+deletedId).fadeOut(8000);
				$j("#hire_request_"+temp_id).fadeIn('slow');		
				$j("#hire_request_"+temp_id).fadeOut('slow');
				var new_rec_act="<li style='text-align:center;'><img src='"+imgPath+"/ajax-loader_small.gif' ></li>";
				$j("ul.activity-list").prepend(new_rec_act);
				$j("#update-message").fadeIn();
				setTimeout(function() {
					$j('#update-message').fadeOut();
				}, 10000 );
				
				$j.fancybox.close();
			}
		}
	});
}

var recentActivityUrl="seeker/recentActivities";
var totalRequest=0;
var recentActivitySMS=0;
var recentActivityGENERAL=0;
$j(document).ready(function(){
	autoPendingHireRequest();
	autoRecentActivities();
	//refresh recent hire request box
	//totalPendingHireRequest();
	totalRecentActivy();
	autoRefreshSeeker=setInterval(function(){	
		totalPendingHireRequest();
		totalRecentActivy();
	},10000);
});

function getTotalActivity(activityType)
{
	if(activityType=="GENERAL")
	{
		return window.recentActivityGENERAL;	
	}
}
	
function totalRecentActivy()
{
	if(window.recentActivityUrl=="seeker/recentActivities")
	{
		url="seeker/getTotalGeneralActivity";	
	}
	else
	{
		autoRecentActivities();
		return false;
	}
	
	$j.ajax({
		type: "POST",
		url: base_path+url,
		data: csrfToken,
		cache: false,
		success: function(data)
		{
			if(trim(data)=='logout')
			{
				clearInterval(autoRefreshSeeker);
				window.location=base_path;
				return false;
			}
			else
			{
				setTotalActivity('GENERAL',parseInt(data));	
			}
		}
	});				
}
	
function setTotalActivity(activityType,nRequest)
{
	if(activityType=="GENERAL")
	{
		if(window.recentActivityGENERAL!=nRequest)
		{
			autoRecentActivities();
			autoPendingHireRequest();
		}
		window.recentActivityGENERAL=nRequest;	
	}
	return false;		
}

function getTotalRequest()
{
	return window.totalRequest;	
}
	
function setTotalRequest(nRequest)
{	
	if(window.totalRequest!=nRequest)
	{
		autoPendingHireRequest();
	}
	window.totalRequest=nRequest;
	return false;		
}
	
function totalPendingHireRequest()
{
	$j.ajax({
		type: "POST",
		url: base_path+"seeker/totalHireRequestData",
		data: csrfToken,
		cache: false,
		success: function(data)
		{
			if(trim(data)=='logout')
			{
				clearInterval(autoRefreshSeeker);
				window.location=base_path;
				return false;
			}
			else
			{
				setTotalRequest(parseInt(data));
			}
		}
	});		
}
	
function autoRecentActivities()
{
	$j.ajax({
		type: "POST",
		url: base_path+getRecentActivityUrl(),
		data: csrfToken,
		cache: false,
		success: function(data)
		{			
			if(data == 'logout')
			{
				window.location.href = base_path;
			}
			else
			{
				$j('#recent_activities_box').remove();
				$j('#main_ractivities').html(data);
			}
		}
	});		
}
	
function autoPendingHireRequest()
{
	$j.ajax({
		type: "POST",
		url: base_path+"seeker/recentHireRequest",
		data: csrfToken,
		cache: false,
		success: function(data)
		{
			if(trim(data)=='logout')
			{
				clearInterval(autoRefreshSeeker);
				window.location=base_path;
				return false;
			}
			else
			{
				$j('#recent_hrequest_box').remove();
				$j('#main_rhrequest').html(data);
				var $jq = jQuery.noConflict();	
				$jq("div.scrollable").scrollable({
					vertical:true, 
					size: 3
				}).mousewheel();
			}
		}
	});		
}

function setRecentActivityUrl(url)
{
	window.recentActivityUrl=url;	
	$j('#loader').html('<div align="center" style="height:300px; "><img style="vertical-align:middle; padding-top:140px; " src="'+imgPath+'/ajax-loader_small.gif" alt="" border="0" /></div>');

	$j('#main_ractivities').load(base_path+url,function(response){
	if(trim(response)=='logout')
	{
		$j('#main_ractivities').html('');
		window.location=base_path;
		return false;
	}
	
	$j('#update-message').html('');
	});		
}

function getRecentActivityUrl()
{
	return window.recentActivityUrl;
}	

function getInfoBoxContent(data)
{
	var boxText = document.createElement("div");
	boxText.id = 'locationPopup';
	boxText.style.cssText = "border: 3px solid orange; margin-top: 8px; background: white; padding: 5px;";
	boxText.innerHTML = data;
	
	var myOptions = {
		content: boxText
		,disableAutoPan: false
		,maxWidth: 0
		,pixelOffset: new google.maps.Size(-140, 0)
		,zIndex: null
		,boxStyle: { 
		background: "url('tipbox.gif') no-repeat"
		,opacity: 1
		,width: "280px"
		}
		,closeBoxMargin: "12px 4px 2px 2px"
		//,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
		,closeBoxURL: imgPath+"/map-icon/close.png"
		,infoBoxClearance: new google.maps.Size(1, 1)
		,isHidden: false
		,pane: "floatPane"
		,enableEventPropagation: false
	};
	
	return myOptions;
}

function boxOpen(id)
{
	$j('#'+id).show();
}

function boxClose(id,fieldId)
{
	$j('#'+id).hide();
	$j('#'+fieldId).val('');
}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
	return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
	return stringToTrim.replace(/\s+$/,"");
}
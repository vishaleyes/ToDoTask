<script type="text/javascript">
var base_path='<?php echo Yii::app()->params->base_path; ?>';

$j(document).ready(function(){

$j(".avatar_link").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
	
	
	$j(".avatar_link").click(function(){
		$j("#apply_avatar").attr("disabled","disabled");
	});
	
	 
	//change password popup
	$j("#change_password").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
	//Make avatar entry in database
	$j('#apply_avatar').click(function(){
		
		$j('#loading_text').html(msg['_AVATAR_UPLOADING_']);
		$j('#loading_segment').fadeIn('fast');
		var action = '<?php echo Yii::app()->params->base_path;?>'+'user/avatar/stat/update';
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
					window.location.href = '<?php echo Yii::app()->params->base_path;?>';
				}
				else if(data['status']==0)
				{
					$j("#main_image_preview").attr('src','<?php echo Yii::app()->params->base_path;?>'+'upload/getAvatar/dir/'+data['dir']+'/fileName/'+data['result']).css("height","90px").css("width","90px");
					$j('#loading_segment').css('display','none');
					$j.fancybox.close();
				}
				else
				{
					$j('#loading_segment').css('display','none');
					$j.fancybox.close();
				}
			}
		});
	});
	
});

function boxOpen(id)
{
	$j('#'+id).show();
}

function boxClose(id,fieldId)
{
	$j('#'+id).hide();
	$j('#'+fieldId).val('');
}

function phoneBoxOpen(id)
{
	$j('#'+id).show();
}

function phoneBoxClose(id,fieldId)
{
	$j('#'+id).hide();
	$j('#errorAddPhone').html('');
	$j('#errorAddPhone').removeClass();
}

function addFiles()
{
	var base_path = '<?php echo Yii::app()->params->base_path;?>';
	$j('#loading_text').html(msg['_UPLOADING_']);
	$j('#loading_segment').fadeIn('fast');
	var action = base_path +'user/avatar';
	$j.ajaxFileUpload
	(
		{
			url:action,
			secureuri:false,
			fileElementId:'avatar',
			dataType: 'json',
			data: {id:$j("#id").val(),YII_CSRF_TOKEN:csrfTokenVal},
			success: function (data, status)
			{
				
				if(data['status'] == 0)
				{
					
					$j("#avatarPreview").attr('src',base_path+'upload/getAvatar/dir/'+data['dir']+'/fileName/'+data['result']);
					$j("#avatarPreview").load(function(){
						$j('#loading_segment').css('display','none');
					});
					$j("#file_name").val(data['result']);
					$j("#avatar").val('');
					$j("#apply_avatar").removeAttr('disabled');
				}
				else
				{
					$j('#loading_segment').css('display','none');
					alert(data['message']);	
				}
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	);
}
function setUrl(myurl)
	{
		
		smoothScroll('mainWrapper');
		$j('#update-message').removeClass();
		$j('#mainContainer').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" border="0" /> Loading...</div>').show();
		$j.ajax ({
				url: myurl,
				data: csrfToken,
				success: function(response)
				{
					if(trim(response)=='LOGOUT')
					{
						window.location=BASHPATH;
						return false;
					}
					$j('#mainContainer').html(response);
					//inner tab menu
					$j('#update-message').html('');
					//close inner tab menu
					return false;
				}
		});
	}
	


</script>
<h3 class="reddot">
   <p>##_LEFT_VIEW_PROFILE_##</p><div class="addtext"><a href="javascript:;" onclick="javascript:$j('#aboutme').trigger('click');" lang="" title="##_LEFT_VIEW_EDIT_##" class="editImg"> <img src="<?php echo Yii::app()->params->base_url; ?>images/edit.png" /></a></div>   
   <div class="clear"></div>
</h3>
<div class="box-body">
    <div class="avatar">
        <a id="avatar_link" class="avatar_link"  href="#inline2">  
            <?php if(!empty($users) && $users['avatar'] != '' && $users['avatar'] != NULL){ ?>
                <img id="main_image_preview" src="<?php echo Yii::app()->params->base_path; ?>upload/getAvatar/dir/<?php echo $imageDir;?>/fileName/<?php echo $users['avatar'];?>" height="90" width="90" alt="" border="0" />
            <?php }else{ ?>
                <img src="<?php echo Yii::app()->params->base_url; ?>images/avatar.png" id="main_image_preview" height="90" width="90" alt="Avatar"/>
            <?php } ?>
        </a>
    </div>
    <div class="userdetail">
        <div class="title" id="myfullname">
        	<b><?php echo Yii::app()->session['fullname']; ?></b>
        </div>
        <div class="user">
			<?php
                if($users['email'] != ''){
                    echo "<p>".$users['email']."</p>";
                } else { ?>
                    <a id="add_email" href="javascript:;" title="Add email"  onclick="javascript:$j('#aboutme').trigger('click');">
                    ##_LEFT_VIEW_ADD_EMAIL_##
                    </a>
                <?php
            }?>
			<?php  if($users['vPhone'] != ''){ ?>                            
                <div>
                     <span class="verified"><?php echo $users['vPhone']['loginId'];?></span>
                </div>     
            <?php
            }
            ?>
           <div id="socialLinks">
           	<a href="<?php if(isset($users['facebookLink'])){ echo $users['facebookLink']; }?>" id="facebookHomeLink" title="##_LEFT_VIEW_FACEBOOK_##" target="_blank">
				<?php if(isset($users['facebookLink']) && $users['facebookLink'] != ""){?><img src="<?php echo Yii::app()->params->base_url; ?>images/facebook-icon.png" /><?php } ?>
			</a> 
            
            <a href="<?php if(isset($users['twitterLink'])){ echo $users['twitterLink']; }?>" id="twitterHomeLink" title="##_LEFT_VIEW_TWITTER_##" target="_blank">
				<?php if(isset($users['twitterLink']) && $users['twitterLink'] != ""){?><img src="<?php echo Yii::app()->params->base_url; ?>images/twitter-icon.png" /><?php } ?>
			</a> 
            
            <a href="<?php if(isset($users['linkedinLink'])){ echo $users['linkedinLink']; }?>" id="linkedinHomeLink" title="##_LEFT_VIEW_LINKEDIN_##" target="_blank">
				<?php if(isset($users['linkedinLink']) && $users['linkedinLink'] != ""){?><img src="<?php echo Yii::app()->params->base_url; ?>images/linkedin-icon.png" /><?php } ?>
			</a> 
            
                
            </div>
        </div>
        
    </div>
    <div class="clear"></div>
</div>


<!--Upload avatar-->
<div id="content1" style="display:none;">
    <div id="test_t1">
        <div id="inline2" class="popup" style="width:470px; height:260px; overflow:auto;">
             <?php echo CHtml::beginForm('','post',array('id' => 'frm_avatar','name' => 'frm_avatar','enctype'=>"multipart/form-data")) ?>
                <input type="hidden" name="id" id="id1" value="<?php echo Yii::app()->session['userId'];?>" />
                <div>				
                    <table cellpadding="0" cellspacing="0" border="0" class="inbox-title popup-table avtar-popup">
                        <tr>
                            <th width="100%" class="lastcolumn">##_LEFT_VIEW_UPLOAD_AVATAR_##</th>
                        </tr>
                        <tr>
                            <td>
                                
                                  <?php if(isset($users) && $users['avatar'] != ''){ ?>
                                    <img id="avatarPreview" src="<?php echo Yii::app()->params->base_path; ?>upload/getAvatar/dir/<?php echo $imageDir;?>/fileName/<?php echo $users['avatar'];?>" height="90" width="90" alt="" border="0" />
                               <?php }else{ ?>
                                    <img src="<?php echo Yii::app()->params->base_url; ?>images/avatar.png" id="avatarPreview" height="90" width="90" alt="Avatar"/>
                                <?php } ?>
                                <p>Preferred image size is 90x90 pixels.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="alignCenter">
                                <div class="loading-text" id="loading_segment">
                                    <span id="loading_text"></span>
                                    <img src="<?php echo Yii::app()->params->base_url; ?>images/image_loader.gif"/> 
                                </div>
                                <input type="file" name="avatar" id="avatar" class="styled" onChange="addFiles()" style="width:180px;" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div align="center">
                    <input type="button" name="apply_avatar" id="apply_avatar" disabled="disabled" class="btn" value="##_BTN_APPLY_##" />
                </div>
                <input type="hidden" name="file_name" id="file_name" value="" />
            <?php echo CHtml::endForm();?>
        </div>
    </div>
</div>			
<!--end Upload avatar-->

<div class="clear"></div>
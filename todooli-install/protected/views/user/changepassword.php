<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path; ?>";	

$j(document).ready(function(){
	
	$j("#btn_change_password_menu").click(function(){
		if($j('#old_password_menu').val() == "")
		{	
			$j('#passwordreseterror_menu').removeClass().addClass('false');
			$j('#passwordreseterror_menu').html(msg['PASSWORD_VALIDATE']);
			$j('#old_password_menu').focus();
			return false;
		}
		
		if($j('#new_password_menu').val() == "" || $j('#new_password_menu').val().length < 6)
		{	
			$j('#passwordreseterror_menu').removeClass().addClass('false');
			$j('#passwordreseterror_menu').html(msg['VPASSWORD_VALIDATE']);
			$j('#new_password_menu').focus();
			return false;
		}
		
		if($j('#new_password_menu').val() != $j('#c_password_menu').val())
		{	
			$j('#passwordreseterror_menu').removeClass().addClass('false');
			$j('#passwordreseterror_menu').html(msg['MPASSWORD_VALIDATE']);
			$j('#c_password_menu').focus();
			return false;
		}
		$j('#passwordreseterror_menu').removeClass();
		$j('#passwordreseterror_menu').html('');
	
		var post_data = $j("#frm_change_password_menu").serialize();
		$j("#btn_change_password_menu").attr("disabled","disabled");
		$j("#loader_change_password").css('display','block');
		$j.ajax({			
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path; ?>'+'user/changePassword',
			data: post_data,
			cache: false,
			success: function(data)
			{
				if(trim(data) == "logout")
				{
					window.location.href = "<?php echo Yii::app()->params->base_path; ?>user";
				}
				else if(trim(data) == "success")
				{
					$j('#update-message').removeClass();
					$j('#update-message').addClass('msg_success');
					$j("#update-message").html(msg['FP_SUCCESS']);
					$j("#update-message").fadeIn();
					$j("#old_password_menu").val('');
					$j("#new_password_menu").val('');
					$j("#c_password_menu").val('');
					$j("#loader_change_password").css('display','none');
					setTimeout(function() 
					{
						$j('#update-message').fadeOut();
					}, 10000 );
					$j("#btn_change_password_menu").attr("disabled",false);
				}	
				else
				{
					$j("#btn_change_password_menu").attr("disabled",false);
					$j('#passwordreseterror_menu').removeClass().addClass('false');
					$j('#passwordreseterror_menu').html(data);
					$j("#loader_change_password").css('display','none');
				}
			}
		});
	});
});
</script>	
<div class="RightSide">
    <h1>##_PROFILE_CHANGE_MY_PASSWORD_##</h1>
    <div class="">
    <?php echo CHtml::beginForm('','post',array('id'=>'frm_change_password_menu','name'=>'frm_change_password_menu')) ?>
        <input type="hidden" id="user_id" name="userId" value="<?php echo Yii::app()->session['userId']; ?>" />
        
        <div class="field">
            <span id="passwordreseterror_menu"></span>
        </div>
        <div class="clear"></div>
        
        <div class="field">
            <label>##_PROFILE_OLD_PASSWORD_##</label>
            <input type="password" maxlength="20" name="oldpassword" class="textbox width159" id="old_password_menu"/>
        </div>
        <div class="clear"></div>
        
        <div class="field">
            <label>##_PROFILE_NEW_PASSWORD_##</label>
            <input type="password" maxlength="20" name="newpassword" class="textbox width159" id="new_password_menu"/>
        </div>
        <div class="clear"></div>
        
        <div class="field">
            <label>##_PROFILE_CONFIRM_PASSWORD_##</label>
            <input type="password" maxlength="20" name="confirmpassword" class="textbox width159" id="c_password_menu"/>
        </div>
        <div class="clear"></div>
            
        <div class="btnfield">
            <input type="button" id="btn_change_password_menu"  name="btn_change_password_menu" value="##_BTN_SUBMIT_##" class="btn" />
            <input id="btn_cancel_password" type="button" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>user'" value="##_BTN_CANCEL_##" class="btn" />
            <span><img style="display:none; margin-left:20px; position:absolute;" id="loader_change_password" src="<?php echo Yii::app()->params->base_url; ?>images/spinner-small.gif" border="0" /></span>
            <div class="clear"></div>
        </div>
            
    <?php echo CHtml::endForm();?>
    </div>
</div>
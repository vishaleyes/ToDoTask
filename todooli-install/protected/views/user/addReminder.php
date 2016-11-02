<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	$j('#update-message').removeClass().html('');
	var lis	=	$j('.navigation ul').find('li');
	$j(lis).removeClass('current');
	$j('#reminders')
		.addClass('current');

	$j('.navigation_pagination').click(function() {
		$arr = $j(this).attr("lang").split("*");
		$j('#maincontainer').load($arr[0],function(response){	
			if(response == 'logout')
			{
				$j('#maincontainer').html('');
				window.location.href = "<?php echo Yii::app()->params->base_path; ?>user";
			}
		 });
	});
	
});
$j(function() {
	var dates = $j( "#startdate, #enddate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "startdate" ? "minDate" : "maxDate",
				instance = $j( this ).data( "datepicker" ),
				date = $j.datepicker.parseDate(
					instance.settings.dateFormat ||
					$j.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});

function validateReminderName()
{
	$j('#nameError')
		.removeClass()
		.html('');
	var fName=document.getElementById('reminderName').value,
		reg = msg["FULL_NAME_REG"];
		
	if( fName != '' ) {
		if( reg.test(fName) ) {
			$j('#nameError')
				.removeClass()
				.addClass('true')
				.html('##_BTN_OK_##');
			return true;
		} else {
			$j('#nameError')
				.removeClass()
				.addClass('false')
				.html(msg['REMINDER_NAME_REG_SPECIAL_CHARACTER']);
			return false;
		}
	}
	return true;
}

function validateList() {
	if ( !$j("#todoList option:selected").length ) {
		$j('#listError')
			.removeClass()
			.addClass('false')
			.html(msg['REMINDER_LIST_ATLEAST_ONE']);
		return false;
	} else {
		$j('#listError')
			.removeClass()
			.addClass('true')
			.html('##_BTN_OK_##');
			return true;
	}
}

function add_reminder() {
	$j('#update-message').removeClass().html('<div class="updateLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
	if(!validateAll())
	{
		$j('#update-message').html('');
		return false;
	}
	
	$j("#btnSubmitReminder").attr("disabled","disabled");
	var postData	=	$j('#addReminder').serialize();
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/addReminder',
		data: postData,
		cache: false,
		success: function(data)
		{
			if( trim(data) == 'logout' ) {
				$j('#mainContainer').html('');
				window.location=BASHPATH;
				return false;
			}
			$j("#btnSubmitReminder").attr("disabled",false);
			var obj = $j.parseJSON(data);
			if(obj.status == 0){
				$j('#mainContainer')
					.load('<?php echo Yii::app()->params->base_path;?>user/reminders', function() {
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html(obj.message);
						$j("#update-message").fadeIn();
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
					});
				$j('#reminderAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/remindersAjax');
			} else {
				$j("#btnSubmitReminder").attr("disabled",false);
				$j("#update-message").removeClass().addClass('error-msg');
				$j("#update-message").html(obj.message);
				$j("#update-message").fadeIn();
			}
		}
	});
}
function validateStatus(){
	var radios = document.getElementsByName('status')

    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
			$j('#statusError').removeClass().html('');
			return true; // checked
    	}
    };

    // not checked, show error
	$j('#statusError').addClass('false').html('Select atleast one');
	return false;
}
function validateDueDate(){
	var radios = document.getElementsByName('dueDate')

    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
			$j('#dueDateError').removeClass().html('');
			return true; // checked
    	}
    };

    // not checked, show error
	$j('#dueDateError').addClass('false').html('Select atleast one');
	return false;
}
function validateAll(){
	if(!validateReminderName()) {
		return false;
	}
	if(!validateList()) {
		return false;
	}
	if(!validateStatus()) {
		return false;
	}
	if(!validateDueDate()) {
		return false;
	}
	
	return true;
}
</script>
<div id="update-message"></div>
<div class="RightSide">
    <div align="center">
    <?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    </div>

	<h1>
    <?php if(isset($data['id'])){
		echo '##_EDIT_REMINDER_##';
	} else {
		echo '##_ADD_REMINDER_##';
	}?>
    </h1>

 	<?php echo CHtml::beginForm('','post',array('id' => 'addReminder','name' => 'addReminder','enctype'=>'multipart/form-data')) ?>
    <?php
	if(isset($data['id'])){ ?>
    	<input type="hidden" value="<?php if(isset($data['id'])){ echo $data['id']; } ?>" name="id" />
    <?php
	}?>
    <div class="field">
    	<label>##_REMINDER_NAME_##<span id="nameError"></span></label>
        <input type="text" maxlength="25" class="textbox" id="reminderName" name="reminderName" <?php if( isset($data['name']) ) {?> value="<?php echo $data['name'];?>"<?php }?> onkeyup="validateReminderName()" />
    </div>
    <div class="clear"></div>
    <div class="field">
    	<label>##_LIST_NAME_##<span class="star">*</span><span id="listError"></span></label>
        <select name="todoList[]" id="todoList" class="select-box" multiple="multiple" style="height:90px;">
        	<option value="0" <?php if( isset($data['reminderList']) && in_array(0, $data['reminderList']) ) {?> selected="selected"<?php }?>>##_ALL_##</option>
        	<?php 
			foreach($data['lists'] as $row){ ?>
            	<option value="<?php echo $row['id']; ?>" id="opt_selection_<?php echo $row['id']; ?>" <?php if( isset($data['reminderList']) && in_array($row['id'], $data['reminderList']) ) {?> selected="selected"<?php }?>>
				<?php 
				echo $row['name'];
				if(isset($seen) && in_array($row['name'],$seen)) {
					echo " - " .$row['firstName'].' '. $row['lastName'];
				}?>
                </option>
            <?php 
			}?>
        </select>
    </div>
    <div class="clear"></div>

    <div class="field" id="status"><span id="statusError"></span>
        <label >##_REM_STATUS_##</label>
        <input type="radio" name="status" value="0" <?php if(isset($data['itemStatus'])){ if($data['itemStatus']==0){?>checked="checked"<?php }} else {?>checked="checked" <? }?> /> ##_REM_ANY_##
		<input type="radio" name="status" value="1" <?php if(isset($data['itemStatus']) && $data['itemStatus']==1){?>checked="checked"<?php }?> /> ##_REM_OPEN_##
        <input type="radio" name="status" value="2" <?php if(isset($data['itemStatus']) && $data['itemStatus']==2){?>checked="checked"<?php }?> /> ##_REM_CLOSE_##
    </div>
    <div class="clear"></div>

 	<div class="field"><span id="dueDateError"></span>
        <label>##_REM_DUE_DATE_##</label>
        <input type="radio" name="dueDate" value="0" <?php if(isset($data['dueDate'])){ if($data['dueDate']==0){?>checked="checked"<?php }} else {?>checked="checked"<? }?> /> ##_REM_ANY_##
		<input type="radio" name="dueDate" value="1" <?php if(isset($data['dueDate']) && $data['dueDate']==1){?>checked="checked"<?php }?> /> ##_REM_TODAY_##
        <input type="radio" name="dueDate" value="2" <?php if(isset($data['dueDate']) && $data['dueDate']==2){?>checked="checked"<?php }?> /> ##_REM_WEEK_## 
    </div>
    <div class="clear"></div>
    
    <div class="field">
        <input type="checkbox" name="summaryOnly" id="summaryOnly" value="1" <?php if( isset($data['summaryStatus']) && $data['summaryStatus'] == 1 ) {?> checked="checked"<?php } ?> /> <b>##_SUMMARY_ONLY_##</b>
    </div>
    <div class="clear"></div>

    <div class="field">
        <label>##_REM_AT_##</label>
        <select name="time" class="select-box2 width65">
                  <option <?php if(isset($data['time']) && $data['time']==1){?>selected="selected"<?php }?>>
                  	1
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==2){?>selected="selected"<?php }?>>
                  	2
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==3){?>selected="selected"<?php }?>>
                  	3
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==4){?>selected="selected"<?php }?>>
                  	4
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==5){?>selected="selected"<?php }?>>
                  	5
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==6){?>selected="selected"<?php }?>>
                  	6
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==7){?>selected="selected"<?php }?>>
                  	7
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==8){?>selected="selected"<?php }?>>
                  	8
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==9){?>selected="selected"<?php }?>>
                  	9
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==10){?>selected="selected"<?php }?>>
                  	10
                  </option>
				  <option <?php if(isset($data['time']) && $data['time']==11){?>selected="selected"<?php }?>>
                  	11
                  </option>
                  <option <?php if(isset($data['time']) && $data['time']==12){?>selected="selected"<?php }?>>
                  	12
                  </option>
		</select>&nbsp;
		<select name="ampm" class="select-box2 width65">
              <option <?php if(isset($data['ampm']) && $data['ampm']=='am'){?>selected="selected"<?php }?>>
              	AM
              </option>
              <option <?php if(isset($data['ampm']) && $data['ampm']=='pm'){?>selected="selected"<?php }?>>
              	PM
              </option>
		</select>
            
        <select class="select-box width119" name="duration">
                  <option <?php if(isset($data['duration']) && $data['duration'] == 0){ ?>selected="selected" <?php } ?> value="0">Daily</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 1){ ?>selected="selected" <?php } ?> value="1">Sunday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 2){ ?>selected="selected" <?php } ?> value="2">Monday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 3){ ?>selected="selected" <?php } ?> value="3">Tuesday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 4){ ?>selected="selected" <?php } ?> value="4">Wednesday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 5){ ?>selected="selected" <?php } ?> value="5">Thursday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 6){ ?>selected="selected" <?php } ?> value="6">Friday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 7){ ?>selected="selected" <?php } ?> value="7">Saturday</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 8){ ?>selected="selected" <?php } ?> value="8">Monthly</option>
                  <option <?php if(isset($data['duration']) && $data['duration'] == 9){ ?>selected="selected" <?php } ?> value="9">Yearly</option>
				</select>
    </div>
    <div class="clear"></div>
        
    <div class="btnfield">
        <input type="button" id="btnSubmitReminder" name="submitReminder" class="btn" value="##_BTN_SUBMIT_##" onclick="add_reminder();" />
        <input type="button" name="Back" class="btn" value="##_BTN_CANCEL_##" onclick="$j('#reminders').trigger('click');" />
    </div>
<?php echo CHtml::endForm(); ?> 
</div>
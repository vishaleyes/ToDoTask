<script type="text/javascript">
var resbool;
$j(document).ready(function(){
		
	$j("#addtodolistPop").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 700,
 		'height' : 650
	});
	
	$j("#userSelectLink").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',	
		'type'	 : 'iframe',		
		'width' : 700,
 		'height' : 450
	});
	$j('#errormsg').removeClass();
	$j('#errormsg').html('');
	
});

function IsNumeric(input)
{
    return (input - 0) == input && input.length > 0;
}
function addAttachFiles()
{
	
	var base_path = '<?php echo Yii::app()->params->base_path;?>';
	var action = base_path +'user/attachment';
	$j('#attachmentNotice').html('<img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Uploading...');
	$j.ajaxFileUpload
	(
		{
			url:action,
			secureuri:false,
			fileElementId:'attachmentFile',
			dataType: 'json',
			data: {YII_CSRF_TOKEN:csrfTokenVal},
			success: function (data, status)
			{				
				$j("#attachment").val(data);
				$j('#attachmentNotice').html(data);	
				
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	);
}

function validateAll()
{
	var title = $j("#title").val();
	var duedate = $j("#startdate").val();
	var email = $j("#userlist").val();
	var list = $j("#todoListSelectBox").val();
	var bool = false;
	

	if(list=='')
	{
		$j("#todoListMsg").addClass('false');
		$j("#todoListMsg").html('Please select list.');
		bool = true;
	}
	if(title=='')
	{	
		$j("#titlemsg").addClass('false');
		$j("#titlemsg").html('Please enter title.');
		bool = true;
	}
	else
	{
		$j('#titlemsg').removeClass();
		$j('#titlemsg').addClass('true');
		$j('#titlemsg').html('##_BTN_OK_##');
		return true;
	}
	if(duedate=='')
	{
		$j("#duedatemsg").addClass('false');
		$j("#duedatemsg").html('Please enter dueDate.');
		bool = true;
	}
	else
	{
		$j("#duedatemsg").removeClass('false');
		$j("#duedatemsg").html('');
	}
	
	if(document.getElementById('selfRadioBtn').checked==false)
	{
		if(email=='')
		{
			$j("#msg").addClass('false');
			$j("#msg").html('Please select email.');
			bool = true;
		}
		else
		{
			$j("#msg").removeClass('false');
			$j("#msg").html('');
		}
	}
	if(bool == true)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function addItem(){
	var res1  = validateAll();
	if(res1)
	{
	$j("#btnSubmitTodo").attr("disabled","disabled");
	$j("#update-message").removeClass().html('<img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" />');	
	 var postData	=	$j('#addTodoForm').serialize();
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/addTodoItem',
		data: postData,
		cache: false,
		success: function(data)
		{
			var obj = $j.parseJSON(data);
			if(obj.status == 0){
				$j("#update-message").removeClass().addClass('msg_success');
				$j("#update-message").html(obj.message);
				$j("#update-message").fadeIn();
				window.location.href	=	'<?php echo Yii::app()->params->base_path;?>user';
				/*document.getElementById('addTodoForm').reset();
				$("#assignBox").hide();*/
			} else {
				$j("#btnSubmitTodo").attr("disabled",false);	
				$j("#update-message").removeClass().addClass('error-msg');
				$j("#update-message").html(obj.message);
				$j("#update-message").fadeIn();
			}
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
			
		}
	});
	}
}

$j(function() {
			var dates = $j( "#startdate, #enddate" ).datepicker({
				defaultDate: "+1w",
				dateFormat: 'yy-mm-dd',
				minDate: 0,
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
</script>
<script type="text/javascript">
function addTodoList(){
	var title =  $j("#todoListtitle").val();
	if(title=='')
	{
		$("#todoListtitlemsg").css('display','');
		$("#todoListtitlemsg").addClass('false');
		$("#todoListtitlemsg").text("Please enter list name");
		return false;
	}
	else
	{
		$j("#btnSubmitList").attr("disabled","disabled");
		var postData	=	$j('#addTodoForm1').serialize();
		$j.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>user/saveToDoList',
			data: postData,
			cache: false,
			success: function(data)
			{
				
				var obj = $j.parseJSON(data);
				if(obj.succstr != ''){
					parent.$j("#update-message").removeClass().addClass('msg_success');
					parent.$j("#update-message").html(obj.succstr);
					parent.$j("#update-message").fadeIn();
					$j.fancybox.close();
					document.getElementById('addTodoForm1').reset();
					$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/addtodo');
					$j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax');
					}
					if(obj.errstr != ''){
					$j("#btnSubmitList").attr("disabled",false);	
					parent.$j("#update-message1").removeClass().addClass('error-msg');
					parent.$j("#update-message1").html(obj.errstr);
					parent.$j("#update-message1").fadeIn();
					}
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
				setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
			}
		});
	}
}

function chkIsMyTodo(id)
{
	if(id==1)
	{
		$j("#assignBox").hide();
	}
	else
	{
		$j("#assignBox").show();
	}
}
</script>
<div class="RightSide">
	<div id="update-message"></div>
    <div id="update-message1"></div>
    <div class="clear"></div>
	<h1>##_ADD_TODO_##</h1>
    <?php echo CHtml::beginForm('','post',array('id' => 'addTodoForm','name' => 'addTodoForm','enctype'=>'multipart/form-data')) ?>
    <input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>"  />
    
	<div class="field">
    	<label>##_ADD_TODO_LIST_NAME_## <span id="todoListMsg"></span></label>
        <select name="todoList" id="todoListSelectBox" class="select-box" >
        	
        <?php 
		if(count($data['myLists']) > 0){
			foreach($data['myLists'] as $row){ ?>
			<option value="<?php echo $row['id']; ?>"  <?php if($lastFavrite['last_listId']==$row['id']){ echo "selected='selected'";}?>  ><?php echo $row['name']; ?> <?php if(isset($seen) && in_array($row['name'],$seen)) { echo " - " .$row['firstName'].' '. $row['lastName']; } ?> </option>
			<?php 
			}
		} else { ?>
            <option value="" selected="selected" >##_ADD_TODO_NO_LIST_##</option>
        <?php
		}?>
        </select>
        <span>
            <a id="addtodolistPop" href="#addtodo">##_ADD_TODO_CREATE_NEW_##</a>
        </span>
    </div>
    <div class="clear"></div>
    
    <div class="field">
    	<label>##_ADD_TODO_TITLE_## * <span id="titlemsg"></span></label>
        <input type="text" name="title" class="textbox" id="title" value="" />
    </div>
    <div class="clear"></div>
    
    <div class="field">
    	<label>##_ADD_TODO_DESC_##</label>
		<?php
        $this->widget('application.extensions.cleditor.ECLEditor', array(
        'name'=>'description',
        'value'=>'',
        ));
        ?>
    </div>
    <div class="clear"></div>
    
    <div class="field">
    	<label>##_ADD_TODO_ATTACH_## <span id="attachmentNotice">&nbsp;</span></label>
        <input type="file" onchange="addAttachFiles()"  name="attachmentFile" id="attachmentFile" />
        <input type="hidden" name="attachment" id="attachment" value="" />  
    </div>
    <div class="clear"></div>
    
    <div class="field">
    	<label>##_ADD_TODO_PRIORITY_## *</label>
        <select name="priority" class="select-box">
            <option <?php if($lastFavrite['last_priority']==0){ echo "selected=selected";}?> value="0" selected="selected">##_ADD_TODO_PRIORITY_LOW_##</option>
            <option  <?php if($lastFavrite['last_priority']==1){ echo "selected=selected";}?>  value="1">##_ADD_TODO_PRIORITY_MEDIUM_##</option>
            <option  <?php if($lastFavrite['last_priority']==2){ echo "selected=selected";}?>  value="2">##_ADD_TODO_PRIORITY_HIGH_##</option>
            <option  <?php if($lastFavrite['last_priority']==3){ echo "selected=selected";}?>  value="3">##_ADD_TODO_PRIORITY_URGENT_##</option>
        </select>
    </div>
    <div class="clear"></div>
    
    <div class="field">
        <label>##_ADD_TODO_DUE_DATE_## * <span id="duedatemsg"></span></label>
        <input name="duedate" id="startdate" class="textbox datebox" type="text" value="<?php echo date("Y-m-d", strtotime("1 days")); ?>"/>
        
    </div>
    <div class="clear"></div>
   <?php   if(strlen($lastFavrite['last_todoassign'])<=1)
	{
		$lastFavrite['last_todoassign']='';	
	}
	?>
    <div class="field"  >
        <label>##_ADD_TODO_ASSIGN_##</label>
        <div class="checkbox1"><input type="radio" name="assignerType" <?php if($lastFavrite['last_todoassign']=='') {?> checked="checked" <?php }?> id="selfRadioBtn" onclick="chkIsMyTodo('1')" value="self" /><span>##_ADD_TODO_ASSIGN_SELF_##</span></div>
        <div class="clear"></div>
        <div class="checkbox1"><input type="radio" <?php if($lastFavrite['last_todoassign']!='') {?> checked="checked"  <?php }?> onclick="chkIsMyTodo('2')" name="assignerType" id="othersRadioButton" value="other" /><span>##_ADD_TODO_ASSIGN_OTHER_##</span></div>
        <div class="clear"></div>
        <div id="assignBox" <?php if($lastFavrite['last_todoassign']=='') {?> style="display:none;"  <?php }?>>
            <input type="text" name="userlist"   id="userlist" class="textbox"  value="<?php echo $lastFavrite['last_todoassign'];?>" /><a href="<?php echo Yii::app()->params->base_path;?>user/myNetworkUser" id="userSelectLink" > ##_ADD_TODO_SELECT_EMAIL_##</a> <span id="msg">&nbsp;</span>&nbsp;
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    
    <div class="fieldBtn">
        <input type="button" class="btn" id="btnSubmitTodo" name="submit" value="##_BTN_SUBMIT_##" onclick="addItem();"  />
        <input type="button" class="btn" name="cancel" value="##_BTN_CANCEL_##" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path ?>'" />
    </div>
    <?php echo CHtml::endForm(); ?> 
</div>

<div id="addtodo_form" style="display:none;">
    <div>
        <div id="addtodo" class="popup" style="width:350px; height:340px; overflow:auto;">
               
<h1 align="center">##_ADD_TODO_LIST_##</h1>
 <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/saveToDoList','post',array('id' => 'addTodoForm1','name' => 'addTodoForm1')) ?>
    <input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>" />
    
    <div class="field">
		<label>##_ADD_TODO_LIST_NAME_##<span id="todoListtitlemsg"></span></label>
        <input type="text" name="todoList" id="todoListtitle" class="textbox" value="" />
        
    </div>
    <div class="clear"></div>
    
    <div class="field">
		<label>##_ADD_TODO_DESC_##</label>
        <?php
		$this->widget('application.extensions.cleditor.ECLEditor', array(
		'name'=>'description',
		'value'=>'',
		));
		?>
    </div>
    <div class="clear"></div>
    
    <div class="field">
		<label>##_ADD_TODO_INVITE_##</label>
        <input type="text" name="userlist" class="textbox" value="" /> <div><span class="info">(##_ADD_TODO_INVITE_EXAMPLE_##)</span></div>
    </div>
    <div class="clear"></div>
    
    <div class="fieldBtn">
    	<input type="button" class="btn" name="submit"  value="##_BTN_SUBMIT_##" onclick="addTodoList()" />
        <input type="button" class="btn" name="cancel" value="##_BTN_CANCEL_##" onclick="$j.fancybox.close();"/>
    </div>
    
    <?php echo CHtml::endForm(); ?> 

        </div>
    </div>
</div>
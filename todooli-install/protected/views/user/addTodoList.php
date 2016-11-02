<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.cleditor.min.js"></script>
<script type="text/javascript">
function validateall()
{
		if(!validatelistname())
		{
			return false;
		}
		if(!addTodoList())
		{
			return false;
		}
			
		return true;	
	
}
function validatelistname()
	{
		var title =  $j("#todoList").val();
		reg = msg["FULL_NAME_REG"];
		if(title=='')
			{
				$j('#titlemsg').removeClass();
				$j('#titlemsg').addClass('false');
				$j('#titlemsg').html('Please enter list name.');
				return false;
			}
			else
			{
				if( title != '' ) {
					
				if(title.length > 25)
				{
					$j('#titlemsg').removeClass();
					$j('#titlemsg').addClass('false');
					$j('#titlemsg').html('Please enter maximum 25 characters in listname.');
					return false;
				}	
					
				if( reg.test(title) ) {
					$j('#titlemsg')
						.removeClass()
						.addClass('true')
						.html('##_BTN_OK_##');
					return true;
				} else {
					$j('#titlemsg')
						.removeClass()
						.addClass('false')
						.html(msg['REMINDER_NAME_REG_SPECIAL_CHARACTER']);
					return false;
				}
				}
				$j('#titlemsg').removeClass();
				$j('#titlemsg').addClass('true');
				$j('#titlemsg').html('##_BTN_OK_##');
				return true;	
			}
		
	}
function addTodoList(){
		$j("#btnSubmitTodolist").attr("disabled","disabled");
		var postData	=	$j('#addTodoForm').serialize();
		$j.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>user/saveToDoList',
			data: postData,
			cache: false,
			success: function(data)
			{
				var obj = $j.parseJSON(data);
				$j("#btnSubmitTodolist").attr("disabled",false);
				if(obj.succstr != ''){
					parent.$j("#update-message").removeClass().addClass('msg_success');
					parent.$j("#update-message").html(obj.succstr);
					parent.$j("#update-message").fadeIn();
					$j.fancybox.close();
					document.getElementById('addTodoForm').reset();
					//$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/myLists');
					$j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax');
					}
					if(obj.errstr != ''){
					
					parent.$j("#update-message1").removeClass().addClass('error-msg');
					parent.$j("#update-message1").html(obj.errstr);
					parent.$j("#update-message1").fadeIn();
					}
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
				setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
			}
		});
	}

</script>
<div class="RightSide">
<div class="main-wrapper">
	<div id="update-message"></div>
    <div id="update-message1"></div>
    <div class="clear"></div>
    <h1>##_TODO_LIST_ADD_TODO_##</h1>
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/saveToDoList','post',array('id' => 'addTodoForm','name' => 'addTodoForm')) ?>
    <input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>"  />
    
    <div class="field">
		<label>##_TODO_LIST_TODO_NAME_## * <span id="titlemsg"></span></label>
        <input type="text" name="todoList" id="todoList" class="textbox" value="" onblur="validatelistname();"/>
        
    </div>
    <div class="clear"></div>
    
    <div class="field">
		<label>##_TODO_LIST_DESC_##</label>
        <?php
		$this->widget('application.extensions.cleditor.ECLEditor', array(
		'name'=>'description',
		'value'=>'',
		));
		?>
    </div>
    <div class="clear"></div>
    
    <div class="field">
		<label>##_TODO_LIST_INVITE_##</label>
        <input type="text" name="userlist" class="textbox" value="" /> <div><span class="info">(##_TODO_LIST_INVITE_EXAMPLE_##)</span></div>
    </div>
    <div class="clear"></div>
    
    <div class="fieldBtn">
    	<input type="button" class="btn" id="btnSubmitTodolist" name="submit" value="##_BTN_SUBMIT_##" onclick="validateall()" />
        <input type="button" class="btn" name="cancel" value="##_BTN_CANCEL_##" onclick="$j('#mylists').trigger('click');" />
    </div>
    
    <?php echo CHtml::endForm(); ?> 
</div>
</div>

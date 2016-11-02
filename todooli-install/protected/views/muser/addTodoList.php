	<div class="title">##_MOBILE_USER_ADD_LIST_TODO_##</div>
   
	<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
	
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/saveToDoList','post',array('id' => 'addTodoForm','name' => 'addTodoForm')) ?>
	<input type="hidden" id="id" name="id" value="<?php echo Yii::app()->session['userId']; ?>" />
	<div class="field-area">
		<div class="field">
            <label>##_MOBILE_USER_ADD_LIST_TODO_NAME_## *<span id="nameerror"></span></label>
            <input type="text" name="todoList" id="todoList" maxlength="18" value="" class="textbox" onfocus="this.style.color='black';" />
        </div>
		<div class="field">
            <label>##_MOBILE_USER_ADD_LIST_DESC_## </label>
            <textarea name="description" id="description"  cols="40" class="textarea" rows="5" onfocus="this.style.color='black';"></textarea>
            
        </div> 
		<div class="field">
            <label>##_MOBILE_USER_ADD_LIST_INVITE_## <span id="emailerror">##_MOBILE_USER_ADD_LIST_INVITE_EXAMPLE_##</span></label>
            <input type="text" maxlength="256" name="userlist" class="textbox" value="" onfocus="this.style.color='black';"/>
            
        </div>
				
		<div align="left">
			<input type="submit" id="btn_submit"  name="btn_submit" value="##_BTN_SUBMIT_##" class="btn" />  
            <input type="button" value="##_BTN_CANCEL_##" onclick="javascript:history.go(-1);" class="btn" />
		</div>               
	</div>
	<div class="clear"></div>
<?php echo CHtml::endForm();?>
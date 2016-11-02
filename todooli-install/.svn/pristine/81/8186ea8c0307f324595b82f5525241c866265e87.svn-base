	<div class="title">##_MOBILE_USER_ADD_INVITE_NEW_##</div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
	
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/addInviteUser','post',array('id' => 'addInviteForm','name' => 'addInviteForm')) ?>
	<input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>"  />
	<div class="field-area">
		<div class="field">
        	<label>##_MOBILE_USER_ADD_INVITE_TODO_LIST_##</label>
            <select class="select-box" name="todoList">
			    <?php  
				if(count($myList) > 0){
					foreach($myList as $row){?>
					<option selected="selected" value="<?php echo $row['id']; ?>"><?php echo $row['name'];?></option>
					<?php 
					}
				} else { ?>
					<option value="" selected="selected" >##_MOBILE_USER_ADD_INVITE_NO_LIST_##</option>
				<?php
				}?>
            </select>
        </div>
		<div class="field">
            <label>##_MOBILE_USER_ADD_INVITE_INVITE_##</label>
            <input type="text" name="userlist" id="userlist" class="textbox" value="" />
            <span id="titlemsg" style="color:#F00;"></span>
        </div>
				
		<div align="left">
			<input type="submit" id="btn_submit"  name="btn_submit" value="##_BTN_SUBMIT_##" class="btn" />  
            <input type="button" value="##_BTN_CANCEL_##" onclick="javascript:history.go(-1);" class="btn" />
		</div>               
	</div>
	<div class="clear"></div>
    
<?php echo CHtml::endForm();?>
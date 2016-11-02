	<div class="title">##_MOBILE_ADD_NETWORK_ADD_TODO_##</div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
	
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/addInviteUser','post',array('id' => 'addTodoNetworkForm','name' => 'addTodoNetworkForm')) ?>
	<input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>"  />
	<div class="field-area">
		<div class="field">
            <label>##_MOBILE_ADD_NETWORK_EMAIL_## *</label>
            <input type="text" name="email" id="email" class="textbox" value="" />
            <span id="titlemsg" style="color:#F00;"></span>
        </div>
		<div class="field">
        	<label>##_MOBILE_ADD_NETWORK_TODO_LIST_NAME_##</label>
            <select class="select-box" name="todoList">
			    <?php 
				if(count($list) > 0){
					foreach($list as $row){ ?>
					<option selected="selected" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> -  <?php if($row['createdBy']==Yii::app()->session['loginId']){ echo "Me";}else { echo $row['firstName'].' '. $row['lastName'];} ?></option>
					<?php 
					}
				} else { ?>
					<option value="" selected="selected" >##_MOBILE_ADD_NETWORK_NO_LIST_##</option>
				<?php
				}?>
            </select>
        </div>
				
		<div align="left">
			<input type="submit" id="btn_submit"  name="btn_submit" value="##_BTN_SUBMIT_##" class="btn" />  
            <input type="button" value="##_BTN_CANCEL_##" onclick="javascript:history.go(-1);" class="btn" />
		</div>               
	</div>
	<div class="clear"></div>
   
<?php echo CHtml::endForm();?>
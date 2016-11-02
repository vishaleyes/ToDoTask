<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/todooliapp/jquery-1.7.2.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>


<script>

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
<div class="title">##_MOBILE_USER_ADD_ITEMS_TODO_##</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
<div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
<div class="clear"></div>
<?php endif; ?>
	
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/addTodo','post',array('id' => 'addTodoForm1','name' => 'addTodoForm1','enctype'=>'multipart/form-data')) ?>
	<!--<input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>"  />-->
	<div class="field-area">
		<div class="field">
        	<label>##_MOBILE_USER_ADD_ITEMS_TODO_LIST_NAME_##</label>
            <select class="select-box" name="todoList">
			    <?php 
				if(count($data['myLists']) > 0){
					foreach($data['myLists'] as $row){ ?>
					<option value="<?php echo $row['id']; ?>"  <?php if($lastFavrite['last_listId']==$row['id']){ echo "selected='selected'";}?>  ><?php echo $row['name']; ?></option>
					<?php 
					}
				} else { ?>
					<option value="" selected="selected" >##_MOBILE_USER_ADD_ITEMS_NO_LIST_##</option>
				<?php
				}?>
            </select>
        </div>
		<div class="field">
            <label>##_MOBILE_USER_ADD_ITEMS_TITLE_## *</label>
            <input type="text" name="title" id="title" class="textbox" value="" />
            <span id="titlemsg" style="color:#F00;"></span>
        </div>
		<div class="field">
            <label>##_MOBILE_USER_ADD_ITEMS_DESC_## </label>
            <textarea name="description" id="description"  cols="40" class="textarea" rows="5" onfocus="this.style.color='black';"></textarea>
        </div> 
        <div class="field">
    	<label>##_ADD_TODO_ATTACH_##</label>
        <input type="file" onchange="addFiles()"  name="attachmentFile" id="attachmentFile" /><span id="attachmentNotice">&nbsp;</span>
        <input type="hidden" name="attachment" id="attachment" value="" />  
    </div>
    	<div class="clear"></div>
    
		<div class="field">
        	<label>##_MOBILE_USER_ADD_ITEMS_PRIORITY_## *</label>
            <select class="select-box" name="priority">
              <option <?php if($lastFavrite['last_priority']==0){ echo "selected=selected";}?> value="0" selected="selected">##_MOBILE_USER_ADD_ITEMS_PRIORITY_LOW_##</option>
            <option  <?php if($lastFavrite['last_priority']==1){ echo "selected=selected";}?>  value="1">##_MOBILE_USER_ADD_ITEMS_PRIORITY_MEDIUM_##</option>
            <option  <?php if($lastFavrite['last_priority']==2){ echo "selected=selected";}?>  value="2">##_MOBILE_USER_ADD_ITEMS_PRIORITY_HIGH_##</option>
            <option  <?php if($lastFavrite['last_priority']==3){ echo "selected=selected";}?>  value="3">##_MOBILE_USER_ADD_ITEMS_PRIORITY_URGENT_##</option>			   
            </select>
        </div>
		<div class="field">
            <label>##_MOBILE_USER_ADD_ITEMS_DUE_DATE_## * ##_MOBILE_USER_ADD_ITEMS_DATE_FORMATE_##</label>
            <input type="text" name="duedate" id="startdate" class="textbox" value="<?php echo date("Y-m-d", strtotime("1 days")); ?>" />
        </div> 
		<div class="field">
            <label>##_MOBILE_USER_ADD_ITEMS_ASSIGN_##</label>
            <div class="fields fieldswidth88" id="languagesselected">
            	<?php
				
                 if(strlen($lastFavrite['last_todoassign'])<=1)
				{
					$lastFavrite['last_todoassign']='';	
				}
				?>
                <div class="checkbox1"><input type="radio" name="assignerType" <?php if(isset($lastFavrite['last_todoassign']) && $lastFavrite['last_todoassign']==''){?> checked="checked" <?php }?> id="selfRadioBtn" onchange="chkIsMyTodo('1')" value="self" /> <span>##_MOBILE_USER_ADD_ITEMS_ASSIGN_SELF_##</span></div>
        		<div class="clear"></div>
                <div class="checkbox1"><input type="radio" <?php if(isset($lastFavrite['last_todoassign']) && $lastFavrite['last_todoassign']!=''){?>  checked="checked" <?php }?> onchange="chkIsMyTodo('2')" name="assignerType" value="other" /> <span>##_MOBILE_USER_ADD_ITEMS_ASSIGN_OTHER_##</span></div>
        		<div class="clear"></div>
                <div id="assignBox" <?php if(isset($lastFavrite['last_todoassign']) && $lastFavrite['last_todoassign']==''){?>style="display:none;" <?php }?>>
                ##_MOBILE_USER_ADD_ITEMS_SELECT_EMAIL_##
                <select name="userlist"  id="userlist" class="select-box" >
                <?php foreach($networkdata as $row){ ?>
                <option value="<?php echo $row['loginId']; ?>" <?php if(isset($lastFavrite['last_todoassign']) && $lastFavrite['last_todoassign']==$row['loginId']) { echo "selected=selected";} ?>><?php echo $row['loginId']; ?></option>
                <?php } ?>
                </select>
        	</div>
        	<div class="clear"></div>
        </div> 	
		<div class="clear"></div>	
		<div align="left">
			<input type="submit" id="btn_submit"  name="btn_submit" value="##_BTN_SUBMIT_##" class="btn" />  
            <input type="button" value="##_BTN_CANCEL_##" onclick="javascript:history.go(-1);" class="btn" />
		</div>               
	</div>
    </div>
    <div class="clear"></div>
       
<?php echo CHtml::endForm();?>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.cleditor.min.js"></script>
<script type="text/javascript">

$j(document).ready(function(){
	
	$j("#addtodolistPop").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
});
function addTodoList(){
	var todoList =  $j("#todoListtitle").val();
	
	if(todoList=='' || todoList == 'undefined')
	{
		$("#todoListtitlemsg").removeClass();
		$("#todoListtitlemsg").text("Please enter list name");
		$("#todoListtitlemsg").addClass('false');
		return false;
	}
	else
	{
		//$j("#todoListtitle").attr("disabled","disabled");
		var postData	=	$j('#addTodoForm1').serialize();
		$j.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>user/saveToDoList',
			data: postData,
			cache: false,
			success: function(data)
			{
				var obj = $j.parseJSON(data);
				$j("#todoListtitle").attr("disabled",false);
				if(obj.succstr != ''){
					parent.$j("#update-message").removeClass().addClass('msg_success');
					parent.$j("#update-message").html(obj.succstr);
					parent.$j("#update-message").fadeIn();
					$j.fancybox.close();
					document.getElementById('addInviteForm').reset();
					$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/AddInvite');
					setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
					}
					if(obj.errstr != ''){
					
					parent.$j("#update-message1").removeClass().addClass('error-msg');
					parent.$j("#update-message1").html(obj.errstr);
					parent.$j("#update-message1").fadeIn();
					$j.fancybox.close();
					setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
					}
				
				
				
			}
		});
	}
}

function addUserInvite()
{
	var email = $j("#userlist").val();
	if(email=='')
	{
		$j("#userlistMsg").text("Please Enter Email.");
		$j("#userlistMsg").addClass('false');
		return false;
	}
	else
	{
		$j("#btnSubmitTodoinvite").attr("disabled","disabled");
		var postData	=	$j('#addInviteForm').serialize();
		var returnTo	=	'<?php  if(isset($data['from'])){ echo $data['from'];}?>';
			$j.ajax({
				type: 'POST',
				url: '<?php echo Yii::app()->params->base_path;?>user/addInviteUser',
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
					document.getElementById('addInviteForm').reset();
					$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/'+returnTo);
					setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
					}
					if(obj.errstr != ''){
					$j("#btnSubmitTodoinvite").attr("disabled",false);
					parent.$j("#update-message1").removeClass().addClass('error-msg');
					parent.$j("#update-message1").html(obj.errstr);
					parent.$j("#update-message1").fadeIn();
					setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
					}
				}
			});
	}
}
</script>
<div class="RightSide">
    <div class="main-wrapper">
        <div id="update-message"></div>
        <div id="update-message1"></div>
        <div class="clear"></div>
        <h1>##_INVITE_NEW_USER_##</h1>
        <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/addInviteUser','post',array('id' => 'addInviteForm','name' => 'addInviteForm')) ?>
        	<input type="hidden" name="id" value="<?php echo Yii::app()->session['loginId']; ?>"  />
       		<div class="field">
                <label>##_INVITE_TODO_LIST_## </label>
                <select name="todoList" id="todoList" class="select-box floatLeft">
                <?php  
                if(isset($listId) && $listId!= NULL)
                {
                    if(count($myList) > 0){ 
                        foreach($myList as $row){ ?>
                            <?php
                            if($row['id']==$listId){?>
                            <option selected="selected" value="<?php echo $row['id']; ?>"><?php echo $row['name'];?> <?php if(isset($seen) && in_array($row['name'],$seen)) { echo " - " .$row['firstName'].' '. $row['lastName']; }  ?></option>
                            <?php
                            }else{ ?> 
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name'];?> <?php if(isset($seen) && in_array($row['name'],$seen)) { echo " - " .$row['firstName'].' '. $row['lastName']; } ?></option>
                            <?php
                            }
                        }
                    }?>
                <?php  
                }elseif(count($myList) > 0){ 
                    foreach($myList as $row){ ?>
                    <option selected="selected"   value="<?php echo $row['id']; ?>"><?php echo $row['name'];?> <?php if(isset($seen) && in_array($row['name'],$seen)) { echo " - " .$row['firstName'].' '. $row['lastName']; } ?></option>
                    <?php 
                     }
                } else { ?>
                    <option value="" selected="selected" >##_INVITE_NO_LIST_##</option>
                <?php
                }?>
                </select>
                <?php if(!isset($listId) && $listId == NULL){ ?>
                <span class="addTodoList">
                    <a id="addtodolistPop" href="#addtodo">##_INVITE_NEW_TODO_LIST_##</a>
                </span>
                <?php } ?>
            </div>
            <div class="clear"></div>
            
            <div class="field">
                <label>##_INVITE_##<span id="userlistMsg"></span></label>
                <input type="text" name="userlist" id="userlist" class="textbox" value="" /> 
                <div><span class="info">(##_INVITE_EXAMPLE_##)</span></div>
            </div>
        	<div class="clear"></div>
        
       		<div class="fieldBtn">
                <input type="button" id="btnSubmitTodoinvite" class="btn" name="submit" value="##_BTN_SUBMIT_##" onclick="addUserInvite()" />
                <input type="button" class="btn" name="cancel" value="##_BTN_CANCEL_##" onclick="setUrl('<?php echo Yii::app()->params->base_url;?>index.php?r=user/<?php if(isset($data['from'])) { echo $data['from'];}?>');"/>
            </div>
        
        <?php echo CHtml::endForm(); ?> 
    </div>
    <div id="addtodo_form" style="display:none;">
        <div>
            <div id="addtodo" class="popup" style="width:360px; height:350px; overflow:auto;">
                   
    <h1 align="center">##_INVITE_ADD_TODO_##</h1>
     <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/saveToDoList','post',array('id' => 'addTodoForm1','name' => 'addTodoForm1')) ?>
        <input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>" />
        
        <div class="field">
            <label>##_INVITE_TODO_LIST_##<span id="todoListtitlemsg"></span></label>
            <input type="text" name="todoList" id="todoListtitle" class="textbox" value="" />
            
        </div>
        <div class="clear"></div>
        
        <div class="field">
            <label>##_INVITE_DESC_##</label>
            <?php
            $this->widget('application.extensions.cleditor.ECLEditor', array(
            'name'=>'description',
            'value'=>'',
            ));
            ?>
        </div>
        <div class="clear"></div>
        
        <div class="field">
            <label>##_INVITE_##</label>
            <input type="text" name="userlist" class="textbox" value="" /> <div><span class="info">(##_INVITE_EXAMPLE_##)</span></div>
        </div>
        <div class="clear"></div>
        
        <div class="fieldBtn">
            <input type="button" class="btn" name="submit" value="##_BTN_SUBMIT_##" onclick="addTodoList()" />
            <input type="button" class="btn" name="cancel" value="##_BTN_CANCEL_##" onclick="$j.fancybox.close();"/>
        </div>
        
        <?php echo CHtml::endForm(); ?> 
    
            </div>
        </div>
    </div>
</div>
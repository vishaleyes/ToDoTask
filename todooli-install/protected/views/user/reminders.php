<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	$j('#addReminder').click(function(){
		$j('#update-message').removeClass().html('');
		$j('#mainContainer')
			.html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show()
			.load('<?php echo Yii::app()->params->base_path;?>user/addReminder');
	});
	
	$j('.various4').click(function(){
		var url	=	$j(this).attr('lang');
		jConfirm('Are you sure want delete this reminder ?', 'Confirmation dialog', function(res){
			if( res == true ) {
				$j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')			.show();
				$j.ajax({
					url: '<?php echo Yii::app()->params->base_path;?>user/'+url,
					cache: false,
					success: function(data)
					{
						var obj	=	$j.parseJSON(data);
						if( obj.status == 0 ){
							$j('#mainContainer')
							.load('<?php echo Yii::app()->params->base_path;?>user/reminders', function() {
								$j("#update-message").hide().removeClass().addClass('msg_success');
								$j("#update-message").html('Reminder deleted successfully');
								$j("#update-message").fadeIn();
								setTimeout(function() {
									$j('#update-message').fadeOut();
								}, 10000 );
							});
						}
					}
				});
			}
		});
	});
	
	$j('.remindMe').click(function() {
		var url	=	$j(this).attr('lang');
		jConfirm('Send reminder again?', 'Confirmation dialog', function(res){
		if(res == true){
		$j.ajax({
			url: url,
			success: function(response) {
				var obj	=	$j.parseJSON(response);
				if( obj.status == 0 ) {
					$j("#update-message").removeClass().addClass('msg_success');
					$j("#update-message").html('Reminder sent successfully');
					$j("#update-message").fadeIn();
				}
				setTimeout(function() {
					$j('#update-message').fadeOut();
				}, 10000 );
			}
		});
	    }
	  });
	});
});

function editRemider(id){
	$j('#update-message').removeClass().html('');
	$j('#mainContainer')
		.html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
		.show()
		.load('<?php echo Yii::app()->params->base_path;?>user/addReminder/id/'+id);
	}
</script>
 <div id="eventLoader"></div>
<div class="RightSide">   
 <div id="update-message"></div>
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
    
    <div>
        <div class="rightNavigation">
            <a href="javascript:;" id="addReminder" >
                <input type="button" name="add reminder" class="btn" value="##_ADD_REM_##" />
            </a>
        </div>
        <h1>##_MY_REMINDERS_##</h1>
        <table cellpadding="0" cellspacing="0" border="0" class="listing">
            <tr>
                <th width="30%">##_REMINDERS_TODO_LIST_##</th>
                <th width="20%">##_REMINDER_LIST_NAME_##</th>
                <th width="7%">##_REMINDERS_STATUS_##</th>
                <th width="10%">##_REMINDERS_DUE_DATE_##</th>
                <th width="10%">##_REMINDERS_DURATION_##</th>
                <th width="10%">##_REMINDERS_TIME_##</th>
                <th width="13%" class="lastcolumn">&nbsp;</th>
            </tr>
            
            <?php 
            if(count($data) > 0) {
                for($i=0;$i<count($data);$i++){ ?>
                    <tr>
                        <td><?php echo $data[$i]['listName']; ?></td>
                        <td><?php echo $data[$i]['name']; ?></td>
                        <td>
                            <?php 
                            if($data[$i]['itemStatus'] == 0) {
                                echo 'ANY';
                            } elseif ($data[$i]['itemStatus'] == 1) {
                                echo 'OPEN';
                            } else {
                                echo 'CLOSE';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if ($data[$i]['dueDate'] == 0) {
                                echo 'Any';
                            } elseif ($data[$i]['dueDate'] == 1) {
                                echo 'Today';
                            } else {
                                echo 'This week';
                            }
                            ?>
                        </td>
                        <td>
                        <?php
                        if($data[$i]['duration']==0){
                            echo 'Daily';
                        } else if($data[$i]['duration']==1) {
                            echo 'Sunday';
                        } else if($data[$i]['duration']==2) {
                            echo 'Monday';
                        } else if($data[$i]['duration']==3) {
                            echo 'Tuesday';
                        } else if($data[$i]['duration']==4) {
                            echo 'Wednesday';
                        } else if($data[$i]['duration']==5) {
                            echo 'Thursday';
                        } else if($data[$i]['duration']==6) {
                            echo 'Friday';
                        } else if($data[$i]['duration']==7) {
                            echo 'Saturday';
                        } else if($data[$i]['duration']==8) {
                            echo 'Monthly';
                        } else if($data[$i]['duration']==9) {
                            echo 'Yearly';
                        }
                        
                        ?>
                        </td>
                        <td><?php echo date('h:i:s a', strtotime($data[$i]['time'])); ?></td>
                        <td class="lastcolumn">
                            <div class="panding_hire_options" style="margin-left:5px;">
                                <p>
                                <a id="addReminder" href="javascript:;" lang="<?php Yii::app()->params->base_path;?>user/addReminder/id/<?php echo $data[$i]['id']; ?>" onclick="editRemider(<?php echo $data[$i]['id'];?>);" title="##_EDIT_REM_##">
                                <img src="<?php echo Yii::app()->params->base_url; ?>images/edit-icon.png" width="20" height="20" alt="" border="0" /></a>
                                </p>
                                
                                <p>
                                <a class="various4 deleteIcon" href="javascript:;" lang="<?php Yii::app()->params->base_url;?>deleteReminder/id/<?php echo $data[$i]['id'];?>" title="##_DEL_REM_##" ></a>
                                </p>
                                
                                <p>
                                <a class="remindMe" href="javascript:;" lang="<?php echo Yii::app()->params->base_path.'user/remindMe/reminderId/'.$data[$i]['id'];?>" title="##_REMIND_##">
                                    <img src="<?php echo Yii::app()->params->base_url;?>images/emailreminder.png" alt="email" />
                                </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                <?php 
                }
            }else { ?>
            <tr>
                <td colspan="7" class="lastrow lastcolumn">
                   ##_REMINDERS_NO_ACTIVE_##
                </td>
            </tr> 
            <?php } ?>
        </table>
    </div>
</div>
<script type="text/javascript">
	$j(document).ready(function(){
		$j('table tr td').each(function(){
			if($j(this).html() == ''){
				$j(this).html('&nbsp;');
			}
		});	
	});
</script>
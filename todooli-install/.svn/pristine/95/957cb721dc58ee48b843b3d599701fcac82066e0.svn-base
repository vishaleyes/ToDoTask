<script type="text/javascript">
$j(document).ready(function(){
	$j('.reminderList').tinyscrollbar();	
	$j('.reminderViewMore').fancybox({
		'width' : 410,
 		'height' : 280,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	$j('.deleteReminder').click(function(){
		var url	=	$j(this).attr('lang');
		var id	=	url.split('id/');
		
		jConfirm('Are you sure want to delete this reminder?', 'Confirmation dialog', function(res){
			if(res == true){
				$j.ajax({
					url: '<?php echo Yii::app()->params->base_path;?>user/'+url,
					cache: false,
					success: function(data)
					{
						var obj	=	$j.parseJSON(data);
						if( obj.status == 0 ){
							$j('#hire_request_'+id[1]).fadeOut('slow', function() {
								smoothScroll('update-message');
								$j("#update-message").removeClass().addClass('msg_success');
								$j("#update-message").html(obj.message);
								$j("#update-message").fadeIn();
							});
							
						}
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
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
					smoothScroll("update-message");
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
</script>

<div>
	<h3 class="reddot">
    	<p>##_MY_REMINDERS_##<div class="addtext"><a href="#" onclick="$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/AddReminder');" title="##_ADD_REM_##"><img src="<?php echo Yii::app()->params->base_url;?>images/plus.png" alt="" border="0" /></a></div></p>
        
        <div class="clear"></div>
	</h3>
</div>
    <div class="ajaxBox reminderList">
		<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
		<div class="viewport" style=" <?php if(count($data)==1){?>height:128px !important;<?php } elseif(count($data)==2){?>height:200px !important;<?php } elseif(count($data)==3){?>height:290px !important;<?php } elseif(count($data) >  3){?> height:300px !important; <?php } else { ?>height:30px !important;<?php } ?>">
			<div class="overview">
                <ul class="hire-list items">
            
                <?php $cnt = count($data); if($cnt>5){ $cnt = 5;}for($i=0;$i<$cnt;$i++){ ?>
                    <li id="hire_request_<?php echo $data[$i]['id'];?>">
                        <div class="hire-data">
                            <div>
                                <?php
								if( $data[$i]['name'] != '' ) {?>
                                	<p class="title">
										<b><?php echo $data[$i]['name'];?></b>
                                	</p>
								<?php
								}?>
        						<p <?php if($data[$i]['name'] == ''){?>class="title"<?php }?>>
                                  <?php /*?>  <a class="reminderViewMore" href="<?php echo Yii::app()->params->base_path;?>user/reminderViewMore/id/<?php echo $data[$i]['id'];?>" title="##_VIEW_REM_##"><span id="hire_request_name_<?php echo $data[$i]['id'];?>"><?php */?><span id="hire_request_name_<?php echo $data[$i]['id'];?>"><?php echo $data[$i]['listName'];?></span></p>
                                <p>
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
                                </p>
                            </div>
                            <div>
                                <p class="post"><span>##_REMINDERS_DUE_DATE_##:</span>
                                    <?php 
                                    if ($data[$i]['dueDate'] == 0) {
                                        echo 'Any';
                                    } elseif ($data[$i]['dueDate'] == 1) {
                                        echo 'Today';
                                    } else {
                                        echo 'This week';
                                    }
                                    ?> 
                                </p>
                                <div class="checkbox1">
                                    <input id="othersRadioButton" type="checkbox"<?php if($data[$i]['summaryStatus'] == 1){?> checked="checked"<?php }?> disabled="disabled" >
                                    <span>##_REMINDERS_SUMMARY_ONLY_##</span>
                                </div>
                                <div class="clear"></div>
                                <p class="time inner_time_<?php echo $data[$i]['id'];?>" id="time_<?php echo $data[$i]['id'];?>">
                                    <?php echo date('h:i:s a', strtotime($data[$i]['time'])); ?>
                                </p>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="hire-options">
                            <p>
                            <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/addReminder/id/<?php echo $data[$i]['id']; ?>');" lang="" title="##_EDIT_REM_##">
                                        <img src="<?php echo Yii::app()->params->base_url; ?>images/edit-icon.png" width="20" height="20" alt="" border="0" />
                            </a>
                            </p>
                                        
                            <a class="deleteReminder deleteIcon" href="javascript:;" lang="<?php Yii::app()->params->base_url;?>deleteReminder/id/<?php echo $data[$i]['id'];?>" title="##_DEL_REM_##" ></a>
                            
                            <a class="remindMe" href="javascript:;" lang="<?php echo Yii::app()->params->base_path.'user/remindMe/reminderId/'.$data[$i]['id'];?>" title="##_REMIND_##">
                                <img src="<?php echo Yii::app()->params->base_url;?>images/emailreminder.png" alt="email" />
                            </a>
                        </div>
                        <div class="clear"></div>
                    </li>
                    <?php if($i==4) {?>
                    <li>
                        <div align="center"><a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_url;?>index.php?r=user/reminders');" lang="" title="##_REM_INVITES_##">##_REMINDERS_MORE_##</a></div>
                    </li> 							
                                            
                <?php } } ?>
                    <?php if(is_array($data) && count($data) > 0){ } else { ?>
                        <li class="no_request">
                            <div>##_REMINDERS_NO_ACTIVE_##</div>
                        </li>
                    <?php } ?>
            </ul>
			</div>
		</div>
    </div>
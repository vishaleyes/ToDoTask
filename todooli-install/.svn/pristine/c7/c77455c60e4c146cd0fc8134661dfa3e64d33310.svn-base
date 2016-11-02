<script type="text/javascript">
	$j(document).ready(function(){
		$j('.invitesList').tinyscrollbar();	
		var count = $j('.viewport').find('li');
	});
	
</script>
<script type="text/javascript">
$j(document).ready(function() {
	$j(".viewmorelist").fancybox({
		'width' : 410,
 		'height' : 280,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	
	/******* ACCEPT INVITATION *******/
	$j('.inviteAccept').click(function() {
		var url	=	$j(this).attr('lang');
		$j.ajax({
			url: '<?php echo Yii::app()->params->base_path;?>user/'+url,
			cache: false,
			success: function(data)
			{
				var obj = $j.parseJSON(data);
				if(obj.status == 0){
					$j('#inviteAjaxBox')
					.load('<?php echo Yii::app()->params->base_path;?>user/inviteAjax', function(){
						smoothScroll("update-message");
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html(obj.message);
						$j("#update-message").fadeIn();
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
					});
				} else {
					smoothScroll("update-message");
					$j("#update-message").removeClass().addClass('error-msg');
					$j("#update-message").html(obj.message);
					$j("#update-message").fadeIn();
				}
			}
		});
	});
	
	/******* DELETE INVITATION *******/
	$j('.deleteInvite').click(function(){
		var url	=	$j(this).attr('lang');
		jConfirm('Are you sure want delete this Invite?', 'Confirmation dialog', function(res){
		if(res == true){
		$j.ajax({
			url: url,
			cache: false,
			success: function(data)
			{
				var obj = $j.parseJSON(data);
				if(obj.status == 0){
					$j('#inviteAjaxBox')
					.load('<?php echo Yii::app()->params->base_path;?>user/inviteAjax', function() {
						smoothScroll("update-message");
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html('Invite deleted successfully');
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
	
});
</script>

<div>
	<h3 class="reddot">
        <p>##_INVITES_AJAX_INVITES_##</p>
        
        <div class="clear"></div>
	</h3>
</div>

<div class="ajaxBox invitesList">
    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
    <div class="viewport" style=" <?php if(count($data)==1){?>height:108px !important;<?php } elseif(count($data)==2){?>height:190px !important;<?php } elseif(count($data)==3){?>height:234px !important;<?php } elseif(count($data) >  3){?> height:230px !important; <?php } else { ?>height:30px !important;<?php } ?>">
        <div class="overview">
            <ul class="hire-list items">        
            <?php
			//print_r(count($data));exit;
			if( isset($data) && count($data) > 0 ) {
				foreach($data as $each){ ?>
                    <li id="hire_request_<?php echo $each['id'];?>">
                        <div class="hire-data">
                            <div>
                                <p class="title">
                                    <a class="viewmorelist" href="<?php echo Yii::app()->params->base_path;?>user/viewMoreInvite/id/<?php echo $each['id'];?>/popUp/true" title="View Invite Description"><span id="hire_request_name_<?php echo $each['id'];?>"><?php echo $each['listName'];?> - <?php if( $each['listcreatedBy']==Yii::app()->session['loginId']){ echo "Me";}else { echo  $each['listOwner'];} ?></span></a>
                                </p>
                                <p>
                                <?php 
                                if($each['role'] == 0){
                                    echo '##_INVITES_AJAX_MEMBER_##';
                                } else {
                                    echo '##_INVITES_AJAX_MANAGER_##';
                                }
                                ?>
                                </p>
                            </div>
                            <div>
                                <p class="post"><span>##_INVITES_AJAX_BY_##:</span> <?php echo $each['senderFirstName']. ' ' . $each['senderLastName']; ?></p>
                                <p class="time inner_time_<?php echo $each['id'];?>" id="time_<?php echo $each['id'];?>">
                                    <?php echo $each['time']; ?>
                                </p>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="hire-options">
                            <p><a class="viewmorelist viewIcon" href="<?php echo Yii::app()->params->base_path;?>user/viewMoreInvite/id/<?php echo $each['id'];?>/popUp/true" title="##_INVITES_AJAX_INVITATION_##"></a></p>
                           
                            <p><a class="deleteInvite deleteIcon" href="javascript:;" lang="<?php echo Yii::app()->params->base_path;?>user/deleteInvite/id/<?php echo $each['id'];?>" title="##_INVITES_AJAX_INVITATION_DELETE_##" ></a></p>
                            <?php 
                            if($each['status'] == 2){?>
                                <p>
                                    <a href="javascript:;" lang="<?php Yii::app()->params->base_path;?>changeStatus/id/<?php echo $each['id'];?>/status/1" title="##_INVITES_AJAX_ACCEPT_##" class="inviteAccept">
                                    <img src="<?php echo Yii::app()->params->base_url; ?>images/mark-true1.gif" width="20" height="20" alt="" border="0" />
                                    </a>
                                </p>
                            <?php 
                            } ?>
                        </div>
                        <div class="clear"></div>
                    </li>
                   <?php 
                }
                if( $pagination->getItemCount() > 10 ) {?>
                     <li>
                        <div align="center"><a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_url;?>index.php?r=user/invites');" lang="" title="##_INVITES_AJAX_INVITES_##">##_INVITES_AJAX_MORE_##</a></div>
                    </li> 
                <?php
                }
			} else { ?>
                    <li class="no_request">
                        <div>##_INVITES_AJAX_NO_ACTIVE_##</div>
                    </li>
                <?php } ?>
        </ul>
        </div>
    </div>
</div>
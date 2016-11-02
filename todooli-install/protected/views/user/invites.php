<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	$j('.viewIcon').click(function(){
		$j('#update-message').removeClass().html('');
		var url	=	$j(this).attr('lang');
		$j('#mainContainer').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')			.show().load(url);
	});
	
	
	 $j('.sort').click(function() {
               $j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show();
			    var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','mainContainer');
			 
	  });
				
	
	/******* ACCEPT INVITATION *******/
	$j('.inviteAccept').click(function() {
		  $j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show();
			
		var url	=	$j(this).attr('lang');
		$j.ajax({
			url: '<?php echo Yii::app()->params->base_path;?>user/'+url,
			cache: false,
			success: function(data)
			{
				var obj = $j.parseJSON(data);
				if(obj.status == 0){
					$j('#mainContainer')
						.load('<?php echo Yii::app()->params->base_path;?>user/invites'+'<?php echo  $extraPaginationPara;?>', function(){
							$j("#update-message").removeClass().addClass('msg_success');
							$j("#update-message").html(obj.message);
							$j("#update-message").fadeIn();
							setTimeout(function() {
								$j('#update-message').fadeOut();
							}, 10000 );
						});
					$j('#inviteAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/inviteAjax');
				} else {
					$j("#update-message").removeClass().addClass('error-msg');
					$j("#update-message").html(obj.message);
					$j("#update-message").fadeIn();
				}
			}
		});
	});
	
	/******* DELETE INVITATION *******/
	$j('.various4').click(function(){
		var url	=	$j(this).attr('lang');
		jConfirm('Are you sure want delete this Invite?', 'Confirmation dialog', function(res){
			if( res == true ) {
				  $j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show();
				
				$j.ajax({
					url: url,
					cache: false,
					success: function(data)
					{
						var obj = $j.parseJSON(data);
						if( obj.status == 0 ) {
							$j('#mainContainer')
								.load('<?php echo Yii::app()->params->base_path;?>user/invites'+'<?php echo  $extraPaginationPara;?>', function() {
								
								});
								$j("#update-message").removeClass().addClass('msg_success');
									$j("#update-message").html('Invite deleted successfully');
									$j("#update-message").fadeIn();
									setTimeout(function() {
										$j('#update-message').fadeOut();
									}, 10000 );
							$j('#inviteAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/inviteAjax');
						} else {
							$j('#update-message').html('');
						}
					}
				});
			}
		});
	});
});
function addInvite() {
	$j('#update-message').removeClass().html('');
	$j('#mainContainer')
		.html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
		.show()
		.load('<?php echo Yii::app()->params->base_path;?>user/AddInvite/from/invites');
}
</script>
<div id="eventLoader"></div>
<div class="RightSide">
    <div id="update-message"></div>
    <div>
		<?php if(Yii::app()->user->hasFlash('success')): ?>                                
            <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
            <div class="clear"></div>
        <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
            <div class="clear"></div>
        <?php endif; ?>
    </div>
    <div class="rightNavigation">
        <a href="#">
        	<input type="button" class="btn" lang="<?php echo Yii::app()->params->base_path;?>user/AddInvite" value="##_BTN_ADD_INVITE_##" id="addInvite" onclick="addInvite();" />
        </a>
    </div>
    <h1>##_INVITES_INVITE_LIST_##</h1>
    <table cellpadding="0" cellspacing="0" border="0" class="listing">
        <tr>
            <th width="37%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/invites/sortType/<?php echo $ext['sortType'];?>/sortBy/listName' >##_INVITES_TODO_NAME_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'listName'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
            <th width="15%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/invites/sortType/<?php echo $ext['sortType'];?>/sortBy/role' >##_INVITES_ROLE_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'role'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
            <th width="15%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/invites/sortType/<?php echo $ext['sortType'];?>/sortBy/createdAt' >##_INVITES_INVITED_TIME_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'createdAt'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
            <th width="20%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/invites/sortType/<?php echo $ext['sortType'];?>/sortBy/firstName' >##_INVITES_INVITED_BY_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'firstName'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
            <th width="13%" class="lastcolumn">&nbsp;</th>
        </tr>
        
        <?php if(count($data) > 0) {
            for($i=0;$i<count($data);$i++){ ?>
                <tr>
                    <td><?php echo $data[$i]['listName']; ?> </td>
                    <td>
                        <?php
                        if($data[$i]['role']==0){
                            echo '##_INVITES_MEMBER_##';
                        } else {
                            echo '##_INVITES_MANAGER_##';
                        }
                        ?>
                    </td>
                    <td><?php echo $data[$i]['time']; ?></td>
                    <td><?php echo $data[$i]['senderFirstName']. ' ' . $data[$i]['senderLastName']; ?></td>
                    <td class="lastcolumn">
                        <div class="panding_hire_options" style="margin-left:5px;">
                            <p><a id="viewMoreInvite" class="viewIcon viewMore" href="javascript:;" lang="<?php echo Yii::app()->params->base_path;?>user/viewMoreInvite/id/<?php echo $data[$i]['id'];?>" title="##_INVITES_INVITATION_##"></a></p>
                            
                            <?php
                            if($data[$i]['status'] == 2){ ?>
                                <p>
                                    <a href="javascript:;" lang="<?php Yii::app()->params->base_url;?>changeStatus/id/<?php echo $data[$i]['id'];?>/status/1" title="##_INVITES_ACCEPT_##" class="inviteAccept">
                                    <img src="<?php echo Yii::app()->params->base_url; ?>images/mark-true1.gif" width="20" height="20" alt="" border="0" />
                                    </a>
                                </p>
                            <?php
                            } ?>
                            
                            <p><a class="various4 deleteIcon" href="javascript:;" lang="<?php echo Yii::app()->params->base_path;?>user/deleteInvite/id/<?php echo $data[$i]['id'];?>" title="##_INVITES_INVITATION_DELETE_##" ></a></p>
                            
                            
                        </div>
                    </td>
                </tr>
            <?php 
            }
        } else { ?>
        <tr>
            <td colspan="6" class="lastrow lastcolumn">
               ##_INVITES_NO_ACTIVE_##
            </td>
        </tr> 
        <?php } ?>
    </table>
    <?php
    if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
    <div class="pagination">
        <?php
        $this->widget('application.extensions.WebPager', 
                        array('cssFile'=>true,
                                
								 'pages' => $pagination,
                                 'id'=>'link_pager',
        ));
    ?> 
    </div> 
	<?php } ?>
</div>
<script type="text/javascript">
	$j(document).ready(function(){
		$j('#link_pager a').each(function(){
			$j(this).click(function(ev){
				ev.preventDefault();
				$j.get(this.href,{ajax:true},function(html){
					$j('#mainContainer').html(html);
				});
			});
		});
	});
</script>
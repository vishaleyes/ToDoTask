<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
/*
function getSearch()
{
	$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	var keyword = $j("#keyword").val();
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/myNetwork',
		data: 'keyword='+keyword+"&"+csrfToken,
		cache: false,
		success: function(data)
		{
			$j("#mainContainer").html(data);
			$j("#keyword").val(keyword);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}*/
</script>
<script type="text/javascript">
function setUrl(myurl)
{	
	$j('#update-message').removeClass();
	$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
	$j.ajax ({
			url: myurl+'<?php echo  $extraPaginationPara;?>',
			data: csrfToken,
			success: function(response)
			{
				if(trim(response)=='LOGOUT')
				{
					window.location=BASHPATH;
					return false;
				}
				$j('#mainContainer').html(response);
				//inner tab menu
				$j('#update-message').html('');
				//close inner tab menu
				return false;
			}
	});
}

function deleteNetworkUser(id)
{
	jConfirm('Are you sure want delete this network user?', 'Confirmation dialog', function(res)
	{
		if( res == true )
	 	{
			$j.ajax ({
					url: '<?php echo Yii::app()->params->base_path;?>user/removeFrommyNetwork&id='+id,
					data: csrfToken,
					success: function(response)
					{
						$j('#mainContainer').html(response);
						//inner tab menu
							$j("#update-message").removeClass().addClass('msg_success');
							$j("#update-message").html("Successfully delete network user.");
							$j("#update-message").fadeIn();
							setTimeout(function() {
								$j('#update-message').fadeOut();
							}, 10000 );
					}
			});
		}
	});
}

</script>

<div class="RightSide">
  <div id="update-message"></div>
  <div align='center' id="loading"></div>
  <div class="rightNavigation"> <a href="#">
    <input type="button" name="addnetwork" id="addnetwork" class="btn" value="##_NET_INVITE_##" onclick="$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/AddInvite/from/myNetwork');" />
    </a> </div>
  <h1>##_NET_MY_TODO_NET_##</h1>
  <table cellpadding="0" cellspacing="0" border="0" class="listing">
    <tr>
      <th width="40%"> <?php
                if(count($networks['networks']) > 0){ ?>
        <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetwork/sortType/<?php echo $ext['sortType'];?>/sortBy/firstName/flag/1')" >##_NET_FULL_NAME_##
        <?php 
                    if($ext['img_name'] != '' && $ext['sortBy'] == 'firstName'){ ?>
        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
        <?php
                    } ?>
        </a>
        <?php 
                } else { ?>
        ##_NET_FULL_NAME_##
        <?php 
                } ?>
      </th>
      <th width="37%"> <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetwork/sortType/<?php echo $ext['sortType'];?>/sortBy/loginId/flag/1')" >##_NET_EMAIL_##
        <?php 
                    if($ext['img_name'] != '' && $ext['sortBy'] == 'loginId'){ ?>
        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
        <?php
                    } ?>
        </a></th>
      <th width="15%"> <?php
                if(count($networks['networks']) > 0){ ?>
        <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetwork/sortType/<?php echo $ext['sortType'];?>/sortBy/created/flag/1')" >##_NET_CREATED_##
        <?php 
                    if($ext['img_name'] != '' && $ext['sortBy'] == 'created'){ ?>
        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
        <?php
                    } ?>
        </a>
        <?php 
                } else { ?>
        ##_NET_FULL_NAME_##
        <?php 
                } ?>
      </th>
      <th width="8%" class="lastcolumn">&nbsp;</th>
    </tr>
    <?php 
		if($networks['pagination']->getItemCount() > 0){ 
			 foreach($networks['networks'] as $row){ ?>
    <tr>
      <td><?php 
					if(isset($row['user']['firstName']) && isset($row['user']['lastName'])){
						echo $row['user']['firstName'] . ' ' . $row['user']['lastName'];
					}
					?></td>
      <td><?php echo $row['user']['loginId']; ?></td>
      <td><?php echo $row['time']; ?></td>
      <td class="lastcolumn"><a href="javascript:;" class="viewIcon viewMore floatLeft" onclick="$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/getNetworkUserDetails&id=<?php echo $row['netId'];?>');" title="##_NET_VIEW_##"></a> <a href="javascript:;" class="various4 deleteIcon" onclick="deleteNetworkUser('<?php echo $row['netId'];?>');" title="##_NET_DELETE_##"></a></td>
    </tr>
    <?php
            }
		} else { ?>
    <tr>
      <td colspan="5" class="lastcolumn"> ##_NET_NO_NETWORK_## </td>
    </tr>
    <?php
		}?>
  </table>
  <?php
		
        if(!empty($networks['pagination']) && $networks['pagination']->getItemCount()  > $networks['pagination']->getLimit()){?>
  <div class="pagination">
    <?php
            $this->widget('application.extensions.WebPager', 
                            array('cssFile'=>true,
                                     'pages' => $networks['pagination'],
                                     'id'=>'link_pager',
            ));
            ?>
  </div>
  <?php
		}
        ?>
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
<div id="addmynetwork_form" style="display:none;">
  <div id="addmynetwork" class="popup" style="width:400px; height:320px; overflow:auto;">
    <div id="update-message"></div>
    <div class="clear"></div>
    <h1>##_NET_ADD_NETWORK_##</h1>
    <?php echo CHtml::beginForm('','post',array('id' => 'addTodoNetworkForm','name' => 'addTodoNetworkForm','enctype'=>'multipart/form-data')) ?>
    <input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>"  />
    <div class="field">
      <label>##_NET_EMAIL_## *</label>
      <input type="text" name="email" class="textbox" id="email" value="" />
      <span id="emailmsg" style="color:#F00;"></span> </div>
    <div class="clear"></div>
    <div class="field">
      <label>##_NET_TODO_LIST_NAME_## </label>
      <select name="todoList" class="select-box">
        <?php
		if(count($list) > 0){$i=0;
			foreach($list as $row){ 
			if($i=0)
			{ ?>
        <option selected="selected"  value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php }else {?>
        <option  value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php 
			$i++; }}
		} else { ?>
        <option value="" selected="selected" >##_NET_NO_LIST_##</option>
        <?php
		}?>
      </select>
    </div>
    <div class="clear"></div>
    <div class="field">&nbsp;</div>
    <div class="clear"></div>
    <div class="fieldBtn">
      <input type="button" class="btn" name="submit" value="##_BTN_SUBMIT_##" onclick="addNetwork();"  />
      <input type="button" class="btn" name="cancel" value="##_BTN_CANCEL_##" onclick="$j.fancybox.close();" />
    </div>
    <?php echo CHtml::endForm(); ?> </div>
</div>

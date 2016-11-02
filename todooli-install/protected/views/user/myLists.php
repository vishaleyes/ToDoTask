<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript">
$j(document).ready(function() {
	
	$j(".viewMore").fancybox({
		'width' : 800,
 		'height' : 450,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	
	  $j('.sort').click(function() {
                var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','mainContainer');
	  });
				
				
	$j('.various4').click(function() {
		
		var id	=	$j(this).attr('lang');
		
		jConfirm('Are you sure want delete this TODO list ?', 'Confirmation dialog', function(res){
			if( res == true ) {
				$j('#update-message').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
				$j('#mainContainer')
					.load('<?php echo Yii::app()->params->base_path;?>user/removeList/id/'+id, function() {
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html('List deleted successfully');
						$j("#update-message").fadeIn();
						$j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax');
						$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/myLists');
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
					});
			}
		});
		
	});
	
	
	$j('#addTodo').click(function() {
		var id	=	$j(this).attr('lang');
		$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/AddTodoList');
	});
});
	
function getSearch()
{
	$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	var keyword = $j("#keyword").val();
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/myLists',
		data: 'keyword='+keyword+"&"+csrfToken,
		cache: false,
		success: function(data)
		{
			$j("#mainContainer").html(data);
			$j("#keyword").val(keyword);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}

function inviteFromLists(id)
{
	setUrl('<?php echo Yii::app()->params->base_path; ?>user/addinvite/id/'+id+'/from/myLists');
}
</script>

<div class="RightSide">
	<span id="loading"></span>
    
	<div class="rightNavigation">
    	<a href="#">
            <input type="button" name="addTodo" id="addTodo" class="btn" value="##_MY_LISTS_ADD_TODO_##" onclick="$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/AddTodoList');" />
        </a>
    </div>
	<h1>##_MY_LISTS_MY_TODO_##</h1>
        <div class="clear"></div>
    <div class="searchArea innerSearch">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">
            <label class="label floatLeft">##_MY_LISTS_TODO_##</label>
            <input type="text" class="textbox floatLeft" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" autocomplete="off" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
        </form>
        <div class="clear"></div>
    </div>
	
    <table cellpadding="0" cellspacing="0" border="0" class="listing" id="list">
    	<tr>
    		<th width="16%"> <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myLists/sortType/<?php echo $ext['sortType'];?>/sortBy/name' >##_MY_LISTS_LIST_NAME_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'name'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
            <th width="15%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myLists/sortType/<?php echo $ext['sortType'];?>/sortBy/firstName' >##_MY_LISTS_CREATED_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'firstName'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
            <th width="27%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myLists/sortType/<?php echo $ext['sortType'];?>/sortBy/description' >##_MY_LISTS_DESC_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'description'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
            <th width="7%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myLists/sortType/<?php echo $ext['sortType'];?>/sortBy/totalItems' >##_MY_LISTS_TOTAL_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'totalItems'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
            <th width="9%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myLists/sortType/<?php echo $ext['sortType'];?>/sortBy/pendingItems' >##_MY_LISTS_PENDING_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'pendingItems'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
            <th width="15%"><a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myLists/sortType/<?php echo $ext['sortType'];?>/sortBy/createdAt' >##_MY_LISTS_CREATED_DATE_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'createdAt'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
            <th width="11%" class="lastcolumn">&nbsp;</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
			foreach($data as $row){ ?> 
            <tr>
            	<td>
                	<a href="<?php echo Yii::app()->params->base_path;?>user/index/list/<?php echo $row['id'];?>"> <?php echo $row['name']; ?>  <?php if(isset($seen) && in_array($row['name'],$seen) ) { echo " - " .$row['firstName'].' '. $row['lastName']; } ?></a>
				</td>
                <td>
                	<?php
					if($row['createdBy']==Yii::app()->session['loginId'])
					{
                    echo 'me';
					}
					else
					{
						echo $row['firstName'].' '.$row['lastName'];	
					}
					?>
                </td>
				<td>
                	<span><?php echo $row['description']; ?></span>
				</td>
				
                <td>
                <?php echo $row['totalItems'];?>
                </td>
                <td>
                <?php echo $row['pendingItems'];?>
                </td>
                <td>
                	<?php echo $row['time']; ?>
				</td>
                <td class="lastcolumn">
                	<a href="<?php echo Yii::app()->params->base_path;?>user/listDescription/id/<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>" id="viewMore_<?php echo $row['id'];?>" class="viewIcon noMartb viewMore floatLeft" title="##_MY_LISTS_VIEW_##">
                    </a>
                    <a style="cursor:pointer;" onclick="inviteFromLists('<?php echo $row['id'];?>');" class="floatLeft" title="##_REM_INVITES_LOGO_##"><img src="<?php echo Yii::app()->params->base_path;?>images/invite.png" /></a>
                    <?php if($row['createdBy']==Yii::app()->session['loginId'] && $row['name'] != 'Self'){?>
                    <a href="javascript:;" lang="<?php echo $row['id'];?>" id="remove_<?php echo $row['id'];?>" class="various4 deleteIcon noMartb floatLeft" title="##_MY_LISTS_DELETE_##">
                    </a>
                    <?php } ?>
				</td>
			</tr>
			<?php
           $i++; }
		} else { ?>
			<tr>
            	<td colspan="7" class="lastcolumn alignLeft">
                	##_NO_MY_LISTS_TODO_##
				</td>
			</tr>
		<?php
		}?>
        </table>
         <?php
        if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
            <div class="pagination">
                <?php
				$extraPaginationPara='&keyword='.$ext['keyword'];
                $this->widget('application.extensions.WebPager', 
                                array('cssFile'=>true,
                                        'extraPara'=>$extraPaginationPara,
										 'pages' => $pagination,
                                         'id'=>'link_pager',
                )); ?>
            </div>
			<?php
		} ?>
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
<?php 
$ListBox='<select id="txtSearchListDP" name="txtSearchListDP" style="width:120px;" onchange="reloadHomeByList()">';
$ListBox.='<option value="0">All</option>';
$listData	=	'{';
for($i=0; $i<=count($items['myLists']); $i++){
	
	if($i == count($items['myLists'])){
		$listData .= "}";
	} else if($i == 0) {
		$ListBox.='<option  value="'.$items['myLists'][$i]['id'].'">'.$items['myLists'][$i]['name'].'</option>';
		$listData .= "'".$items['myLists'][$i]['id']."':'".$items['myLists'][$i]['name']."'";
	} else {
		$ListBox.='<option  value="'.$items['myLists'][$i]['id'].'">'.$items['myLists'][$i]['name'].'</option>';
		$listData .= ",'".$items['myLists'][$i]['id']."':'".$items['myLists'][$i]['name']."'";
	}
}
$ListBox.='</select>';
?>
  <div class="RightSide">	
	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'user','post',array('id' => 'serchDPForm','name' => 'serchDPForm')) ?>
    <ul class="todoList">
       
        <li>
            <span>##_HOME_TODO_LIST_##:</span>
                <div id="searchListDP" class="floatLeft">
                <?php echo $ListBox;?>
            </div>
        </li>
    </ul>


<div id="items" class="RightSide">	
	
<script type="text/javascript">
var BASHPATH='<?php echo Yii::app()->params->base_url; ?>';
var imgPath='<?php echo Yii::app()->params->base_url; ?>images/';
$j(document).ready(function(){
	
	$j(".reassign").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',	
		'type'	 : 'iframe',		
		'width' : 400,
 		'height' : 200
	});
	
	$j("#searchText").focus();
	
	$j('.sort').click(function() {
		var url	=	$j(this).attr('lang');
		loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url,'items');
		
	});
	
	/******* CHANGE STATUS OF TODO ITEM *******/
	$j('.editable').editable('<?php echo Yii::app()->params->base_path;?>user/changeItemStatus/', { 
		indicator : '<img src="'+BASHPATH+'images/progress_indicator_16_gray_transparent.gif">',
		data   : " {'1':'OPEN','3':'DONE'}",
		submitdata : {<?php echo Yii::app()->request->csrfTokenName;?>:"<?php echo Yii::app()->request->csrfToken;?>"},
		style  : "inherit",
		type   : 'select',
		submit : 'Save',
		callback: function(response){
			var obj	=	$j.parseJSON(response);
			if(obj.status == 0){
				if(obj.change == 1) {
					$j('#items').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem');
				} else{
					$j(this)
						.closest('td')
						.html('<div class="checkbox1"><span class="done">Done</span></div>');
				}
			}
		}
	});
	
	$j('.statusDone').click(function() {
		var details	=	$j(this).attr('lang'),
			id	=	details.split('*');
			value	=	$j(this).val();
		
		$j.ajax({
			url: '<?php echo Yii::app()->params->base_path;?>user/changeItemStatus/id/'+id[0]+'/stat/'+value,
			success: function(response){
				var obj	=	$j.parseJSON(response);
				if(obj.status == 0){
					if( id[1] == 'done' ) {
						$j('#status_'+id[0]).html('<div class="checkbox1"><span class="'+id[1]+'">Done</span></div>');
					} else {
						$j('#status_'+id[0]).html('<div class="checkbox1"><span class="'+id[1]+'">Open</span></div>');
					}
					$j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax');
				}
			}
		});
	});
	
	/******* CHANGE LIST OF TODO ITEM *******/
	$j('.changeList').editable('<?php echo Yii::app()->params->base_path;?>user/changeItemField/field/listId', {
		
		indicator : '<img src="'+BASHPATH+'images/progress_indicator_16_gray_transparent.gif">',
		data   : " <?php echo $listData;?>",
		submitdata : {<?php echo Yii::app()->request->csrfTokenName;?>:"<?php echo Yii::app()->request->csrfToken;?>"},
		style  : "inherit",
		type   : 'select',
		submit : 'Save',
		callback: function(response){
			if(response == 'success'){
				$j('#items').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem');
			}
		}
		
	});
	
	/******* CHANGE TITLE OF TODO ITEM *******/
	$j('.changeTitle').editable('<?php echo Yii::app()->params->base_path;?>user/changeItemField/field/title', { 
		indicator : '<img src="'+BASHPATH+'images/progress_indicator_16_gray_transparent.gif">',
		type   : 'textarea',
		submitdata : {<?php echo Yii::app()->request->csrfTokenName;?>:"<?php echo Yii::app()->request->csrfToken;?>"},
		submit : 'Save',
		callback: function(response){
			if(response == 'success'){
				$j('#items').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem');
			}
		}
	});
	
	/****** CHANGE TODO ITEM DUE DATE *******/
	$j(".datepicker-initiative")
		.editable('<?php echo Yii::app()->params->base_path;?>user/changeItemField/field/dueDate', {
			indicator : '<img src="'+BASHPATH+'images/progress_indicator_16_gray_transparent.gif">',
			type: 'datepicker',
			tooltip: 'Click to edit',
			submitdata : {<?php echo Yii::app()->request->csrfTokenName;?>:"<?php echo Yii::app()->request->csrfToken;?>"},
			callback: function(response){
				if(response == 'success'){
					$j('#items').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem');
				}
			}
	});

	/******* CHANGE PRIORITY OF TODO ITEM *******/
	$j('.changePriority').editable('<?php echo Yii::app()->params->base_path;?>user/changeItemField/field/priority', { 
		indicator : '<img src="'+BASHPATH+'images/progress_indicator_16_gray_transparent.gif">',
		data   : " {'0':'Low','1':'Medium','2':'High','3':'Urgent'}",
		submitdata : {<?php echo Yii::app()->request->csrfTokenName;?>:"<?php echo Yii::app()->request->csrfToken;?>"},
		style  : "inherit",
		type   : 'select',
		submit : 'Save',
		callback: function(response){
			if(response == 'success'){
				$j('#items').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem');
			}
		}
	});
	
	$j('.delete').click(function(){
		
			var details	=	$j(this).attr('lang'),
			id	=	details.split('*');
			value	=	$j(this).attr('rel');
			jConfirm('##_ASSIGNED_BY_ME_AJAX_CLOSE_TODO_##', 'Confirmation dialog', function(res){
			if(res == true){		
			$j.ajax({
				url: '<?php echo Yii::app()->params->base_path;?>user/changeItemStatus/id/'+id[0]+'/stat/'+value,
				success: function(response){
					var obj	=	$j.parseJSON(response);
					if( obj.status == 0 ) {
						if( id[1] == 'close' ) {
							$j("#contentrow_"+id[0]).fadeOut(0);
							$j('#items').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem');
						}
					}
				}
		    });	
		}
      });		
	});
});
</script>
<script type="text/javascript">
function forceDownload(url)
{
	console.log(url);
	var ifrm = document.getElementById('frame1');
    ifrm.src = url;
}
function urlify(text) {
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, function(url) {
        return '<a href="' + url + '" target="_blank" >' + url + '</a>';
    })
    // or alternatively
    // return text.replace(urlRegex, '<a href="$1">$1</a>')
}
function searchFromMyTodo()
{	
    var key = $j("#searchText").val();
	
	$j.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->params->base_path;?>user/MyTodoItem',
			data: 'keyword='+key,
			cache: false,
			success: function(data)
			{
				$j('#items').html(data);
				$j("#searchText").val(key);
			}
		});
	
}
</script>

<iframe id="frame1" style="display:none"></iframe>
<div class="listHeading" align="right">
    <div class="label reddot">
        <p>##_MY_TODO_AJAX_##</p>
        <?php
		if($items['count'] > 0){ ?>
        	<p class="reddot-bg">
            	<a class="spch-bubble-inside" onclick="$j('#myTodo').trigger('click');" href="javascript:;"><span class="bubblepoint"></span>
                	<em id="myTodoBubble"><?php echo $items['count']; ?></em>
                </a>
        	</p>
        <?php
		} ?>
        <div class="clear"></div>
    </div>
    <div class="floatRight">
        <input type="text" name="" class="textbox floatLeft" id="searchText" value="" />
        <input type="button" class="searchImg floatLeft" name="searchBtn" id="searchBtn" onclick="searchFromMyTodo();" />
	</div>
        
    ##_OTHER_TODO_AJAX_SHOWS_##:<input type="checkbox" <?php if( $items['user']['myOpenStatus'] == 1 ) {?>onchange="updateShowStatus('myOpenStatus', 0, 'myTodoItem', 'items')" checked="checked" <?php } else {?> onchange="updateShowStatus('myOpenStatus', 1, 'myTodoItem', 'items')"<?php }?> id="myOpen" name="myOpen" /> Open
     
        <input type="checkbox" <?php if( $items['user']['myDoneStatus'] == 3 ) {?>onchange="updateShowStatus('myDoneStatus', 0, 'myTodoItem', 'items')" checked="checked" <?php } else {?> onchange="updateShowStatus('myDoneStatus', 3, 'myTodoItem', 'items')"<?php }?> id="myDone" name="myDone" /> Done
        
        <input type="checkbox" <?php if( $items['user']['myCloseStatus'] == 4 ) {?>onchange="updateShowStatus('myCloseStatus', 0, 'myTodoItem', 'items')" checked="checked" <?php } else {?> onchange="updateShowStatus('myCloseStatus', 4, 'myTodoItem', 'items')"<?php }?> id="myClose" name="myClose" /> Close
    
    <div class="clear"></div>
</div>
<div id="test">
<table cellpadding="0" cellspacing="0" border="0" class="listing">
    <tr>
    	<th width="5%">##_MY_TODO_AJAX_NO_##</th>
        
        <th width="12%">
			<?php
            if(count($items['items']) > 0){ ?>
                <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/sortType/<?php echo $items['sortType'];?>/sortBy/assignedBy/flag/1' >##_MY_TODO_AJAX_ASSIGN_BY_##
                <?php 
                if($items['img_name'] != '' && $items['sortBy'] == 'assignedBy'){ ?>
                    <img src="<?php Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                    <?php
                } ?>
                </a>
            <?php 
            } else { ?>
                ##_MY_TODO_AJAX_ASSIGN_BY_##
            <?php 
            } ?>
		</th>
        
        <th width="12%">
			<?php
            if(count($items['items']) > 0){ ?>
                <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/sortType/<?php echo $items['sortType'];?>/sortBy/name/flag/1' >##_MY_TODO_AJAX_LIST_NAME_##
                <?php 
                if($items['img_name'] != '' && $items['sortBy'] == 'listId'){ ?>
                    <img src="<?php Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                    <?php
                } ?>
                </a>
            <?php 
            } else { ?>
                ##_MY_TODO_AJAX_LIST_NAME_##
            <?php 
            } ?>
        </th>
        
        <th width="41%">
        <?php
		if(count($items['items']) > 0){ ?>
            <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/sortType/<?php echo $items['sortType'];?>/sortBy/title/flag/1' >##_MY_TODO_AJAX_TITLE_##
            <?php 
            if($items['img_name'] != '' && $items['sortBy'] == 'title'){ ?>
                <img src="<?php Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                <?php
            } ?>
        </a>
		<?php 
		} else { ?>
        	##_MY_TODO_AJAX_TITLE_##
        <?php 
		} ?>
        </th>
        
        <th width="8%">
        <?php
		if(count($items['items']) > 0){ ?>
            <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/sortType/<?php echo $items['sortType'];?>/sortBy/dueDate/flag/1' >##_MY_TODO_AJAX_DUE_DATE_##
            <?php 
            if($items['img_name'] != '' && $items['sortBy'] == 'dueDate'){ ?>
                <img src="<?php Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_MY_TODO_AJAX_DUE_DATE_##
        <?php 
		} ?>
        </th>
        
        <th width="5%">
        <?php
		if(count($items['items']) > 0){ ?>
            <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/sortType/<?php echo $items['sortType'];?>/sortBy/priority/flag/1' >##_MY_TODO_AJAX_PRIORITY_##
            <?php 
            if($items['img_name'] != '' && $items['sortBy'] == 'priority'){ ?>
                <img src="<?php Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_MY_TODO_AJAX_PRIORITY_##
        <?php 
		} ?>
        </th>
        
        <th width="7%">
        <?php
        if(count($items['items']) > 0){ ?>
        	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/sortType/<?php echo $items['sortType'];?>/sortBy/status/flag/1' >##_MY_TODO_AJAX_STATUS_##
            <?php 
            if($items['img_name'] != '' && $items['sortBy'] == 'status'){ ?>
                <img src="<?php Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
			<?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_MY_TODO_AJAX_STATUS_##
        <?php 
		} ?>
        </th>
        <th width="20%" class="lastcolumn">&nbsp;</th>
    </tr>
    <?php 
    if(count($items['items']) > 0){
        foreach($items['items'] as $row) { ?>
        <tr id="contentrow_<?php echo $row['id'];?>" >
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['assignedByFname'] .' '. $row['assignedByLname']; ?></td>
            
            <td class="<?php if($row['assignedBy'] == 0){ ?>changeList<?php }?>" id="list_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>"><?php echo $row['listName']; ?> <?php if(isset($seen) && in_array($row['listName'],$seen)) { echo " - " .$row['listOwner']; } ?></td>
            
            <td><p class="<?php if($row['assignedBy'] == 0){ ?>changeTitle<?php }?>"  id="title_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>"><?php 
					echo $row['title'];
					?>
                  </p>
            	<div class="bubbleInfo">
                   
					<div>
						<?php
                        if( isset($row['description']) && $row['description'] != '' ) {
                        ?>
                        <a href="#" class="trigger">##_MY_TODO_AJAX_MORE_##</a>
                        <?php
                        }
                        ?>
                    </div>
                     <?php
					 
					
                    if( isset($row['description']) && $row['description'] != '' ) {
					?>
                    	<div id="#popup_tooltip_<?php echo $row['id'];?>" class="popup_tooltip" >
                            <div class="popupbg"> <img src="<?php echo Yii::app()->params->base_url;?>images/tooltip/arrow.png" alt="" title="" class="popuparrow" />
                                <div class="summary">
                                    <a href="#" onclick="javascript:$j('#popup_tooltip_<?php echo $row['id'];?>').fadeOut(0);"><img src="<?php echo Yii::app()->params->base_url;?>images/tooltip/close.png" align="right" alt="" title="##_BTN_CLOSE_##" /></a>
                                    <p class="headline"> 
										<?php
                                        if( isset($row['description']) && $row['description'] != '' ) {
											echo $row['description'];
                                        ?>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                        ##_MY_TODO_AJAX_NO_DESC_##
                                        <?php
                                        }
                                        ?>
									</p>
                                </div>
                            </div>
                    	</div>
                    <?php
					}
					?>
				</div>
				<div class="clear"></div>
            </td>
            <?php
			if( $row['dueDate'] == date('Y-m-d') ) {
				$dueDate	=	'Today';
			} else if( $row['dueDate'] == date('Y-m-d', strtotime("+1 day")) ) {
				$dueDate	=	'Tomorrow';
			} else {
				$dueDate	=	$row['dueDate'];
			}
			?>
            <td class="<?php if($row['assignedBy'] == 0){ ?>datepicker-initiative<?php }?>" id="dueDate_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>"><?php echo $dueDate;?></td>
            <td class="<?php if($row['assignedBy'] == 0){ ?>changePriority<?php }?>" id="priority_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>">
            <?php
            if($row['priority'] == 0){
                echo 'Low';
            } else if($row['priority'] == 1){
                echo 'Medium';
            }else if($row['priority'] == 2){
                echo 'High';
            } else{
                echo 'Urgent';
            }
            ?>
            </td>
            <?php
			if($row['status'] == 1) {
				$class	=	'open';
				$value	=	'Open';
			} else if($row['status'] == 2) {
				$class	=	'';
				$value	=	'QA';
			} else if($row['status'] == 3) {
				$class	=	'done';
				$value	=	'Done';
			} else {
				$class	=	'close';
				$value	=	'Close';
			}
			?>
            <td id="status_<?php echo $row['id'];?>">
            	<div class="checkbox1">
            	<?php
				if( $row ['status'] == 1 ){ ?>
					<input type="checkbox" name="status" lang="<?php echo $row['id'].'*done';?>" class="statusDone" value="3" />
				<?php
                } else if( $row ['status'] == 3 || $row ['status'] == 4 ) { ?>
					<input type="checkbox" checked="checked" name="status" lang="<?php echo $row['id'].'*open';?>" class="statusDone" value="1" />
				<?php
                } ?>
                <span class="<?php if($row['status'] !=4){ ?> <?php }?> <?php echo $class;?>" id="<?php echo $row['id'];?>">
                <?php
				echo $value;?>
                </span>
                </div>
            </td>
            <td class="lastcolumn">
                <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $row['id'];?>/from/home');" id="viewMore_<?php echo $row['id'];?>" class="viewIcon floatLeft noMartb" title="##_BTN_VIEW_##">
                </a>
                <a href="<?php echo Yii::app()->params->base_path;?>user/reassignTask/id/<?php echo $row['id'];?>" id="reassign" class="reassign floatLeft noMartb" title="##_BTN_REASSIGN_##"><img src="<?php echo Yii::app()->params->base_url;?>images/reassign.png" alt="Reassign" /></a>
                <?php 
				if($row['assignedBy'] == 0){ ?>
				<a href="javascript:;" class="deleteIcon noMartb deleteItem delete" rel="4" lang="<?php echo $row['id'].'*close';?>"  id="delete_<?php echo $row['id'];?>" title="##_BTN_DELETE_##"></a>
                <?php
				}?>
                <?php
				if( isset($row['attachmentFile']) && $row['attachmentFile'] != '' ) {
				?>
				<a href="javascript:forceDownload('<?php echo Yii::app()->params->base_path;?>upload/getAttach/dir/<?php echo $row['attachmentDir'];?>/fileName/<?php echo $row['attachmentFile'];?>')" class="floatLeft" >
                <img src="<?php echo Yii::app()->params->base_url;?>images/attachment.png" />
                </a>
				<?php
				}?>
                
                <?php
				if( $row['assignedBy'] != 0 ) { ?>
					<a href="<?php echo Yii::app()->params->base_path;?>user/assignBack/itemId/<?php echo $row['id'];?>" class="reassign noMartb" title="##_BTN_ASSIGN_BACK_##">
						<img src="<?php echo Yii::app()->params->base_url;?>images/query.png" />
					</a>
				<?php
				}?>
                
            </td>
        </tr>
        <?php 
        }
    } else { ?>
        <tr>
            <td colspan="9" class="lastcolumn">
                ##_MY_TODO_AJAX_NO_TODO_ITEM_##
            </td>
        </tr>
    <?php
    } ?>
    </table>
 <?php
if(!empty($items['pagination']) && $items['pagination']->getItemCount()  > $items['pagination']->getLimit()){?>
<div class="pagination">
    <?php
	$extraPaginationPara='mylist='.$extraPara['mylist'].'&mytodoStatus='.$extraPara['mytodoStatus'];
    $this->widget('application.extensions.WebPager', 
                    array('cssFile'=>true,
							'extraPara'=>$extraPaginationPara,
                             'pages' => $items['pagination'],
                             'id'=>'link_pager',
    ));
    ?> </div> <?php
    }
    ?>
    <script type="text/javascript">
    $j(document).ready(function(){
        $j('#link_pager a').each(function(){
            $j(this).click(function(ev){
                ev.preventDefault();
                $j.get(this.href,{ajax:true},function(html){
                    $j('#items').html(html);
                });
            });
        });
    });
</script>
</div>
<script type="text/javascript">
	$j(function () {
	$j('.bubbleInfo').each(function () {
	var distance = 10;
	var time = 250;
	var hideDelay = 500;
	
	var hideDelayTimer = null;
	
	var beingShown = false;
	var shown = false;
	var trigger = $j('.trigger', this);
	var info = $j('.popup_tooltip', this).css('opacity', 0);
	
	
	$j([trigger.get(0), info.get(0)]).mouseover(function () {
		if (hideDelayTimer) clearTimeout(hideDelayTimer);
		if (beingShown || shown) {
			// don't trigger the animation again
			return;
		} else {
			// reset position of info box
			beingShown = true;
	
			info.css({
				top:10,
				left:20,
				display: 'block'
			}).animate({
				top: '-=' + distance + 'px',
				opacity: 1
			}, time, 'swing', function() {
				beingShown = false;
				shown = true;
			});
		}
	
		return false;
	}).mouseout(function () {
		if (hideDelayTimer) clearTimeout(hideDelayTimer);
		hideDelayTimer = setTimeout(function () {
			hideDelayTimer = null;
			info.animate({
				top: '-=' + distance + 'px',
				opacity: 0
			}, time, 'swing', function () {
				shown = false;
				info.css('display', 'none');
			});
	
		}, hideDelay);
	
		return false;
	});
	
	});
	});
	</script>
</div>
 	
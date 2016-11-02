<?php 
$extraPaginationPara='&mylist='.$extraPara['mylist'].'&mytodoStatus='.$extraPara['mytodoStatus'].'&keywordOther='.$extraPara['keywordOther'];
if(trim($extraPara['keywordOther'])!='')
 {
	 $extraPaginationPara.= '&keywordOther='.$extraPara['keywordOther'];
 }
 if(trim($extraPara['assignToSearch'])!='')
 {
	 $extraPaginationPara.= '&assignToSearch='.$extraPara['assignToSearch'];
 }
  if(trim($extraPara['assignBySearch'])!='')
 {
	 $extraPaginationPara.= '&assignBySearch='.$extraPara['assignBySearch'];
 }
  if(isset($_REQUEST['mylist']))
 {
	 $others['currentList']=$_REQUEST['mylist'];
 }
$ListBox='<select id="txtSearchListDP" name="txtSearchListDP" style="width:120px;" onchange="reloadHomeByList(1, 3)">';
$ListBox.='<option value="0">All</option>';
$listData	=	'{';
for($i=0; $i<=count($others['myLists']); $i++){
	
	if( $i != count($others['myLists']) ) {
		if( isset($others['currentList']) && $others['currentList'] == $others['myLists'][$i]['id'] ) {
			$selected	=	'selected="selected"';
		} else {
			$selected	=	'';
		}
	}
	
	if($i == count($others['myLists'])){
		$listData .= "}";
	} else if($i == 0) {
		$ListBox.='<option '.$selected.' value="'.$others['myLists'][$i]['id'].'">'.$others['myLists'][$i]['name'].'</option>';
		$listData .= "'".$others['myLists'][$i]['id']."':'".$others['myLists'][$i]['name']."'";
	} else {
		$ListBox.='<option '.$selected.' value="'.$others['myLists'][$i]['id'].'">'.$others['myLists'][$i]['name'].'</option>';
		$listData .= ",'".$others['myLists'][$i]['id']."':'".$others['myLists'][$i]['name']."'";
	}
}
$ListBox.='</select>';?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/smoothscroll.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	
	$j('#otherTodoBubble').click(function(){
		$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/1'+'<?php echo  $extraPaginationPara;?>');
	});
	
	$j('.sortOther').click(function() {
		var url	=	$j(this).attr('lang'),
			container	=	getOtherContainer();
		loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>', container);
	});
});
function updateOtherShowStatus( field, status, url ) {
	$j.ajax({
		url	: '<?php echo Yii::app()->params->base_path;?>user/changeShowStatus',
		data : 'field='+field+'&status='+status+'&'+csrfToken,
		type : 'POST',
		dataType : 'json',
		success : function(response) {
			if( response.status == 0 ) {
				var container	=	getOtherContainer();
				loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/'+url+'<?php echo  $extraPaginationPara;?>',container);
			}
		}
	});
}
function getOtherContainer() {
	if( '<?php echo $others['moreflag'];?>' == 1 ) {
		return 'mainContainer';
	} else {
		return 'otherTodoItem';
	}
}
function searchFromOthersTodo()
{	
$j('#update-message').removeClass().html('<div class="updateLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
		container	=	getOtherContainer();
		
            $j.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>',
                    data: $j("#otherTODOSearch").serialize(),
                    cache: false,
                    success: function(data)
                    {
                        $j('#'+container).html(data);
                    }
                });
				$j('#update-message').removeClass().html('<div class="updateLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').hide();
	
}
</script>
<?php if($others['moreflag']==1){?>
    <div class="RightSide">	
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user','post',array('id' => 'serchDPForm','name' => 'serchDPForm')) ?>
    	<div class="todoList">
            <span class="floatLeft">##_HOME_TODO_LIST_##:</span>
            <div id="searchListDP">
				<?php echo $ListBox;?>
            </div>
        </div>
        <div class="clear"></div>
     <?php echo CHtml::endForm(); ?>	          
<?php } ?>
<iframe id="frame1" style="display:none"></iframe>
<div class="listHeading" align="right">
    <div class="label reddot">
        <p>
        	##_OTHER_TODO_AJAX_OTHER_## <span class="red"><?php if( $others['moreflag'] == 1 ) { echo '('.$others['count'].')'; }?></span>
        </p>
        <?php
        if( $others['count'] > 0 && $others['moreflag'] == 0 ){ ?>
            <p class="reddot-bg">
                <a class="spch-bubble-inside" href="javascript:;"><span class="bubblepoint"></span>
                	<em id="otherTodoBubble"><?php echo $others['count']; ?></em>
                </a>
            </p>
        <?php
        } ?>
    </div>
    <div class="floatRight">
    	<div style="width:300px;">
        	 <?php echo CHtml::beginForm(Yii::app()->params->base_path,'post',array('id' => 'otherTODOSearch','name' => 'otherTODOSearch','onsubmit' => 'return false;')) ?>
                <input type="button" class="searchImg floatRight" name="searchBtnOthersTodo"  onclick="searchFromOthersTodo();" />
                <input type="text" name="keywordOther" id="searchOthersText" onkeypress="if(event.keyCode==13){searchFromOthersTodo();}" autocomplete="off"  value="<?php echo $extraPara['keywordOther'];?>" class="textbox floatRight" />
			<?php echo CHtml::endForm(); ?>	   
        </div>
        <div class="topOptions">
            <div class="checkbox1"><input type="checkbox" <?php if( $others['user']['otherOpenStatus'] == 1 ) {?>onchange="updateOtherShowStatus('otherOpenStatus', 0, 'otherTodoItem/moreflag/<?php echo $others['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateOtherShowStatus('otherOpenStatus', 1, 'otherTodoItem/moreflag/<?php echo $others['moreflag'];?>')"<?php }?> id="otherOpen" name="otherOpen" /><span>Open</span></div>            
            <div class="checkbox1"><input type="checkbox" <?php if( $others['user']['otherDoneStatus'] == 3 ) {?>onchange="updateOtherShowStatus('otherDoneStatus', 0, 'otherTodoItem/moreflag/<?php echo $others['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateOtherShowStatus('otherDoneStatus', 3, 'otherTodoItem/moreflag/<?php echo $others['moreflag'];?>')"<?php }?> id="otherDone" name="otherDone" /><span>Done</span></div>            
            <div class="checkbox1"><input type="checkbox" <?php if( $others['user']['otherCloseStatus'] == 4 ) {?>onchange="updateOtherShowStatus('otherCloseStatus', 0, 'otherTodoItem/moreflag/<?php echo $others['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateOtherShowStatus('otherCloseStatus', 4, 'otherTodoItem/moreflag/<?php echo $others['moreflag'];?>')"<?php }?> id="otherClose" name="otherClose" /><span>Close</span></div>
            <span class="floatRight"><b>##_OTHER_TODO_AJAX_SHOWS_##:</b></span>
            <div class="clear"></div>
        </div>
        <div class="clear"></div> 
    </div>
    <div class="clear"></div>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="listing">
    <tr>
    	<th width="5%">##_OTHER_TODO_AJAX_NO_##</th>
        
        <th width="12%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/assignedByFname/flag/1' >##_OTHER_TODO_AJAX_ASSIGNED_BY_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'assignedByFname'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_ASSIGNED_BY_##
        <?php 
		}?>
        </th>
        
        <th width="12%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/assignedToFname/flag/1' >##_OTHER_TODO_AJAX_ASSIGNED_TO_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'assignedToFname'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_ASSIGNED_TO_##
        <?php 
		}?>
        </th>
        
        <th width="12%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/listName/flag/1' >##_OTHER_TODO_AJAX_LIST_NAME_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'listName'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_LIST_NAME_##
        <?php 
		}?>
        </th>
        
        <th width="32%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/title/flag/1' >##_OTHER_TODO_AJAX_TITLE_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'title'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_TITLE_##
        <?php 
		}?>
        </th>
        
        <th width="8%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/dueDate/flag/1' >##_OTHER_TODO_AJAX_DUE_DATE_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'dueDate'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_DUE_DATE_##
        <?php 
		}?>
        </th>
        
        <th width="5%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/priority/flag/1' >##_OTHER_TODO_AJAX_PRIORITY_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'priority'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_PRIORITY_##
        <?php 
		}?>
        </th>
        
        <th width="7%">
        <?php
		if(count($others['items']) > 0){ ?>
        	<a href="javascript:;" class="sortOther" lang='<?php Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/<?php echo $others['moreflag'];?>/sortType/<?php echo $others['sortType'];?>/sortBy/status/flag/1' >##_OTHER_TODO_AJAX_STATUS_##
            <?php 
            if($others['img_name'] != '' && $others['sortBy'] == 'status'){ ?>
            	<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $others['img_name'];?>" class="sortImage" />
                <?php
            } ?>
            </a>
		<?php 
		} else { ?>
        	##_OTHER_TODO_AJAX_STATUS_##
        <?php 
		}?>
        </th>
        
        <th width="12%" class="lastcolumn">&nbsp;</th>
    </tr>
    <?php 
    if(count($others['items']) > 0){
        foreach($others['items'] as $row) { ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td class="alignLeft"><?php echo $row['assignedByFname'] .' '. $row['assignedByLname']; ?></td>
            <td class="alignLeft"><?php echo $row['assignedToFname'] .' '. $row['assignedToLname']; ?></td>
            <td><?php echo $row['listName']; ?> <?php if(isset($seen) && in_array($row['listName'],$seen)) { echo " - " .$row['listOwner']; } ?></td>
            <td>
				<?php if( $row['commentCount'] > 0 )
                {
                ?>
                <span class="commentIcon">
                    <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $row['id'];?>/flag/<?php echo $others['moreflag'];?>/url/OtherTodoItem');" lang="<?php echo $row['id'];?>">
                        <?php echo $row['commentCount']; ?>
                    </a>
                </span>
                <?php } ?>
				<p>
				<?php
				if( isset($row['title']) && $row['title'] != '' ) {				
					echo $row['title'];
				}
				 ?>
                </p>
                <div class="bubbleInfo">
                   
					<div>
						<?php
                        if( isset($row['description']) && $row['description'] != '' ) {
                        ?>
                        <a href="#" class="trigger">##_OTHER_TODO_AJAX_MORE_##</a>
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
                                    <a  href="javascript:;" onclick="$j('.popup_tooltip').css('display','none');"><img src="<?php echo Yii::app()->params->base_url;?>images/tooltip/close.png" align="right" alt="" title="##_BTN_CLOSE_##" /></a>
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
                                        ##_OTHER_TODO_AJAX_NO_DESC_##
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
						
			$generalObj=new General();
			$dueDate=$generalObj->pastdue($row['dueDate'],$row['myTimeZone']);
			?>
			<td style="color:<?php echo $dueDate['class'];?>;"><?php echo $dueDate['value'];?></td>
            
            <td>
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
            <td class="<?php echo $class;?>">
            	<?php echo $value; ?>
			</td>
            <td class="lastcolumn">
                <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $row['id'];?>/flag/<?php echo $others['moreflag'];?>/url/OtherTodoItem');" lang="<?php echo $row['id'];?>" id="viewMore_<?php echo $row['id'];?>" class="viewIcon viewMore noMartb floatLeft" title="##_BTN_VIEW_##">
                </a>
                
                <?php
				if( isset($row['attachmentFile']) && $row['attachmentFile'] != '' ) {
				?>
					<a href="javascript:forceDownload('<?php echo Yii::app()->params->base_path;?>upload/getAttach/dir/<?php echo $row['attachmentDir'];?>/fileName/<?php echo $row['attachmentFile'];?>')" class="floatLeft" title="##_BTN_ATTACH_##">
						<img src="<?php echo Yii::app()->params->base_url;?>images/attachment.png" />
					</a>
				<?php
				}?>
            </td>
        </tr>
        <?php 
        }
    } else { ?>
<tr>
    <td colspan="10" class="lastcolumn">
        ##_OTHER_TODO_AJAX_NO_ITEMS_##
    </td>
</tr>
<?php
} ?>
</table>
<?php
if(!empty($others['pagination']) && $others['pagination']->getItemCount()  > $others['pagination']->getLimit()){?>
<div class="pagination">
    <?php
	
    $this->widget('application.extensions.WebPager', 
                    array('cssFile'=>true,
							'extraPara'=>$extraPaginationPara,
                             'pages' => $others['pagination'],
                             'id'=>'link_pager2',
    ));
    ?> 
</div> 
<?php
}
?>
<script type="text/javascript">
	$j(document).ready(function(){
		$j('#link_pager2 a').each(function(){
			$j(this).click(function(ev){
				ev.preventDefault();
				$j.get(this.href,{ajax:true},function(html){
					var container	=	getOtherContainer();
					$j('#'+container).html(html);
				});
			});
		});
	});
</script>
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
<?php
if($others['moreflag']==1){?>
	</div>
<?php
}?>
<script type="text/javascript">
$j(document).ready(function () {
	var flag	=	'<?php echo $others['moreflag'];?>';
	if( flag == 1 ) {
		window.currentPage	=	3;
	}
	window.extraPara="<?php echo $extraPaginationPara?>";
});
</script>
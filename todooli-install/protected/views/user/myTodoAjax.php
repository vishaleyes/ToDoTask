<?php
 $extraPaginationPara='&mylist='.$extraPara['mylist'].'&mytodoStatus='.$extraPara['mytodoStatus'];
 if(trim($extraPara['keywordMyTODO'])!='')
 {
	 $extraPaginationPara.= '&keywordMyTODO='.$extraPara['keywordMyTODO'];
 }
 if(trim($extraPara['assignBySearch'])!='')
 {
	 $extraPaginationPara.= '&assignBySearch='.$extraPara['assignBySearch'];
 }
 if(isset($_REQUEST['mylist']))
 {
	 $items['currentList']=$_REQUEST['mylist'];
 }
 $ListBox='<select id="txtSearchListDP" name="txtSearchListDP" style="width:120px;" onchange="reloadHomeByList(1, 1)">';
$ListBox.='<option value="0">All</option>';
$listData	=	'{';
for($i=0; $i<=count($items['myLists']); $i++){
	
	if( $i != count($items['myLists']) ) {
		if( isset($items['currentList']) && $items['currentList'] == $items['myLists'][$i]['id'] ) {
			$selected	=	'selected="selected"';
		} else {
			$selected	=	'';
		}
	}
		
	if($i == count($items['myLists'])){
		$listData .= "}";
	} else if($i == 0) {
		$ListBox.='<option '.$selected.' value="'.$items['myLists'][$i]['id'].'">'.$items['myLists'][$i]['name'].'</option>';
		$listData .= "'".$items['myLists'][$i]['id']."':'".$items['myLists'][$i]['name']."'";
	} else {
		$ListBox.='<option '.$selected.' value="'.$items['myLists'][$i]['id'].'">'.$items['myLists'][$i]['name'].'</option>';
		$listData .= ",'".$items['myLists'][$i]['id']."':'".$items['myLists'][$i]['name']."'";
	}
}
$ListBox.='</select>';
?>
<?php if($items['moreflag']==1){?>
<div class="RightSide" id="insideContainer">	
	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'user','post',array('id' => 'serchDPForm','name' => 'serchDPForm')) ?>
		<div class="todoList">
            <span class="floatLeft">##_HOME_TODO_LIST_##:</span>
            <div id="searchListDP">
                <?php echo $ListBox;?>
            </div>
        </div>
    <?php echo CHtml::endForm(); ?>	       
    <?php } ?>
	<script type="text/javascript">
    var BASHPATH='<?php echo Yii::app()->params->base_url; ?>';
    var imgPath='<?php echo Yii::app()->params->base_url; ?>images/';
    $j(document).ready(function(){
        
		$j('#myTodoBubble').click(function(){
		$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/1'+'<?php echo  $extraPaginationPara;?>');
		});
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
            var url	=	$j(this).attr('lang'),
                container	=	getContainer();
            loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>',container);
            
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
                var obj	=	$j.parseJSON(response),
                    container	=	getContainer();
                if(obj.status == 0){
                    if(obj.change == 1) {
                        $j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
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
                        //alert(window.mylist);
                        $j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax/list/'+window.mylist);
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
                    var container	=	getContainer();
                    $j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
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
                var container	=	getContainer();
                if(response == 'success'){
                    $j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
                } else {
					$j("#update-message")
						.addClass('error-msg')
						.html(response)
						.fadeIn();
					smoothScroll('update-message');
					setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
					$j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
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
                    var container	=	getContainer();
                    if(response == 'success'){
                        $j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
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
                    var container	=	getContainer();
                    $j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
                }
            }
        });
        
        $j('.delete').click(function(){
            
                var details	=	$j(this).attr('lang'),
                    id	=	details.split('*');
                    value	=	$j(this).attr('rel'),
                    container	=	getContainer();
                jConfirm('##_ASSIGNED_BY_ME_AJAX_CLOSE_TODO_##', 'Confirmation dialog', function(res){
                if(res == true){		
                $j.ajax({
                    url: '<?php echo Yii::app()->params->base_path;?>user/changeItemStatus/id/'+id[0]+'/stat/'+value,
                    success: function(response){
                        var obj	=	$j.parseJSON(response);
                        if( obj.status == 0 ) {
                            if( id[1] == 'close' ) {
                                $j("#contentrow_"+id[0]).fadeOut(0);
                                $j('#'+container).load('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>');
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
		$j('#update-message').removeClass().html('<div class="updateLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
            container	=	getContainer();
        $j.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>'+'<?php echo  $extraPaginationPara;?>',
                data: $j("#myTODOSearch").serialize(),
                cache: false,
                success: function(data)
                {
                    $j('#'+container).html(data);
					$j('#update-message').removeClass().html('<div class="updateLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').hide();
                }
            });
        
    }
    function updateMyShowStatus( field, status, url ) {
        $j.ajax({
            url	: '<?php echo Yii::app()->params->base_path;?>user/changeShowStatus',
            data : 'field='+field+'&status='+status+'&'+csrfToken,
            type : 'POST',
            dataType : 'json',
            success : function(response) {
                if( response.status == 0 ) {
                    var container	=	getContainer();
                    loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/'+url+'<?php echo  $extraPaginationPara;?>',container);
                }
            }
        });
    }
    function getContainer() {
        if( '<?php echo $items['moreflag'];?>' == 1 ) {
            return 'mainContainer';
        } else {
            return 'items';
        }
    }
    
    </script>
    
    <iframe id="frame1" style="display:none"></iframe>
    <div class="listHeading" align="right">
        <div class="label reddot">
            <p>
                ##_MY_TODO_AJAX_## <span class="red"><?php if( $items['moreflag'] == 1 ){ echo '('.$items['count'].')'; } ?></span>
            </p>
            <?php
            if($items['count'] > 0 && $items['moreflag'] == 0){ ?>
                <p class="reddot-bg">
                    <a class="spch-bubble-inside"  href="javascript:;"><span class="bubblepoint"></span>
                        <em id="myTodoBubble"><?php echo $items['count']; ?></em>
                    </a>
                </p>
            <?php
            } ?>
        </div>
        <div class="floatRight">
            <div>
                 <?php echo CHtml::beginForm(Yii::app()->params->base_path,'post',array('id' => 'myTODOSearch','name' => 'myTODOSearch','onsubmit' => 'return false;')) ?>
                    <input type="text" name="keywordMyTODO" class="textbox floatLeft" id="searchText" onkeypress="if(event.keyCode==13){searchFromMyTodo();}"  value="<?php echo $extraPara['keywordMyTODO'];?>" />
                    <input type="button" class="searchImg floatLeft" name="searchBtn" id="searchBtn" onclick="searchFromMyTodo();" />
                <?php echo CHtml::endForm(); ?>	   
            </div>
            <div class="topOptions">
                <div class="checkbox1"><input type="checkbox" <?php if( $items['user']['myOpenStatus'] == 1 ) {?>onchange="updateMyShowStatus('myOpenStatus', 0, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateMyShowStatus('myOpenStatus', 1, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')"<?php }?> id="myOpen" name="myOpen" /><span>Open</span></div>
                <div class="checkbox1"><input type="checkbox" <?php if( $items['user']['myDoneStatus'] == 3 ) {?>onchange="updateMyShowStatus('myDoneStatus', 0, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateMyShowStatus('myDoneStatus', 3, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')"<?php }?> id="myDone" name="myDone" /><span>Done</span></div>
                <div class="checkbox1"><input type="checkbox" <?php if( $items['user']['myCloseStatus'] == 4 ) {?>onchange="updateMyShowStatus('myCloseStatus', 0, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateMyShowStatus('myCloseStatus', 4, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')"<?php }?> id="myClose" name="myClose" /><span>Close</span></div>
                <span class="floatRight"><b>##_OTHER_TODO_AJAX_SHOWS_##:</b></span>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="test">
        <table cellpadding="0" cellspacing="0" border="0" class="listing">
            <tr>
                <th width="5%">##_MY_TODO_AJAX_NO_##</th>
                
                <th width="12%">
                    <?php
                    if(count($items['items']) > 0){ ?>
                        <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>/sortType/<?php echo $items['sortType'];?>/sortBy/assignedByFname/flag/1' >##_MY_TODO_AJAX_ASSIGN_BY_##
                        <?php 
                        if($items['img_name'] != '' && $items['sortBy'] == 'assignedByFname'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
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
                        <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>/sortType/<?php echo $items['sortType'];?>/sortBy/listName/flag/1' >##_MY_TODO_AJAX_LIST_NAME_##
                        <?php 
                        if($items['img_name'] != '' && $items['sortBy'] == 'listName'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a>
                    <?php 
                    } else { ?>
                        ##_MY_TODO_AJAX_LIST_NAME_##
                    <?php 
                    } ?>
                </th>
                
                <th width="36%">
                <?php
                if(count($items['items']) > 0){ ?>
                    <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>/sortType/<?php echo $items['sortType'];?>/sortBy/title/flag/1' >##_MY_TODO_AJAX_TITLE_##
                    <?php 
                    if($items['img_name'] != '' && $items['sortBy'] == 'title'){ ?>
                        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
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
                    <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>/sortType/<?php echo $items['sortType'];?>/sortBy/dueDate/flag/1' >##_MY_TODO_AJAX_DUE_DATE_##
                    <?php 
                    if($items['img_name'] != '' && $items['sortBy'] == 'dueDate'){ ?>
                        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                        <?php
                    } ?>
                    </a>
                <?php 
                } else { ?>
                    ##_MY_TODO_AJAX_DUE_DATE_##
                <?php 
                } ?>
                </th>
                
                <th width="6%">
                <?php
                if(count($items['items']) > 0){ ?>
                    <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>/sortType/<?php echo $items['sortType'];?>/sortBy/priority/flag/1' >##_MY_TODO_AJAX_PRIORITY_##
                    <?php 
                    if($items['img_name'] != '' && $items['sortBy'] == 'priority'){ ?>
                        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                        <?php
                    } ?>
                    </a>
                <?php 
                } else { ?>
                    ##_MY_TODO_AJAX_PRIORITY_##
                <?php 
                } ?>
                </th>
                
                <th width="8%">
                <?php
                if(count($items['items']) > 0){ ?>
                    <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/myTodoItem/moreflag/<?php echo $items['moreflag'];?>/sortType/<?php echo $items['sortType'];?>/sortBy/status/flag/1' >##_MY_TODO_AJAX_STATUS_##
                    <?php 
                    if($items['img_name'] != '' && $items['sortBy'] == 'status'){ ?>
                        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $items['img_name'];?>" class="sortImage" />
                    <?php
                    } ?>
                    </a>
                <?php 
                } else { ?>
                    ##_MY_TODO_AJAX_STATUS_##
                <?php 
                } ?>
                </th>
                <th width="23%" class="lastcolumn">&nbsp;</th>
            </tr>
            <?php 
            if(count($items['items']) > 0){
                foreach($items['items'] as $row) { ?>
                <tr id="contentrow_<?php echo $row['id'];?>" >
                    <td>
                    <?php
                    //echo "<pre>";
                    //print_r($items['items'])
                    ?>
                    
                    <?php echo $row['id'] ?></td>
                    <td><?php echo $row['assignedByFname'] .' '. $row['assignedByLname']; ?></td>
                    <td class="<?php if($row['assignedBy'] == 0){ ?>changeList<?php }?>" id="list_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>"><?php echo $row['listName']; ?> <?php if(isset($seen) && in_array($row['listName'],$seen)) { echo " - " .$row['listOwner']; } ?></td>
                    <td>
                        <?php if( $row['commentCount'] > 0 )
                        {
                        ?>
                        <span class="commentIcon">
                            <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $row['id'];?>/flag/<?php echo $items['moreflag'];?>/url/myTodoItem');">
                                <?php echo $row['commentCount']; ?>
                            </a>
                        </span>
                        <?php } ?>
                        <p class="<?php if($row['assignedBy'] == 0){ ?>changeTitle<?php }?>"  id="title_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>">
                        <?php echo $row['title']; ?>
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
                                            <a href="javascript:;" onclick="$j('.popup_tooltip').css('display','none');"><img src="<?php echo Yii::app()->params->base_url;?>images/tooltip/close.png" align="right" alt="" title="##_BTN_CLOSE_##" /></a>
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
					$generalObj=new General();
					$dueDate=$generalObj->pastdue($row['dueDate'],$row['myTimeZone']);
                 
                    ?>
                    <td class="<?php if($row['assignedBy'] == 0){ ?>datepicker-initiative<?php }?>" style="color:<?php echo $dueDate['class'];?>;" id="dueDate_<?php echo $row['id'];?>" lang="<?php echo $row['id'];?>"><?php echo $dueDate['value'];?></td>
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
                        <a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $row['id'];?>/flag/<?php echo $items['moreflag'];?>/url/myTodoItem');" id="viewMore_<?php echo $row['id'];?>" class="viewIcon floatLeft noMartb" title="##_BTN_VIEW_##">
                        </a>
                        <a href="<?php echo Yii::app()->params->base_path;?>user/reassignTask/id/<?php echo $row['id'];?>" id="reassign" class="reassign floatLeft noMartb" title="##_BTN_REASSIGN_##"><img src="<?php echo Yii::app()->params->base_url;?>images/reassign.png" alt="Reassign" /></a>
                        <?php 
                        if($row ['status'] != 4 && Yii::app()->session['loginId']==$row['creater']){ ?>
                        <a href="javascript:;" class="deleteIcon noMartb deleteItem delete floatLeft" rel="4" lang="<?php echo $row['id'].'*close';?>"  id="delete_<?php echo $row['id'];?>" title="##_BTN_CLOSE_##"></a>
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
                            var container	=	getContainer();
                            $j('#'+container).html(html);
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
   
<?php
if($items['moreflag']==1){?>
	</div>
<?php
}?>
<script type="text/javascript">
$j(document).ready(function () {
	var flag	=	'<?php echo $items['moreflag'];?>';
	if( flag == 1 ) {
		window.currentPage	=	1;
	}
	window.extraPara="<?php echo $extraPaginationPara?>";
});
</script>
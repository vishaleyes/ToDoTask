<?php

if(!isset($items['currentList']))
{
	$items['currentList']=0;
}
$ListBox='<select id="txtSearchListDP" name="mylist" style="width:120px;" onchange="this.form.submit()">';
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
<script>
function updateMyShowStatus( field, status, url ) {
          window.location.href="<?php echo Yii::app()->params->base_path;?>muser/changeShowStatus/field/"+field+"/status/"+status+"/url/mytodo/mylist/<?php echo $items['currentList'];?>";  
}		
</script>
<div class="title">##_MOBILE_USER_TODO_LISTS_TODO_## <label class="red"><?php if( isset(Yii::app()->session['myTodoCount']) ){echo "(".Yii::app()->session['myTodoCount'].")";} ?></label>
</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>

<div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
<div class="clear"></div>
<?php endif; ?>

<div class="topOptionsBg">
	<div class="searchBox">
		<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/myTodo','post',array('id' => 'myTodo','name' => 'myTODOSearch')) ?>
			<?php echo $ListBox;?>
    	<?php echo CHtml::endForm(); ?>
    </div>
    
    <div class="topOptions checkbox1"><input type="checkbox" <?php if( $items['user']['myOpenStatus'] == 1 ) {?>onchange="updateMyShowStatus('myOpenStatus', 0, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateMyShowStatus('myOpenStatus', 1, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')"<?php }?> id="myOpen" name="myOpen" /><span>Open</span><input type="checkbox" <?php if( $items['user']['myDoneStatus'] == 3 ) {?>onchange="updateMyShowStatus('myDoneStatus', 0, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateMyShowStatus('myDoneStatus', 3, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')"<?php }?> id="myDone" name="myDone" /><span>Done</span><input type="checkbox" <?php if( $items['user']['myCloseStatus'] == 4 ) {?>onchange="updateMyShowStatus('myCloseStatus', 0, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateMyShowStatus('myCloseStatus', 4, 'myTodoItem/moreflag/<?php echo $items['moreflag'];?>')"<?php }?> id="myClose" name="myClose" /><span>Close</span></div><div class="clear"></div>
</div>

<?php
if(count($data['items']) > 0){
	?> <ul class="listView todoList"> <?php
	foreach($data['items'] as $row){ ?>
		 <?php
			if($row['status'] == 1) {
				$value	=	'Open';
			} else if($row['status'] == 2) {
				$value	=	'QA';
			} else if($row['status'] == 3) {
				$value	=	'Done';
			} else {
				$value	=	'Close';
			}
			$generalObj=new General();
			$dueDate=$generalObj->pastdue($row['dueDate'],$row['myTimeZone']);
			?>
		<li onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>muser/itemDescription/id/<?php echo $row['id_encrypt'];?>'">
			<div class="arrow">
				<p><?php echo $row['listName']; ?> [<b><?php echo $value;?></b>] - <?php echo $row['title']; ?></p>
				<p>By <?php echo $row['assignedByFname'] .' '. $row['assignedByLname']; ?> ##_MOBILE_USER_TODO_LISTS_DUE_DATE_## : <span style="color:<?php echo $dueDate['class'];?>;"><?php echo $dueDate['value']; ?>&nbsp;</span></p>
			</div>
		</li>
	<?php
	}
	?> </ul> <?php
} else { ?>
<div class="nodata"> ##_MOBILE_USER_TODO_LISTS_NO_TODO_##</div>
<?php
}?>

<?php if(!empty($data['pagination']) && $data['pagination']->getItemCount() > $data['pagination']->getLimit()){?>
<div class="pagination" align="left">
	<?php
	$extraPara="&mylist=".$items['currentList'];
	
    $this->widget('application.extensions.MobilePager',
         array('cssFile'=>true,
                'pages' => $data['pagination'],
				'extraPara'=>$extraPara,
                'id'=>'link_pager',
    ));
	?> 
</div> 
<?php } ?>
<div class="clear"></div>

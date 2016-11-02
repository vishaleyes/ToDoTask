
<script type="text/javascript">
	$j(document).ready(function(){
		$j('.todoItems').tinyscrollbar();	
	});
	
	function searchByName(name,type)
	{
		if(type==1)
		{
			$j("#assignBySearch").val(name);
			reloadHomeByList();
		}
		else if(type==2)
		{
			$j("#assignToSearch").val(name);
			reloadHomeByList();
		}
		else
		{
			$j("#assignToSearch").val(name);
			reloadHomeByList();
		}	
	}
</script>	


<div>
	<h3 class="reddot">
        <p>##_ITEMS_AJAX_TODO_##<div class="addtext"></div></p>
        <div class="clear"></div>
	</h3>
</div>
<div class="ajaxBox todoItems">
    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
    <div class="viewport" style=" <?php if(count($data)==1){?>height:128px !important;<?php } elseif(count($data)==2){?>height:160px !important;<?php } elseif(count($data)==3){?>height:204px !important;<?php } elseif(count($data) >  3){?> height:200px !important; <?php } else { ?>height:30px !important;<?php } ?>">
        <div class="overview">
            <ul class="hire-list items list-items">
                <li id="list_request">
                    <div class="title">
                        <b><span id="list_request_name">##_ITEMS_AJAX_MY_TODO_##</span></b>
                    </div>
                    <div class="itemListing">
                        <?php foreach($mytodoitems as $row) {  ?>
                            <label><a href="#txtSearchListDP"  onclick="searchByName('<?php echo $row['assignedByFname'] ." ". $row['assignedByLname'];?>','1')"><?php echo $row['assignedByFname'] ."". $row['assignedByLname'];?></a></label>
                            <span><?php echo "<b>".$row['total']."</b>"; ?></span>
                            <div class="clear"></div>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </li>
                <li id="list_request">
                    <div class="title">
                        <b><span id="list_request_name">##_ITEMS_AJAX_ASSIGNED_BY_##</span></b>
                    </div>
                    <div class="itemListing">
                        <?php foreach($assingByMeItems as $row) {  ?>
                            <label ><a href="#assignedByMeTodoItem" onclick="searchByName('<?php echo $row['assignedByFname'] ." ". $row['assignedByLname'];?>','2')"><?php echo $row['assignedByFname'] ."". $row['assignedByLname'];?></a></label>
                            <span><?php echo "<b>".$row['total']."</b>"; ?></span>
                            <div class="clear"></div>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </li>
                <li id="list_request">
                    <div class="title">
                        <b><span id="list_request_name">##_ITEMS_AJAX_OTHER_##</span></b>
                    </div>
                    <div class="itemListing" >
                        <?php foreach($othersTodoItems as $row) {  ?>
                            <label ><a href="#otherTodoItem" onclick="searchByName('<?php echo $row['assignedByFname'] ." ". $row['assignedByLname'];?>','3')"><?php echo $row['assignedByFname'] ."". $row['assignedByLname'];?></a></label>
                            <span><?php echo "<b>".$row['total']."</b>"; ?></span>
                            <div class="clear"></div>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </li>
                <?php if(count($mytodoitems) == 0 && count($othersTodoItems) == 0 && count($assingByMeItems) == 0){   ?>
                    <li class="no_request">
                        <div></div>
                    </li>
                <?php } ?>
                
            </ul>
        </div>
    </div>
</div>	
    
<?php 
if(isset($_GET['list']) && $_GET['list']!='')
{
?>
<script type="text/javascript">
$j(".listItem").removeClass('activeListItems');
$j("#list_request_"+<?php echo $_GET['list'];?>).addClass('activeListItems');
</script>
<?	} ?>



<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['currentSortType'].'&sortBy='.$ext['sortBy'].'&startdate='.$ext['startdate'].'&enddate='.$ext['enddate'].'&stat1='.$ext['stat1'].'&stat3='.$ext['stat3'].'&stat4='.$ext['stat4'];
?>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path;?>";
var $j = jQuery.noConflict();
$j(document).ready(function(){
	$j('.delete_this').click(function(){
		var id	=	$j(this).attr('lang');
		var total	=	document.getElementById("total_acc").value;
		current_page=1;
		if(confirm("Do you want to delete this record")){
			window.location=base_path+"admin/deleteUser/id/"+id+"/current_page/"+current_page+"/total/"+total;
		}
	});
	
	$j(function() {
		var dates = $j( "#startdate, #enddate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $j( this ).data( "datepicker" ),
					date = $j.datepicker.parseDate(
						instance.settings.dateFormat ||
						$j.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
});
function checkAll(){
	for (var i=0;i<document.forms[2].elements.length;i++)
	{
		var e=document.forms[2].elements[i];
		if ((e.name != 'checkboxAll') && (e.type=='checkbox'))
		{
			e.checked=document.forms[2].checkboxAll.checked;
		}
	}
}

function dSelectCheckAll()
{
	document.getElementById('checkboxAll').checked="";
}

function validateForm(){
	var checked	=	$j("input[name=checkbox[]]:checked").map(
    function () {return this.value;}).get().join(",");
	
	if(!checked){
		alert('Please select at least one record.');
		return false;
	}
	
	if(confirm("Do you want to delete this record")){
		return true;
	}
	return false;
}

function validateAll()
{
	var flag=0;
	
	return true;
	
}

function statusChange(stat,value)
{
	if(!$j('#close').attr('checked') && stat == 4) 
	{
		value = 0
		state = "&stat4";
	}
	if($j('#close').attr('checked') && stat == 4) 
	{
		state = "&stat4";
	}
	if(!$j('#done').attr('checked') && stat == 3)
	{
		value = 0;
		state = "&stat3"
	}
	if($j('#done').attr('checked') && stat == 3)
	{
		state = "&stat3";
	}
	if(!$j('#open').attr('checked') && stat == 1)
	{
		value = 0;state = "&stat1";
	}
	if($j('#open').attr('checked') && stat == 1)
	{
		state = "&stat1";
	}
	
	window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/items/"+state+"="+value;
}

function popitup(url) {
	newwindow=window.open(url,'name','height=400,width=780,scrollbars=yes,screenX=250,screenY=200,top=150');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<div align="center">
	<?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
</div>
<div class="clear"></div>
<div id="content">
	<div>
		<h1>TODO Items Listing</h1>
          <table width="100%" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<?php 
                    echo CHtml::beginForm(Yii::app()->params->base_path.'admin/items/','post',array('id' => 'searchForm','name' => 'searchForm')) ?>
                  <tr>
                  	<td colspan="5">
                    <input type="checkbox" name="open" id="open"  <?php if(isset($ext['stat1']) && $ext['stat1']==1){ ?> checked="checked" <?php } ?> value="1" onchange="statusChange(1,this.value);"/>
					Open
                    <input type="checkbox" name="done" id="done" <?php if(isset($ext['stat3']) && $ext['stat3']==3){ ?> checked="checked" <?php } ?> value="3" onchange="statusChange(3,this.value);"/>
                    Done  
                    <input type="checkbox" name="close" id="close" <?php if(isset($ext['stat4']) && $ext['stat4']==4){ ?> checked="checked" <?php } ?> value="4" onchange="statusChange(4,this.value);" />
                    Close 
                    </td>
                    
                  </tr>
                    <tr><td colspan="8" class="height10"></td></tr>
                    <tr>
                        <td width="8%" align="left">Search :</td>
                        <td width="20%" align="left">
                        	<input name="keyword" id="keyword" class="textbox2" type="text" value="<?php echo $ext['keyword'];?>"/>
                        </td>
                   		<td width="14%" align="right">Start Date :</td>
                      	<td width="14%">
                        	<input name="startdate" id="startdate" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/>
                        </td>
                        <td width="12%" align="right">End Date :</td>
						<td width="14%" align="left">
                        	<input name="enddate" width="20" id="enddate" class="textbox2 datebox" type="text" value="<?php if(isset($ext['enddate'])){echo $ext['enddate'];}?>"/>
                        </td>
                        <td width="9%" align="right">
                        	<input type="submit"  name="Search" value="Search"  class="btn" />
                        </td>
                        <td width="9%" align="right">
                        	<input type="button"  name="" value="Show All"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/items'"  class="btn"  />
                        </td>
                    </tr>
                    <?php echo CHtml::endForm();?>
                </table>
		<?php 
        echo CHtml::beginForm(Yii::app()->params->base_path.'admin/deleteRecord/type/All','post',array('id' => 'deleteRecordForm','name' => 'deleteRecordForm','onsubmit' => 'return validateForm();')) ?>
        <div id="employee">
            <div class="content-box">
                <table cellpadding="0" cellspacing="0" border="0" class="listing" width="960">
                	<tr>
                    	<th width="20">No</th>
                        <th width="10"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/title" class="sort">Title<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'title'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="10"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/description" class="sort">Description<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'description'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="30"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/assignedByFname" class="sort">Asigned By<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'assignedByFname'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="30"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/assignToFname" class="sort">Asigned To<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'assignToFname'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="30"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/dueDate" class="sort">Due Date<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'dueDate'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="30">Priority</th>
                        <th width="30">Status</th>
                        <th width="80" class="alignCenter"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/createdAt" class="sort">Created Date<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'createdAt'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                      	<th width="80"><a href="<?php echo Yii::app()->params->base_path;?>admin/items/sortType/<?php echo $ext['sortType'];?>/sortBy/modifiedAt" class="sort">Modified Date<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'modifiedAt'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                    </tr>
                    
                    <?php
                    $i=1;
					$cnt = $data['pagination']->itemCount;
					if($cnt>0){
						foreach($data['items'] as $row){ ?>
                            <tr>
                                <td align="center">
                                    <?php 
                                    echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
                                    ?>
                                </td>
                                <td><?php echo $row['title'];?></td>
                                <td align="center">
									<?php echo $row['description'];	?>
                                </td>
								<td><?php echo $row['assignedByFname'] .' '. $row['assignedByLname']; ?></td>
                                <td><?php echo $row['assignToFname'] .' '. $row['assignToLname']; ?></td>
                                <td><?php echo $row['dueDate'];?></td>
                                <td><?php 
									if($row['priority'] == 0){
										echo 'Low';
									} else if($row['priority'] == 1) {
										echo 'Medium';
									} else if($row['priority'] == 2) {
										echo 'High';
									} else {
										echo 'Urgent';
									}
									?>
                                </td>
                                <td>
                                <?php
									if($row['status'] == 1) {
										echo 'open';
									} else if($row['status'] == 2) {
										echo 'QA';
										$class	=	'';
										$value	=	'QA';
									} else if($row['status'] == 3) {
										echo 'done';
									} else {
										echo 'close';
									}
									?>
                                </td>
                                <td align="center"><?php echo $row['createdAt'];?></td>
                                <td align="center"><?php echo $row['modifiedAt'];?></td>
                            </tr>
                            <?php
                            $i++;
						}
					}else{?>
                    <tr>
                    	<td colspan="10">No Record Found</td>
                    </tr>
                    <?php
					}?>
                    <input type="hidden" name="total_acc" id="total_acc" value="<?php echo $i;?>" />
                </table>
            </div>
            <div>
                <div class="floatLeft">
                    <?php
					if($cnt == '1'){?>
                    	&nbsp;
                    <?php 
					}else{?>
                        <!--<span>
                       	 <input type="submit" name="delete_record" id="delete_record" value="Delete" class="btn"/>
                        </span>-->
                    <?php
					}?>
                </div>
                <div>
                	 <?php 
					 if($cnt > 0 && $data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
                    	 <div class="pagination">
                         <?php 
						 $this->widget('application.extensions.WebPager',
										 array('cssFile'=>Yii::app()->params->base_url.'css/style.css',
												'extraPara'=>$extraPaginationPara,
												'pages' => $data['pagination'],
												'id'=>'link_pager',
						));
					 ?>	
                     </div>
					 <?php  
					 }?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
  	<?php echo CHtml::endForm();?>
</div>
</div>
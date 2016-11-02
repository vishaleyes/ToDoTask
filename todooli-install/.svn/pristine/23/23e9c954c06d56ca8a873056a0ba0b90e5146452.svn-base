<?php echo $header; ?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
$j(document).ready(function(){	
	$j('.navigation_pagination').click(function() {
		$arr = $j(this).attr("lang").split("*");
		$j('#maincontainer').load($arr[0],function(response){	
			if(response == 'logout')
			{
				$j('#maincontainer').html('');
				window.location.href = "<?php echo Yii::app()->params->base_path; ?>seeker";
			}
		 });
	});
});
</script>

<div class="RightSide">
	<h1>##_ITEMS_MY_TODO_##</h1>
	<table cellpadding="0" cellspacing="0" border="0" class="account-manager-table">
  		<tr>
    		<th width="150">
            	<a href="javascript:;" class="navigation_pagination" lang="<?php echo Yii::app()->params->base_path; ?>seeker/recentHireRequest/flag/1/orderBy/<?php echo $orderBy; ?>/orderById/occupation">##_ITEMS_PROJECT_NAME_##
    <?php if($sort_name == 'occupation') { ?>  <img src="<?php echo Yii::app()->params->base_url; ?>images/<?php echo $img_name; ?>" /><?php } ?></a>
   			</th>
            <th width="160">##_ITEMS_TITLE_##</th>
            <th width="160">##_ITEMS_DESC_##</th>
            <th width="160">##_ITEMS_ASSIGN_BY_##</th>
            <th width="100"><a href="javascript:;" class="navigation_pagination" lang="<?php echo Yii::app()->params->base_path; ?>seeker/recentHireRequest/flag/1/orderBy/<?php echo $orderBy; ?>/orderById/created">##_ITEMS_DUE_DATE_##
            <?php if($sort_name == 'created') { ?> <img src="<?php echo Yii::app()->params->base_url; ?>images/<?php echo $img_name; ?>" /><?php } ?></a></th>
            <th width="100">##_ITEMS_STATUS_##</th>
            <th width="90" class="lastcolumn">##_ITEMS_PRIORITY_##</th>
		</tr>
		
        <?php if(count($data) > 0) {?>
        
		<?php for($i=0;$i<count($data);$i++){ ?>
        <tr>
        	
            <td style="text-align:center;"><?php echo $data[$i]['listName']; ?></td>
            <td style="text-align:center;"><?php echo $data[$i]['title']; ?></td>
            <td style="text-align:center;"><?php echo $data[$i]['description']; ?></td>
        	<td style="text-align:center;"><?php echo $data[$i]['assignedByFname'] . $data[$i]['assignedByLname']; ?></td>
            <td style="text-align:center;"><?php echo $data[$i]['dueDate']; ?></td>
            <td style="text-align:center;">
            <?php
            if($data[$i]['status']==1){
				echo 'Open';
			} else if($data[$i]['status']==2) {
				echo 'QA';
			}
			 else if($data[$i]['status']==3) {
				echo 'Done';
			
			} else if($data[$i]['status']==4) {
				echo 'Close';
			}
			?>
            </td>
            <td style="text-align:center;"><?php echo $data[$i]['priority']; ?></td>
            <?php  } ?>
        </tr>
      	<?php } else { ?>
      	<tr>
            <td colspan="5" class="lastrow alignCenter lastcolumn">
               ##_ITEMS_NO_ITEM_##
            </td>
       	</tr> 
        <?php } ?>
    </table>
    <?php
    if($data!= '' && $pagination->getItemCount() > $pagination->getLImit()) {?>
        <div class="pagination" >
        <?php
        $this->widget('application.extensions.WebPager',
             array('cssFile'=>true,
                    'pages' => $pagination,
                    'id'=>'link_pager',
        ));
        ?>
        </div>
    <?php
	}?>
<script type="text/javascript">
$j(document).ready(function(){
        $j('#link_pager a').each(function(){
                        $j(this).click(function(ev){
                                ev.preventDefault();
                                $j.get(this.href,{ajax:true},function(html){
                                                $j('#maincontainer').html(html);
                                        });
                               });
                });
        });
</script>
</div>
<span class="navigation_readmore">
	<a href="#" id="reloadLink" onclick="setLink('<?php echo Yii::app()->params->base_path; ?>seeker/recentHireRequest')" lang="" ></a>
    <a id="deleteRefresh" lang="<?php echo Yii::app()->params->base_path; ?>seeker/recentHireRequest/flag/1/desc/id/" href="javascript:;" class="navNum navigation_pagination"></a>
</span>

<script type="text/javascript">
$j(document).ready(function(){
	
	$j('.likeIcon').click(function(){
		$j("#intrestId").val($j(this).attr('lang'));
		});
			
	$j('#deleteRefresh').attr('lang',"<?php echo Yii::app()->params->base_path; ?>seeker/recentHireRequest/flag/1/desc/id/");
});
</script>
<?php echo $footer; ?>
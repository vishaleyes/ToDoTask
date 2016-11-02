<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path;?>";
$j(document).ready(function(){
	$j('.delete_this').click(function(){
		var id= $j(this).attr('lang');
		if(confirm("Do you want to delete this record"))
		{
			window.location=base_path+"admin/deleteApiModule/id/"+id;
		}
		else
		{
			window.location=base_path+"admin/apiModules";
		}
	})
})

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
      	<h1>Module Listing</h1>  
		<div>
        <?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/searchSeekers/find_seekers','post',array('id' => 'events','name' => 'events','enctype' => 'multipart/form-data','onsubmit' => 'return validateAll();')) ?>
				<table width="100%" border="0" class="search-table" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right"><input type="button" name="" value="Add Modules"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addApiModule'"  class="btn" /></td>
					</tr>
				</table>
        <?php echo CHtml::endForm();?>
			   </div>   
         <div id="employee">
         <div class="content-box">
                  <table cellpadding="0" cellspacing="0" border="0" class="listing" width="100%">
                    <tr>
                    	  <th width="5%">No</th>
                          <th>Modules </th>  
                          <th width="20%" class="alignCenter">Functions</th>
             			  <th width="5%" class="alignCenter">Edit</th>
                          <th width="8%" class="alignCenter">Delete</th>
                    </tr>
					<?php 
					if(count($moduleList) > 0)
					{
						$i=1;
						foreach($moduleList as $moduleList){ ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $moduleList['label'];?></td> 
                                <td align="center">
                                    <a href="<?php echo Yii::app()->params->base_path;?>admin/apiFunctions/module/<?php echo $moduleList['id'];?>" title="View <?php echo $moduleList['label'];?> Functions">
	                                    <img src="<?php echo Yii::app()->params->base_url;?>images/login_key.png"/>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="<?php echo Yii::app()->params->base_path;?>admin/addApiModule/id/<?php echo $moduleList['id'];?>" title="Edit <?php echo $moduleList['label'];?>" >
                                        <img src="<?php echo Yii::app()->params->base_url;?>images/edit-icon.png"/>
                                    </a>
                                </td>
                                <td align="center">
									<center>
                                 		<a href="javascript:;" lang="<?php echo $moduleList['id'];?>" class="delete_this" title="Delete <?php echo $moduleList['label'];?>"> 
                                        	<img src="<?php echo Yii::app()->params->base_url;?>images/false.png" alt="Delete"/>
                                    	</a>
									</center>                                     
                                </td>                                 
                            </tr>
						<?php
                    	$i++;
						}
					}else{?>    
						<tr>
							<td colspan="100%">No Record Found</td>
						</tr>
					<?php
                    }?>    
                    </table>
                   </div>
				 </div>
	</div>
</div>
<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path;?>";
$j(document).ready(function(){
	$j('.delete_this').click(function(){
		var id= $j(this).attr('lang');
		var fn_id= <?php echo $fun_ref_id;?>;
		if(confirm("Do you want to delete this record"))
		{
			window.location=base_path+"admin/deleteFunctionParameter/fn_id/"+fn_id+"/id/"+id;
		}
		
	})
})

function validateAll()
{
	var flag=0;
	
	return true;
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
    <h1>
    <a href="<?php echo Yii::app()->params->base_path;?>admin/apiFunctions">Functions</a> 
    <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> Parametes
    </h1>
    <div>
    	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/searchSeekers/find_seekers','post',array('id' => 'events','name' => 'events','enctype' => 'multipart/form-data')) ?>
            <table width="100%" border="0" class="search-table" cellpadding="5" cellspacing="5">
                <tr>
                    <td>
					    <div align="right">
					        <input type="button" name="" value="Add Parameter"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addFunctionParameter/fn_id/<?php echo $fun_ref_id;?>'"  class="btn" />
						</div>	
					</td>
                </tr>
        	</table>
		<?php echo CHtml::endForm();?>
    </div>
    <div id="employee">
        <div class="content-box">
            <table cellpadding="0" cellspacing="0" border="0" class="listing" width="100%">
                <tr>
                    <th width="6%" class="alignCenter">No</th>
                    <th width="78%">Parametes</th>
                    <th width="8%" class="alignCenter">Edit</th>
                    <th width="8%" class="alignCenter">Delete</th>
                </tr>
                <?php 				
				if(count($paramList) > 0){
					$i=1;
					foreach($paramList as $paramList){ ?>
                        <tr>
                            <td align="center">
								<?php 
                                echo $i+($pagination->getCurrentPage()*$pagination->getLimit());
                                ?>
                            </td>
                            <td><?php echo $paramList['fnParamName'];?></td>
                            <td align="center">
                                <a href="<?php echo Yii::app()->params->base_path;?>admin/addFunctionParameter/fn_id/<?php echo $fun_ref_id;?>/id/<?php echo $paramList['id'];?>" title="Edit Function" >
                                <img src="<?php echo Yii::app()->params->base_url;?>images/edit-icon.png"/>
                                </a>
                            </td>
                            <td align="center">
                                <center>
                                    <a href="javascript:;" lang="<?php echo $paramList['id'];?>"  class="delete_this" title="Delete Seeker"> 
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
            <?php
			if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
                <div class="pagination" style="margin:10px auto;">
                <?php 
                $this->widget('application.extensions.WebPager',
                         array('cssFile'=>Yii::app()->params->base_url.'css/style.css',
                                'pages' => $pagination,
                                'id'=>'link_pager',
                ));
                ?>
                </div>
            <?php
			}?>
    </div>
</div>
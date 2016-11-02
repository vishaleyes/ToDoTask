<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path;?>";
$j(document).ready(function(){
	$j('.delete_this').click(function(){
		var id= $j(this).attr('lang');
		if(confirm("Do you want to delete this record"))
		{
			window.location=base_path+"admin/deleteApiFunction/id/"+id;
		}
	})
})

function approveFunction(obj)
{
	var statusValue='0'; 
	if($j(obj).attr('checked'))
	{
		statusValue='1';
	}
	
	$j.ajax({
		type: "POST",
		url: base_path+"admin/approvalApiFunction",
		data: "statusName="+$j(obj).attr('name')+"&statusValue="+statusValue+"&id="+$j(obj).attr('lang')+"&"+csrfToken,
		cache: false,
		success: function(data)
		{
			if(statusValue=='1')
			{
				alert("Approved successfully");
			}
			else
			{
				alert("Disapproved successfully");	
			}
		}
	});		
}

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
    	<a href="<?php echo Yii::app()->params->base_path;?>admin/apiModules">Module</a> 
        <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />
         Function Listing
    </h1>
    <div>
    	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/apiFunctions/','post',array('id' => 'events','name' => 'events','enctype' => 'multipart/form-data','onsubmit' => 'return validateAll();')) ?>
            <table width="100%" border="0" class="search-table" cellpadding="0" cellspacing="0">
                <tr>
	                <td width="8%" align="left">Search :</td>
                    <td width="28%" align="left">
                    	<input name="findname" id="findname" class="textbox2" type="text" value="<?php echo Yii::app()->session['findname']; ?>"/>
                    </td>
                    <td width="9%" align="left">
                    	<input type="submit"  name="Search" value="Search"  class="btn" />
                    </td>
                    <td width="55%" align="left">
                    	<input type="button" name="" value="Show All"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/apiFunctions/'"  class="btn" />
                    </td>
                    <td align="right">
                    	<input type="button" name="" value="Add Function"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addApiFunction'"  class="btn" />
                    </td>
                </tr>
            </table>
        <?php echo CHtml::endForm();?>
    </div>
    <div id="employee">
        <div class="content-box">
            <table cellpadding="0" cellspacing="0" border="0" class="listing api" width="100%">
                <tr>
                    <th>No</th>
                    <th>Function</th>
                    <th align="left">Module</th>
                    <th align="left">Approved By</th>
                    <th class="alignCenter">Parameters</th>
                    <th align="left">Resources</th>
                    <th class="alignCenter">Edit</th>
                    <th class="alignCenter">Delete</th>
                </tr>
                <?php 
					if(count($functionList) > 0)
					{
						$i=1;
						foreach($functionList as $functionList){ ?>
                            <tr>
                                <td align="center">
                                    <?php 
									echo $i+($pagination->getCurrentPage()*$pagination->getLimit());
									?>
                                </td>
                                <td><?php echo $functionList['function_name'];?></td>
                                <td align="center"><?php echo $functionList['moduleLabel'];?></td>
                                <td align="left">
                                	<input type="checkbox" <?php if(isset($functionList['uiTeamApproval']) && $functionList['uiTeamApproval']==1){ ?>  checked="checked" <?php } ?> name="uiTeamApproval" lang="<?php echo $functionList['id'];?>" onchange="approveFunction(this)" />
                                    UI Team<br />
                                    <input type="checkbox" <?php if(isset($functionList['backendTeamApproval']) && $functionList['backendTeamApproval']==1){ ?> checked="checked" <?php } ?> name="backendTeamApproval" lang="<?php echo $functionList['id'];?>" onchange="approveFunction(this)" />
                                    Backend Team<br />
                                    <input type="checkbox" <?php if(isset($functionList['overallApproval']) && $functionList['overallApproval']==1){ ?> checked="checked" <?php } ?>  name="overallApproval" lang="<?php echo $functionList['id'];?>" onchange="approveFunction(this)" />
                                    overall<br />
								</td>
                                <td align="center">
                                    <a href="<?php echo Yii::app()->params->base_path;?>admin/functionParametes/fn_id/<?php echo $functionList['id'];?>" title="View Parametes">
                                    	<img src="<?php echo Yii::app()->params->base_url;?>images/login_key.png"/>
                                    </a>
                                </td>
                                <td align="left">
                                    <div class="resources">
                                        <table cellpadding="0" cellspacing="0" border="0" class="inner-listing">
                                            <tr>
                                                <td>
                                                	<div class="resources-url"><b>URL</b>:<?php if(isset($functionList['resource_url'])){ echo $functionList['resource_url']; }?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<b>Res. Formats</b>:<?php if(isset($functionList['response_formats'])){ echo $functionList['response_formats']; }?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<b>Http Methods</b>:<?php if(isset($functionList['http_methods'])){ echo $functionList['http_methods']; }?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo Yii::app()->params->base_path;?>admin/apiResource/fn_id/<?php echo $functionList['id'];?>" title="Edit Resources"> 
                                                        <img src="<?php echo Yii::app()->params->base_url;?>images/login_key.png"/> 
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td align="center">
                                    <a href="<?php echo Yii::app()->params->base_path;?>admin/addApiFunction/id/<?php echo $functionList['id'];?>" title="Edit Function" >
                                        <img src="<?php echo Yii::app()->params->base_url;?>images/edit-icon.png"/>
                                    </a>
                                </td>
                                <td align="center">
                                	<center>
                                        <a href="javascript:;" lang="<?php echo $functionList['id'];?>" class="delete_this" title="Delete Seeker"> 
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
		if($pagination->getItemCount() > $pagination->getLimit()){?>
        <div class="pagination" style="margin:0 auto;">
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
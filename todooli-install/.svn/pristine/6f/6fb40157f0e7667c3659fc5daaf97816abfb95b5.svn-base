<div class="middle-section">
    <div id="content-outer">
        <div class="wrapper">
            <div class="api">
                
                <!-- Path Navigation -->
                
                <div id="breadcrumbs">
                    <div class="breadcrumb">
                        <a href="<?php echo Yii::app()->params->base_path; ?>apidoc">Home</a> &rarr; <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/api">API</a> &rarr; Method	
                    </div> 
                </div>
                
                <!-- Container -->
                
                <div class="api-container">
                    
                    <!-- Content Part -->
                    
                    <div class="api-content">
                        <h1 id="title"><?php if(isset($resource['http_methods']) && $resource['http_methods']==0) {?> GET <?php }elseif($resource['http_methods'] == 1){ ?> POST <?php }else{ ?> REQUEST <?php } echo $function['function_name']?> </h1>
                        <div id="content-inner">
                            <div id="content-main">
                                
                                <!-- Resource URL -->
                                
                                <div id="panel-top">
                                    <p>
                                        <i>Updated on , <?php if(isset($function['modifiedAt']) && $function['modifiedAt']!='0000-00-00 00:00:00') { echo $function['modifiedAt']; }else{ echo $function['createdAt']; }?></i>
                                        <?php echo $function['fn_description'];?>
                                    </p>
                                    <h2>Resource URL</h2>
                                    <p><?php echo $resource['resource_url'];?></p>
                                </div>                
                                
                                <!-- Parameters -->
                                
                                <div>
                                    <h2>Parameters</h2>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="api-list">
                                        <?php 
										foreach($parameters as $parameters)
										{
										?>
                                            <tr>
                                                <td class="first" valign="top">
                                                    <p><b><?php echo $parameters['fnParamName'];?></b></p>
                                                    <p><?php if(isset($parameters['ParamType']) && $parameters['ParamType']==0){?> Optional <?php }else{ ?> Required <?php }?></p>
                                                </td>
                                                <td class="second" valign="top">
                                                    <?php echo $parameters['fnParamDescription'];?>
                                                    <p><b>Example Values</b> : <?php echo $parameters['example'];?></p>
                                                    <p><b>UI Validation Rules</b> : <?php echo $parameters['uiValidationRule'];?></p>
                                                </td>
                                             </tr>
                                        <?php } ?>                   
                                    </table> 
                                </div>
                                
                                <!-- Example -->
                                
                                <div>
                                    <h2>Example</h2>
                                    <div><?php echo $resource['example'];?></div>
                                </div>
                                
                                <!-- Response -->
                                
                                <div>
                                    <h2>Response</h2>    
                                    <div class="response"><?php echo $resource['response'];?></div> 
                                </div>
                                
                                <!-- Error Codes -->
                                
                                <div>
                                    <h2>Error Codes</h2>    
                                    <div>All error codes are at <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/error_codes/method/<?php echo $method;?>"><b>Error Codes</b></a></div> 
                                </div>
                                
                                <!-- Fields Values -->
                                
                                <div>
                                    <h2>Fields Values</h2>    
                                    <div>All field values are at <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/field_values/method/<?php echo $method;?>"><b>Field Values</b></a></div> 
                                </div>
                                       
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    
                    <div class="api-sidebar">
                        
                        <!-- Resource Information -->
                        
                        <div class="api-sidebar-box">
                            <h2>Resource Information</h2>
                            <ul>
                                <li><label>Rate Limited?</label><span><a href="#"><?php if($resource['limited']==1){?> Yes <?php } else {?> No <?php }?></a></span><div class="clear"></div></li>
                                <li><label>Requires Authentication?</label><span><a href="#"><?php if($resource['authentication']==1){?>  Yes <?php } else {?> No <?php }?></a></span><div class="clear"></div></li>
                                <li><label>Response Formats</label><span><?php if($resource['response_formats']==1){?> XML <?php } elseif($resource['response_formats']==2){?> JSON <?php } else {?> XML, JSON <?php }?></span><div class="clear"></div></li>
                                <li><label>HTTP Methods</label><span><?php if($resource['http_methods']==0){?> GET <?php } elseif($resource['http_methods']==1){?> POST <?php } else {?> REQUEST <?php }?></span><div class="clear"></div></li>
                            </ul>
                        </div>
                        
                        <!-- Function Approval By -->
                        
                        
                        <div class="api-sidebar-box">                
                            <h2>Function Approval By</h2>
                            <ul>
                                <li><label>UI Team</label><span><a href="#"><?php if($function['uiTeamApproval']==1){?> Yes <?php } else {?> No <?php }?></a></span><div class="clear"></div></li>
                                <li><label>Backend Team</label><span><a href="#"><?php if($function['backendTeamApproval']==1){?> Yes <?php } else {?> No <?php }?></a></span><div class="clear"></div></li>
                                <li><label>Overall</label><span><a href="#"><?php if($function['overallApproval']==1){?> Yes <?php } else {?> No <?php }?></a></span><div class="clear"></div></li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
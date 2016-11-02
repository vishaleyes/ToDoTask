<div class="middle-section">
    <div id="content-outer">
        <div class="wrapper">
        	<div class="api">
                
                <!-- Path Navigation -->

                <div id="breadcrumbs">
                    <div class="breadcrumb">
                        <a href="<?php echo Yii::app()->params->base_path; ?>apidoc">Home</a> &rarr; API
                    </div>
                </div>

                <!-- Container -->

                <div class="api-container">
                    <h1 id="title">REST API RESOURCES</h1>
                    <div id="content-inner">
                    <?php 
					foreach($modules as $modules)
					{
					?>
                        <div id="content-main">
                            <div id="panel-top">
                               <h2><?php echo $modules['label']?></h2>
                               <b><p><?php echo $modules['description']?></p></b>
                            </div>	
                            
                            <div>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="api-list">
                                   <tr>
                                        <td width="25%"><b>Resource</b></td>
                                        <td><b>Description</b></td>
                                   </tr>
                                    <?php 
									foreach($modules['function'] as $funcctions)
									{
									?>
                                    <tr>
                                        <td class="func-name"><a href="<?php echo Yii::app()->params->base_path; ?>apidoc/method/id/<?php echo $funcctions['id']?>"><?php echo $funcctions['function_name']?></a></td>
                                        <td><p><?php echo $funcctions['fn_description']?></p></td>
                                    </tr>
                                    <?php } ?>                   
                                </table>		 
                            </div>
                            
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

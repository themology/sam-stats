<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 
 <div class="sam-settings">
        <div class="sam-dashboard"> 

			<div class="dash-cg">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">SAM STATS</span></div></center>
                <center><div class="dash-box-info"><a href="admin.php?page=sam_settings" class="myButton"><i class="fa fa-tachometer fa-2x"></i></br>DASHBOARD</a><a href="admin.php?page=sam_admin_visitors" class="myButton"><i class="fa fa-users fa-2x"></i></br>ALL VISITORS</a><a href="admin.php?page=sam_admin_online" class="myButton"><i class="fa fa-user-secret fa-2x"></i></br>ONLINE USERS</a><a href="admin.php?page=sam_admin_filter" class="myButton"><i class="fa fa-filter fa-2x"></i></br>FILTER STATS</a><a href="admin.php?page=sam_dashboard" class="myButton"><i class="fa fa-cog fa-2x"></i></br>SETTINGS</a><a href="http://themology.net/forum" target="_blank" class="myButton"><i class="fa fa-question-circle fa-2x"></i></br>HELP & SUPPORT</a>
				</div></center>
			</div>
			</div>

<?php

	if(empty($_POST['sam_hidden']))
		{
			$sam_refresh_time = get_option( 'sam_refresh_time' );	
			$sam_delete_data = get_option( 'sam_delete_data' );	
						
					
		}

	else
		{
		
		if($_POST['sam_hidden'] == 'Y')
			{
			
			
			$sam_delete_data = $_POST['sam_delete_data'];
			update_option('sam_delete_data', $sam_delete_data);			

			$sam_refresh_time = $_POST['sam_refresh_time'];
			update_option('sam_refresh_time', $sam_refresh_time);	

			
			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p>
            </div>
 
<?php
			}
		} 
?>

 
 
 
 
 
 
 
<div class="wrap">

<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="sam_hidden" value="Y">
        <?php settings_fields( 'sam_options' );
				do_settings_sections( 'sam_options' );
		?>



    <div class="sam-settings"> 

		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">

<center><h3>Basic Settings</h3></center>	
            
				<div class="option-box">
                    <p class="option-title">Refresh visitors statistics data every              
                    <input type="text" name="sam_refresh_time" value="<?php  if(!empty($sam_refresh_time)) echo $sam_refresh_time; else  echo '5000'; ?>" /> millisecond's.</p>
<p class="option-info">(minimum: 3000)</p>
                    
                </div>

				<div class="option-box">
                    <p class="option-title">

					<label ><input type="radio" name="sam_delete_data"  value="yes" <?php  if($sam_delete_data=='yes') echo "checked"; ?>/><span title="yes" class="sam_delete_data_yes <?php  if($sam_delete_data=='yes') echo "selected"; ?>">Delete</span> or </label>
          
 					<label ><input type="radio" name="sam_delete_data"  value="no" <?php  if($sam_delete_data=='no') echo "checked"; ?>/><span title="no" class="sam_delete_data_no <?php  if($sam_delete_data=='no') echo "selected"; ?>">Do not delete</span> all statistics data from database when I deactivate the plugin.</label>
</p>
                     <p class="option-info">(Recommend)</p>                   
                </div>
<center><h3>Advanced Settings</h3></center>
		
				<div class="option-box">
                    <p class="option-title">My Smart Stats tracking code:              
                    <input type="password" name="" value="<?php  echo '52Xh34H43L8ds7sdss'; ?>" /></p>
<p class="option-info"><i class="fa fa-info-circle fa-lg"></i> (Don't change this unless you know what you are doing)</p>
                    
                </div>
				
				<div class="option-box">
                    <p class="option-title">Unique User ID <input type="text" name="" value="<?php  echo 'H7QG9-K2O55-L16T2-FF1Y'; ?>" /> that's implement into database.</p>
<p class="option-info">(Automatically generated)</p>
                    
                </div>







            
            
            </li>

            
		</ul>
	</div>  
	
    <p class="submit">
    	<center><input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Sam Stats Settings' ) ?>" /></center>
	</p>


</form>

</div>
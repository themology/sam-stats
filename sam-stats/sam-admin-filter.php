<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 
        <div class="sam-settings">
        <div class="sam-dashboard"> 

			<div class="dash-cg">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">SAM STATS</span></div></center>
                <center><div class="dash-box-info"><a href="admin.php?page=sam_settings" class="myButton"><i class="fa fa-tachometer fa-2x"></i></br>DASHBOARD</a><a href="admin.php?page=sam_admin_visitors" class="myButton"><i class="fa fa-users fa-2x"></i></br>ALL VISITORS</a><a href="admin.php?page=sam_admin_online" class="myButton"><i class="fa fa-user-secret fa-2x"></i></br>ONLINE USERS</a><a href="admin.php?page=sam_admin_filter" class="myButton"><i class="fa fa-filter fa-2x"></i></br>FILTER STATS</a><a href="admin.php?page=sam_dashboard" class="myButton"><i class="fa fa-cog fa-2x"></i></br>SETTINGS</a><a href="http://themology.net/forum" target="_blank" class="myButton"><i class="fa fa-question-circle fa-2x"></i></br>HELP & SUPPORT</a>
				</div></center>
			</div>
			</div>

<div class="wrap">
    <div class="sam-settings">
<center>
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
            	<div class="sam-fliters">
                	<div class="filter-tools">
                    Filter for
                    	<select name="filter_for" class="filter-for">
                        	<option value="url_id">URL</option>                        
                        	<option value="userid">Users</option>
                        	<option value="platform">Operating System</option>
                        	<option value="browser">Browser Type</option>
                        	<option value="screensize">Screensize</option>
                            <option value="referer_doamin">Referer Domain</option>                     
                        	<option value="referer_url">Referer URL</option>
                         	<option value="city">City</option>                           
                         	<option value="countryName">Country</option>
                         	<option value="url_term">Link Type</option>                            
                                                        
                        </select> and show Top  
                        <input type="text" size="3" class="max-items" name="max_items" value="10" /> items between date <input type="text" size="10" class="first-date" name="first_date" value="<?php echo date("Y-m-d");?>" /> and <input type="text" size="10" class="second-date" name="second_date" value="<?php echo date("Y-m-d");?>" />
                        
                        <br />
                        <input class="filter-submit button" type="submit" value="Submit" /> 
                        <script>
						jQuery(document).ready(function($) {
							$('.first-date, .second-date').datepicker({
								dateFormat : 'yy-mm-dd'
							});
						});
						</script>
                    </div>
                    <div class="filter-result">
                    
                    </div>
                
                </div>
            
            
            </li>         
        </ul>
 </center>       
        
        
        
        
        
</div>

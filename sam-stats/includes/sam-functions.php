<?php

if ( ! defined('ABSPATH')) exit;

function sam_dashboard_widget( $post, $callback_args ) {
	
	
	$sam_refresh_time = get_option( 'sam_refresh_time' );	
	
	if(!empty($sam_refresh_time))
		{
			if($sam_refresh_time < 3000)
				{
					$sam_refresh_time = '3000';
				}
			else
				{
				$sam_refresh_time = $sam_refresh_time;
				}
			
		}
	else
		{
			$sam_refresh_time = '3000';
		}
	
	
	?>
	<p>Online visitors:</p>
	<p class="total-online" style="text-align:center; font-size:30px;">0</p>
    
	<script>		
        jQuery(document).ready(function($)
            {
    
                setInterval(function(){
                    $.ajax(
                            {
                        type: 'POST',
                        url: sam_ajax.sam_ajaxurl,
                        data: {"action": "sam_ajax_online_total"},
                        success: function(data)
                                {
                                    $(".total-online").html(data);
                                }
                            });	
                }, <?php echo $sam_refresh_time; ?>)
                        });
                
    </script> 
<p align="right">Last time updated: <?php echo sam_get_datetime(); ?></p>
    <?php
	
	
	
}

function sam_add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'Sam Stats - Total Online Visitors', 'sam_dashboard_widget');
}


add_action('wp_dashboard_setup', 'sam_add_dashboard_widgets' );






function sam_UniquePageView($isunique) 
	{	
		global $wpdb;
		$table = $wpdb->prefix . "sam";
		$result = $wpdb->get_results("SELECT $isunique FROM $table WHERE isunique='yes'", ARRAY_A);
		$total_rows = $wpdb->num_rows;
		
		return $total_rows;
	}






function sam_UniqueVisitor($ip) 
	{	
		global $wpdb;
		$table = $wpdb->prefix . "sam";
		$result = $wpdb->get_results("SELECT $ip FROM $table GROUP BY $ip ORDER BY COUNT($ip) DESC", ARRAY_A);
		$total_rows = $wpdb->num_rows;
		
		return $total_rows;
	}
	
	
	
	
	





function sam_TotalSession($session_id) 
	{	
		global $wpdb;
		$table = $wpdb->prefix . "sam";
		$result = $wpdb->get_results("SELECT $session_id FROM $table GROUP BY $session_id ORDER BY COUNT($session_id) DESC", ARRAY_A);
		$total_rows = $wpdb->num_rows;
		
		return $total_rows;
	}





function sam_login($user_login, $user)
	{
	$sam_date = sam_get_date();
	$sam_time = sam_get_time();
	$sam_datetime = sam_get_datetime();	
	$sam_endtime = $sam_datetime;
	
	$browser = new Browser_sam();
	$platform = $browser->getPlatform();
	$browser = $browser->getBrowser();
	
	$ip = $_SERVER['REMOTE_ADDR'];
	
	
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$city = $geoplugin->city;
	$region = $geoplugin->region;
	$countryName = $geoplugin->countryCode;

	$referer = sam_get_referer();
	$referer = explode(',',$referer);
	$referer_doamin = $referer['0'];
	$referer_url = $referer['1'];

	$screensize = sam_get_screensize();


	$userid = get_userdatabylogin($user_login );
	$userid = $userid->ID;

	$url_id_array = sam_geturl_id();
	$url_id_array = explode(',',$url_id_array);
	$url_id = $url_id_array['0'];
	$url_term = $url_id_array['1'];

	$event = "login";

	$isunique = sam_get_unique();
	$landing = '0';
	$sam_session_id = sam_session();
	
	
	global $wpdb;
	$table = $wpdb->prefix . "sam";
		
	$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, sam_date, sam_time, sam_endtime, userid, event, browser, platform, ip, city, region, countryName, url_id, url_term, referer_doamin, referer_url, screensize, isunique, landing )
			VALUES	( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
						array	( '', $sam_session_id, $sam_date, $sam_time, $sam_endtime, $userid, $event, $browser, $platform, $ip, $city, $region, $countryName, $url_id, $url_term, $referer_doamin, $referer_url, $screensize, $isunique, $landing )
								));
		
		


$table = $wpdb->prefix . "sam_online";	
$result = $wpdb->get_results("SELECT * FROM $table WHERE session_id='$sam_session_id'", ARRAY_A);
$count = $wpdb->num_rows;


 

	if($count==NULL)
		{
	$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, sam_time, userid, url_id, url_term, city, region, countryName, browser, platform, referer_doamin, referer_url) VALUES	(%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							array( '', $sam_session_id, $sam_datetime, $userid, $url_id, $url_term, $city, $region, $countryName, $browser, $platform, $referer_doamin, $referer_url)
								));
		}
	else
		{
			$wpdb->query("UPDATE $table SET sam_time='$sam_datetime', url_id='$url_id', referer_doamin='$referer_doamin', referer_url='$referer_url' WHERE session_id='$sam_session_id'");
		}
			
	}

function sam_logout()
	{
	$sam_date = sam_get_date();
	$sam_time = sam_get_time();
	$sam_datetime = sam_get_datetime();	
	$sam_endtime = $sam_datetime;
	
	$browser = new Browser_sam();
	$platform = $browser->getPlatform();
	$browser = $browser->getBrowser();
	
	$ip = $_SERVER['REMOTE_ADDR'];
	
	
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$city = $geoplugin->city;
	$region = $geoplugin->region;
	$countryName = $geoplugin->countryCode;

	$referer = sam_get_referer();
	$referer = explode(',',$referer);
	$referer_doamin = $referer['0'];
	$referer_url = $referer['1'];

	$screensize = sam_get_screensize();

	$userid = sam_getuser();

	$url_id_array = sam_geturl_id();
	$url_id_array = explode(',',$url_id_array);
	$url_id = $url_id_array['0'];
	$url_term = $url_id_array['1'];

	$event = "logout";

	$isunique = 'no';
	$landing = '0'; 
	$sam_session_id = sam_session();
	
	
	global $wpdb;
	$table = $wpdb->prefix . "sam";
		
	$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, sam_date, sam_time, sam_endtime, userid, event, browser, platform, ip, city, region, countryName, url_id, url_term, referer_doamin, referer_url, screensize, isunique, landing )
			VALUES	( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
						array	( '', $sam_session_id, $sam_date, $sam_time, $sam_endtime, $userid, $event, $browser, $platform, $ip, $city, $region, $countryName, $url_id, $url_term, $referer_doamin, $referer_url, $screensize, $isunique, $landing )
								));
		
		


$table = $wpdb->prefix . "sam_online";	
$result = $wpdb->get_results("SELECT * FROM $table WHERE session_id='$sam_session_id'", ARRAY_A);
$count = $wpdb->num_rows;


 

	if($count==NULL)
		{
	$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, sam_time, userid, url_id, url_term, city, region, countryName, browser, platform, referer_doamin, referer_url) VALUES	(%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							array( '', $sam_session_id, $sam_datetime, $userid, $url_id, $url_term, $city, $region, $countryName, $browser, $platform, $referer_doamin, $referer_url)
								));
		}
	else
		{
			$wpdb->query("UPDATE $table SET sam_time='$sam_datetime', url_id='$url_id', referer_doamin='$referer_doamin', referer_url='$referer_url' WHERE session_id='$sam_session_id'");
		}
			
	}

add_action('wp_logout', 'sam_logout');



function sam_register_session(){
    if( !session_id() )
        session_start();


		
}
add_action('init','sam_register_session');


function sam_session(){

	$sam_session_id = session_id();
	return $sam_session_id;


}


function sam_ajax_online_total()
	{	
		global $wpdb;
		$table = $wpdb->prefix . "sam_online";	
		$count_online = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
		$count_online = $wpdb->num_rows;

		echo $count_online;
		
		$time = date("Y-m-d H:i:s", strtotime(sam_get_datetime()." -120 seconds"));
		$wpdb->query("DELETE FROM $table WHERE sam_time < '$time' ");

		die();
	}
add_action('wp_ajax_sam_ajax_online_total', 'sam_ajax_online_total');
add_action('wp_ajax_nopriv_sam_ajax_online_total', 'sam_ajax_online_total');



function sam_offline_visitors()
	{
		$sam_session_id = sam_session();
		$last_time = sam_get_time();


		global $wpdb;
		$table = $wpdb->prefix."sam";
		
		
		$wpdb->query("UPDATE $table SET sam_endtime = '$last_time' WHERE session_id='$sam_session_id' ORDER BY id DESC LIMIT 1");

		$table = $wpdb->prefix . "sam_online";
		
		$wpdb->delete( $table, array( 'session_id' => $sam_session_id ) );




	}

add_action('wp_ajax_sam_offline_visitors', 'sam_offline_visitors');
add_action('wp_ajax_nopriv_sam_offline_visitors', 'sam_offline_visitors');

















function sam_visitors_page()
	{	
		global $wpdb;
		$table = $wpdb->prefix . "sam_online";
		$entries = $wpdb->get_results( "SELECT * FROM $table ORDER BY sam_time DESC" );
		

		

 		echo "<br /><br />";
		echo "<table class='widefat' >";
		echo "<thead><tr>";
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Page</strong></th>";
		echo "<th scope='col' class='manage-column column-name' style=''><strong>User</strong></th>";
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Time</strong></th>";		
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Duration</strong></th>";		
		echo "<th scope='col' class='manage-column column-name' style=''><strong>City</strong></th>";
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Country</strong></th>";
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Browser</strong></th>";	
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Platform</strong></th>";
		echo "<th scope='col' class='manage-column column-name' style=''><strong>Referer</strong></th>";
		
		echo "</tr></thead>";
		echo "<tr class='no-online' style='text-align:center;'>";
				echo "<td colspan='8' style='color:#f00;'>";
				
				if($entries ==NULL)
					{
					echo "No User online";
					
					}
				
				echo "</td>";
		
		echo "</tr>";

		
		
		
		
		 $count = 1;
		foreach( $entries as $entry )
			{

				
				$class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
				
				
				echo "<tr $class>";
				echo "<td>";
				$url_term = $entry->url_term;
				$url_id = $entry->url_id;
				if(is_numeric($url_id))
					{	
						echo "<a href='".get_permalink($url_id)."'>".get_the_title($url_id)."</a>";

					}
				else
					{
						
						echo "<a href='".$url_id."'>".$url_term."</a>";

					}
				echo "</td>";				
				


				echo "<td>";
				$userid = $entry->userid;
				if(is_numeric($userid))
					{	
						$user_info = get_userdata($userid);

						echo "<span title='".$user_info->display_name."' class='avatar'>".get_avatar( $userid, 32 )."</span>";
					}
				else
					{
						echo "<span title='Guest' class='avatar'>".get_avatar( 0, 32 )."</span>";
					}
				echo "</td>";



				
				echo "<td>";
				$sam_time = $entry->sam_time;
				
				
				$time = date("H:i:s", strtotime($sam_time));
				
				echo "<span class='time'>".$time."</span>";
				echo "</td>";				
				
				
				echo "<td>";
				$current_time = strtotime(sam_get_datetime());
				$sam_time = strtotime($entry->sam_time);
				$duration = ($current_time - $sam_time);

				echo "<span class='duration'>".gmdate("H:i:s", $duration)."</span>";
				echo "</td>";				
				
				echo "<td>";
				$city = $entry->city;
				
				if(empty($city))
					{
					echo "<span title='unknown' class='city'>Unknown</span>";
					}
				else
					{
					echo "<span title='".$city."' class='city'>".$city."</span>";
					}
				
				
				echo "</td>";				
				
				echo "<td>";
				$countryName = $entry->countryName;
				if(empty($countryName))
					{
					echo "<span title='unknown' >Unknown</span>";
					}
				else
					{
					echo "<span title='".$countryName."' class='flag flag-".strtolower($countryName)."'></span>";
					}
				
				
				echo "</td>";
				
				echo "<td>";
				$browser = $entry->browser;			
				echo "<span  title='".$browser."' class='browser ".$browser."'></span>";			
				echo "</td>";				
				
				echo "<td>";
				$platform = $entry->platform;				
				echo "<span  title='".$platform."' class='platform ".$platform."'></span>";				
				echo "</td>";				
				
				
				echo "<td>";
				$referer_doamin = $entry->referer_doamin;
				
				if($referer_doamin==NULL)
					{
						echo "<span title='Referer Doamin'  class='referer_doamin'>Unknown</span>";
						
					}
				elseif($referer_doamin=='direct')
					{
					echo "<span title='Referer Doamin'  class='referer_doamin'>Direct Visit</span>";
					}	
					
				elseif($referer_doamin=='none')
					{
					echo "<span title='Referer Doamin'  class='referer_doamin'>Unknown</span>";
					}
				else
					{
						echo "<span title='Referer Doamin'  class='referer_doamin'>".$referer_doamin."</span> - ";
					}
					
					
				$referer_url = $entry->referer_url;
				
				if($referer_url==NULL || $referer_url=='none' || $referer_url=='direct')
					{
						echo "<span title='Referer URL' class='referer_url'></span>";
						
					}
				else
					{
						echo "<span title='Referer URL' class='referer_url'> <a href='".$referer_url."'>URL</a></span>";
					}				

				echo "</td>";				
				
				
				
				
				
				
								
				echo "</tr>";
				
				
			$count++;
			}
		
		
		echo "</table>";

		die();
	}


add_action('wp_ajax_sam_visitors_page', 'sam_visitors_page');
add_action('wp_ajax_nopriv_sam_visitors_page', 'sam_visitors_page');









function sam_getuser()
	{
		if ( is_user_logged_in() ) 
			{
				$userid = get_current_user_id();
			}
		else
			{
				$userid = "guest";
			}
			
		return $userid;
	}











function sam_geturl_id()
	{	
		global $post;
		
		
		
		if(is_home()) 
			{
				$url_term = 'home';
				
				$home_url = get_bloginfo( 'url' );
			
				$url_id = $home_url;
			}
		elseif(is_singular()) 
			{
				$url_term = get_post_type();
				$url_id = get_the_ID();
			}
		elseif( is_tag()) 
			{
				$url_term = 'tag';
				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}			
			
		elseif(is_archive()) 
			{
				$url_term = 'archive';
				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
		elseif(is_search())
			{
				$url_term = 'search';
				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}			
			
			
		elseif( is_404())
			{
				$url_term = 'err_404';
				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}			
		elseif( is_admin())
			{
				$url_term = 'dashboard';
				$url_id = admin_url();
			}	

		else
			{
				$url_term = 'unknown';
				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
					
	
		return $url_id.",".$url_term;
		
	}


function sam_get_referer()
	{	
		if(isset($_SERVER["HTTP_REFERER"]))
			{
				$referer = $_SERVER["HTTP_REFERER"];
				$pieces = parse_url($referer);
				$domain = isset($pieces['host']) ? $pieces['host'] : '';
					if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs))
						{
							$referer = $regs['domain'];
						}
					else
						{
							$referer = "none";
						}
				
				$referurl = $_SERVER["HTTP_REFERER"];
			
			}
		else
			{
				$referer = "direct";
				$referurl = "none";
			}
		return $referer.",".$referurl;
	}









	function sam_get_screensize()
		{
	
		if(!isset($_COOKIE["sam_screensize"]))
			{
				
			?>
			<script>
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + 365);    
		var screen_width =  screen.width +"x"+ screen.height;  
		var c_value=screen_width + "; expires="+exdate.toUTCString()+"; path=/";
		document.cookie= 'sam_screensize=' + c_value;
			
			
			</script>
            
            <?php
				$sam_screensize = "unknown";
				
				
			}
		else 
			{
				$sam_screensize = $_COOKIE["sam_screensize"];
			}
		
		
		return $sam_screensize;  
		} 




	function sam_landing()
		{
			if (!isset($_COOKIE['sam_landing']))
				{	

					?>
					<script>
						var exdate=new Date();
						exdate.setDate(exdate.getDate() + 365);    
						sam_landing = 1;
						var c_value=sam_landing + "; expires="+exdate.toUTCString()+"; path=/";
						document.cookie= 'sam_landing=' + c_value;
					
					</script>
					
					<?php
					
					$sam_landing = 1;
					
				}
			else
				{

					$sam_landing = $_COOKIE['sam_landing'];
					$sam_landing += 1;

					?>
					<script>
						var exdate=new Date();
						exdate.setDate(exdate.getDate() + 365);    
						sam_landing =<?php echo $sam_landing; ?>;
						var c_value=sam_landing + "; expires="+exdate.toUTCString()+"; path=/";
						document.cookie= 'sam_landing=' + c_value;
					
					</script>
					
					<?php
					
					
					
					
					
					
					
				}
				

			return $sam_landing;
			
		}


















	function sam_get_date()
		{	
			$gmt_offset = get_option('gmt_offset');
			$sam_datetime = date('Y-m-d', strtotime('+'.$gmt_offset.' hour'));
			
			return $sam_datetime;
		
		}
		

	function sam_get_time()
		{	
			$gmt_offset = get_option('gmt_offset');
			$sam_time = date('H:i:s', strtotime('+'.$gmt_offset.' hour'));
			
			return $sam_time;
		
		}		
		
	function sam_get_datetime()
		{	
			$gmt_offset = get_option('gmt_offset');
			$sam_datetime = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));
			
			return $sam_datetime;
		
		}		
		
		
		


	function sam_get_unique()
		{	

			$cookie_site = md5($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

			$cookie_nam = 'sam_page_'.$cookie_site;

			if (isset($_COOKIE[$cookie_nam]))
				{	
					
					$visited = "yes";
		
				}
			else
				{
					
					?>
					<script>
					document.cookie="<?php echo $cookie_nam ?>=yes";
					</script>
					
					<?php
					
					$visited = "no";
				}
		
		
		
		
		
		
			if(empty($_COOKIE[$cookie_nam]))
				{
					$isunique ="yes";
				}
			else 
				{
					$isunique ="no";
				}
				
			return $isunique;
		
		}



	function sam_live_cities_array()
		{
			
			$html = '';
					
			$html .= '<script>';
			
			$html .= 'var address = [];';
							
			
			global $wpdb;
			$table = $wpdb->prefix . "sam_online";
			$entries = $wpdb->get_results( "SELECT * FROM $table ORDER BY sam_time DESC" );
			
			$i = 0;
			foreach( $entries as $entry )
				{
					$countryName = $entry->countryName;
					$city = $entry->city;	
					
					$html .='address[ '.$i.' ] = "'.$city.' '.$countryName.'";';

					$i++;			
				}
			$html .= '</script>';		
				
			echo $html;
			
			die();
			

		}

add_action('wp_ajax_sam_live_cities_array', 'sam_live_cities_array');
add_action('wp_ajax_nopriv_sam_live_cities_array', 'sam_live_cities_array');





	function sam_top_filter()
		{
			
			$filter_for = $_POST['filter_for'];
			$max_items = (int)$_POST['max_items'];					
			$first_date = $_POST['first_date'];			
			$second_date = $_POST['second_date'];			
			
			if($filter_for == 'url_id')
				{
					$factor = 'URL';
				}
			else if($filter_for == 'userid')
				{
					$factor = 'User ID';
				}
			else if($filter_for == 'platform')
				{
					$factor = 'Platform(OS)';
				}			
			else if($filter_for == 'browser')
				{
					$factor = 'Browser';
				}			
			else if($filter_for == 'screensize')
				{
					$factor = 'Screen Size';
				}
			else if($filter_for == 'referer_url')
				{
					$factor = 'Referer Url';
				}
			else if($filter_for == 'referer_doamin')
				{
					$factor = 'Referer Doamin';
				}
			else if($filter_for == 'city')
				{
					$factor = 'City';
				}				
			else if($filter_for == 'countryName')
				{
					$factor = 'Country';
				}								
			else if($filter_for == 'url_term')
				{
					$factor = 'Link Type';
				}								
				
			else
				{
					$factor = '';
				}	
				
			if(!empty($max_items))
				{
					$max_items = $max_items;
				}
			else
				{
					$max_items = 10;
				}				
						
			
			global $wpdb;
			$table = $wpdb->prefix . "es";
			$result = $wpdb->get_results("SELECT $filter_for FROM $table WHERE  (sam_date BETWEEN '$first_date' AND '$second_date')  GROUP BY $filter_for ORDER BY COUNT($filter_for)   DESC LIMIT $max_items", ARRAY_A);
			$total_rows = $wpdb->num_rows;
			
			$count_factor = $wpdb->get_results("SELECT $filter_for, COUNT(*) AS $filter_for FROM $table WHERE  (sam_date BETWEEN '$first_date' AND '$second_date')  GROUP BY $filter_for ORDER BY COUNT($filter_for)  DESC LIMIT $max_items", ARRAY_A);
			
			
			
			
			$html = '';
			
			$html .= 'Top <u>'.$total_rows.'</u> <b>'.ucfirst($factor). '</b> between date: <b>'.$first_date.'</b> and <b>'.$second_date.'</b><br /><br />';


			$html .='<table class="widefat">';
			$html .='<thead><tr><th>Factor: '.$factor.'</th><th>Count</th></tr></thead>';

			$i=0;
			while($total_rows>$i)
				{	
					$class = ( $i % 2 == 0 ) ? ' alternate ' : '';

					$html .= '<tr class="'.$class.'">';
					
					if( is_numeric($result[$i][$filter_for]))
						{
							if($filter_for=='url_id')
								{
									$value = get_permalink($result[$i][$filter_for]);
								}
							else if($filter_for=='userid')
								{
									$value = get_the_author_meta('user_email',$result[$i][$filter_for]).' - '.get_the_author_meta('display_name',$result[$i][$filter_for]);
								}
							else
								{
									$value = $result[$i][$filter_for];
								}
							
							
						}
					else
						{

							$value = $result[$i][$filter_for];
							
						}
					$html .='<td>'.$value;
					$html .="</td>";
					
					$html .="<td>".$count_factor[$i][$filter_for];
					$html .="</td>";


					$html .="</tr>";
			
					
					
					$i++;
				}
				
				$html .="</table>";		
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			echo $html;
			
			
			die();
			
		}


add_action('wp_ajax_sam_top_filter', 'sam_top_filter');
add_action('wp_ajax_nopriv_sam_top_filter', 'sam_top_filter');







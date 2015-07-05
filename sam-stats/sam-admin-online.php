<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 
<?php

	$sam_refresh_time = get_option( 'sam_refresh_time' );	
	if(!empty($sam_refresh_time))
		{
			if($sam_refresh_time < 5000)
				{
					$sam_refresh_time = '5000';
				}
			else
				{
				$sam_refresh_time = $sam_refresh_time;
				}
			
		}
	else
		{
			$sam_refresh_time = '5000';
		}
?>
<div class="sam-settings">

        <div class="sam-dashboard"> 

			<div class="dash-cg">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">SAM STATS</span></div></center>
                <center><div class="dash-box-info"><a href="admin.php?page=sam_settings" class="myButton"><i class="fa fa-tachometer fa-2x"></i></br>DASHBOARD</a><a href="admin.php?page=sam_admin_visitors" class="myButton"><i class="fa fa-users fa-2x"></i></br>ALL VISITORS</a><a href="admin.php?page=sam_admin_online" class="myButton"><i class="fa fa-user-secret fa-2x"></i></br>ONLINE USERS</a><a href="admin.php?page=sam_admin_filter" class="myButton"><i class="fa fa-filter fa-2x"></i></br>FILTER STATS</a><a href="admin.php?page=sam_dashboard" class="myButton"><i class="fa fa-cog fa-2x"></i></br>SETTINGS</a><a href="http://themology.net/forum" target="_blank" class="myButton"><i class="fa fa-question-circle fa-2x"></i></br>HELP & SUPPORT</a>
				</div></center>
			</div>

			</div>

<div class="wrap">
<center>
<div class="kento-wp-stats-admin">
    <style>
#map-canvas {
  height: 500px;
  margin: 0;
  padding: 0;
  width: 100%;
}
    </style>



<div class="onlinecount">

<span class="count"></span><br />
<span class="script"><script>var address = []; </script></span><br />
Users Online
</div>
</center>
</br>
<div id="map-canvas" ></div>
<script>		



	var geocoder;
	var map;


	function initialize() {

		geocoder = new google.maps.Geocoder();


		var myLatlng = new google.maps.LatLng(51.482557, -0.007670);
	
		var mapOptions = {
		zoom: 1,
		center: myLatlng
		};
		
		var map = new google.maps.Map(document.getElementById('map-canvas'),
		  mapOptions);
		  
		var i;
	
	
		
		


		for (i = 0; i < address.length; i++) { 
		
		
		
		
		
		
		  
		geocoder.geocode( { 'address': address[i]}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);
			  var marker = new google.maps.Marker({
				  map: map,
				  position: results[0].geometry.location
			  });
			} else {

			}
		  });	
	
	
	
	


      
    }
	
	
	  
	}
	


	
	
	function loadScript() {

	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' +
	  'callback=initialize';
	document.body.appendChild(script);
	}
	


	


	setInterval(function(){
		
		
		
		
		
		jQuery.ajax(
				{
			type: 'POST',
			url: sam_ajax.sam_ajaxurl,
			data: {"action": "sam_live_cities_array"},
			success: function(data)
					{
						
						jQuery(".onlinecount .script").html(data);
						
						loadScript();	
					}
				});	
	}, <?php echo $sam_refresh_time; ?>)


	setInterval(function(){

		jQuery.ajax(
				{
			type: 'POST',
			url: sam_ajax.sam_ajaxurl,
			data: {"action": "sam_ajax_online_total"},
			success: function(data)
					{
						jQuery(".onlinecount .count").html(data);
					}
				});	
	}, <?php echo $sam_refresh_time; ?>)
				
			
</script>


<script>		
	jQuery(document).ready(function($)
		{

			setInterval(function(){
				$.ajax(
						{
					type: 'POST',
					url: sam_ajax.sam_ajaxurl,
					data: {"action": "sam_visitors_page"},
					success: function(data)
							{
								$(".visitors").html(data);
							}
						});	
			}, <?php echo $sam_refresh_time; ?>)
					});
			
</script>


<div class="visitors"></div>


</div>



</div>

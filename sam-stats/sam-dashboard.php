<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 
<div class="wrap">
    <div class="sam-settings">
        <div class="sam-dashboard"> 

			<div class="dash-cg">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">SAM STATS</span></div></center>
                <center><div class="dash-box-info"><a href="admin.php?page=sam_settings" class="myButton"><i class="fa fa-tachometer fa-2x"></i></br>DASHBOARD</a><a href="admin.php?page=sam_admin_visitors" class="myButton"><i class="fa fa-users fa-2x"></i></br>ALL VISITORS</a><a href="admin.php?page=sam_admin_online" class="myButton"><i class="fa fa-user-secret fa-2x"></i></br>ONLINE USERS</a><a href="admin.php?page=sam_admin_filter" class="myButton"><i class="fa fa-filter fa-2x"></i></br>FILTER STATS</a><a href="admin.php?page=sam_dashboard" class="myButton"><i class="fa fa-cog fa-2x"></i></br>SETTINGS</a><a href="http://themology.net/forum" target="_blank" class="myButton"><i class="fa fa-question-circle fa-2x"></i></br>HELP & SUPPORT</a>
				</div></center>
			</div>
       	
			<div class="dash-box">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">VISITORS ONLINE</span></div></center>
                <div class="dash-box-info"><center>Estimated visitors on your website at the moment:</br><a href="">Click to Refresh the Statistics</a></center></div>
                <div class="total-online">0</div>
                
                
                
				<?php
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
         
            </div>
            
            
            
            
            <div class="dash-box">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">TOTAL PAGE VIEWS</span></div></center>
                
                <div class="unique-visitor"><?php echo sam_UniquePageView("isunique"); ?></div>
				<center><div class="dash-box-info">Unique page views</div></center>
            </div>  
            
            
			<div class="dash-box">
                <center><div class="dash-box-title"><span class="sam-icons user-crowd">UNIQUE VISITORS</span></div></center>

                <div class="unique-visitor"><?php echo sam_UniqueVisitor("ip"); ?></div>
                <center><div class="dash-box-info">Unique visitors</div></center>
				</div>  
            
			            
            
            <div class="dash-box">
                <center><div class="dash-box-title"><span class="sam-icons page">MOST POPULAR PAGES</span></div></center>
                <center><div class="dash-box-info">Top page list by view count.</div></center>
                <center><?php echo sam_TopPages("url_id"); ?></center>
            </div>
            
			<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons page">MOST POPULAR PAGE TERMS</span></div></center>
            
            <div id="TopPageTerms" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
								<?php echo sam_TopPageTerms("url_term"); ?>
							];
							
				  var TopOS = $.jqplot ('TopPageTerms', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
            <center><div class="dash-box-info">Most popular categories for visited links.</div></center>
            </div>            
			
			<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons user-group">MOST ACTIVE USERS</span></div></center>
            
            <div id="TopUser" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
							<?php echo sam_TopUser("userid"); ?>
							];
							
				  var TopOS = $.jqplot ('TopUser', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
            <center><div class="dash-box-info">Most active users (by id) on your site.</div></center>
            </div>
			
        	<div class="dash-box">
            	<center><div class="dash-box-title"><span class="sam-icons os-windows">TOP OPERATING SYSTEMS</span></div></center>

            
            <div id="TopOS" style="height:320px;width:100%; "></div>
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
								<?php echo sam_TopOS("platform"); ?>
							];
							
				  var TopOS = $.jqplot ('TopOS', [data],
					{

					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
             	<center><div class="dash-box-info">Your visitors most used operating systems.</div></center>           
            
            </div>
            
        	<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons device-monitor">TOP SCREEN SIZE</span></div></center>

            <div id="TopScreenSize" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
								<?php echo sam_TopScreenSize("screensize"); ?>
							];
							
				  var TopOS = $.jqplot ('TopScreenSize', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
            
             <center><div class="dash-box-info">Your visitors most used screen sizes.</div></center>          
            
            </div>            
            
            
        	<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons browser-firefox">TOP BROWSERS</span></div></center>

            <div id="TopBrowsers" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
								<?php echo sam_TopBrowsers("browser"); ?>
							];
							
				  var TopOS = $.jqplot ('TopBrowsers', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
            
            <center><div class="dash-box-info">Your visitors most used browsers.</div></center>           
            
            </div>
 
            
        	<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons globe">TOP COUNTRIES</span></div></center>

            <div id="TopCountries" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
							<?php echo sam_TopCountries("countryName"); ?>
							];
							
				  var TopOS = $.jqplot ('TopCountries', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
            <center><div class="dash-box-info">You are getting most visits from this countries.</div></center>            
            </div>
			
        	<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons map-pin">TOP CITIES</span></div></center>

            <div id="TopCities" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
							<?php echo sam_TopCities("city"); ?>
							];
							
				  var TopOS = $.jqplot ('TopCities', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
              <center><div class="dash-box-info">You are getting most visits from this cities.</div></center>          
            </div>   
            
        	<div class="dash-box">
            <center><div class="dash-box-title"><span class="sam-icons share-hub">TOP REFERERS</span></div></center>

            <div id="TopReferers" style="height:320px;width:100%; "></div>
            
            <script>
				jQuery(document).ready(function($){
				  var data =
				  			[
							<?php echo sam_TopReferers("referer_doamin"); ?>
							];
							
				  var TopOS = $.jqplot ('TopReferers', [data],
					{




					  	seriesDefaults: {


						shadow:false,
						renderer: $.jqplot.PieRenderer,
						rendererOptions: {
							showDataLabels: true,


						}
					  },
					  
						highlighter: {
							show: true,
							sizeAdjust: 1,
							tooltipOffset: 9
						},
					  
					  legend: {
							show:true,
							location: 's',
							renderer: $.jqplot.EnhancedLegendRenderer,
							rendererOptions:
								{
								numberColumns: 3,
								disableIEFading: false,
								border: 'none',
								},
							},
						grid: {
							background: 'transparent',
							borderWidth: 0,
							shadow: false,
							
							},
						highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},
							
					}
				  );

				  
				});
			</script>
             <center><div class="dash-box-info">Most popular referers to your website.</div></center>           
            </div>
			
        <div class="dash-cg">
                <center><div class="dash-box-title"><span class="sam-icons page">REFRESH STATISTICS</span></div></center>
                <center><div class="dash-box-info">Last time data was updated: <?php echo sam_get_datetime(); ?></br></br>
				
				<a href="" class="myButton">Click to Refresh the page</a>
				</div></center>
		</div>    
            
        </div>


		
	</div>	  
</div>
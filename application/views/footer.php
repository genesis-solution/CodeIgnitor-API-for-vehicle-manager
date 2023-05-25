	<script src="<?php echo base_url()?>js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url()?>js/bootstrap.min.js"></script>
	<script src="<?php echo base_url()?>js/chart.min.js"></script>
	<script src="<?php echo base_url()?>js/chart-data.js"></script>
	<script src="<?php echo base_url()?>js/easypiechart.js"></script>
	<script src="<?php echo base_url()?>js/easypiechart-data.js"></script>
	<script src="<?php echo base_url()?>js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url()?>js/custom.js"></script>	

	 <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	 <style type="text/css">
	 	.btn_wrap{
	 		text-align: center;
	 	}
	 </style>

	<script>
		window.onload = function () {
			var chart1 = document.getElementById("line-chart").getContext("2d");
			window.myLine = new Chart(chart1).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "rgba(0,0,0,.2)",
			scaleGridLineColor: "rgba(0,0,0,.05)",
			scaleFontColor: "#c5c7cc"
			});				
		};

		$('document').ready(function(){
			if(window.location.href.indexOf("Bollywood_actercess") > -1 
				|| window.location.href.indexOf("hollywood_actors") > -1 
				|| window.location.href.indexOf("Hollywood_actercess") > -1 
				|| window.location.href.indexOf("bollywood_actors") > -1 
                || window.location.href.indexOf("Chinese_wallpaper") > -1 
                || window.location.href.indexOf("Sauth_actors") > -1 
				
				){
       			setTimeout(function(){			
					$('.cw').click();
				}, 1000);

    		}else if(window.location.href.indexOf("Diwali") > -1) {
       			setTimeout(function(){
					$('.diwali').click();
				}, 1000);
    		}else if(window.location.href.indexOf("Video_app") > -1) {
       			setTimeout(function(){
					$('.va').click();
				}, 1000);
    		}
    		else if(window.location.href.indexOf("Mahendi_app") > -1) {
       			setTimeout(function(){
					$('.MA').click();
				}, 1000);

    		}else if(window.location.href.indexOf("manage_image_rangoli_cate") > -1 
				|| window.location.href.indexOf("manage_rangoli_images") > -1 
				
				|| window.location.href.indexOf("manage_rangoli_youtube_category") > -1 
				|| window.location.href.indexOf("manage_rangoli_youtube") > -1 
				
				){
       			setTimeout(function(){			
					$('.ra').click();
				}, 1000);
       		}

                else if(window.location.href.indexOf("Recipe_app") > -1 
				
				|| window.location.href.indexOf("manage_rangoli_youtube_category") > -1 
				|| window.location.href.indexOf("manage_rangoli_youtube") > -1 
				
			){
       			setTimeout(function(){			
					$('.recipe').click();
				}, 1000);
       		}	

       		else if(window.location.href.indexOf("hd_wallpaper") > -1){
       			setTimeout(function(){
					$('.hd_wallpaperhd').click();
				}, 1000);
       		}
       		
       		else if(window.location.href.indexOf("Fastival") > -1){
       			setTimeout(function(){
					$('.fastival').click();
				}, 1000);
       		}

       		else if(window.location.href.indexOf("None_veg_recipe_app") > -1){
       			setTimeout(function(){
					$('.none_recipe').click();
				}, 1000);
       		}     

		});
	</script>	
</body>
</html>
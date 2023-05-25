<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span></button>
			<a class="navbar-brand" href="#"><span>Vehicle</span> Admin</a>				
		</div>
	</div>
</nav>
	
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="<?php echo base_url() ?>images/admin_icon.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">
					<?php 
						$user_data=$this->session->userdata();						
					?>
				</div>				
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>

	<ul class="nav menu">		
		<?php
			$data=$this->uri->segment(2);			
			$first_perameter=$this->uri->segment(1);
		?>

		<li class="<?php if($data==''){ echo 'active'; }?>">
			<a href="<?php echo base_url();?>"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a>
		</li>		


		<li class="parent">
			<a  href="<?php echo base_url() ?>index.php/vehicle_manage/manage_user" class="profile_parent">
				<em class="fa fa-navicon">&nbsp;</em> Users List				
			</a>
			<!-- <a data-toggle="collapse" href="#sub-item-3" class="profile_parent cw">
				<em class="fa fa-navicon">&nbsp;</em>Manage Vehicle <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a> -->

			<!-- <ul class="children collapse" id="sub-item-3">
				<li>
					<li class="parent <?php #if($data=='manage_festival_cate'){ echo 'active'; }?>">
						<a data-toggle="collapse" href="#sub-item-5" class="profile_parent">
							<em class="fa fa-navicon">&nbsp;</em>Manage Expense<span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>	

						<ul class="children collapse" id="sub-item-5">
							<li>
								<a class="m_pass" href="<?php echo base_url()?>index.php/vehicle_manage/manage_expense_type">
									<span class="fa fa-arrow-right">&nbsp;</span> Manane Type
								</a>
							</li>

						</ul>			
					</li>
				</li>
			</ul> -->
		</li>						

	    <!---------------------------------------------------------------------------------------------->
		<li class="parent ">
			<a data-toggle="collapse" href="#sub-item-profile" class="profile_parent">
				<em class="fa fa-navicon">&nbsp;</em> Proflie <span data-toggle="collapse" href="#sub-item-profile" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>

			<ul class="children collapse" id="sub-item-profile">
				<li>
					<a class="m_pass" href="<?php echo base_url()?>index.php/Admin/change_password">
						<span class="fa fa-arrow-right">&nbsp;</span> Manage Password
					</a>
				</li>

				<li>
					<a href="<?php echo base_url()?>index.php/welcome/logout">
						<span class="fa fa-arrow-right">&nbsp;</span> Logout
					</a>
				</li>
			</ul>
		</li>		
	</ul>
</div>
<?php   
    $current_page = $this->uri->segment(3);
    $back[0]=$current_page;
    $this->session->set_userdata( 'back',$back);     
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<script type="text/javascript">
    $(document).ready(function() {             
        $('#main_table').dataTable({searching: false}); 
    });
</script> 

<div id="content">
    <div id="content-header">        
        <h1>Vehicle List</h1>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
				<div><span></span></div>
                <div class="widget-box">
                    <a href="<?php echo base_url() ?>index.php/vehicle_manage/manage_user" class="back_btn btn-success btn">Back</a>

                    <div class="widget-content nopadding">
                        <table class="table table-bordered" id="main_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Vehicle id</th>
                                    <th>Email Id</th>  
                                    <th>Title</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Registration no</th>
                                    <th>More Details</th>                                    
                                </tr>
                            </thead>
                            <tbody>

							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>
                                        <td><?php echo $i++;?></td>                                                                                  

                                        <td>
                                            <?php  echo $v['Vehicle_id']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['email_id']; ?>
                                        </td>                                         

                                        <td>
                                            <?php  echo $v['vehicle_title']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['vehicle_brand']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['vehicle_model']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['vehicle_regi_no']; ?>
                                        </td>  

                                        <td class="btn_wrap">
                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/accident_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-success">Accident Details</a>                                        

                                        
                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/expense_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-danger">Expenses Details</a>

                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/insurance_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-warning">Insurance Details</a>

                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/permit_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-default">Permit Details</a>

                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/puc_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-info">Puc Details</a>


                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/refuel_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-success">Refuel Details</a>

                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/service_details/<?php  echo $v['Vehicle_id']; ?>" class="btn btn-primary">Service Details</a>


                                        </td>
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                    <th>No</th>
                                    <th>Vehicle id</th>
                                    <th>Email Id</th>  
                                    <th>Vehicle title</th>
                                    <th>Vehicle brand</th>
                                    <th>Vehicle model</th>
                                    <th>Vehicle registration no</th>
                                    <th>More Details</th>                                                                    
                            </tfooter>
                        </table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
</div>
<style type="text/css">
    .btn_wrap a{
        margin: 3px;
    }    
</style>
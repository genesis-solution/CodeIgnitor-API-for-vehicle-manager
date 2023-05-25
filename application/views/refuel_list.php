<?php   
    $current_page = $this->uri->segment(3);
    $back=$this->session->userdata('back');       
  
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<script type="text/javascript">
    $(document).ready(function() {             
        $('#main_table').dataTable(); 
    });
</script> 

<div id="content">
    <div id="content-header">        
        <h1>Refuel List</h1>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
				<div><span></span></div>
                <div class="widget-box">
                    
                    <a href="<?php echo base_url() ?>index.php/vehicle_manage/show_vehicle/<?php echo $back[0]; ?>" class="back_btn btn-success btn">Back</a>

                    <div class="widget-content nopadding">
                        <table class="table table-bordered" id="main_table">
                            <thead>
                                <tr>                                    
                                    <th>Refuel id</th>
                                    <th>Action Type</th>
                                    <th>Vehicle Id</th>
                                    <th>Refuel date</th>
                                    <th>Refuel type</th>
                                    <th>Refuel amount</th>
                                    <th>Refuel fuel price</th>
                                    <th>Refuel quantity</th>
                                    <th>Refuel station</th>                                   
                                </tr>
                            </thead>

                            <tbody>
							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>                                       

                                        <td>
                                            <?php  echo $v['refuel_id']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['action_type']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['vehicle_id']; ?>
                                        </td>  


                                        <td>
                                            <?php  echo $v['refuel_date']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['refuel_type']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['refuel_amount']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['refuel_fuel_price']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['refuel_quantity']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['refuel_station']; ?>
                                        </td>
                                       
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                <tr>                                    
                                    <th>Refuel id</th>
                                    <th>Action Type</th>
                                    <th>Vehicle Id</th>
                                    <th>Refuel date</th>
                                    <th>Refuel type</th>
                                    <th>Refuel amount</th>
                                    <th>Refuel fuel price</th>
                                    <th>Refuel quantity</th>
                                    <th>Refuel station</th>
                                </tr>                    
                            </tfooter>
                        </table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
</div>
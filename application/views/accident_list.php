<?php
   
    $current_page = $this->uri->segment(3);
    $back=$this->session->userdata('back');               


    if(end($back)!=$current_page){                    
        $back[1]=$current_page;
        $this->session->set_userdata( 'back',$back);
    }            

?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<script type="text/javascript">
    $(document).ready(function() {
        $('#main_table').dataTable(); 
    });
</script> 

<div id="content">
    <div id="content-header">        
        <h1>Acciendts List</h1>
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
                                    <th>Accident id</th>
                                    <th>Vehicle id</th>
                                    <th>Accident time</th>                                    
                                    <th>Accident driver name</th>
                                    <th>Accident Date</th>                                    
                                </tr>
                            </thead>

                            <tbody>
							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>                                       

                                        <td>
                                            <?php  echo $v['accident_id']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['vehicle_id']; ?>
                                        </td>                                         

                                        <td>
                                            <?php  echo $v['accident_time']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['accident_driver_name']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['accident_date']; ?>
                                        </td>                                          
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                    <tr>                                    
                                    <th>Accident id</th>
                                    <th>Vehicle id</th>
                                    <th>Accident time</th>                                    
                                    <th>Accident driver name</th>
                                    <th>Accident Date</th>
                                    
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
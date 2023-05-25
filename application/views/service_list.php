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
                                    <th>Service id</th>
                                    <th>Vehicle id</th>
                                    <th>Service body</th>
                                    <th>Service general</th>
                                    <th>Service clutch</th>
                                    <th>Service engine</th>
                                    <th>Service oil change</th>
                                    <th>Service brakes</th>
                                    <th>Service colling systerm</th>
                                    <th>Service sparkplug</th>
                                    <th>Service other</th>
                                    <th>Service battery</th>
                                    <th>Service garrage name</th>
                                    <th>Service contact no</th>
                                    <th>Service amout</th>
                                    <th>Service km reading</th>
                                    <th>Service description</th>
                                </tr>
                            </thead>

                            <tbody>
							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>                                      

                                        <td>
                                            <?php  echo $v['service_id']; ?>
                                        </td> 

                                        <td>
                                            <?php  echo $v['vehicle_id']; ?>
                                        </td>

                                        <td>
                                            <?php
                                                if($v['service_body']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?>

                                              
                                        </td>

                                        <td>

                                            <?php
                                                if($v['service_general']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?>                                            
                                        </td>

                                        <td>
                                             <?php
                                                if($v['service_clutch']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>                                           

                                            <?php
                                                if($v['service_engine']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>
                                             <?php
                                                if($v['service_oil_change']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>                                           

                                            <?php
                                                if($v['service_brakes']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>                                          

                                            <?php
                                                if($v['service_colling_systerm']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 

                                        </td>

                                        <td>                                            
                                            <?php
                                                if($v['service_sparkplug']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>                                            
                                             <?php
                                                if($v['service_other']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>                                            
                                             <?php
                                                if($v['service_battery']){ ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger">No</span>
                                                <?php }
                                             ?> 
                                        </td>

                                        <td>
                                            <?php  echo $v['service_garrage_name']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['service_contact_no']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['service_amout']; ?>
                                        </td>
                                        <td>
                                            <?php  echo $v['service_km_reading']; ?>
                                        </td>
                                        <td>
                                            <?php  echo $v['service_description']; ?>
                                        </td>                                        
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                <tr>                                    
                                    <th>Service id</th>
                                    <th>Vehicle id</th>
                                    <th>Service body</th>
                                    <th>Service general</th>
                                    <th>Service clutch</th>
                                    <th>Service engine</th>
                                    <th>Service oil change</th>
                                    <th>Service brakes</th>
                                    <th>Service colling systerm</th>
                                    <th>Service sparkplug</th>
                                    <th>Service other</th>
                                    <th>Service battery</th>
                                    <th>Service garrage name</th>
                                    <th>Service contact no</th>
                                    <th>Service amout</th>
                                    <th>Service km reading</th>
                                    <th>Service description</th>
                                    
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
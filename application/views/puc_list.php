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
        <h1>PUC List</h1>
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
                                    <th>puc_id</th>
                                    <th>Vehicle id</th>
                                    <th>Puc no</th>                                    
                                    <th>Puc issue date</th>
                                    <th>Puc expiry date</th>
                                    <th>Puc amount</th>
                                    <th>Puc description</th>
                                </tr>
                            </thead>

                            <tbody>
							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>                                       

                                        <td>
                                            <?php  echo $v['puc_id']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['vehicle_id']; ?>
                                        </td>                                         

                                        <td>
                                            <?php  echo $v['puc_no']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['puc_issue_date']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['puc_expiry_date']; ?>
                                        </td>                                          

                                        <td>
                                            <?php  echo $v['puc_amount']; ?>
                                        </td>
                                        
                                        <td>
                                            <?php  echo $v['puc_description']; ?>
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
<?php   
    $current_page = $this->uri->segment(3);
    $back=$this->session->userdata('back');            
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<script type="text/javascript">
    $(document).ready(function() {             
        $('#main_table').dataTable({searching: false}); 
    });
</script> 

<div id="content">
    <div id="content-header">        
        <h1>Insurance List</h1>
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
                                    <th>Vehicle id</th>
                                    <th>Insurance Company</th>
                                    <th>Insurance policy type</th>
                                    <th>Insurance policy no</th>
                                    <th>Insurance issue date</th>
                                    <th>Insurance expiry date</th>
                                    <th>Insurance payment mode</th>
                                    <th>Insurance amount</th>
                                    <th>Insurance preminum</th>
                                    <th>Insurance agent name </th>
                                </tr>
                            </thead>
                            <tbody>

							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>                                       
                                        <td>
                                            <?php  echo $v['vehicle_id']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_company']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_policy_type']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_policy_no']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_issue_date']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_expiry_date']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_payment_mode']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_amount']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_premium']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['insurance_agent_name']; ?>
                                        </td>

                                                                
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                    <tr>               
                                        <th>Vehicle id</th>
                                        <th>Insurance Company</th>
                                        <th>Insurance policy type</th>
                                        <th>Insurance policy no</th>
                                        <th>Insurance issue date</th>
                                        <th>Insurance expiry date</th>
                                        <th>Insurance payment mode</th>
                                        <th>Insurance amount</th>
                                        <th>Insurance preminum</th>
                                        <th>Insurance agent name </th>                                    
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
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
        <h1>Permit List</h1>
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
                                    <th>Permit type</th>
                                    <th>Permit issue date</th>
                                    <th>Permit expiry date</th>
                                    <th>Permit no</th>
                                    <th>Permit cost</th>
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
                                            <?php  echo $v['permit_type']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['permit_issue_date']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['permit_expiry_date']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['permit_no']; ?>
                                        </td>

                                        <td>
                                            <?php  echo $v['permit_cost']; ?>
                                        </td>
                                                                
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                    <tr>               
                                        <th>Vehicle id</th>
                                        <th>Permit type</th>
                                        <th>Permit issue date</th>
                                        <th>Permit expiry date</th>
                                        <th>Permit no</th>
                                        <th>Permit cost</th>
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
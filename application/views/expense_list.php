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
        <h1>Expense List</h1>
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
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Km reading</th>
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
                                            <?php  echo $v['expense_detail_type']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['expense_detail_amount']; ?>
                                        </td>  

                                        <td>
                                            <?php  echo $v['expense_detail_km_reading']; ?>
                                        </td>                                          
                                    </tr>

                                    <?php } ?>
                            </tbody>

                            <tfooter>
                                    <tr>               
                                        <th>Vehicle id</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Km reading</th>                                    
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
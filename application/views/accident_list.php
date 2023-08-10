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
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
							    <?php
                                $i=1;
                                foreach ($vehicle as $v) { ?>
                                    <tr>                                       

                                        <td>
                                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#galleryModal<?php  echo $v['accident_id']; ?>"><?php  echo $v['accident_id']; ?></button>

                                            <div class="modal fade" id="galleryModal<?php  echo $v['accident_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="galleryModalLabel">Accident by <?php  echo $v['accident_driver_name']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <?php foreach ($v['accident_images'] as $image): ?>
                                                                    <div style="padding: 10px;display: inline-block">
                                                                        <img src="<?php echo base_url('images/uploads/accident/'.$image['file_name']); ?>" style="width: 200px; object-fit: cover;height: 150px; max-height: 250px" class="img-fluid" alt="<?php echo $image['file_name']; ?>">
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#galleryModal<?php  echo $v['accident_id']; ?>">View</button>
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
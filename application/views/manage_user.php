<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<script type="text/javascript">
    $(document).ready(function() {
        $("#save").click(function() {
            ajax("save");
        });

        $("#add_new").click(function() {
            $(".entry-form").fadeIn("fast");
        });

        $("#close").click(function() {
            $(".entry-form").fadeOut("fast");
        });

        $("#cancel").click(function() {
            $(".entry-form").fadeOut("fast");
        });    
        
        $(".del").on("click", function() {
            var r = confirm("Are you sure you want to delete this Wallpaper");
            if (r == true) {
                ajaxdel("delete_event", $(this).attr("id"),$(this).attr("image"));
            } else {

            }
        });
        
        function ajax(action, id,stat) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->siteurll ?>/admin/status_event",
                data: {id: id, stat: stat},
                success: function(response) {
                    var row_id = id;
                    var r = JSON.parse(response);
                    location.reload();
					
                    if (r.id == true) {
						
                        $("a[id='" + row_id + "']").closest("tr").effect("highlight", {
                            color: '#4BADF5'
                        }, 1000);                        
                    }
                }
            });
        }
        
        function ajaxdel(action, id,image) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->siteurll ?>/Bollywood_actercess/delete_wall",
                data: {id: id,'image':image},
                dataType:'JSON',
                success: function(response) {
                    if(response.status=="success"){
                        location.reload();
                    }else{
                        alert('Please try again');
                    }                   
                }
            });
        }        
        $('#main_table').dataTable({searching: false});        
    });
</script> 

<link rel="stylesheet" href="<?php echo $this->baseurl; ?>jquery.nyroModal/styles/nyroModal.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>css/uniform.css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>css/select2.css" />

<div id="content">
    <div id="content-header">        
        <h1>Manage Users</h1>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
				<div><span></span></div>
                <div class="widget-box">

                    <div class="widget-content nopadding">
                        <table class="table table-bordered" id="main_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email Id</th>                                    
                                    <th>Vehicle</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

							    <?php
                                $i=1;
                                foreach ($users as $v) { ?>
                                    <tr>
                                        <td><?php echo $i++;?></td>                                                                                  

                                         <td>
                                            <?php  echo $v['email_id']; ?>
                                        </td>  
                                         <td>
                                            <a href="<?php echo base_url(); ?>index.php/Vehicle_manage/show_vehicle/<?php  echo $v['email_id']; ?>" class="btn btn-success">Show Vehicle</a>
                                        </td>                                       
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
</div>
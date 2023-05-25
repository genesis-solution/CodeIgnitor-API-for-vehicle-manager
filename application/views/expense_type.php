<?php   
    $current_page = $this->uri->segment(3);
    $back=$this->session->userdata('back');       

    if($back[0]!=$current_page){                    
        $back[]=$current_page;
        $this->session->set_userdata( 'back',$back);
    }          
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <script type="text/javascript">
        $(document).ready(function() {           

            $('#main_table').dataTable({searching: false}); 

            $('.delete').click(function(){
                $t_id=$(this).attr('t_id');

                var r = confirm("You will loss related data of this record, Are you sure you want to delete?");
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url()?>index.php/Vehicle_manage/delete_expense_type",
                        data: {'t_id':$t_id},
                        dataType:'JSON',
                        success: function(response) {                            
                            if(response.status=="success"){
                                location.reload();
                            }                   
                        }
                    });
                }
            });

            $('.add_type').click(function(){
                $('#myModal').modal('show');
            });

            $('.update').click(function(){
                $('#update_t_m').modal('show');
                $('#edit_type_name').val($(this).attr('t_type'));
                $('#edit_status').val($(this).attr('t_status'));
                $update_id=$(this).attr('t_id');                
            });            


            $('.update_type_final').click(function(){

                if(!confirm("Are you sure to update?")){
                    return false;
                }



                $status=$('#edit_status').val();
                $type_name=$('#edit_type_name').val();

                var formData = new FormData();
                formData.append('status', $status);
                formData.append('type_name', $type_name);       
                formData.append('type_id', $update_id);       

                  $.ajax({
                    url:'<?php echo base_url();?>index.php/Vehicle_manage/edit_expense_type',              
                    type:'POST',
                    dataType: "json",

                    data: formData,
                    processData: false,
                    contentType: false, 

                    success:function(data){
                        if(data.status=="success"){
                            location.reload();
                        }else{
                          alert(data.message);
                        }                    
                    }                
                });
            });
            

            $('.add_type_final').click(function(){
                $status=$('#status').val();
                $type_name=$('#type_name').val();

                var formData = new FormData();
                formData.append('status', $status);
                formData.append('type_name', $type_name);       

                  $.ajax({
                    url:'<?php echo base_url();?>index.php/Vehicle_manage/add_expense_type',              
                    type:'POST',
                    dataType: "json",

                    data: formData,
                    processData: false,
                    contentType: false, 

                    success:function(data){
                        if(data.status=="success"){
                            location.reload();
                        }else{
                          alert(data.message);
                        }                    
                    }                
                });           
            });
        });
    </script> 

    <div id="content">
        <div id="content-header">        
            <h1>Expense Type</h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
    				<div><span></span></div>
                    <div class="widget-box">
                        
                        <a href="javascript:void(0);" class="btn btn-success pull-right add_type" >Add Type</a>

                        <div class="widget-content nopadding">
                            <table class="table table-bordered" id="main_table">
                                <thead>
                                    <tr>                                    
                                        <th>Expense id</th>
                                        <th>Expense type</th>
                                        <th>Create Date</th>
                                        <th>Update Date</th>
                                        <th>Action</th>                                    
                                    </tr>
                                </thead>
                                <tbody>

    							    <?php
                                    $i=1;
                                    foreach ($type as $v) { ?>
                                        <tr>
                                            <td>
                                                <?php  echo $v['ExpenseTypeId']; ?>
                                            </td>  

                                            <td>
                                                <?php  echo $v['ExpenseType']; ?>
                                            </td> 

                                            <td>
                                                <?php  echo $v['date_create']; ?>
                                            </td> 

                                            <td>
                                                <?php  echo $v['date_update']; ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-success update" t_type="<?php  echo $v['ExpenseType']; ?>" t_status="<?php  echo $v['status']; ?>"  t_id="<?php  echo $v['ExpenseTypeId']; ?>">Update</a>
                                                <a href="javascript:void(0);" class="btn btn-danger delete" t_id="<?php  echo $v['ExpenseTypeId']; ?>">Delete</a>
                                            </td>

                                        </tr>
                                        <?php } ?>
                                </tbody>

                                <tfooter>
                                    <th>Expense id</th>
                                    <th>Expense type</th>
                                    <th>Create Date</th>
                                    <th>Update Date</th>
                                </tfooter>
                            </table>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>

<div id="update_t_m" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Type</h4>
      </div>

      <div class="modal-body">                    
          <form action="#">

            <div class="form-group">
              <label for="cate_name">Type Name</label>
              <input type="text" class="form-control" id="edit_type_name" placeholder="Enter type" name="type_name">
            </div>            

            <div class="form-group">
              <label for="cate_status">Status</label>
              <select id="edit_status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
              </select>
            </div>

            <button type="button" class="btn btn-default update_type_final">Add</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Type</h4>
      </div>

      <div class="modal-body">                    
          <form action="#">

            <div class="form-group">
              <label for="cate_name">Type Name</label>
              <input type="text" class="form-control" id="type_name" placeholder="Enter type" name="type_name">
            </div>            

            <div class="form-group">
              <label for="cate_status">Status</label>
              <select id="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
              </select>
            </div>

            <button type="button" class="btn btn-default add_type_final">Add</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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
    $(document).ready(function(){       

        $('.submit_btn').click(function(){
            $pass1=$('.pass1').val();
            $pass2=$('.pass2').val();

            if($pass1==""){
                alert('Please enter password.');
                $('.pass1').focus();    
                return false;
            }

            if($pass2==""){
                alert('Please enter confirm password.');
                $('.pass2').focus();
                return false;
            }

            if($pass1!=$pass2){
                alert('Password not match, please try again!.');
                return false;
            }
            $('.ss').submit();

        });
    });
    
</script> 

<?php 

$message=$this->uri->segment(3);
if(!empty($message)){

    if($message=='success'){?>

        <div class="text-center"><span class="label label-success">Password successfully update!</span></div>

    <?php }else{ ?>

        <div class="text-center"><span class="label label-warning">Please try again!</span></div>

    <?php }


}

    
?>

<div id="content">
    <div id="content-header">        
        <h1>Change password</h1>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12 col-sm-6">
                <div class="widget-box">                    
                   
                   <form action="<?php echo base_url() ?>index.php/admin/change_pass" class="ss" method="post"
                    >
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control pass1"  placeholder="Password" name="password">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control pass2"  placeholder="Confirm password">
                      </div>
                      
                      <button type="button" class="btn btn-primary submit_btn">Submit</button>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>
</div>
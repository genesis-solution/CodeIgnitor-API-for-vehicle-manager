<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading text-center">Log in</div>
        <div class="panel-body">
          <form role="form" >
            <fieldset>
              <div class="form-group">
                <input class="form-control username" placeholder="Username" name="username" type="text">
              </div>

              <div class="form-group">
                <input class="form-control password" placeholder="Password" name="password" type="password">
              </div>                            
              <button type="button" class="btn btn-primary login_btn">Login</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div><!-- /.col-->
  </div><!-- /.row -->  

  <script type="text/javascript">
    $(document).ready(function(){

      csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

      $('.login_btn').click(function(){

        $username=$('.username').val();
        $password=$('.password').val();

         if($username==""){

            $('.username').focus();
            return false;
         } 

         if($password==""){
            $('.password').focus();
            return false;           
         } 

         $.ajax({

            url:'<?php echo base_url();?>index.php/Welcome/user_login',
            data:{'username':$username,
                  'password':$password,
                  'csrf_sq_name':csrfHash
                  },
            type:'post',
            dataType:'JSON',
            success:function(data){
              if(data.status=='success'){
                location.href = "<?php echo base_url()?>";

              }else{
                alert(data.msg);
              }
            },
            error:function(){

            }
        });
        
      });
    });
  </script>
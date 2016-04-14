<div class="row">
  <div class="col-sm-10">
    <div class="contentpanel">
    <div class="row">
       <div class="col-md-12">
       <h3></h3>
       
        <div class="panel panel-default">
        <div class="panel-body">
       <div class="row">
       <div class="col-md-6 mb15"> 
       <div class="lbltitle">Change Password </div>
       </div>      
      
      </div>
      
      <div class="row">
     <div class="mb30">
      <form action="<?php site_url('login/change_password') ?>" method="post">
      
      <div class="panel-body">
        
        <div class="row">
          
          <div class="col-md-8">
          <?php if($msg)
                  echo $msg;
           ?>
          <?php echo form_error('current_password'); ?>
            <input type="password" name="current_password" class="form-control" placeholder="Current Password" value="<?php echo set_value('current_password'); ?>">
          </div>

          <div class="clear"></div></br></br>
          <br />
          <div class="col-md-8">
          <?php echo form_error('new_password'); ?>
            <input type="password" name="new_password" class="form-control" placeholder="New Password" value="<?php echo set_value('new_password'); ?>">
          </div>

          <div class="clear"></div></br></br>
          <br />
          <div class="col-md-8">
          <?php echo form_error('retype_new_password'); ?>
            <input type="password" name="retype_new_password" class="form-control" placeholder="Retype New Password" value="<?php echo set_value('retype_new_password'); ?>">
          </div>

          <div class="clear"></div></br></br>
          </br>
          <div class="row">
          <div class="col-sm-12">
            <input type="submit" class="btn btn-maroon" value="Change Password">
            <input type="reset" class="btn btn-normal" value="Reset">
          </div>
          </div>
          
        </div>
        </div></form>
      
      </div>
      </div>
      
    </div>
  </div>
       
  </div>
</div>
   
     
      
    </div><!-- contentpanel -->
  </div>  
</div>
     

     


<?php 
$info = $this->session->flashdata('info'); 
if(!empty($info)){    
?>
<div class="alert alert-block alert-success">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>

  <i class="ace-icon fa fa-check green"></i>
    <strong class="green">
      <?php   echo $info;   ?>
    </strong>
</div>

<?php
}
?>

<div class="row">
  <div class="col-md-3">
  <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/uploads/<?php echo $foto; ?>" alt="User profile picture">
        <h3 class="profile-username text-center"><?php echo $name; ?></h3>
        <p class="text-muted text-center"><?php echo $status; ?></p>
        
        <a href="<?php echo base_url();?>home" class="btn btn-warning btn-block"><i class="fa fa-arrow-left pull-left"></i>Home</a>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  <!-- About Me Box -->
  </div><!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#activity" data-toggle="tab">Profil</a></li>
        <li><a href="#timeline" data-toggle="tab">Upload Foto</a></li>
        <li><a href="#settings" data-toggle="tab">Setting Password</a></li>
      </ul>
    <div class="tab-content">
      <div class="active tab-pane" id="activity">
        <form action="<?php echo base_url();?>admin/update-profil" method="POST" class="form-horizontal">
          <input type="hidden"  id="id" name="id"  value="<?php echo $user_id; ?>" class="form-control">
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" id="name" name="name"  value="<?php echo $name; ?>" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="email" id="email" name="email"  value="<?php echo $email; ?>" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Location</label>
            <div class="col-sm-10">
              <input type="text" id="location" name="location"  value="<?php echo $location; ?>" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputExperience" class="col-sm-2 control-label">Employe Type</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="employetype" name="employetype"  value="<?php echo $employetype; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputSkills" class="col-sm-2 control-label">Department</label>
            <div class="col-sm-10">
              <input type="text" id="department" name="department" class="form-control"  value="<?php echo $department; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputSkills" class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
              <input type="date" id="status_date" name="status_date" class="form-control"  value="<?php echo $status_date; ?>">
            </div>
          </div>
          <div class="footer">
            <div class="box-body">
              <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-save"></i> Save</button>
            </div>
          </div>
        </form>
      </div><!-- /.tab-pane -->
      <div class="tab-pane" id="timeline">
        <form action="<?php echo base_url(); ?>admin/upload" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <input type="hidden" value="<?php echo $user_id; ?>" class="form-control" name="id" id="id">
            </div>
            <!-- <img src="#" id="image-preview" alt=""> -->
            <div class="form-group">
                <input type="file" name="filefoto" id="image-source" onchange="previewImage();" class="form-control">
            </div>
                
                      
          </div><!-- /.box-body -->
          <div class="box-footer">
            <input type="submit" name="userSubmit" value="Add" class="btn btn-primary">
          </div>
        </form>
      </div><!-- /.tab-pane -->
      <div class="tab-pane" id="settings">
        <form action="<?php echo base_url();?>admin/changepassword" method="post" class="form-horizontal">
          <input type="hidden" name="id" id="id" value="<?php echo $user_id; ?>" class="form-control" >
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Old Password</label>
            <div class="col-sm-10">
              <input type="text" readonly name="password" value="<?php echo $password; ?>" class="form-control" >
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">New Password</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="newpassword" id="newpassword" placeholder="New Password">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Confirm Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" onchange="checkPassword();">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <div class="registrationFormAlert" id="divCheckPasswordMatch">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
            </div>
          </div>
        </form>
      </div><!-- /.tab-pane -->
      </div><!-- /.tab-content -->
    </div><!-- /.nav-tabs-custom -->
  </div><!-- /.col -->
</div><!-- /.row -->
<script>
  function checkPassword() {
    var password = $("#newpassword").val();
    var confirmPassword = $("#confirmpassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
    }

    $(document).ready(function () {
       $("#confirmpassword").keyup(checkPassword);
    });
</script>

<script>
  function previewImage() {
    document.getElementById("image-preview").style.display = "block";
    var oFReader = new FileReader();
     oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

    oFReader.onload = function(oFREvent) {
      document.getElementById("image-preview").src = oFREvent.target.result;
    };
</script>
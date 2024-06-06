<h1>Welcome to <?php echo $_settings->info('name') ?> - Admin Panel</h1>
<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3 dashboard_grid"  data-link='<?php echo base_url ?>?page=tests'>
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-vial"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Test List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `test_list` where `status` = 1 AND `delete_flag` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3 dashboard_grid"  data-link='<?php echo base_url ?>?page=doctors'>
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-navy elevation-1"><i class="nav-icon fa fa-user-md"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Doctor List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `doctor_list` WHERE `delete_flag` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3 dashboard_grid" data-link='<?php echo base_url ?>?page=patients'>
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Patient List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `patient_list` WHERE `delete_flag` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3 dashboard_grid" data-link='<?php echo base_url ?>?page=reports'>
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reports</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `report_list` WHERE `delete_flag` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-12 col-sm-12 col-md-6 col-lg-3 dashboard_grid" data-link='<?php echo base_url ?>?page=user/list'>
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="nav-icon fas fa-users-cog"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">User List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `users` WHERE `type` = 2")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
</div>
<hr>

<script>
$(document).ready(function(){

  $(".dashboard_grid").click(function(){
      var link = $(this).attr('data-link');
      window.location.href = link;
  });

});
</script>

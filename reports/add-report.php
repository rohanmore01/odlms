<?php
require_once('../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `report_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
    $test_ids = explode(',', $test_ids);
}
?>
<style>
	img#cimg{
		height: 17vh;
		width: 25vw;
		object-fit: scale-down;
	}
</style>
<div class="container-fluid">
    <form action="" id="patient-create-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
                  <div class="form-group col-md-6">
                  <select name="report_of" id="report_of" class="form-control form-control-sm form-control-border" required>
                  <option value="">Select Patient Name</option>
                  <?php
                    $getPatientName = $conn->query("SELECT id, name FROM `patient_list`");
                    while($row = mysqli_fetch_assoc($getPatientName))
                    {  ?>
                          <option <?= isset($report_of) && $report_of == $row['name'] ? 'selected' : "" ?> data-id="<?php echo $row['id']; ?>"><?= $row['name'] ?></option>
                    <?php } ?>
                    </select>
                      <small class="mx-2">Report of</small>
                      <input type="hidden" id="patient_id" name="patient_id" value="<?= isset($patient_id) ? $patient_id :"" ?>">
                  </div>
                  <div class="form-group col-md-6">
                      <input type="date" name="report_date" id="report_date" required class="form-control form-control-sm form-control-border" value="<?= isset($report_date) ? $report_date :"" ?>">
                      <small class="mx-2">Report Date</small>
                  </div>
        </div>
        <div class="row">
                    <div class="form-group col-md-6">
                      <input type="date" name="report_due_date" id="report_due_date" required class="form-control form-control-sm form-control-border" value="<?= isset($report_due_date) ? $report_due_date :"" ?>">
                      <small class="mx-2">Report Due Date</small>
                  </div>
                  <div class="form-group col-md-6">
                  <select name="ref_doctor" id="ref_doctor" class="form-control form-control-sm form-control-border" required>
                    <option value=""></option>
                  <?php
                    $getDoctorName = $conn->query("SELECT name FROM `doctor_list`");
                    while($row = mysqli_fetch_assoc($getDoctorName))
                    {  ?>
                          <option <?= isset($ref_doctor) && $ref_doctor == $row['name'] ? 'selected' : "" ?>><?= $row['name'] ?></option>
                    <?php } ?>
                      </select>
                      <small class="mx-2">Ref Doctor</small>   
                  </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="upload_report" name="upload_report" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="upload_report"><?= isset($uploaded_report_name) ? substr($uploaded_report_name,0,47) : "upload report"  ?></label>
		        </div> 
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
            <small class="mx-2">Select Tests</small>
                <select name="test_ids[]" id="test_ids" class="form-control form-control-border select2" placeholder="Enter appointment Name" multiple required>
                    <?php 
                    $tests = $conn->query("SELECT * FROM `test_list` where delete_flag = 0 and status = 1 order by `name` asc");
                    while($row= $tests->fetch_assoc()):
                    ?>
                    <option value="<?= $row['id'] ?>" <?= isset($test_ids) && in_array($row['id'],$test_ids) ? 'selected' : "" ?>><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    </form>
</div>
<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name.substring(0, 47))
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
            _this.siblings('.custom-file-label').html("Choose file")
        }
	}
    $(function(){

        $("#report_of").change(function(){
            var patientId = $(this).find(":selected").attr('data-id');
            $('#patient_id').val(patientId);
        });

        $('#uni_modal').on('shown.bs.modal',function(){
            $('#test_ids').select2({
                dropdownParent: $('#uni_modal'),
                width:'100%',
                placeholder:'Please Select Test(s) Here',
            })
        })

        $('#uni_modal #patient-create-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_report",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>
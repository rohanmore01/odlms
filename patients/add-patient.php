<?php
require_once('../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `patient_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
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
                      <input type="text" name="name" id="name" placeholder="Enter Patient Name" autofocus required class="form-control form-control-sm form-control-border" value="<?= isset($name) ? $name :"" ?>">
                      <small class="mx-2">Name</small>
                  </div>
                  <div class="form-group col-md-6">
                      <input type="number" name="mobile_no" id="mobile_no" placeholder="Enter Mobile No." required class="form-control form-control-sm form-control-border" value="<?= isset($mobile_no) ? $mobile_no :"" ?>">
                      <small class="mx-2">Mobile No.</small>
                  </div>
        </div>
        <div class="row">
                  <div class="form-group col-md-6">
                      <input type="email" name="email" id="email" placeholder="Enter Email" autofocus required class="form-control form-control-sm form-control-border" value="<?= isset($email) ? $email :"" ?>">
                      <small class="mx-2">Email</small>
                  </div>
                  <div class="form-group col-md-6">
                  <select name="gender" id="gender" class="form-control form-control-sm form-control-border" required>
                          <option <?= isset($gender) && $gender =='Male' ? 'selected' : "" ?>>Male</option>
                          <option <?= isset($gender) && $gender =='Female' ? 'selected' : "" ?>>Female</option>
                      </select>
                      <small class="mx-2">Gender</small>
                  </div>
        </div>
        <div class="row">
                  <div class="form-group col-md-6">
                  <input type="date" name="dob" id="dob" placeholder="(optional)" required class="form-control form-control-sm form-control-border"  value="<?= isset($dob) ? $dob :"" ?>">
                      <small class="mx-2">Date Of Birth</small>
                  </div>
                  <div class="form-group col-md-6">
                      <input type="text" name="address" id="address" placeholder="Enter Patient Address" autofocus required class="form-control form-control-sm form-control-border" value="<?= isset($address) ? $address :"" ?>">
                      <small class="mx-2">Address</small>
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
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
            _this.siblings('.custom-file-label').html("Choose file")
        }
	}
    $(function(){
        $('#uni_modal #patient-create-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_patient",
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
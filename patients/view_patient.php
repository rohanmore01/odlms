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
    #uni_modal .modal-footer{
        display:none;
    }
</style>
<div class="container-fluid">
    <div class="row">
            <dl>
                <dt class="text-muted">Patient Name</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($name) ? $name : 'N/A' ?></dd>
                <dt class="text-muted">Mobile No.</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($mobile_no) ? $mobile_no : 'N/A' ?></dd>
                <dt class="text-muted">Email</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($email) ? $email : 'N/A' ?></dd>
                <dt class="text-muted">Gender</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($gender) ? $gender : 'N/A' ?></dd>
                <dt class="text-muted">Birth Date</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($dob) ? $dob : 'N/A' ?></dd>
                <dt class="text-muted">Address</dt>
                <dd class='pl-4 fs-4 fw-bold'><?= isset($address) ? $address : 'N/A' ?></dd>
            </dl>
    </div>
   
    <div class="text-right">
        <button class="btn btn-dark btn-sm btn-flat" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
    </div>
</div>

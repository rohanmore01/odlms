<?php 

if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `report_list` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }

    $qry = $conn->query("SELECT `name`, `mobile_no`, `email`, `gender`, `dob`, `address` FROM `patient_list` WHERE id = '{$patient_id}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>

<div class="content py-5">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h4 class="card-title"><b>Reports Details</b></h4>
            <div class="card-tools">    
                <button class="btn btn-default bg-gradient-navy btn-flat btn-sm" type="button"><form method='POST' action='reports/download_report.php' target='_blank'> <input type="hidden" value="<?php echo $uploaded_report ?>" name="uploaded_report"> <input type="hidden" value="<?php echo $uploaded_report_name ?>" name="uploaded_report_name"><a  onclick='this.parentNode.submit();' href=""  title="Report Download" style="color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
  <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
</svg></a></form></button>
                
                <button class="btn btn-primary btn-flat btn-sm" type="button" id="edit_data"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-danger btn-flat btn-sm" type="button" id="delete_data"><i class="fa fa-trash"></i> Delete</button>
                <a class="btn btn-default border btn-flat btn-sm" href="./?page=reports" id="delete_data"><i class="fa fa-angle-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid" id="outprint">
                <div class="row">
                    <div class="col-2 border bg-gradient-primary text-light">Patient Name</div>
                    <div class="col-4 border"><?= isset($report_of) ? $report_of :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Mobile No.</div>
                    <div class="col-4 border"><?= isset($mobile_no) ? $mobile_no :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Email</div>
                    <div class="col-4 border"><?= isset($email) ? $email :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Gender</div>
                    <div class="col-4 border"><?= isset($gender) ? $gender :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Birth Date</div>
                    <div class="col-4 border"><?= isset($dob) ? $dob :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Ref Doctor</div>
                    <div class="col-4 border"><?= isset($ref_doctor) ? $ref_doctor :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Report Date</div>
                    <div class="col-4 border"><?= isset($report_date) ? $report_date :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Report Due Date</div>
                    <div class="col-4 border"><?= isset($report_due_date) ? $report_due_date :"" ?></div>
                    <div class="col-2 border bg-gradient-primary text-light">Address</div>
                    <div class="col-10 border"><?= isset($address) ? $address :"" ?></div>
                </div>
                <hr>
                <fieldset>
                    <legend class="text-muted">List of Tests</legend>
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col width="10%">
                            <col width="45%">
                            <col width="45%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-primary text-light">
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            if(isset($test_ids)):
                            $tests = $conn->query("SELECT* FROM `test_list` where id in (".$test_ids.") order by name asc");
                            $totalTestCost = 0;
                            while($row= $tests->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="py-1 px-2 text-center"><?= $i++; ?></td>
                                <td class="py-1 px-2"><?= $row['name'] ?></td>
                                <td class="py-1 px-2 text-right"><?= number_format($row['cost'],2) ?></td>
                            </tr>
                            <?php
                            $totalTestCost += $row['cost'];
                            endwhile; ?>
                            <tr>
                               <td colspan="2" style="text-align:center;" class="py-1 px-2 text-danger">Total</td>
                               <td class="py-1 px-2 text-danger" style="text-align:right;"><?= number_format($totalTestCost,2); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#delete_data').click(function(){
			_conf("Are you sure to delete this Report?","delete_report",['<?= isset($id) ? $id : '' ?>'])
		})
        $('#edit_data').click(function(){
			uni_modal("Update Report Details","reports/add-report.php?id=<?= isset($id) ? $id : '' ?>",'mid-large')
		})
    })
    function delete_report($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_report",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.href="./?page=reports";
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
<?php
	main_header(['dashboard']);	
	// var_dump($prod_details);
?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
	<div class="row">		
		<div class="box box-body">
			<a class="btn btn-primary pull-right" href="<?=@base_url().'dashboard'?>" id=""> <i class="fa fa-arrow-left"></i>	Back</a>
			<h2><?=@$user_details->first_name.' '.@$user_details->middle_name.' '.@$user_details->last_name.' - Account'?></h2>
				<div class="row">
                    <div class="col-md-6">
						<form role="form">
							<div class="form-group">
								<label class="bold-font">Employee ID:	</label>
								<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->employee_no?>" >
							</div>
						</form>
						<form role="form">
							<div class="form-group">
								<label class="bold-font">Employee name:	</label>
								<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->first_name.' '.@$user_details->middle_name.' '.@$user_details->last_name?>" >
							</div>
						</form>
						<div class="col-md-6">
							<form role="form">
								<div class="form-group">
									<label class="bold-font">Gender:	</label>
									<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->gender?>" >
								</div>
							</form>
							</div>
							<div class="col-md-6">
							<form role="form">
								<div class="form-group">
									<label class="bold-font"> Birthday:	</label>
									<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->birthday?>" >
								</div>
							</form>
						</div>
						<div class="col-md-6">
							<form role="form">
								<div class="form-group">
									<label class="bold-font">Contact #:	</label>
									<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->contact_number?>" >
								</div>
							</form>
							</div>
							<div class="col-md-6">
							<form role="form">
								<div class="form-group">
									<label class="bold-font"> Account created:	</label>
									<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->created_at?>" >
								</div>
							</form>
						</div>
						<form role="form">
							<div class="form-group">
								<label class="bold-font">Employee address:	</label>
								<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->blk_door.' '.@$user_details->street.', '.@$user_details->brgy.', '.@$user_details->citynum.', '.@$user_details->province?>" >
							</div>
						</form>
                    </div>
                    <div class="col-md-6">
						<form role="form">
							<div class="form-group">
								<label class="bold-font"> Position:	</label>
								<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->designation?>" >
							</div>
						</form>
						<form role="form">
							<div class="form-group">
								<label class="bold-font"> Account name:	</label>
								<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->account_name?>" >
							</div>
						</form>
						<form role="form">
							<div class="form-group">
								<label class="bold-font"> Department:	</label>
								<input type="text" class="form-control" data-field="" disabled value="<?=@$user_details->department?>" >
							</div>
						</form>
					
                    </div>
                </div>			
									
		</div>		
	<div class="row">		
		<div class="col-md-12">
			<div class="box box-body">
			<h2>Employee salary</h2>
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<table class="table m-b-none border-in-table" ui-jp="footable" data-filter="#filter" data-page-size="20">   
							<thead>                            
								<tr>
									<th >No classes</th>
									<th >Hourly rate</th>
									<th >No of hours</th>
									<th >Total earned </th>
									<th >Datetime encoded </th>
								</tr>
							</thead>
							<tbody id="employee_salary">

							</tbody>
							<tfoot class="hide-if-no-paging">
							<tr>
								<td colspan="5" class="text-center">
									<ul class="pagination"></ul>
								</td>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>		
				</div>									
		</div>		
	</div>			
	<div class="row">		
		<div class="col-md-12">
			<div class="box box-body">
			<h2>Transaction Logs</h2>
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<table class="table m-b-none border-in-table" ui-jp="footable" data-filter="#filter" data-page-size="20">   
							<thead>                            
								<tr>			
									<th >Transaction No</th>
									<th >Salary Cycle</th>
									<th >Date coverage</th>
									<th >Datetime created </th>
									<th >Option </th>

								</tr>
							</thead>
							<tbody id="transaction-list">

							</tbody>
							<tfoot class="hide-if-no-paging">
							<tr>
								<td colspan="5" class="text-center">
									<ul class="pagination"></ul>
								</td>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>		
				</div>									
		</div>		
	</div>		
</div>

<!-- ############ PAGE END-->
<?php
	main_footer();
?>
<script>

$(document).ready(function() {
	credit_load();
	employee_salary();
});
	
var credit_load = () =>{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const token = urlParams.get('token')

    $.ajax({
        url: baseUrl + 'dashboard/list-transaction',
        type: "POST",
        data: {
            token : token
        },
    }).always(function(e) {
        $('#transaction-list').html(e);
    });
}

var employee_salary = () =>{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const token = urlParams.get('token')

    $.ajax({
        url: baseUrl + 'dashboard/employee_salary',
        type: "POST",
        data: {
            token : token
        },
    }).always(function(e) {
        $('#employee_salary').html(e);
    });
}

</script>
<script src="<?php echo base_url()?>assets/js/dashboard/index.js"></script>
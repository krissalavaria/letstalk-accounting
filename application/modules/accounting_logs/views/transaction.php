<?php
	main_header(['accounting_logs']);	
	@$token = $_GET['token'];
	@$cycleID = $_GET['cycleID'];

	// var_dump($cycleID);

?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
	<div class="row">		
		<div class="box box-body">
			<a class="btn btn-primary pull-right" href="<?=@base_url().'accounting_logs/open-employee?token='.$token?>" id=""> <i class="fa fa-arrow-left"></i>Back</a>
			<h3><?=@$user_details->first_name.' '.@$user_details->middle_name.' '.@$user_details->last_name.' - Accounting Logs / Transaction'?></h3>
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
			<button class="btn btn-danger pull-right" id="rollback" value="<?=@$cycleID?>"> <i class="fa fa-repeat"></i>	Roll back</button>
			<h2>Orderlist / Transaction No: <?=@$cycleID?></h2>
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<table class="table m-b-none border-in-table" ui-jp="footable" data-filter="#filter" data-page-size="20">   
							<thead>                            
								<tr>			
									<th >Order Status</th>
									<th >Order No</th>
									<th >Subtotal</th>
									<th >Datetime created </th>
									<th >Option </th>

								</tr>
							</thead>
							<tbody id="order-list">

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
$(document).ready(function(){
	orderlist();
})
var orderlist = () =>{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const token = urlParams.get('token')

    $.ajax({
        url: baseUrl + 'accounting_logs/orderlist',
        type: "POST",
        data: {
            token : token
        },
    }).always(function(e) {
        $('#order-list').html(e);
    });
}

$(document).on('click', '#rollback', function(){
	var cycle_id = $(this).val();

	if (confirm('Are you sure you want to roll back this transaction no <?=@$cycleID?>?')) {
		$(document).gmPostHandler({
			url: 'accounting_logs/roll_back',
			data: {
				cycle_id : cycle_id
			},
			parameter: true,
            function_call: true,
            function: prompt,
			alert_on_error: false,
			errorsend: true,
			errorsend_function: [{
				function: error_connection,
				msg: "Please check your connection and try again."
			}],
			function_call_on_error: true,
			error_function: [{
				function: error,
				parameter: true,
			}]
		});
		} else {
				// Do nothing!
				alert('Sorry, Unable to proceed this action. Please try again!');
		}
})


function prompt(data){ 
	if(data.has_error){
		alert(data.message);
	}else{
		alert(data.message);
	}
    location.reload();
}

</script>
<!-- <script src="<?php echo base_url()?>assets/js/accounting_logs/index.js"></script> -->
<?php
	main_header(['accounting_logs']);	
?>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
	<div class="row">		
		<div class="col-md-12">
			<div class="box box-body">
			<h2>ALL EMPLOYEE'S</h2>		
				
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<table class="table m-b-none border-in-table" ui-jp="footable" data-filter="#filter" data-page-size="20">   
							<thead>                            
								<tr>			
									<th >Empl. No</th>
									<th >Empl. Name</th>
									<th >Department</th>
									<th >Designation</th>
									<th >Account Type</th>
									<th >Status</th>
									<th >Option</th>
								</tr>
							</thead>
							<tbody id="employee">
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

<!-- ############ PAGE END-->
<?php
	main_footer();
?>
<script src="<?php echo base_url()?>assets/js/accounting_logs/index.js"></script>

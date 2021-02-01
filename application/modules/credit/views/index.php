<?php
	main_header(['credit']);	
?>
<style>
.category-menu{
	height:100px;
	width:120px;
	margin-top:10px;
	margin-right:6px;
}
.item{
	height:100px;
	width:120px;
	margin-top:10px;
	margin-right:10px;
	white-space: unset;
}
.box-body{
	min-height: 80vh;
}

#total_row{
	font-size:20px;
	background-color: lightgreen;
}

#total{
	font-size:20px;
	font-weight:bold;
}
#display_total{
	margin-right:10px;
	background-color:green;
	color:white;
	padding: 4px;
}
</style>
<!-- ############ PAGE START-->
<link rel="stylesheet" href="<?= base_url()?>assets/css/global.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url()?>assets/css/tables.css" type="text/css" />
<div class="padding">	
	<div class="row order-row">	
		<div class="col-md-12">
			<div class="box box-body">
				<h3>EMPLOYEE CREDIT</h3>	
				<hr>
				
				<div class="row" >
					<div class="col-md-12">
						<table class="table m-b-none border-in-table" ui-jp="footable" data-filter="#filter" data-page-size="20">   
							<thead>                            
								<tr>			
									<th >Empl. no</th>
									<th >Empl. name</th>
									<th >Total Credit</th>
									<th >View</th>
								</tr>
							</thead>
							<tbody id="loademplcredit">
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
<script src="<?php echo base_url()?>assets/js/credit/index.js"></script>
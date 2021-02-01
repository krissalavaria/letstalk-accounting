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
			<h2> <b> ORDER NO:  <?=@$owner->order_no?> </b> / Order by : <?=@$owner->first_name.' '.@$owner->middle_name.' '.@$owner->last_name?></h2>		
				<div class="row">
					<table class="table m-b-none border-in-table" ui-jp="footable" data-filter="#filter" data-page-size="20">   
							<thead>                            
								<tr>			
									<th >Product</th>
									<th >Category</th>
									<th >Unit</th>
									<th >Qty</th>
									<th >Price</th>
									<th >Subtotal</th>
									<th >Create at</th>

								</tr>
							</thead>
							<tbody >
								<?php foreach($order as $key=>$value){?>
								<tr>
									<td><?=@$value->product_name?></td>
									<td><?=@$value->product_category_name?></td>
									<td><?=@$value->unit_name?></td>
									<td><?=@$value->qty?></td>
									<td><?=@$value->product_price?></td>
									<td><?=@$value->total_amount?></td>
									<td><?=@$value->datetime_created?></td>
								</tr>
								<?php }?>
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

<!-- ############ PAGE END-->
<?php
	main_footer();
?>
<script src="<?php echo base_url()?>assets/js/product-mngmt/index.js"></script>
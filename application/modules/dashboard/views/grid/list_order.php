<?php
    if(!empty($data)){
        $total = 0;
        foreach ($data as $key => $value) {
            $total+=$value->total_amount;
            ?>
                <tr>                    
                    <td> <b><?=@$value->order_no?></b> </td>
                    <td><?=@$value->total_amount?> </td>
                    <td><?=@$value->order_date?></td>
                    <td><a href="<?php echo base_url()?>dashboard/order?no=<?=@$value->order_no?>&token=<?=@$value->auth_token?>"><button class="btn btn-primary btn-sm">OPEN</button></a></td> 
                </tr>
            <?php
        }
        ?>
            <tr>                    
                <td> <b>TOTAL</b>  </td>
                <td><?=@$total?> </td>
                <td></td>
                <td></td> 
            </tr>
        <?php 
    }else{
        ?><tr>
            <td colspan="3"><div>
                <h5 style="color:red">No Data Found.</h5>
            </div></td>
        </tr><?php
    }
?>
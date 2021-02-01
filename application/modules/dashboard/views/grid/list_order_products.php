<?php
    if(!empty($data)){
        $total = 0;
        foreach ($data as $key => $value) {
            $total+=$value->total_amount;
            ?>
                <tr>                    
                    <td> <b><?=@$value->product_name?></b> </td>
                    <td><?=@$value->product_category_name?> </td>
                    <td><?=@$value->price?> </td>
                    <td><?=@$value->qty?></td>
                    <td><?=@$value->total_amount?></td>
                    <td><?=@$value->datetime_order?></td>
                </tr>
            <?php
        }
        ?>
            <tr>                    
                <td> <b>TOTAL</b>  </td>
                <td></td>
                <td></td> 
                <td></td> 
                <td><?=@$total?> </td>
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
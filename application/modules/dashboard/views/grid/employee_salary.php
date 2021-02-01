<?php
    if(!empty($data)){
        $total = 0;
        foreach ($data as $key => $value) {
            $total +=$value->total_amount;
            ?>
            <tr>
                <td><?=@$value->no_classes?></td>
                <td><?=@$value->hourly_rate?></td>
                <td><?=@$value->no_hours?></td>
                <td><?=@$value->total_amount?></td>
                <td><?=@$value->date_created?></td>

            </tr>
            <?php
        }
        ?>
            <tr>
                <td>Total Amount</td>
                <td></td>
                <td></td>
                <td><b><?='₱ '.@$total?></b> </td>
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
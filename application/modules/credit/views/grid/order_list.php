<?php
    if(!empty($data)){            
        $total = 0;
        foreach ($data as $key => $value) {
            ?>
            <tr>
                <td><span style="color:black; font-weight:bold;"><?=@$key + 1?></span>. <b><?=@$value->order_no?></b>  </td>
                <td><?=@$value->total_credit?></td>
                <td>
                    <a class="btn btn-primary btn-sm" href="<?php echo base_url()?>credit/orderno?view=<?=@$value->order_no?>">OPEN</a>
                </td>
            </tr>
            <?php
            $total += $value->total_credit;
        }
        ?>
        <tr>
            <td><span style="color:black; font-weight:bold;">TOTAL</td>
            <td><?=@$total?></td>
            <td><button class="btn btn-success btn-sm clearallcredit" value="<?=@$token?>">CLEAR ALL CREDIT</button></td>
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
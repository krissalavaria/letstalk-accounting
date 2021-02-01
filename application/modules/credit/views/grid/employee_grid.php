<?php
    if(!empty($credit_emp)){            
        $total = 0;

        foreach ($credit_emp as $key => $value) {
            $total += $value->total_credit;
            ?>
                <tr>
                    <td><span style="color:black; font-weight:bold;"><?=@$key + 1?></span>. <?=@$value->employee_no?></td>
                    <td><?=@$value->first_name.' '.@$value->middle_name.' '.@$value->last_name?></td>
                    <td><?=@$value->total_credit?></td>
                    <td><a href="<?php echo base_url()?>credit/view?token=<?=@$value->auth_token?>"><button class="btn btn-primary btn-sm">OPEN</button></a></td>
                </tr>
            <?php
        }
        ?>
        <tr>
            <td> <b></b> TOTAL</td>
            <td></td>
            <td> <b> <?=@$total?></b></td>
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
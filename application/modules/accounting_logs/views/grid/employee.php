<?php
    if(!empty($data)){

        foreach ($data as $key => $value) {
            ?>
            <tr>
                <td><span style="color:red; font-weight:bold;"><?=@$value->employee_no?></span> </td>
                <td><?=@ucfirst($value->first_name).' '.@$value->last_name?></td>
                <td><?=@$value->department?></td>
                <td><?=@$value->designation?></td>
                <td><?=@$value->account_name?></td>
                <td><?=@empty($value->deleted_at)?'ACTIVE':'NOT ACTIVE';?></td>
                <td><a href="<?php echo base_url()?>accounting_logs/open-employee?token=<?=@$value->auth_token?>"><button class="btn btn-primary btn-sm">OPEN</button></a></td> 
            </tr>
            <?php
        }

    }else{
        ?><tr>
            <td colspan="3"><div>
                <h5 style="color:red">No Data Found.</h5>
            </div></td>
        </tr><?php
    }
?>
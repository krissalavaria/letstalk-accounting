<?php
    if(!empty($data)){

        foreach ($data as $key => $value) {
            $filled_int = @sprintf("%09d", $value->Cycle_id)
            ?>
                <tr>                    
                    <td><?=@$filled_int?></td>
                    <td><?=@$value->type?></td>
                    <td><?=@$value->cycle_date?>--<?=@$value->cycle_date_end?> </td>
                    <td><?=@$value->created_at?></td>
                    <td><a href="<?php echo base_url()?>accounting_logs/transaction?token=<?=@$value->auth_token?>&cycleID=<?=@$filled_int?>"><button class="btn btn-primary btn-sm">OPEN</button></a></td> 
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
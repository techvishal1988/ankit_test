<div class="table-responsive">
             <?php // echo '<pre />'; print_r($staff); ?>
    <table class="table table-bordered" id="rtt">
            <thead>
            <?php foreach($staff as $val)
            {
                foreach($val as $key=>$val) {
                ?>
                <th><?php echo str_replace('_',' ',$key) ?></th>
            <?php } 
                break;
                } ?>
                </thead>
                <tbody>
                    <?php 
                    foreach($staff as $stf) { 
                        echo '<tr>';
                        foreach($stf as $k=>$v) {?>
                        
                            <td><?php echo $stf[$k] ?></td>
                        
                    <?php  } echo '</tr>'; } ?>
                </tbody>
            
        </table>
        </div>


<div class="col-md-12 background-cls"  style="    padding-bottom: 60px;">
        <div class="mailbox-content">
            <div class="table-responsive" >
                <table class="table table-bordered" id="rtt">
                <?php if(count($report)>0) {?>
            <thead>
            <?php foreach($report as $val)
            {
                foreach($val as $key=>$val) {
                ?>
                <th><?php echo ucfirst(str_replace('_',' ',$key)) ?></th>
            <?php } 
                break;
                } ?>
                </thead>
                <tbody>
                    <?php 
                    foreach($report as $stf) { 
                        echo '<tr>';
                        foreach($stf as $k=>$v) {?>
                        
                            <td><?php echo $stf[$k] ?></td>
                        
                    <?php  } echo '</tr>'; } ?>
                </tbody>
            <?php } else { echo "<thead><tr><th></th></tr></thead><tbody><tr><td> No Record Found </td></tr></tbody>"; } ?>
        </table>
                </div>
        </div>
        
       
    </div>
<table class="table">
                        <thead>
                                <th>#</th>
                                
                                <th>Tooltip</th>
                        </thead>
                        <?php
                        $steps=json_decode(@$tooltipdesc[0]->step);
                        $k=1;
                        for($i=0;$i<=6;$i++)
                        {
                        ?>
                        <tr>
                            <td><?php echo $k ?></td>
                            
                            <td>
                                <div class="form-group">
                                   
                                    <textarea  class="form-control" id="description[]" name="description[]" placeholder="Enter description" ><?php echo @$steps[$i] ?></textarea>

                                </div>
                            </td>
                        </tr>
                        <?php $k++; } ?> 
                    </table> 
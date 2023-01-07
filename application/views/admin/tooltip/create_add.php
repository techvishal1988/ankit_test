<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        
        <li><a href="<?php echo base_url("admin/tooltip"); ?>">Tooltip</a></li>
        
        <li class="active">
            <?php
            if($tooltipdesc[0]->tooltip_page_id!='')
            {
                echo 'Edit tooltip';
            }
            else
            {
                echo 'Create tooltip';
            }
            ?>
            </li>
    </ol>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-8">
		<?php if(isset($tooltipdesc) and $tooltipdesc[0]->img_url !=""){?>
        	<img src="<?php echo base_url($tooltipdesc[0]->img_url); ?>" id="myImg" class="img-responsive" />
        <?php }else{ ?>
        	<img src="<?php echo base_url('assets/tooltips/salary_rule_1.jpg') ?>" id="myImg" class="img-responsive" />
        <?php } ?>
    </div>
    <div class="col-md-4">
        <div class="mailbox-content">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            <?php //echo '<pre />'; print_r($templatedesc); ?>
            <div class="panel-body pad_l_r_0" style="    height: 355px;">
                <?php echo @$this->session->flashdata('msg'); ?>
                <form class="form-horizontal" method="post" action="" id="frmtooltip" onsubmit="return checkVal();">
                	<?php echo HLP_get_crsf_field();?>
                    <?php //echo '<pre />'; print_r($pages); ?>
                    <div class="form-group mar_l_r_0">
                        <?php 
                            if(!empty($parentArray)){
                        ?>
                        <label class="wht_lvl" for ="temptile">Tooltip Section</label>
                        <select name="tooltip_parent_id" id="tooltip_parent_id" <?php if(@$updation=='yes'){echo 'disabled';} ?> class="form-control" onchange="show_child_for_tooltip(this.value);">
                                <option value="">Select</option>
                                <?php 
                                foreach($parentArray as $val){ 
                                    $psel = '';
                                    if(@$tooltipdesc[0]->group_id == $val['id'])
                                        $psel = 'selected';
                                ?>
                                <option <?=$psel;?> value="<?=$val['id'];?>"><?=$val['name'];?></option>
                                <?php } ?>
                        </select>
                        <?php } ?>
                    </div>
                    <div class="form-group mar_l_r_0">
                        <label class="wht_lvl" for ="temptile">Tooltip Page</label>
                        <select name="tooltip_page_id" id="ddl_tooltip_pages" class="form-control" <?php if(@$updation=='yes'){echo 'disabled';} ?> onchange="show_cols_for_tooltip();">
                            <option value="">Select page</option>
                            <?php 
                                if(@$updation=='yes'){
                                    foreach($pages as $p)
                                    {
                                        if(@$tooltipdesc[0]->tooltip_page_id == $p->tooltip_page_id)
                                        {
                                            $sel='selected';
                                        }
                                        else
                                        {
                                            $sel='';
                                        }
                                        echo '<option value="'.$p->tooltip_page_id.'" '.$sel.'>'.$p->description.'</option>';
                                    }
                                }    
                            ?>
                        </select>
                         </div>
                  <!--  <div class="form-group">
                        <label for ="Screen_No" style="color:#90999c !important">Screens</label>
                        <?php
                        if($tooltipdesc[0]->Screen_No==1)
                        {
                           $sc1="selected";
                        }
                         if($tooltipdesc[0]->Screen_No==2)
                        {
                           $sc2="selected";
                        }
                         if($tooltipdesc[0]->Screen_No==3)
                        {
                           $sc3="selected";
                        }
                         if($tooltipdesc[0]->Screen_No==4)
                        {
                           $sc4="selected";
                        }
                        ?>
                        <?php //if(@$updation=='yes'){echo '<input type="hidden" name="Screen_No" value="'.$tooltipdesc[0]->Screen_No.'" />';} ?>
                        <select name="Screen_No" class="form-control" <?php if(@$updation=='yes'){echo 'onchange="getdata(this.value)"';} ?>>
                            <option value="1" <?php echo $sc1; ?>>Screen 1</option>
                            <option value="2" <?php echo $sc2; ?>>Screen 2</option>
                            <option value="3" <?php echo $sc3; ?>>Screen 3</option>
                            <option value="4" <?php echo $sc4; ?>>Screen 4</option>
                            
                           
                        </select>
                         </div> -->
                    <hr />
                    <div id="res" style="padding-bottom: 5px;<?php if(@$updation){ } else { echo 'display: none';}?>">
                         <table class="table">
                        <thead>
                                <th>#</th>
                                
                                <th style="text-align:left !important;">Tooltip</th>
                        </thead>
                        <?php
                        $steps=json_decode(@$tooltipdesc[0]->step);
                        $k=1;
						$lp_cnt=0;
						if(isset($tooltipdesc))
						{
							$lp_cnt=$tooltipdesc[0]->no_of_columns;
						}
                        //for($i=0;$i<=9;$i++)
						for($i=0;$i<$lp_cnt;$i++)
                        {
                        ?>
                        <tr>
                            <td><?php echo $k ?></td>
                            
                            <td>
                                <div class="form-group">
                                   
                                    <textarea  class="form-control tinput" id="description[]" name="description[]" placeholder="Enter description" ><?php echo @$steps[$i] ?></textarea>

                                </div>
                            </td>
                        </tr>
                        <?php $k++; } ?> 
                    </table> 
                    </div>
                   
                    <?php 
                    if(isset($tooltipdesc))
                        {
                            $btn='Update';
                            $btn_name='update';
                        }
                        else
                        {
                            $btn='Save';
                            $btn_name='save';
                        }
                    ?>
                    <input id="btn_submit" type="submit" name="<?php echo $btn_name ?>" value="<?php echo $btn ?>" class="btn btn-primary pull-right save-btn" <?php if(@$updation){ } else { echo 'style="display: none"';}?>" />
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>
<?php foreach($pages as $p) {?>
<input type="hidden" id="hf_no_of_cols_<?php echo $p->tooltip_page_id; ?>" value="<?php echo $p->no_of_columns; ?>" />
<input type="hidden" id="hf_img_url_<?php echo $p->tooltip_page_id; ?>" value="<?php echo $p->img_url; ?>" />
<?php } ?>
<script>
function show_child_for_tooltip(pid){
    var ch_select = '<option value="">Select Page</option>';
    if(pid > 0){
        var pages = '<?php echo json_encode($pages);?>';
        pages = JSON.parse(pages);
        $.each(pages, function(key,val){
            if(val.group_id == pid) {
                ch_select += '<option value="'+val.tooltip_page_id+'">'+val.description+'</option>'
            }
        });
        $('#ddl_tooltip_pages').empty();
        $('#ddl_tooltip_pages').html(ch_select);
    } else {
        $('#ddl_tooltip_pages').empty();
        $('#ddl_tooltip_pages').html(ch_select);
        $('#res table tbody').empty();
        custom_alert_popup('Please select valid option.');
    }
    $('#btn_submit').hide();
    $('#res').hide();
    
}
function show_cols_for_tooltip()
{
	$("#loading").css('display','block');
	var base_url = "<?php echo base_url(); ?>";
	var id = $("#ddl_tooltip_pages").val();
	var loop_cnt = $("#hf_no_of_cols_"+id).val();
	var img_url = $("#hf_img_url_"+id).val();
	var str = "<table class='table'><thead><th>#</th><th style='text-align:left !important;'>Tooltip</th></thead>";
	var i=0;
    var counter = 0;
	for(i=0; i<loop_cnt; i++)
	{
		counter = 1;
		str += "<tr><td>"+ (i+1) +"</td><td><div class='form-group'><textarea class='form-control tinput' id='description[]' name='description[]' placeholder='Enter description'></textarea></div></td></tr>";
	}
	str += "</table>";

    if(counter == 1) {
        $('#btn_submit').show();
        $('#res').show();
    } else {
        $('#btn_submit').hide();
        $('#res').hide();
    }
    

	$('#res').html(str);
	if(img_url)
	{
		$("#myImg").attr("src", base_url + img_url);
	}
	$("#loading").css('display','none');
}
    function checkVal()
    {
        var pdata = $('#tooltip_parent_id').val();
        if(pdata.length > 0) {

            var childdrop = $('#ddl_tooltip_pages').val();

            if(childdrop.length > 0) {

                //var remove=$('[name="remove"]').val();
                var remove =false;
                var count=0;
                $('.tinput').each(function() {
                    //alert($.trim(this.value).length);
                    if( $.trim(this.value).length>0)
                    {
                        count++;
                    }
                });
                    
                if(count == 0)
                {
                    custom_alert_popup('Please fill atleast one text box.');
                    $('#loading').css('z-index','0').css('opacity','0.0 !important');
                } else {
                    if(request_confirm()) {
                        $('#loading').css('z-index','99999999').css('opacity','0.8 !important');
                        return true;
                    }
                    
                }
                return false;

            } else {
                $('#loading').css('z-index','0').css('opacity','0.0 !important');
                custom_alert_popup('Please select tooltip page first.');
                return false;
            }

            
        } else {
            $('#loading').css('z-index','0').css('opacity','0.0 !important');
            custom_alert_popup('Please select tooltip section first.');
            return false;
        }
    }

function getdata(id)
{
    $.ajax({
            url: "<?php echo base_url('admin/tooltip/ajaxscreen/'.$pageID) ?>/"+id,
          }).done(function(result) {
            $('#res').html(result);
          });
}
</script>
<style>
.save-btn { margin: 5px 0px;}
#res{
    overflow-y: scroll; height: 200px; overflow-x: hidden;
}
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.Imgmodal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 90%;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
} 

/* The Close Button */
.closeee {
   position: absolute;
    /* top: 15px; */
    right: 3%;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
    .close {
        top: 62px;
        right: 0px;
    }
}
</style>
<div id="myModalImg" class="Imgmodal">
  <span class="close closeee">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModalImg');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("closeee")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
};
modalImg.onclick = function() { 
    modal.style.display = "none";
}
</script>
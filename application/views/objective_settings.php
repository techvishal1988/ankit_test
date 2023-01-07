<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
    <div class="page-breadcrumb">
      <div class="container-fluid compp_fluid">
        <div class="row">
          <div class="col-sm-8 padl0">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url("objective-settings"); ?>"> Objective Settings</a></li>
          </ol>
          </div>
          <div class="col-sm-4"></div>    
       </div>
      </div>
    </div>
    <div id="main-wrapper">
      <div class="container-fluid compp_fluid">  
      <div class="row mb40">
        <div class="col-sm-12">
        <div class="panel panel-white pad_b_10">
         <div class="objective_sett">    
          <table class="table border" style="width:100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th>Data fields </th>
                            <th>Type of field</th>  
                            <th>Required</th>
                            <th>Mandatory</th>
                            <th>Objective editable </th>
                            <th>Editable by</th>
                            <th>Start date</th>
                            <th>Reminder date </th>
                        </tr>
                    </thead>
                    <tbody>                   
                        <tr>
                            <td>Linked to overall Strategic goals of the business</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Objectives</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Key Performance Indicator/ Measure of success</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Weighting</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td>
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Targets</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Status update</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Achievement Level for the performance period</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                        <tr>
                            <td>Comments (all comments should automatically get date stamp and edited by who tag)</td>
                            <td style="width: 100px;">
                                <select class="form-control">
                                  <option>Alpha</option>
                                  <option>Numeric</option>
                                  <option>Alpha-Numeric</option>
                                </select>
                            </td> 
                            <td class="text-center max_width100 v_aln_m">
                                <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                             <td class="text-center max_width100 v_aln_m">
                                 <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                            </td> 
                            <td style="width:200px;"> 
                              <select multiple="multiple" name="salary_type"  class="form-control multipleSelect"  multiple="multiple"   >
                                <option value='John'>John</option>
                                <option value='Gigs'>Gigs</option>
                                <option value='Egnis'>Egnis</option>
                                <option value='Peter'>Peter</option>
                              </select>
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="startdatepicker">
                            </td> 
                            <td class="max_width100">
                                <input class="form-control" type="text" id="reminderdatepicker">
                            </td> 
                        </tr> 

                    </tbody>
                   </table> 
                 </div> 
               </div>
              </div>
            </div>   
        </div>
       </div>
<style>
.table tr td span{color: #000;}
.fstMultipleMode {
    display: block;
}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstControls{line-height:17px;}
.fstMultipleMode .fstQueryInputExpanded {
    font-size: 12px; color: #000; padding-top: 0px;}
    .fstMultipleMode:after{top:4px;}
    .fstResultItem{margin-left:3px;}

</style> 
<script type="text/javascript">
$( function() {
 $( "#startdatepicker" ).datepicker();
 $( "#reminderdatepicker" ).datepicker();
} );

$('.multipleSelect').fastselect(); 

</script>      
</script>
       
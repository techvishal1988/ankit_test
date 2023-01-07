<div class="page-breadcrumb">
    <div class="col-md-4">
        <ol class="breadcrumb container">
            <li><a href="javascript:void(0)">Survey List</a></li>
           
        </ol>
    </div>
    
    
</div>

<style type="text/css">

.ur_all_survey .usersurvey_dg .catagory_name{ padding:3% 0%;text-align: center; background-color: #<?php echo $this->session->userdata("company_color_ses"); ?>;border-top-left-radius: 6px;     border-top-right-radius: 6px;}
.table>thead>tr>th{vertical-align: middle;}
</style>

<div id="main-wrapper" class="container">
<div class="row mb20">
    
    <div class="col-md-12">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            <?php // echo '<pre />'; print_r($survey); ?>
            <div class="panel-body">
               <div class="ur_all_survey"> 
                <div class="row">
                    <div class="col-sm-6">
                        <div class="usersurvey_dg">
                            <div class="catagory_name">
                                <label><h2>Ongoing Surveys </h2></label>
                            </div>
                            <div class="related_survey">
                             <?php $mys=0;if(isset($survey) && count($survey)>0) { ?>
                                <table class="table border" id="glossary">
                                    <thead>
                                    <th style="width:200px;">Name</th>
                                    <th>Last Date To Participate</th>
                                    <th>View</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($survey as $g){
                                            if(chkEmpSurvey($this->session->userdata('userid_ses'),$g['survey_id']) && ($g['is_published'] == 1) ) {
                                                $mys++;
                                            ?> 
                                        <tr>
                                            <td><span>
                                                <img class="sur_imgg" src="<?php if($g['survey_img']){ echo base_url($g['survey_img']);}else{ echo base_url("assets/img/no_photo.jpg");}?>">
                                                </span><?php echo $g['survey_name'] ?>
                                            </td>
                                            <td style="text-align:center;"><?= date('d-m-Y',strtotime($g['survey_end_dt'])); ?></td>
                                           
                                            <td style="text-align:center;">
                                                <a class="btn btn-primary" href="<?php echo base_url('survey/welcome/'.$g['survey_id']) ?>">Start</a>                                
                                            </td>
                                        </tr>
                                        <?php } }
                                            if($mys==0)
                                            {
                                              echo '<tr><td colspan="3">No survey found </td></tr>';  
                                            }
                                            ?>
                                    </tbody>
                                </table>
                              <?php } else {echo '<span style="color:#fff;">No survey found</span>';} ?>
                            </div>
                            <div></div>
                        </div>
                        <br/>
                    </div>
                    <?php ?><div class="col-sm-6">
                        <div class="usersurvey_dg">
                            <div class="catagory_name">
                                <label><h2>Completed surveys </h2></label>
                            </div>
                            <div class="related_survey">
                             <?php $mys=0;if(isset($survey) && count($survey)>0) { ?>
                                <table class="table border" id="glossary">
                                    <thead>
                                    <th style="width:200px;">Name</th>
                                    <th>Date of Completion</th>
                                    <th>View</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($survey as $g){
                                            if( (!chkEmpSurvey($this->session->userdata('userid_ses'),$g['survey_id'])) && ($g['is_published'] == 1) ) {
                                                $mys++;
                                            ?> 
                                        <tr>
                                            <td><span><img class="sur_imgg" src="<?php if($g['survey_img']){ echo base_url($g['survey_img']);}else{ echo base_url("assets/img/no_photo.jpg");}?>"></span><?php echo $g['survey_name'] ?></td>
                                            <td style="text-align:center;"><?= date('d-m-Y',strtotime($g['cutoff_date'])); ?></td>
                                            <td style="text-align:center;"> Result
                                                <!-- <a class="btn btn-primary" href="<?php //echo base_url('survey/user-survey-questions/'.$g['survey_id']) ?>">Result</a>                                 -->
                                            </td>
                                        </tr>
                                        <?php } }
                                            if($mys==0)
                                            {
                                              echo '<tr><td colspan="3">No survey found </td></tr>';  
                                            }
                                            ?>
                                    </tbody>
                                </table>
                              <?php } else {echo '<span style="color:#fff;">No survey found</span>';} ?>
                            </div>
                            <div></div>
                        </div>
                    </div><?php ?>
                </div>
               </div>

                
            </div>

             

        </div>
    </div>

</div>
</div>

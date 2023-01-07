<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery.barrating.js"); ?>"></script>

<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>

<?php 
  $checkdays = 0;
  if(isset($survey[0]['start_date']) && $survey[0]['start_date'] != '0000-00-00'){ 
      $date1=date_create($survey[0]['start_date']);
      $date2=date_create(date("Y-m-d"));
      $diff=date_diff($date1,$date2);
      $checkdays = $diff->format("%a"); 
  }
?>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?= base_url('survey');?>">Survey</a></li>
        <?php if(!empty($survey)) { ?>
        <li><a href="<?= base_url('survey/dashboard-analytics');?>">Dashboard</a></li>
        <?php } ?>
        <li class="active"> <?php echo (!empty($survey)) ? 'Update Survey':'Create Survey'; ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-white pad_b_10" >
     
        <section>
           
                   <div class="rank_response">
                       <br>
                    <div id="scale">
                        <div class="scale_response">                  
                        
                        </div>
                        
                        <br>
                        <h3 style="color:#fff;">Ranking</h3>
                        <h4 style="color:#fff;">Please Select Your Response according to the scale </h4>

                        <div class="row">
                           
                              <div class="col-sm-12">
                                  <div class="table-responsive">
                                        <div class="table-responsive"> 
                                            <table class="table_res table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th>Response</th>
                                                    <th>Very Important</th>
                                                    <th>Somewhat Important</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                         <div class="box box-example-1to10">
                                                             
                                                              <div class="box-body">
                                                                <select id="example-1to10" name="rating" autocomplete="off">
                                                                  <option value="1" selected="selected">1</option>
                                                                  <option value="2">2</option>
                                                                  <option value="3">3</option>
                                                                  <option value="4">4</option>
                                                                  <option value="5" >5</option>
                                                                </select>
                                                              </div>

                                                         </div>
                                                        </td>
                                                        <td>
                                                         <div class="box box-example-1to11">
                                                             
                                                              <div class="box-body">
                                                                <select id="example-1to11" name="rating" autocomplete="off">
                                                                  <option value="1">1</option>
                                                                  <option value="2">2</option>
                                                                  <option value="3" selected="selected">3</option>
                                                                  <option value="4" >4</option>
                                                                  <option value="5" >5</option>
                                                                </select>
                                                              </div>

                                                         </div>
                                                        </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                         <div class="box box-example-1to12">
                                                              <div class="box-body">
                                                                <select id="example-1to12" name="rating" autocomplete="off">
                                                                  <option value="1" selected="selected">1</option>
                                                                  <option value="2">2</option>
                                                                  <option value="3">3</option>
                                                                  <option value="4">4</option>
                                                                  <option value="5" >5</option>
                                                                </select>
                                                              </div>
                                                         </div>
                                                        </td>
                                                        <td>
                                                         <div class="box box-example-1to13">
                                                             
                                                              <div class="box-body">
                                                                <select id="example-1to13" name="rating" autocomplete="off">
                                                                  <option value="1">1</option>
                                                                  <option value="2" selected="selected">2</option>
                                                                  <option value="3">3</option>
                                                                  <option value="4">4</option>
                                                                  <option value="5" >5</option>
                                                                </select>
                                                              </div>

                                                         </div>
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

                    <div id="twodimentional">
                      
                      <div class="rank_response">
                       <br>
                      <h3 style="color:#fff;">Two Dimensional</h3>
                          <h4 style="color:#fff;">Please tick mark your Response </h4>
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="table-responsive">
                                        <div class="table-responsive"> 
                                            <table class="table_res table table-bordered">
                                                <thead>
                                                  
                                                  <tr>
                                                    <th>Response</th>
                                                        <th
                                                        style="width:140px;">Very Important</th>
                                                        <th style="width:140px;">
                                                        Somewhat Important</th>
                                                        <th style="width:140px;">Not Sure</th>
                                                        <th style="width:140px;">Not Now</th>
                                                        <th style="width:140px;">Not Important</th>
                                                        <th style="width:140px;">Not Yet</th> 
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                          <label><input type="radio" name="radio1" checked></label>
                                                        </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio1">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio1">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio1">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio1">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio1">
                                                        </label>
                                                      </div>
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       Agility
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio2">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio2">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio2">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio2">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio2">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio2">
                                                        </label>
                                                      </div>
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       
                                                       Analytical Skills
                                                       
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio3">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio3">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio3">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio3">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio3">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio3">
                                                        </label>
                                                      </div>
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       
                                                       Action Orientation
                                                       
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio4">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio4">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio4">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio4">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio4">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio4">
                                                        </label>
                                                      </div>
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                     <td>
                                                       Business Knowledge/Acumen
                                                      
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio5">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio5">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio5">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio5">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" name="radio5">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="radio" neme="radio5">
                                                        </label>
                                                      </div>
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                      Communication
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input  name="radior6" type="radio">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input  name="radior6" type="radio">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input  name="radior6" type="radio">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input  name="radior6" type="radio">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input  name="radior6" type="radio">
                                                        </label>
                                                      </div>
                                                        </td>
                                                        <td>
                                                        <div class="checkbox">
                                                        <label>
                                                          <input name="radior6" type="radio">
                                                        </label>
                                                      </div>
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

                    <div id="threedimentional">
                      
                      <div class="rank_response">
                       <br>
                      <h3 style="color:#fff;">Three Dimensional</h3>
                          <h4 style="color:#fff;">Please enter your Response </h4>
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="table-responsive">
                                        <div class="table-responsive"> 
                                            <table class="table_res table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th></th>
                                                        <th
                                                        style="width:140px;">Very Important</th>
                                                        <th style="width:140px;">
                                                        Somewhat Important</th>
                                                        <th style="width:140px;">Not Sure</th>
                                                        <th style="width:140px;">Not Now</th>
                                                        <th style="width:140px;">Not Important</th>
                                                        <th style="width:140px;">Not Yet</th> 
                                                  </tr>
                                                    <tr>
                                                    <th>Response</th>
                                                        <th
                                                        style="width:140px;">Very Important</th>
                                                        <th style="width:140px;">
                                                        Somewhat Important</th>
                                                        <th style="width:140px;">Not Sure</th>
                                                        <th style="width:140px;">Not Now</th>
                                                        <th style="width:140px;">Not Important</th>
                                                        <th style="width:140px;">Not Yet</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                       Adaptability
                                                       
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
                                                        </td>
                                                        <td>
                                                          <input type="text" name="">
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
        </section>
      </div>
    </div>
  </div>
</div>


<div style="height:250px;"></div>
<!-- Image popup -->
<div id="img_preview" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Preview</h4>
      </div>
      <div class="modal-body">
        <img id="pop_image_preview" style="width: 100%;" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
    /******new css start here********/
.newRow{position: relative;} 
.newRow .det_dyn_btn{text-align:center; padding:3px 6px; position: absolute; right: 17px; top: 2px; background-color: #e8e8e8 !important; }
.newRow .det_dyn_btn i{ color: #000; margin-left:0px;}
 .control-label.grey{background-color: #e8e8e8 !important;}

    #statusbar .label{display: none !important;}
    #mylaunchorsave.modal{
        background-color: rgb(0, 0, 0, .8);}


    .action_view_btn{display: block; width: 100%;}
    .action_view_btn .btn{width: 150px;
        padding: 9px 10px;
        margin-left: 10px;}
    .wizard {
        margin: 0px auto;
        /*background: #fff;*/
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 36%;
        z-index: 1;
    }

    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 70px;
        height: 70px;
        line-height: 70px;
        display: inline-block;
        border-radius: 100px;
        background: #fff;
        border: 2px solid #afafaf;
        background-color: #afafaf;
        z-index: 2;
        position: absolute;
        left: 0px;
        text-align: center;
        font-size: 20px;
    }
    span.round-tab i{
        color:#fff;
    }

  /*  .wizard li.active span.round-tab {
        background: #31b0d5;
        border: 3px solid #31b0d5;
        
    }*/

   /*  .wizard li.active span.round-tab i{
       color: #576a7a;
   } */

    .wizard li.active span.round-tab i{
        color: #fff;
    }

    /*span.round-tab:hover {
        color: #576a7a;
        border: 2px solid #576a7a;
    }
    */
    .wizard li span.round-tab:focus{background:transparent; }

    .wizard .nav-tabs > li {
        width: 20%;
    }

    .wizard .nav-tabs > li{text-align: center;}

    .wizard .nav-tabs > li p{
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        font-family: 'Lato', Arial, Helvetica, sans-serif;
        background:transparent;
        padding: 0px; 
        color: #fff;
    }


    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #fff;
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 43%;
        opacity: 1;
        margin: 0 auto;
        bottom: 1px;
        border: 15px solid transparent;
        border-bottom-color: #31b0d5;
    }

    .wizard .nav-tabs > li a {
        width: 70px;
        height: 70px;
        margin: 12px auto;
        border-radius: 100%;
        padding: 0;
        background-color:transparent !important;
        border:0px; 
    }

        .wizard .nav-tabs > li a:hover {
            background: transparent;
        }

    .wizard .tab-pane {
        position: relative;
        /*padding-top: 20px;*/
    }

    .wizard h3 {
        margin-top: 0;
    }

    .tab-content{    background-color: #fff;
        
    }


    .wizard .form-horizontal .Editor-editor{color: #555;}

    @media( max-width : 585px ) {

        .wizard {
            width: 90%;
            height: auto !important;
        }

        span.round-tab {
            font-size: 16px;
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .wizard .nav-tabs > li a {
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .wizard li.active:after {
            content: " ";
            position: absolute;
            left: 35%;
        }
    }
    
    /* Harshit*/
    .wizard li.pre-active span.round-tab {
        border: 3px solid #31b0d5;
        background: #31b0d5;
        
    }
    .wizard li.pre-active span.round-tab i{
        color: #fff;
    }
    .mt-10{
        margin-top: 10px;
    }
    /******new css ends here********/

    #txt_cutoff_dt{
        margin-bottom: 0px;
    }
    .red{
      color: red;
    }

    .footer {
            margin: auto !important;
    }

    .form-horizontal .Editor-editor{color: #fff;}
    /*.panel-body.area{padding:0px 20px 20px 20px; }*/
    .form-control.sur_img_area{position: relative;}
    #preview_img{width:30px; min-height: 31px; max-height: 31px; position: absolute; top:1%; right: -3%;}
    .left_div{padding-right:2%;}
    .right_div{padding-left:2%;}
    /*.black{color: unset !important;}*/
    .form-horizontal .form-control{margin-bottom: 0px;}

    .fstMultipleMode { display: block; }
    .fstMultipleMode .fstControls {width:25.7em; }

    .my-form{background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
    <!--.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;--> <!--shumsul-->
    border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
    .fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
    border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
    .fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
    .fstResultItem{ font-size:1em;}
    .fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}

    .fstResults{ position:relative !important;}

    .form_head ul{ padding:0px; margin-bottom:0px;}

    .form_head ul li{ display:inline-block;}

    .form-group {
        margin-bottom: 10px;
    }
    .control-label {
        line-height:42px;
        font-size: 11.25px;
        <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
        background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?> !important;
        color: #000;
        margin-bottom:10px;
    }

    .form_head {
        background-color: #f2f2f2;
        <?php /*?>border-top: 8px solid #93c301;<?php */?>
        border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
    }
     .form_head .form_tittle {
        display: block;
        width: 100%;
    }
    .form_head .form_tittle h4 {
        font-weight: bold;
        color: #000;
        text-transform: uppercase;
        margin: 0;
        padding: 12px 0px;
        margin-left: 5px;
    }
    .form_head .form_info {
        display: block;
        width: 100%;
        text-align: center;
    }
    .form_head .form_info i {
        color: #8b8b8b;
        font-size: 24px;
        padding: 7px;
        margin-top:-4px;
    }   
    .form_head .form_info .btn-default {
        border: 0px;
        padding: 0px;
        background-color: transparent!important;
    }
     .form_head .form_info .tooltip {
        border-radius: 6px !important;
    }
    .salary_rt_ftr .form_sec {
        background-color: #f2f2f2;
        margin-bottom: 0px;
        display: block;
        width: 100%;
        padding:20px;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
    }
    .head h4{ margin:0px;}
    .padd{ padding:10px 20px 0px 20px !important; }

    .panel-group{margin-bottom: 10px;}

    .panel-body.area {
        padding: 10px 30px 0px 30px;
    }

    .white, .black{color: unset !important;}

    table.cust_p_p{}
    table.cust_p_p thead th.nobor, table.cust_p_p tbody td.nobor{border-right:0px !important;}
</style>



<script>

    var category_id = ("<?php echo $survey[0]['category_id']; ?>");
    //alert( category_id);
    reset_token();
    function reset_token() {
    $('#loading').show();
        $.ajax({
            url: '<?Php echo site_url('dashboard/get_crsf_field'); ?>',
            type: 'GET',
            success: function (res) {
              console.log('========',res);
                $('input[name=csrf_test_name]').val(res);
                $("#loading").hide();
            }
        });
    }



    $( function() {
        //console.log('test ',$('input[name=csrf_test_name]').val());
    var availableTags = [];

    $.ajax("<?php echo site_url("survey/getQuestion"); ?>", {
      type: 'POST',  // http method
      data: {'csrf_test_name':$('input[name=csrf_test_name]').val() },  // data to submit
      async:false,
      beforeSend: function(jqXHR, settings){
        
            },
      success: function (data, status, xhr) {
        //console.log(data);
         var obj = JSON.parse(data);
         //console.log(obj);
         for(var i=0;i<obj.length;i++){
          availableTags.push(obj[i].QuestionName);
         }
        
      },
      error: function (jqXhr, textStatus, errorMessage) {
        console.log('error');
        
      },complete:function(){

      }
    });

    //return false;
    reset_token();
    if(category_id==1){
        $( "#question_name" ).autocomplete({
          source: availableTags,
          autoSelectFirst:true
        });
    }

  });
    
 
$(document).ready(function(){
    $('#qustiontypeoption').on('change', function() {
        $("#ranking,#matrix,#subQuestionOuterSection,#rankingSection,#scale,#rankingSection").show();
        $('#QuestionTitle').val('');
        $('.both').hide(); 
        $('.newRow').remove();
        $('.ans_value').each(function(k,v){
            $(this).val('');
        });
        if ( this.value == '1' || this.value == '2' || this.value == '3')
        {
        
        }
        if ( this.value == '1'){

        }else if ( this.value == '2'){
        $('.both').show();
        $('.answers').hide(); 
        }else if ( this.value == '3'){
            $('.both, .answers').show(); 
        }else if ( this.value == '4')
        {
            $("#rankingSection").show();
            $("#subQuestionOuterSection").show();
            $('.answers').hide();
        }
        else if ( this.value == '5')
        {
            $("#subQuestionOuterSection").show();
            $('.answers').show(); 
        }
        else if ( this.value == '6')
        {
            var arr = [ "Dissatisfied", "Somewhat Satisfied" ,"Very Satisfied " ,"ExtremelySatisfied"]
            ratingDisable();
            ratingEnable();
            $("#subQuestionOuterSection").show();
            $('.answers').show(); 
        }else if ( this.value == '7'){
            $("#subQuestionOuterSection").show();
            $('.answers').show(); 
        }

    });
});
    function remove(obj){
        var optionId = $(obj).attr('rid');
        $('#header'+optionId).remove();
        $('#body'+optionId).remove();
        $(obj).parent().parent().remove();
        //alert();
    }
    function addMore(obj){
        var optionId = $(obj).attr('rid');
        var nextOption = (parseInt(optionId)+1);
        var option_value = "";
        //alert($('#qustiontypeoption').val());
        if($('#qustiontypeoption').val() == '4'){
            //option_value = "Rank "+nextOption;
            var rankHtml = '<th class="newRow" id="header'+nextOption+'">Rank '+nextOption+'</th>';
            var rankBody = '<td class="newRow" id="body'+nextOption+'"><input type="text" name="rankRespose[]" class="form-control" id="exampleInputEmail1" placeholder="Response no."></td>';
            $('#rankHeader').append(rankHtml);
            $('#rankBody').append(rankBody);
        }

        if($('#qustiontypeoption').val() == '6'){
           // option_value = "Option "+nextOption;
            var rankHtml = '<option class="newRow" value="'+option_value+'">'+option_value+'</option>';
            //var rankBody = '<td class="newRow" id="body'+nextOption+'"><input type="text" name="rankRespose[]" class="form-control" id="exampleInputEmail1" placeholder="Response no."></td>';
            $('#example-movie').append(rankHtml);
            //$('#example-movie').barrating('set', 2);
            //$('#example-movie').barrating();
            ratingDisable();
            ratingEnable();
            // $('#example-movie').barrating('show', {
            //theme: 'bars-movie'
            //});
            //$('#rankBody').append(rankBody);
        }
        
        var html = '<div class="col-md-6 newRow">'
        html += '<div class="form-group my-form">'
        html += '<label class="col-sm-4 col-xs-12 control-label grey removed_padding white black" for="QuestionName"> Response '+nextOption+'</label>';
        html += '<div class="col-sm-8 col-xs-12 form-input removed_padding">';
        html += '<input required="true" rid="'+nextOption+'" type="text" id="survey_name'+nextOption+'" name="answer[]" value="'+option_value+'" placeholder="Enter question name" class="form-control answare" maxlength="1000">';
        html += '</div>'; 
        html +='<button type="button" rid="'+nextOption+'" onclick="remove(this)" class="btn det_dyn_btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        html += '</div>';
        html += '</div>';
        $(obj).attr('rid',nextOption);
        $('#optionSection').append(html);
    }

    function addMoreQuestion(obj){
        //alert();
        var optionId = $(obj).attr('rid');
        var nextOption = (parseInt(optionId)+1);
        var option_value = "";
        //alert($('#qustiontypeoption').val());
        // if($('#qustiontypeoption').val() == '4'){
        //     option_value = "Rank "+nextOption;
        //     var rankHtml = '<th class="newRow" id="header'+nextOption+'">Rank '+nextOption+'</th>';
        //     var rankBody = '<td class="newRow" id="body'+nextOption+'"><input type="text" name="rankRespose[]" class="form-control" id="exampleInputEmail1" placeholder="Response no."></td>';
        //     $('#rankHeader').append(rankHtml);
        //     $('#rankBody').append(rankBody);
        // }

        // if($('#qustiontypeoption').val() == '6'){
        //     option_value = "Option "+nextOption;
        //     var rankHtml = '<option class="newRow" value="'+option_value+'">'+option_value+'</option>';
        //     //var rankBody = '<td class="newRow" id="body'+nextOption+'"><input type="text" name="rankRespose[]" class="form-control" id="exampleInputEmail1" placeholder="Response no."></td>';
        //     $('#example-movie').append(rankHtml);
        //     //$('#example-movie').barrating('set', 2);
        //     //$('#example-movie').barrating();
        //     ratingDisable();
        //     ratingEnable();
        //     // $('#example-movie').barrating('show', {
        //     //theme: 'bars-movie'
        //     //});
        //     //$('#rankBody').append(rankBody);
        // }
        
        var html ='<div class="col-md-6 newRow">';
        html +='<div class="form-group my-form">';
        html +='<label class="col-sm-4 col-xs-12 control-label grey removed_padding"  for ="temptile" > Sub Question '+nextOption+'</label>';
        html +='<div class="col-sm-8 col-xs-12 form-input removed_padding">';
        html +='<input type="text" id="subQuestion" name="subQuestion[]" placeholder="Enter Sub Question" class="form-control"/>';
        html +='</div>';
          html +='<button type="button" rid="'+nextOption+'" onclick="remove(this)" class="btn det_dyn_btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        html +='</div>';
        html +='</div>';

        // var html = '<div class="col-md-6 newRow">'
        // html += '<div class="form-group my-form">'
        // html += '<label class="col-sm-4 col-xs-12 control-label grey removed_padding white black" for="QuestionName"> Response '+nextOption+'</label>';
        // html += '<div class="col-sm-8 col-xs-12 form-input removed_padding">';
        // html += '<input required="true" rid="'+nextOption+'" type="text" id="survey_name'+nextOption+'" name="answer[]" value="'+option_value+'" placeholder="Enter question name" class="form-control answare" maxlength="1000">';
        // html += '</div>'; 
        // html +='<button type="button" rid="'+nextOption+'" onclick="remove(this)" class="btn det_dyn_btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        // html += '</div>';
        // html += '</div>';
        $(obj).attr('rid',nextOption);
        $('#subQuestionSection').append(html);
    }

    //frequency_dependent_on
    $(document).ready(function(){
        $( "#txt_cutoff_dt" ).datepicker({ 
            dateFormat: 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
        });

        var sry_type = '<?php echo $survey[0]['survey_type']; ?>';
        if(sry_type == '<?php echo CV_SURVEY_TYPE_PERIODIC;?>'){
            $('.type_periodic').css('display','block');
            $('.opt_periodic').attr('required',true);
        } else{
            $('.type_periodic').css('display','none');
            $('.opt_periodic').removeAttr('required');
        }

        $( "#start_dt" ).datepicker({ 
            dateFormat: 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            minDate: 0
            // yearRange: "1995:new Date().getFullYear()",
        }); 

        $('#survey_type').change(function(){
            var type = this.value;
            if(type == '<?php echo CV_SURVEY_TYPE_PERIODIC;?>') {
                $('.type_periodic').css('display','block');
                $('.opt_periodic').attr('required',true);
            } else {
                $('.type_periodic').css('display','none');
                $('.opt_periodic').removeAttr('required');
            }
        });

        $('#surevy_open_periods').change(function(){
            var sop = $(this).val();
            if(sop == 0) {
                $(this).val('');
            } else {
                var survey_status = '<?php echo $survey[0]['is_published'];?>';
                if(survey_status) {
                    var start_date = '<?php echo $survey[0]['start_date'];?>'.split("-");
                    var f = new Date(start_date[1] + '/' + start_date[2]+'/'+start_date[0]);
                    var days = '<?php echo $survey[0]['surevy_open_periods'];?>';
                    var curdate = new Date();
                    var set_new_days = addDays(f,sop);
                    if (curdate >= set_new_days) {
                        $(this).val('');
                    }
                }
            }
        });

        $('#frequency_days').change(function(){
            var sop = $(this).val();
            if(sop == 0) {
                $(this).val('');
            }
        });

    });

    function addDays(startDate, numberOfDays) {
        return new Date(startDate.getTime() + (numberOfDays * 24 *60 * 60 * 1000));
    }

    function isNumber(evt,val) {
        var days_gt = "<?php echo $checkdays; ?>";
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if(parseInt(days_gt) > parseInt(val)){
            return false;
        }
        return true;
    }


    $(function(){
        $("#survey_image").change(function() {
            readURL(this);
        });

        $('#preview_img').click(function(){
            $('#pop_image_preview').attr('src',$(this).attr('src'));
            $('#img_preview').modal('show');
        });
    });

    function readURL(input) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif']; 
        if (input.files && input.files[0]) {

            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;

            if (isSuccess) { //yes
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview_img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
            else { 
                $("#survey_image").val('');
                $('#preview_img').attr('src', '');
                custom_alert_popup('Please select valid file type.');
            }    
        }
    }

   $('.multipleSelect').fastselect();
   $(document).ready(function(){
        var classcheck = $('.fstControls .fstQueryInput').hasClass('fstQueryInputExpanded');
        if(classcheck) {
            $('.fstControls .fstQueryInput').attr('required',true);
        }

        $('.fstControls .fstQueryInput').change(function(){
            var check_class = $(this).hasClass('fstQueryInputExpanded');
            if(!check_class) {
                $(this).removeAttr('required',true);
            }
        }); 
   });


    function hide_list(obj_id)
    {
        $(".dv_next").hide();
        $(".dv_confirm_selection").show();
        
        $('#'+ obj_id +' :selected').each(function(i, selected)
        {
            if($(selected).val()=='all')
            {
                $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
                {
                    //if($(this).attr("data-value")!= 'all')
                    //{
                        $(this).find(".fstChoiceRemove").trigger("click");
                    //}
                });
                show_list(obj_id);
                $("div").removeClass("fstResultsOpened fstActive");
            }
        });    
    }

    function show_list(obj)
    {
        $('#'+ obj ).siblings('.fstResults').children('.fstResultItem') .each(function(i, selected)
        {
            if($(this).html()!='All')
            {
                $(this).trigger("click");
            }
        });
    }

    function chkType(val)
    {
        console.log(val);
        if(val == 3) {
            $('.both, .answers').show(); 
            $('.req_two, .req_both').attr('required',true);
        } else if(val==5) {
            //$('.answers, .both').hide();
        }else if(val==1) {
            $('.req_two').attr('required',true);
            $('.answers').show();
            $('.req_both').removeAttr('required');
            $('.both').hide(); 
        } else {
            $('.req_two, .req_both').removeAttr('required');
            
        }
        //alert();
    }
    $(document).ready(function(){
        $('.inp_ans').blur(function(){
            let slen = this.value.trim();
            if(slen.length == 0){
                $(this).val('');
            }
        });
        $('#survey_name').blur(function(){
            let slen = this.value.trim();
            if(slen.length == 0){
                $(this).val('');
            }
        });
        $('#preview_img').click(function(){
            $('#pop_image_preview').attr('src',$(this).attr('src'));
            $('#img_preview').modal('show');
        });

        $('.aws_img_pre').click(function(){
           $('#pop_image_preview').attr('src',$(this).attr('src'));
            $('#img_preview').modal('show'); 
        });
    });

    $(function(){
        $("#question_image").change(function() {
            readURL(this);
        });

        $('.img_aws').change(function(){
            readAwsURL(this);
        });
    });

    function readAwsURL(input) {
        var str = input.id;
        var imgid = str.split("_");
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;

            if (isSuccess) { //yes
                var reader = new FileReader();
                reader.onload = function (e) {
                    var ans_preview = '#ansimg_pre' + imgid[1];
                    if($(ans_preview).length){
                        $(ans_preview).attr('src', e.target.result);
                    }else{
                        $(input).after('<img width="30" height="31" src="'+e.target.result+'" id="ansimg_pre'+ imgid[1] +'" class="aws_img_pre"  />');
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
            else { 
                $("#"+str).val('');
                $(ans_preview).attr('src', '');
                custom_alert_popup('Please select valid file type.');
            }
        }
        
    };

    function readURL(input) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif']; 
        if (input.files && input.files[0]) {

            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;

            if (isSuccess) { //yes
                var reader = new FileReader();
                reader.onload = function (e) {
                    if($('#preview_img').length){
                        $('#preview_img').attr('src', e.target.result);
                    }else{
                        $(input).after('<img width="30" height="31" src="'+e.target.result+'" id="preview_img" />');
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
            else { 
                $("#question_image").val('');
                $('#preview_img').attr('src', '');
                custom_alert_popup('Please select valid file type.');
            }

        }
    }

    function changeURL(url){
        window.location.replace(url);
    }
	
	
	<?php if(count($questions) > 0 and $question[0]['QuestionName'] !=''){ ?>
		setTimeout(show_q_edit_frm, 100);
		function show_q_edit_frm()
		{
            //alert();
			var q_id = '<?php echo $questionID; ?>'
			$("#td_q_row_"+ q_id).html($("#QuestionForm").html());
			$("#tr_q_row_"+ q_id).show();
            $("#QuestionForm").html('');
			$("#QuestionForm").hide();
		}
    <?php }if(count($questions) <= 0){ ?>
    setTimeout(show_q_create_frm, 100);
    function show_q_create_frm()
    {
    $("#QuestionForm").removeClass("hide");
    }    
	<?php } ?>



   

</script>





<style type="text/css">
table.cust_p_p tr td{background-color: unset !important;}

/***bar scale css**/
/* Boxes */
.box {
  width: 100%;
  float: left;
  padding: 5px;
}

.box .box-body {
  position: relative;
}


.box .br-wrapper {}

 @media print {   
.box-blue .box-body {
    background-color: transparent;
    border: none;
  }
}

.br-theme-bars-1to10 .br-widget {
  white-space: nowrap;
  text-align: center;
}

.br-theme-bars-1to10 .br-widget a {
  display: inline-block;
  width: 12px;
  padding: 5px 0;
  height: 24px;
  background-color:#ddd;
  margin: 1px;

}
.br-theme-bars-1to10 .br-widget a.br-active,
.br-theme-bars-1to10 .br-widget a.br-selected {
  background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important;
}

.br-theme-bars-1to10 .br-widget .br-current-rating {
  font-size: 20px;
  padding-left:15px;
  display: inline-block;
 color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important;
  font-weight: 400;
  font-size: 18px;
  vertical-align: super;
}

.br-theme-bars-1to10 .br-readonly a {
  cursor: default;
}

.br-theme-bars-1to10 .br-readonly a.br-active,
.br-theme-bars-1to10 .br-readonly a.br-selected {
  background-color: #f2cd95;
}

.br-theme-bars-1to10 .br-readonly .br-current-rating {
  color: #f2cd95;
}


@media print {
  .br-theme-bars-1to10 .br-widget a {
    border: 1px solid #b3b3b3;
    background: white;
    height: 28px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .br-theme-bars-1to10 .br-widget a.br-active,
  .br-theme-bars-1to10 .br-widget a.br-selected {
    border: 1px solid black;
    background: white;
  }
  .br-theme-bars-1to10 .br-widget .br-current-rating {
    color: black;
  }
}



</style>
<script type="text/javascript">
 /***bar scale script**/   
    function ratingEnable() {

        $('#example-1to10').barrating('show', {
            theme: 'bars-1to10'
        });

        $('#example-1to11').barrating('show', {
            theme: 'bars-1to10'
        });

         $('#example-1to12').barrating('show', {
            theme: 'bars-1to10'
        });

         $('#example-1to13').barrating('show', {
            theme: 'bars-1to10'
        });

    }



    function ratingDisable() {
        $('select').barrating('destroy');
    }

    $('.rating-enable').click(function(event) {
        event.preventDefault();

        ratingEnable();

        $(this).addClass('deactivated');
        $('.rating-disable').removeClass('deactivated');
    });

    $('.rating-disable').click(function(event) {
        event.preventDefault();

        ratingDisable();

        $(this).addClass('deactivated');
        $('.rating-enable').removeClass('deactivated');
    });

    ratingEnable();
</script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 







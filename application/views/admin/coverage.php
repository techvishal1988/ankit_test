<style>


#main-wrapper {
    margin-top: 5px;
    margin-bottom: 20px;
}
</style>

<div class="page-breadcrumb">
<div class="container">
<div class="col-sm-4">
    <ol class="breadcrumb ">
        <?php $u=explode('/',$_SERVER['REQUEST_URI']); ?>
        <li><a href="<?php echo base_url('performance-cycle') ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
        <li class="active"><?php echo ucfirst(end($u)) ?> Rule Coverage</li>
    </ol>
    </div>
   
   </div>
</div>
 <!--Start shumsul--> 
<br>
<div class="container-fluid">
  <div class="container">
     <div class="row text-right">
      <div class="col-sm-12 col-md-12 col-lg-12 ">
	  <button id="export" class="btn btn-primary " data-export="export" >Export</button>
	</div>

     </div>
 </div>
</div>
 <!--End shumsul-->   
<div id="main-wrapper" class="container">

    <div class="row mb20">
	
	
        <!--<button id="export" class="btn btn-primary pull-right" data-export="export" style="">Export</button>-->
        <div class="col-md-12">
        <?php //echo '<pre />'; print_r($salary_rule_list);
            $attr=array('country','city','business_level1','business_level2','business_level3','functions','sub_functions','designations',
                'grades','levels','educations','critical_talents','critical_positions','special_category','tenure_company','tenure_roles');
             function getName($arr,$st)
              {
                  $string='';
                  $vl=explode(',',$st);
                  for($i=0;$i<count($vl);$i++)
                  {
                      foreach($arr as $ar)
                      {
                          if($ar['id']==$vl[$i])
                          {
                            $string.=$ar['name'].',';  
                          }
                      }
                  }
                 return rtrim($string,',');
              }
        ?>
           <div class="mailbox-content pad_b_10 mar_b_10" style="overflow-x:auto">
               
               <table class="table border" id="datatable">
                   <thead>
                   <th>
                   Rules
                   </th>   
                   <?php foreach($salary_rule_list as $srl){
                       if(@$srl['salary_rule_name']!='')
                       {
                           echo '<th>'.$srl['salary_rule_name'].'</th>';
                       }
                       if(@$srl['bonus_rule_name']!='')
                       {
                           echo '<th>'.$srl['bonus_rule_name'].'</th>';
                       }
                       if(isset($srl['rule_name']))
                       {
                           echo '<th>'.$srl['rule_name'].'</th>';
                       }
                       if(@$srl['lti_rule_name']!='')
                       {
                           echo '<th>'.$srl['lti_rule_name'].'</th>';
                       }
                       
                   } ?>
                   </thead>
                   <tbody>
                       <?php 
                 $m = 0;
                 foreach ($salary_rule_list as $row)
                 {  
                    $arr = array();
                    foreach(explode(',',$row['country']) as $key)
                    {
                        array_push($arr,$key);
                    } 
    
                    if($arr)
                    {
                        $country[$m] = implode(", ",$arr); 
                    }else{
                        $country[$m] =  "All";
                    }
    
                    $arr1 = array();
                    foreach(explode(',',$row['business_level1']) as $key1)
                    {
                        array_push($arr1,$key1); 
                    }
    
                    if($arr1)
                    {
                        $bussiness_level1[$m] = implode(", ",$arr1); 
                    }else{
                        $bussiness_level1[$m] =  "All";
                    }
    
                    $arr7 = array();
                    foreach(explode(',',$row['business_level2']) as $key7)
                    {
                        array_push($arr7,$key7); 
                    }
                    if($arr7)
                    {
                        $bussiness_level2[$m] = implode(", ",$arr7); 
                    }else{
                        $bussiness_level2[$m] =  "All";
                    }
    
                    $arr8 = array();
                    foreach(explode(',',$row['business_level2']) as $key8)
                    {
                        array_push($arr8,$key8); 
                    }
                    if($arr8)
                    {
                        $bussiness_level3[$m] = implode(", ",$arr8); 
                    }else{
                        $bussiness_level3[$m] =  "All";
                    }
    
                     $arr2 = array();
                     foreach(explode(',',$row['sub_functions']) as $key2)
                     {
                        array_push($arr2, $key2);
                     }
    
                     if($arr2){$sub_function[$m] = implode(", ",$arr2); }else{$sub_function[$m] = "All";}
                    $arr3 = array();
                    foreach(explode(',',$row['city']) as $key3)
                    {
                        array_push($arr3,$key3);
                    } 
    
                    if($arr3){$city[$m] = implode(", ",$arr3); }else{$city[$m] = "All";}
    
                    $arr4 = array();
                    foreach(explode(',',$row['functions']) as $key4)
                    {
                        array_push($arr4,$key4);
                    }
    
                    if($arr4){$function[$m] = implode(", ",$arr4); }else{$function[$m] = "All";}
    
                    $arr5 = array();
                    foreach(explode(',',$row['designations']) as $key5)
                    {
                        array_push($arr5,$key5);
                    }
                    if($arr5){$designation[$m] = implode(", ",$arr5); }else{$designation[$m] = "All";}
    
                    $arr6 = array();
                    foreach(explode(',',$row['grades']) as $key6)
                    {
                        array_push($arr6,$key6);
                    }
                    if($arr6){$grade[$m] = implode(", ",$arr6); }else{$grade[$m] = "All";}
                    $arr9 = array();
                    foreach(explode(',',$row['levels']) as $key9)
                    {
                        array_push($arr9,$key9);
                    }
                    if($arr9){$level[$m] = implode(", ",$arr9); }else{$level[$m] = "All";}
                    
                    $arr10 = array();
                    foreach(explode(',',$row['critical_talents']) as $key10)
                    {
                        array_push($arr10,$key10);
                    }
                    if($arr10){$critical_talents[$m] = implode(", ",$arr10); }else{$critical_talents[$m] = "All";}
                    
                    $arr11 = array();
                    foreach(explode(',',$row['critical_positions']) as $key11)
                    {
                        array_push($arr11,$key11);
                    }
                    if($arr11){$critical_positions[$m] = implode(", ",$arr11); }else{$critical_positions[$m] = "All";}
                    $arr12 = array();
                    foreach(explode(',',$row['special_category']) as $key12)
                    {
                        array_push($arr12,$key12);
                    }
                    if($arr12){$special_category[$m] = implode(", ",$arr12); }else{$special_category[$m] = "All";}
                    $arr13 = array();
                    foreach(explode(',',$row['tenure_company']) as $key13)
                    {
                        array_push($arr13,$key13);
                    }
                    if($arr13){$tenure_company[$m] = implode(", ",$arr13); }else{$tenure_company[$m] = "All";}
                    
                    $arr14 = array();
                    foreach(explode(',',$row['tenure_roles']) as $key14)
                    {
                        array_push($arr14,$key14);
                    }
                    if($arr14){$tenure_roles[$m] = implode(", ",$arr14); }else{$tenure_roles[$m] = "All";}
                    
                    $arr15 = array();
                    foreach(explode(',',$row['educations']) as $key15)
                    {
                        array_push($arr15,$key15);
                    }
                    if($arr15){$edu[$m] = implode(", ",$arr15); }else{$edu[$m] = "All";}
                    
                    $arr16 = array();
                    foreach(explode(',',$row['sub_subfunctions']) as $key16)
                    {
                        array_push($arr16, $key16);
                    }
    
                    if($arr16){$sub_subfunction[$m] = implode(", ",$arr16); }else{$sub_subfunction[$m] = "All";}
                    $m++;
    
                 }
    
                 
                    echo "<tr>";
                    echo "<td>Country</td>"; 
                    foreach ($country as $value)
                    {
                         echo "<td>".getName($country_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>City</td>"; 
                    foreach ($city as $value)
                    {
                         echo "<td>".getName($city_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Business Level 1</td>"; 
                    foreach ($bussiness_level1 as $value)
                    {
                         echo "<td>".getName($bussiness_level_1_list,$value)."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<td>Business Level 2</td>"; 
                    foreach ($bussiness_level2 as $value)
                    {
                         echo "<td>".getName($bussiness_level_2_list,$value)."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<td>Business Level 3</td>"; 
                    foreach ($bussiness_level3 as $value)
                    {
                         echo "<td>".getName($bussiness_level_3_list,$value)."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<td>Functions</td>"; 
                    foreach ($function as $value)
                    {
                         echo "<td>".getName($function_list,$value)."</td>";
                    }
                    echo "</tr>";
                   
                    echo "<tr>";
                    echo "<td>Sub-Functions</td>"; 
                    foreach ($sub_function as $value)
                    {
                         echo "<td>".getName($sub_function_list,$value)."</td>";
                    }
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>Sub-SubFunctions</td>"; 
                    foreach ($sub_subfunction as $value)
                    {
                         echo "<td>".getName($sub_sub_function_list,$value)."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<td>Designation</td>"; 
                    foreach ($designation as $value)
                    {
                         echo "<td>".getName($designation_list,$value)."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<td>Grade</td>"; 
                    foreach ($grade as $value)
                    {
                         echo "<td>".getName($grade_list,$value)."</td>";
                    }
                    echo "</tr>";
					
                    echo "<tr>";
                    echo "<td>Level</td>"; 
                    foreach ($level as $value)
                    {
                         echo "<td>".getName($level_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Education</td>"; 
                    foreach ($edu as $value)
                    {
                         echo "<td>".getName($education_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Critical talents</td>"; 
                    foreach ($critical_talents as $value)
                    {
                         echo "<td>".getName($critical_talent_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Critical Positions</td>"; 
                    foreach ($critical_positions as $value)
                    {
                         echo "<td>".getName($critical_position_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Special Category</td>"; 
                    foreach ($special_category as $value)
                    {
                        echo "<td>".getName($special_category_list,$value)."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Tenure Company</td>"; 
                    foreach ($tenure_company as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "<tr>";
                    echo "<td>Tenure Roles</td>"; 
                    foreach ($tenure_roles as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
               
                 ?>  
                   </tbody>
               </table>
            </div>
        </div>
        
    </div>
     
</div>
 
 <script src="<?php echo base_url() ?>assets/js/jquery.tabletoCSV.js" type="text/javascript" charset="utf-8"></script>
 <script>

$("#export").click(function(){
  $("#datatable").tableToCSV();
});
 </script>

<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
      text: "Salary Movement Chart"
      },
      data: [
      {
        type: "line",
        dataPoints: [
        { x: 10, y: 71 },
        { x: 20, y: 55 },
        { x: 30, y: 50 },
        { x: 40, y: 65, lineColor:"red" }, //**Change the lineColor here
        { x: 50, y: 68 },
        { x: 60, y: 28 },
        { x: 70, y: 34 },
        { x: 80, y: 14 },
        { x: 90, y: 23},
        ]
      }
      ]
    });

    chart.render();
  }
  
</script>
<script src="../canvasjs.min.js"></script>
	
<div class="profile-cover"></div>
<div id="main-wrapper" class="container">
    <div class="row mb20">
        <div class="col-md-3 user-profile">
            <div class="profile-image-container">
                <img src="<?php echo base_url("assets/images/profile-picture.png"); ?>" alt="">
            </div>
            <h3 id="name" class="text-center"><?php echo $this->session->userdata('username_ses'); ?></h3>
            <p id="desig" class="text-center">UI/UX Designer</p>
            <hr style="margin-bottom:12px; margin-top:12px;">
            <ul class="list-unstyled text-center">
                <li><p><i class="fa fa-map-marker m-r-xs"></i>Laxmi Nagar, Delhi</p></li>
                <li><p><i class="fa fa-envelope m-r-xs"></i><a id="email" href="#"><?php echo $this->session->userdata('email_ses'); ?></a></p></li>
            </ul>
            <hr style="margin-bottom:12px; margin-top:12px;">
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-gray">
                <div class="profile-heading">
                    <h1>Comparative Ratio</h1>
                </div>
                <div class="panel-body text-center">
                    <div class="info-box-stats">
                        <span class="info-box-title">Current Comparative Ratio</span>
                        <p id="salary_comp" class="counter">75%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-gray">
                <div class="profile-heading">
                    <h1>Revised Ratio</h1>
                </div>
                <div class="panel-body text-center">
                    <div class="info-box-stats">
                        <span class="info-box-title">Revised Comparative Ratio</span>
                        <p class="counter">78%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-gray">
                <div class="profile-heading">
                    <h1>Salary Increase</h1>
                </div>
                <div class="panel-body text-center">
                    <div class="info-box-stats">
                        <span class="info-box-title">Salary Increased By </span>
                        <p id="salary" class="counter">20%</p>
                    </div>
                </div>
                <a href="" class="btn btn-block btn-promotion">Add Promotion</a>
            </div>
        </div>
    </div>
    
    <div class="row mb20">
    
        <div class="col-lg-6">
            <div class="panel panel-white datatable" style="height:100%;">
                <div class="panel-heading">
                    <h4 class="panel-title">Salary Movement Chart</h4>
                </div>
                <div class="panel-body">
                  
                       <div id="chartContainer" style="height: 400px; width: 100%;">
</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="panel panel-white datatable" style="height:100%;">
                <div class="panel-heading">
                    <h4 class="panel-title">Current Market Positioning</h4>
                </div>
                <div class="panel-body">
                   <img src="<?php echo base_url("assets/chart2.jpg"); ?>" alt="" />
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="row">
        
        <div class="col-lg-6">
            <div class="panel panel-white datatable" style="height:100%;">
                <div class="panel-heading">
                    <h4 class="panel-title">Comparision With Team Members</h4>
                    <div class="panel-control">
                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Reload" class="panel-reload"><i class="icon-reload"></i></a>                                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive project-stats">  
                       <table class="table table-d">
                           <tbody>
                               <tr>
                                   <td>Name</td>
                                   <td>Rahul </td>
                                   <td>Rahul </td>
                               </tr>
                               <tr>
                                   <td>Salary</td>
                                   <td>25,000/month</td>
                                   <td>25,000/month</td>
                               </tr>
                               <tr>
                                   <td>Salary Increment (%)</td>
                                   <td>20%</td>
                                   <td>20%</td>
                               </tr>
                               <tr>
                                   <td>Salary Increment (Rs.)</td>
                                   <td>Rs. 5000</td>
                                   <td>Rs. 5000</td>
                               </tr>
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="panel panel-white datatable" style="height:100%;">
                <div class="panel-heading">
                    <h4 class="panel-title">Comparision With All Pear Group</h4>
                    <div class="panel-control">
                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Reload" class="panel-reload"><i class="icon-reload"></i></a>                                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive project-stats">  
                       <table class="table table-d">
                           <tbody>
                               <tr>
                                   <td>Name</td>
                                   <td>Rahul </td>
                                   <td>Rahul </td>
                               </tr>
                               <tr>
                                   <td>Salary</td>
                                   <td>25,000/month</td>
                                   <td>25,000/month</td>
                               </tr>
                               <tr>
                                   <td>Salary Increment (%)</td>
                                   <td>20%</td>
                                   <td>20%</td>
                               </tr>
                               <tr>
                                   <td>Salary Increment (Rs.)</td>
                                   <td>Rs. 5000</td>
                                   <td>Rs. 5000</td>
                               </tr>
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
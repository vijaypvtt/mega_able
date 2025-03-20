<?php 
include("includes/links.php");
include ('database/config.php');


$sql = "SELECT * FROM cars WHERE status = 'available'";
$result = $conn->query($sql);

?>

  <body>
    <style>
    
  
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .car-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .car-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }
        .car-card img {
            height: 220px;
            object-fit: cover;
            border-bottom: 3px solid #007bff;
        }
        .car-card .card-body {
            text-align: center;
        }
        .btn-rent {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-rent:hover {
            background-color: #0056b3;
        }
        .btn-add {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-add:hover {
            background-color: #218838;
        }
    </style>
   
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
  <div id="pcoded" class="pcoded">
      <div class="pcoded-overlay-box"></div>
      <div class="pcoded-container navbar-wrapper">
      <!-- header includes nav bar-->
         <?php
           include("includes/header.php");
         ?>

          <div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                 <!--sidebar-->
                 <?php 
                  include("includes/sidebar.php");
                 ?>
                
                <div class="pcoded-content">
                   <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">Dashboard</h5>
                                          <p class="m-b-0">Welcome to Mega Able</p>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <ul class="breadcrumb-title">
                                          <li class="breadcrumb-item">
                                              <a href="index.html"> <i class="fa fa-home"></i> </a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>
                     
                      <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                         <div class="main-body">
                            <div class="page-wrapper">
                            <div class="container mt-5">
                                  <h2 class="text-center mb-4 text-primary">Available Cars for Rent</h2>
                                  <a href="add_cars.php" class="btn btn-add">+ Add Car</a>

                            <div class="row">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="col-md-4 mb-4">
                                                <div class="card car-card">
                                                    <img src="images/' . $row['image'] . '" class="card-img-top" alt="' . $row['brand'] . ' ' . $row['model'] . '">
                                                    <div class="card-body">
                                                        <h5 class="card-title">' . $row['brand'] . ' ' . $row['model'] . '</h5>
                                                        <p class="card-text">Year: ' . $row['year'] . '</p>
                                                        <p class="card-text"><strong>$' . $row['price_per_day'] . ' / day</strong></p>
                                                        <a href="rent_car.php?id=' . $row['id'] . '" class="btn btn-rent">Rent Now</a>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="col-12 text-center"><p class="text-muted">No cars available at the moment.</p></div>';
                                }
                                ?>
                            </div>
                        </div>
                                
                            </div>

                         </div>
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
    <script type="text/javascript" src="assets/pages/widget/excanvas.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/modernizr/modernizr.js "></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="assets/js/SmoothScroll.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
    <!-- Chart js -->
    <script type="text/javascript" src="assets/js/chart.js/Chart.js"></script>
    <!-- amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="assets/pages/widget/amchart/gauge.js"></script>
    <script src="assets/pages/widget/amchart/serial.js"></script>
    <script src="assets/pages/widget/amchart/light.js"></script>
    <script src="assets/pages/widget/amchart/pie.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <!-- menu js -->
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/vertical-layout.min.js "></script>
    <!-- custom js -->
    <script type="text/javascript" src="assets/pages/dashboard/custom-dashboard.js"></script>
    <script type="text/javascript" src="assets/js/script.js "></script>
</body>

</html>


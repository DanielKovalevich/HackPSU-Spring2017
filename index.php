<?php
include('php/graphs.php');
include('php/capitalApi.php');

session_start();

$capitalApi = new capitalApi;

if(!isset($_SESSION['accounttype'])) {

    $_SESSION['accounttype'] = "Credit Card";

}
else if(!isset($_SESSION['accountname'])) {

    $_SESSION['accountname'] = "Alyson's Account";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <style> 
body{ text-align: center;}
#chart_div{width: 800px; margin: 0 auto; text-align: left;}
</style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/CustomFont.css" rel="stylesheet" type="text/css">

    <link href="css/DivCentering.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        //Hardcoded for now.. 
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Balance', 'Reward'],
          ['January',  1000,      400],
          ['Febuary',  1170,      460],
          ['March',  660,       1120],
          ['April',  1030,      540],
          ['May',  40, 50],
          ['June', 499, 231],
          ['July', 429, 999],
          ['August', 200, 412],
          ['September', 400, 211],
          ['October', 222, 211],
          ['November', 100, 211],
          ['December', 1200, 200]
        ]);

        var options = {
          title: 'Account Balances',
          curveType: 'function',
          chartArea : { right: 3, margin: 0 },
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart-body'));

        chart.draw(data, options);
      }
    </script>

    



</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
           
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Alyson's Account<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                        
                        </div>
                    </ul>
                </li>
            </ul>

            <div class="navbar-brand">
            <p class="text-left">InvestOne</p>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Pocket Change <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="invest_dashboard.php">Investment Dashboard</a>
                            </li>
                            <li>
                                <a href="/invest_tools.html">Investment Tools</a>
                            </li>
                            <li>
                                <a href="/stock.php"><i class"fa fa-fw fa-gear"></i>Stock Picks</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="/php/atm.php"><i class="fa fa-fw fa-desktop"></i> ATM Locations</a>
                    </li>

                    <li>
                        <a href="transfer.php"><i class="fa fa-fw fa-desktop"></i> Transfer Funds</a>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-user-circle" aria-hidden="true"></i>Users<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse">
                            <?php foreach($capitalApi->getUserAccounts() as $user) { ?>

                            <?php echo("<a href='supersecret.php?id=".$user['nickname'].">".$user['nickname']."</a>");

                        } ?>


                        </ul>
                    </li>
                </ul>
            </div>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-9">
                        <h1 class="page-header text-center dashboardCenter">
                            Dashboard
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                       <div class="col-lg-4">
                       
                        <div class="divCentering">
                            <div class="text-center">
                                <p class="text-center"> Account Summary</p>
                            </div>
                           <div class="panel-body">
                              
                             
                            </div>
                        </div>
                        </div>
                    </div>
                <!-- /.row -->
             

                <div class="row">
                    
                    <div class="col-lg-4">
                          <div class="col1">
                            <div class="text-center">
                                <p class="panel-title"><i class="fa fa-clock-o fa-fw"></i> <strong>Current Balance</strong></p>
                            </div>
                            <div class="panel-body">  
                            <span class="spanDataEntry">
                                $1,200
                            </span>
                            </div>
                    </div>
                </div>
                    <div class="col-lg-4">
                         <div class="col2">
                            <div class="text-center">
                                <p class="panel-title"><i class="fa fa-money fa-fw"></i> <strong>Current Rewards</strong></p>
                            </div>
                            <div class="panel-body">
                            <span class="spanDataEntry">
                                $200
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
               
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <span class="panel-heading">
                            <div class="panel-body">
                                <div id="chart-body" style="width: 1000px; height: 300px">
                                    <!--Chart spawned in by JS!-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    
                     <div class="col-lg-4">
                          <div class="col1">
                            <div class="text-center">
                                <p class="panel-title"><i class="fa fa-clock-o fa-fw"></i> <strong>Outstanding Loans</strong></p>
                            <table class="table-condensed table-bordered">
                                <caption class="text-center">Credit Score: 724</caption>
                                <thead>
                                    <tr>
                                    <th>Amount</th>
                                    <th>% Interest</th>
                                    <th>Monthly</th>
                                    <th>$ Remaining</th>
                                    <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>1,000,000</td>
                                    <td>2%</td>
                                    <td>$5</td>
                                    <td>750,000</td>
                                    <td>D. Trump
                                    </tr>
                                </tbody>
                            </table>
              
                        
                   
                            </div>
                       
                    </div>
                </div>
                   <div class="col-lg-4">
                         <div class="col2">
                            <div class="text-center">
                                <p class="panel-title"><i class="fa fa-money fa-fw"></i> <strong>Transactions</strong></p>
                                <table class="table-condensed table-bordered">
                                <thead>
                                    <tr>
                                    <th>To/From</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>To: Veigar's Account</td>
                                    <td>+ $100.10</td>
                                    <td>Pending</td>
                                    </tr>
                                    <tr>
                                    <td>From: Kane's Account</td>
                                    <td>+ $204.23</td>
                                    <td>Complete</td>
                                    </tr>
                                    <tr>
                                    <td>To: Obama's Account</td>
                                    <td>- $800.00</td>
                                    <td>Complete</td>
                                    </tr>
                                    <tr>
                                    <td>From: John Cena's Account</td>
                                    <td>+ $0.01</td>
                                    <td>Complete</td>
                                    </tr>
                                </tbody>
                            </table>

                        
                            </div>
                        </div>
                    </div>
                       
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>


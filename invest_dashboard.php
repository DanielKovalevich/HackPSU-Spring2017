    <?php
    include('php/graphs.php');
    include('php/capitalApi.php');

    $capitalApi = new capitalApi;

    if(!isset($_SESSION['accounttype'])) {

        $_SESSION['accounttype'] = "Credit Card";

    }
    else if(!isset($_SESSION['accountname'])) {

        $_SESSION['accountname'] = "Alyson's Account";
    }

    ?>
    
    <html lang="en">


        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <title>SB Admin - Bootstrap Admin Template</title>

            <!-- Bootstrap Core CSS -->
            <link href="css/bootstrap.min.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="css/sb-admin.css" rel="stylesheet">

            <!-- Morris Charts CSS -->
            <link href="css/plugins/morris.css" rel="stylesheet">

            <!-- Custom Fonts -->
            <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

            <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
            <script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->

        </head>

        <body>
             <div id="wrapper">
                <!-- Navigation -->
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                
                    <!-- Top Menu Items -->
                    <ul class="nav navbar-right top-nav">
                    
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
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
                            </ul>
                        </li>
                    </ul>
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
                                            <a href="/php/invest_dash_controller.php"><i class"fa fa-fw fa-gear"></i>Investment Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="/invest_tools.html"><i class"fa fa-fw fa-gear"></i>Investment Tools</a>
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
                    <!-- /.navbar-collapse -->
                </nav>
                <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                               Investment Dashboard <small>Statistics Overview</small>
                            </h1>
                        </div>
                        <div class="col-lg-4">
                            <h2 class="page-header" style="text-align: center;">Account Balance</h2>
                                <p class="lead">
                                    <h3 style="text-align: center;" id="account" value="value">30000</h3>
                                </p>
                        </div>
                        
                        

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Account and Investments</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-chart" style="height: 250px;"></div>
                                    <div class="text-right">
                                        <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <h2 class="page-header" style="text-align: center;">Investment Balance</h2>
                                <p class="lead">
                                    <h3 style="text-align: center;" id="investing" value="value">1500</h3>
                                </p>
                        </div>
                        <div class="col-lg-12 col-md-offset-3">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="transfer">How much would you like to transfer to your investment account:</label>
                                    <input type="number" min="0" class="form-control" id="transfer" value="value">
                                </div>
                                <button type="submit" class="btn btn-default" id="doEverything" onclick="return decriment()">Submit</button>
                            </form>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </body>

    </html>

<script>
    var account = Number(document.getElementById("account").innerHTML);
    var investing = Number(document.getElementById("investing").innerHTML);

   new Morris.Donut({
    element: 'morris-donut-chart',
    data: [
        {label: "Account Balance", value: account},
        {label: "Investment Balance", value: investing}
    ]
    });
</script>
<script type='text/javascript'>
    function decriment() {
        var transfer = Number(document.getElementById("transfer").value);
        console.log(transfer);
        var account = Number(document.getElementById("account").innerHTML);
        console.log(account);
        var investing = Number(document.getElementById("investing").innerHTML);
        console.log(investing);
        if (account - investing >= transfer) {
            document.getElementById("account").innerHTML = account - transfer;
            document.getElementById("investing").innerHTML = investing + transfer;


            var account = Number(document.getElementById("account").innerHTML);
            var investing = Number(document.getElementById("investing").innerHTML);

            new Morris.Donut({
                element: 'morris-donut-chart',
                data: [
                    {label: "Account Balance", value: account},
                    {label: "Investment Balance", value: investing}
                ]
                });
        }
        else {
            alert("You do not have the funds!");
        }

        return false;
            
    }
</script>
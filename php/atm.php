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
            <link href="../css/bootstrap.min.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="../css/sb-admin.css" rel="stylesheet">

            <!-- Morris Charts CSS -->
            <link href="../css/plugins/morris.css" rel="stylesheet">

            <!-- Custom Fonts -->
            <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                                <a href="../index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                            </li>
                    
                            <li>
                                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Pocket Change <i class="fa fa-fw fa-caret-down"></i></a>
                                <ul id="demo" class="collapse">
                                    <li>
                                        <a href="/invest_dash_controller.php"><i class"fa fa-fw fa-gear"></i>Investment Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="../invest_tools.html"><i class"fa fa-fw fa-gear"></i>Investment Tools</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="atm.php"><i class="fa fa-fw fa-desktop"></i> ATM Locations</a>
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
                               ATM Locator
                            </h1>
                        </div>
                    </div>
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="radius">Radius:</label>
                            <input type="number" min="0" class="form-control" id="radius">
                        </div>
                        <button type="submit" class="btn btn-default" id="doEverything" onclick="getLocation()">Submit</button>
                    </form>

                    <iframe
                        width="1400"
                        height="900"
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCBtMu6YjA23pCRTSGnezyoz34kaVFatDo&q=40.803844,-77.865218" allowfullscreen>
                    </iframe>
                    <p id="demo">Hello</p>
            </div>
        </body>
</html>


<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
}
</script>
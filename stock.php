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
        <link href="css/stocks.css" rel="stylesheet" type="text/css">

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
                        <li>
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
                                    <li class="active">
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
                  <div class="navbar-brand">
            <p class="text-left">InvestOne</p>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                               Stock Watchlist
                            </h1>
                        </div>
                    </div>

                    <!-- Put stuff here -->
                    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center headerProperties">
                <u>Your Watchlist</u>
            </h1>
        </div>

        <div class="col-lg-12">
            <form class="form-inline">
                <div class="form-group">
                    <label for="transfer">Add Stock To Watchlist:</label>
                    <input type="text" class="form-control" id="transfer">
                </div>
                <button type="submit" class="btn btn-default" id="doEverything">Submit</button>
            </form>
        </div>

        <div id="no-more-tables">
            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th>Code</th>
                        <th>Company</th>
                        <th class="numeric">Price</th>
                        <th class="numeric">Change</th>
                        <th class="numeric">Change %</th>
                        <th class="numeric">Open</th>
                        <th class="numeric">High</th>
                        <th class="numeric">Low</th>
                        <th class="numeric">Volume</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-title="Code">AAC</td>
                        <td data-title="Company">AUSTRALIAN AGRICULTURAL COMPANY LIMITED.</td>
                        <td data-title="Price" class="numeric">$1.38</td>
                        <td data-title="Change" class="numeric">-0.01</td>
                        <td data-title="Change %" class="numeric">-0.36%</td>
                        <td data-title="Open" class="numeric">$1.39</td>
                        <td data-title="High" class="numeric">$1.39</td>
                        <td data-title="Low" class="numeric">$1.38</td>
                        <td data-title="Volume" class="numeric">9,395</td>
                    </tr>
                    <tr>
                        <td data-title="Code">AAD</td>
                        <td data-title="Company">ARDENT LEISURE GROUP</td>
                        <td data-title="Price" class="numeric">$1.15</td>
                        <td data-title="Change" class="numeric">+0.02</td>
                        <td data-title="Change %" class="numeric">1.32%</td>
                        <td data-title="Open" class="numeric">$1.14</td>
                        <td data-title="High" class="numeric">$1.15</td>
                        <td data-title="Low" class="numeric">$1.13</td>
                        <td data-title="Volume" class="numeric">56,431</td>
                    </tr>
                    <tr>
                        <td data-title="Code">AAX</td>
                        <td data-title="Company">AUSENCO LIMITED</td>
                        <td data-title="Price" class="numeric">$4.00</td>
                        <td data-title="Change" class="numeric">-0.04</td>
                        <td data-title="Change %" class="numeric">-0.99%</td>
                        <td data-title="Open" class="numeric">$4.01</td>
                        <td data-title="High" class="numeric">$4.05</td>
                        <td data-title="Low" class="numeric">$4.00</td>
                        <td data-title="Volume" class="numeric">90,641</td>
                    </tr>
                    <tr>
                        <td data-title="Code">ABC</td>
                        <td data-title="Company">ADELAIDE BRIGHTON LIMITED</td>
                        <td data-title="Price" class="numeric">$3.00</td>
                        <td data-title="Change" class="numeric">+0.06</td>
                        <td data-title="Change %" class="numeric">2.04%</td>
                        <td data-title="Open" class="numeric">$2.98</td>
                        <td data-title="High" class="numeric">$3.00</td>
                        <td data-title="Low" class="numeric">$2.96</td>
                        <td data-title="Volume" class="numeric">862,518</td>
                    </tr>
                    <tr>
                        <td data-title="Code">ABP</td>
                        <td data-title="Company">ABACUS PROPERTY GROUP</td>
                        <td data-title="Price" class="numeric">$1.91</td>
                        <td data-title="Change" class="numeric">0.00</td>
                        <td data-title="Change %" class="numeric">0.00%</td>
                        <td data-title="Open" class="numeric">$1.92</td>
                        <td data-title="High" class="numeric">$1.93</td>
                        <td data-title="Low" class="numeric">$1.90</td>
                        <td data-title="Volume" class="numeric">595,701</td>
                    </tr>
                    <tr>
                        <td data-title="Code">ABY</td>
                        <td data-title="Company">ADITYA BIRLA MINERALS LIMITED</td>
                        <td data-title="Price" class="numeric">$0.77</td>
                        <td data-title="Change" class="numeric">+0.02</td>
                        <td data-title="Change %" class="numeric">2.00%</td>
                        <td data-title="Open" class="numeric">$0.76</td>
                        <td data-title="High" class="numeric">$0.77</td>
                        <td data-title="Low" class="numeric">$0.76</td>
                        <td data-title="Volume" class="numeric">54,567</td>
                    </tr>
                    <tr>
                        <td data-title="Code">ACR</td>
                        <td data-title="Company">ACRUX LIMITED</td>
                        <td data-title="Price" class="numeric">$3.71</td>
                        <td data-title="Change" class="numeric">+0.01</td>
                        <td data-title="Change %" class="numeric">0.14%</td>
                        <td data-title="Open" class="numeric">$3.70</td>
                        <td data-title="High" class="numeric">$3.72</td>
                        <td data-title="Low" class="numeric">$3.68</td>
                        <td data-title="Volume" class="numeric">191,373</td>
                    </tr>
                    <tr>
                        <td data-title="Code">ADU</td>
                        <td data-title="Company">ADAMUS RESOURCES LIMITED</td>
                        <td data-title="Price" class="numeric">$0.72</td>
                        <td data-title="Change" class="numeric">0.00</td>
                        <td data-title="Change %" class="numeric">0.00%</td>
                        <td data-title="Open" class="numeric">$0.73</td>
                        <td data-title="High" class="numeric">$0.74</td>
                        <td data-title="Low" class="numeric">$0.72</td>
                        <td data-title="Volume" class="numeric">8,602,291</td>
                    </tr>
                    <tr>
                        <td data-title="Code">AGG</td>
                        <td data-title="Company">ANGLOGOLD ASHANTI LIMITED</td>
                        <td data-title="Price" class="numeric">$7.81</td>
                        <td data-title="Change" class="numeric">-0.22</td>
                        <td data-title="Change %" class="numeric">-2.74%</td>
                        <td data-title="Open" class="numeric">$7.82</td>
                        <td data-title="High" class="numeric">$7.82</td>
                        <td data-title="Low" class="numeric">$7.81</td>
                        <td data-title="Volume" class="numeric">148</td>
                    </tr>
                    <tr>
                        <td data-title="Code">AGK</td>
                        <td data-title="Company">AGL ENERGY LIMITED</td>
                        <td data-title="Price" class="numeric">$13.82</td>
                        <td data-title="Change" class="numeric">+0.02</td>
                        <td data-title="Change %" class="numeric">0.14%</td>
                        <td data-title="Open" class="numeric">$13.83</td>
                        <td data-title="High" class="numeric">$13.83</td>
                        <td data-title="Low" class="numeric">$13.67</td>
                        <td data-title="Volume" class="numeric">846,403</td>
                    </tr>
                    <tr>
                        <td data-title="Code">AGO</td>
                        <td data-title="Company">ATLAS IRON LIMITED</td>
                        <td data-title="Price" class="numeric">$3.17</td>
                        <td data-title="Change" class="numeric">-0.02</td>
                        <td data-title="Change %" class="numeric">-0.47%</td>
                        <td data-title="Open" class="numeric">$3.11</td>
                        <td data-title="High" class="numeric">$3.22</td>
                        <td data-title="Low" class="numeric">$3.10</td>
                        <td data-title="Volume" class="numeric">5,416,303</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>


                </div>
            </div>
        </div>
    </body>
</html>
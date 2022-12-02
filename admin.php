<?php
session_start();

if($_SESSION['rights']!=1){
    header("Location: login.php");

}
?>

<!DOCTYPE html>
<html>
<head>
    <?php require 'includes.php'?>
    <link rel="stylesheet" type="text/css" href="adminStyle.css"/>

</head>

<body onload="checkIfThereIsCarsForService()">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Car rent</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Logout <strong><?php echo $_SESSION['username']; ?></strong></a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type='button' class='btn btn-info' data-toggle='modal' data-target='#reserveRent'  value='Available/Service' />
                <input type="button" name="newCarName" class="btn btn-success" value="+car" data-toggle='modal' data-target='#newCar'/>
                <input type="button" name="newUserName" class="btn btn-success" value="+user" data-toggle='modal' data-target='#newUser'/>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">

    <div class="row row-offcanvas row-offcanvas-left">

        <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">

            <ul class="nav nav-sidebar">
                <li onclick="showAllUsers();"><a>Clients</a></li>
                <li onclick="showAllCars()"><a href="#">Vehicles</a></li>
                <hr style="border:1px solid blue; opacity: 0.4"/>
                <li onclick="showAllReports()"><a href="#">Reports</a></li>
                <hr style="border:1px solid blue; opacity: 0.4;"/>
                <li><a onclick="showCarsOnRent()" href="#">Cars on service</a></li>
                <li><a onclick="showCarSchecdule()" href="#">Service information</a></li>
                <li><a onclick="showCarsCurrentlyOnService()" href="#">Send cars to service <span id="counter" class="badge"></span></a> </li>
            </ul>

        </div><!--/span-->

        <div class="col-sm-9 col-md-10 main">

            <!--toggle sidebar button-->
            <p class="visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
            </p>

            <table id="lista" class="table table-hover" align="center">
                <h2 id="setWarning" align="center"  style="color:blue;"></h2>
                <br/>
                <thead>
                </thead>
                <tbody >
                </tbody>

            </table>

            

        </div><!--/row-->
    </div>

    <div id="GSCCModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Add new client</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <input id="id-klijent" type="hidden"  />
                    <div class="form-group">
                        <label for="name">Name</label>
                    <input id="name" type="text" placeholder="Your name.." required/>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Lastname</label>
                        <input id="lastName" type="text" placeholder="Your last name.." required/>

                    </div>
                    <div class="form-group">
                        <label for="userName">Username</label>
                        <input id="userName" type="text" placeholder="Your username.." required/>

                    </div>

                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input id="pwd" type="password" placeholder="Your password.." required/>
                    </div>

                    <div class="form-group">
                        <label for="jmbg">JMBG</label>
                        <input id="jmbg" type="number" placeholder="1234567890123" required/>
                    </div>
                    <div class="form-group">
                        <label for="rights">Admin?</label>
                        <input style="margin-right:25%;" id="rights" type="checkbox" required />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="izmeniKorisnika()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="reserveRentCar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Book car</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="idKolaRezervacije" />
                        <label for="datumOd">Please enter start of Your reservation</label>
                        <input name="datumOd" type="date" id="pickDateOdReserve" required />
                    </div>

                    <div class="form-group">
                        <label for="datumDo">Please enter end of Your reservation</label>
                        <input name="datumDo" type="date" id="pickDateDoReserve" required/>
                    </div>
                    <p id="newText" style="color:red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="reserveVehicle()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="reserveRent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Pick dates to check availability</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="idKola" />
                        <label for="datumOd">Start date</label>
                        <input name="datumOd" type="date" id="pickDateOd"  required  />
                    </div>

                    <div class="form-group">
                        <label for="datumDo">End date</label>
                        <input name="datumDo" type="date" id="pickDateDo" required />
                    </div>
                    <p id="newText" style="color:red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="proveraDostupnostiVozila()">Save changes</button>
                </div>
            </div>
        </div>
    </div>





    <div id="newUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Add new client</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <div class="form-group">
                        <label for="newname">Name</label>
                    <input id="newname" type="text" placeholder="Your name.."/>
                        </div>
                    <div class="form-group">
                        <label for="newlastName">Last name</label>
                        <input id="newlastName" type="text" placeholder="Your last name.." />
                    </div>
                    <div class="form-group">
                        <label for="newuserName">Username</label>
                        <input id="newuserName" type="text" placeholder="Your username.."  />
                    </div>
                    <div class="form-group">
                        <label for="newpwd">Password</label>
                        <input id="newpwd" type="password" placeholder="Your password.."  />
                    </div>
                    <div class="form-group">
                        <label for="newjmbg">JMBG</label>
                        <input id="newjmbg" type="number" placeholder="1234567890123"  />
                    </div>

                    <div class="form-group">
                        <label for="newrights">Admin?</label>
                        <input  style="margin-right:25%;" id="newrights" type="checkbox"  />
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="newUser()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="carModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Add new car</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <input id="id-car" type="hidden"  />
                    <input id="klijentId" type="hidden" />
                    <div class="form-group">
                        <label for="naziv">Car name</label>
                        <input id="naziv" type="text" placeholder="Car name.." required/>
                    </div>
                    <div class="form-group">
                        <label for="godiste">Year</label>
                        <input id="godiste" type="number" placeholder="Godiste .." required />

                    </div>
                    <div class="form-group">
                        <label for="opisVozila">Description</label>
                        <textarea id="opisVozila"   placeholder="Opis vozila" required></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="izmeniKola()">Save changes</button>

                </div>
            </div>
        </div>
    </div>



    <div id="insertService" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Add changes</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="idAutomobila" />
                        <input type="hidden" id="pocetniDatumAutomobila" />
                        <label for="promene">Changes</label>
                        <textarea name="promene" type="text" id="promene" placeholder="Changes"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cena">Cost</label>
                        <input name="cena" type="number" id="cena"/>
                    </div>
                    <p id="newText" style="color:red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="insertService();">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <div id="newCar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Add new car</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">

                    <div class="form-group">
                        <label for="newnaziv">Name</label>
                        <input id="newnaziv" type="text" placeholder="Car name.." />


                    </div>
                    <div class="form-group">
                        <label for="newgodiste">Year?</label>
                        <input id="newgodiste" type="number" placeholder="Godiste .." />

                    </div>
                    <div class="form-group">
                        <label for="newopisVozila">Description</label>
                        <textarea id="newopisVozila"  placeholder="Opis vozila" ></textarea>

                    </div>
                    <div class="form-group">
                        <label for="newiznajmljen">Rented?</label>
                        <input style="margin-right:25%;" id="newiznajmljen" type="checkbox" />

                    </div>
                    <input id="newklijentId" type="hidden" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="newCar()">Save changes</button>

                </div>
            </div>
        </div>
    </div>
</div><!--/.container-->

<footer>
    <!--<p class="pull-right">©2014 Code3</p>-->
</footer>
</body>
</html>

<style>

    label{
        display:inline-block;
        text-align: center;
        width: 140px;
    }
    input{
        display: inline-block;
    }

</style>
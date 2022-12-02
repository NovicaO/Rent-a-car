<?php
session_start();
if(!$_SESSION['rights']){
    header("Location: login.php");

}
?>


<!DOCTYPE html>
<html>
<head>
    <?php require 'includes.php'?>
    <link rel="stylesheet" type="text/css" href="adminStyle.css"/>

</head>

<body>

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
                <input type='button' class='btn btn-info' data-toggle='modal' data-target='#reserveRent'  value='Rent/Reserve' />
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">

    <div class="row row-offcanvas row-offcanvas-left">

        <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">

            <ul class="nav nav-sidebar">
                <!--<li><a onclick="showAvailableVehicles()" href="#">Available vehicles</a></li>-->
                <li><a href="#" onclick="showUserCar()">Your cars</a></li>
                <li onclick="showPersonalInfo()" data-toggle='modal' data-target='#GSCCModal'><a href="#">Change your info</a></li>
            </ul>

        </div><!--/span-->

        <div class="col-sm-9 col-md-10 main">

            <!--toggle sidebar button-->
            <p class="visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
            </p>

            <table id="lista" class="table table-hover">
                <thead>
                </thead>
                <tbody >
                </tbody>

            </table>



        </div><!--/row-->
    </div>

    <div id="rent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">RENT</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <input type="hidden" id="idKola" />
                    <label for="datumDo">Izaberite dan do kojeg zelite kola:</label>
                    <input name="datumDo" type="date" id="pickDate" />
                    <p id="newText" style="color:red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="rentACar()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="updateCar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Change rent date</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <div id="zaseban">
                    <input type="hidden" id="updateidKola" />
                    </div>
                    <label for="updatedatumDo">Extend your rent date to: </label>
                    <input name="datumDo" type="date" id="updatepickDate" />
                    <p id="newText" style="color:red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="updateRent()">Save changes</button>
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
                        <input name="datumOd" type="date" id="pickDateOd" required />
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
                        <input name="datumOd" type="date" id="pickDateOdReserve" />
                    </div>

                    <div class="form-group">
                        <label for="datumDo">Please enter end of Your reservation</label>
                        <input name="datumDo" type="date" id="pickDateDoReserve"/>
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

    <div id="GSCCModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 align="center" class="modal-title" id="myModalLabel">Change your info</h4>
                </div>
                <div id="insertInto" align="center" class="modal-body">
                    <input id="id-klijent" type="hidden"  />
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" placeholder="Your name.."/>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Lastname</label>
                        <input id="lastName" type="text" placeholder="Your last name.." />

                    </div>
                    <div class="form-group">
                        <label for="userName">Username</label>
                        <input id="userName" type="text" placeholder="Your username.."  disabled/>

                    </div>

                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input id="pwd" type="password" placeholder="Your password.." />
                    </div>

                    <div class="form-group">
                        <label for="jmbg">JMBG</label>
                        <input id="jmbg" type="number" disabled />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="izmeniSingleKorisnika()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        label{
            width:85px;
            display: inline-block;
        }
        input{
            display: inline-block;
        }
    </style>



</div><!--/.container-->

<footer>
    <!--<p class="pull-right">©2014 Code3</p>-->
</footer>
</body>
</html>


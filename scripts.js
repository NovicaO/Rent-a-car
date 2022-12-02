$( document ).ready(function() {
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    $("#pickDateOd").val(today);
    $("#pickDateDo").val(today);
    $("#pickDateOd").attr("min", today);
    $("#pickDateDo").attr("min", today);
    $.ajax({
        url: "showNotification.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
                var counter=0;
                for (var i = 0; i < data.length; i++) {
                    counter++;
                }
                $("#counter").text(counter);

        },
        error: function (data) {
            console.log(data);
        }

    });




});




function proveraKorisnikaUBazi() {
    var username = $('#username').val();
    var password = $('#pwd').val();
    $.ajax({
        url: "checkLogin.php",
        method: "POST",
        dataType: "JSON",
        data: {username: username, password: password},
        success: function (data) {
            if(data['obrisan']==1){
                $('#error').html("Vas nalog je privremeno blokiran, kontaktirajte admina");
            }else{
            if (data['username']) {
                if (data['rights'] == 1) {
                    window.location.replace("admin.php");
                }
                else {
                    window.location.replace("klijent.php");
                }

            } else {
                $('#error').html(data);
            }
            }
        },
        error: function (data) {
            console.log(data);
        }

    });
}





    function showAllUsers() {
        $('#lista').find('thead').empty();
        $('#lista').find('tbody').empty();
        $.ajax({
            url: "getAllUsers.php",
            method: "POST",
            dataType: "JSON",

            success: function (data) {
                $('#lista').find('thead').append("<tr><th></th><th>Name</th><th>Last name</th><th>Jmbg</th><th>Username</th><th>Delete</th><th>Change</th><th>Car History</th></tr>");
                for (var i = 0; i < data.length; i++) {
                    var uname = data[i]['ime'];
                    var ulastname = data[i]['prezime'];
                    var ujmbg = data[i]['jmbg'];
                    var uusername = data[i]['username'];
                    var obrisan = data[i]['obrisan'];
                    var idKlijenta=data[i]['idKlijent'];
                    if(obrisan==0){
                        obrisan=1;
                       var image=" <span class='glyphicon glyphicon-ok' onclick='changeImage("+obrisan+","+idKlijenta+")'></span>";
                    }else{
                        obrisan=0;
                        var image=" <span class='glyphicon glyphicon-remove' onclick='changeImage("+obrisan+","+idKlijenta+")'></span>"
                    }
                    $('#lista').find('tbody').append("<tr id='changeThisUser'> <td><input id='klijentovId"+idKlijenta+"' type='hidden' value='"+idKlijenta+"' /></td>        <td id='updateUserName'>" + uname + "</td><td id='updateUserLastName'>" + ulastname + "</td><td id='updateUserJmbg'>" + ujmbg + "</td><td id='updateUserUsername'>" + uusername + "</td><td id='obrisanaSlika"+idKlijenta+"'>"+image+"</td><td><input  onclick='loadUsersIntoModal("+idKlijenta+")' data-toggle='modal' data-target='#GSCCModal' value='Change' type='button' class='btn btn-success' /></td><td><input type='button' class='btn btn-danger' onclick='showUserHistory("+idKlijenta+")' value='History' /> </td></tr>");
                }

            },
            error: function (data) {
                console.log(data);
            }

        });


    }

function changeImage(idObrisan, klijentId){
        console.log(idObrisan, klijentId);
    $.ajax({
        url: "logickoBrisanjeKlijenta.php",
        method: "POST",
        dataType: "JSON",
        data:{idObrisan:idObrisan, klijentId:klijentId},
        success: function (data) {
            var dataKlijentId= data['idKlijent'];
            var dataObrisanId= data['obrisan'];
            if(dataObrisanId==1){
                dataObrisanId=0;
            $("#lista").find("#obrisanaSlika"+data['idKlijent']).html("<span id='obrisanaSlika"+dataKlijentId+"' class='glyphicon glyphicon-remove' onclick='changeImage("+dataObrisanId+","+dataKlijentId+")'></span>");
            }else{
                dataObrisanId=1;
                $("#lista").find("#obrisanaSlika"+data['idKlijent']).html("<span id='obrisanaSlika"+klijentId+"' class='glyphicon glyphicon-ok' onclick='changeImage("+dataObrisanId+","+dataKlijentId+")'></span>");
            }
        },
        error: function (data) {
            console.log("ERROR");
        }

    });

}


function showAllCars(){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "getAllCars.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            $('#lista').find('thead').append("<tr><th>Name</th><th>Year</th><th>Description</th><th>Delete</th><th>Change</th><th>Rent history</th></tr>");
            for (var i = 0; i < data.length; i++) {
                var nazivVozila = data[i]['nazivVozila'];
                var godisteVozila = data[i]['godisteVozila'];
                var opisVozila = data[i]['opisVozila'];
                var carId= data[i]['idVozila'];
                var obrisan = data[i]['obrisan'];
                if(obrisan==0){
                    obrisan=1;
                    var image=" <span class='glyphicon glyphicon-ok' onclick='changeImageCar("+obrisan+","+carId+")'></span>";
                }else{
                    obrisan=0;
                    var image=" <span class='glyphicon glyphicon-remove' onclick='changeImageCar("+obrisan+","+carId+")'></span>"
                }
                $('#lista').find('tbody').append("<tr id='changeThisCars'><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td><td id='obrisanaKolaSlika"+carId+"'>"+image+"</td><td><input data-toggle='modal' data-target='#carModal' onclick='loadCarsIntoModal("+carId+")'  value='Change' type='button' class='btn btn-success' /></td><td><input type='button' class='btn btn-danger' id='checkCarHistory' value='History' onclick='showCarHistory("+carId+")' /></td></tr>");
            }

        },
        error: function (data) {
            console.log(data);
        }

    });
}

function changeImageCar(idObrisan, carId){
    console.log(idObrisan, carId);
    $.ajax({
        url: "logickoBrisanjeKola.php",
        method: "POST",
        dataType: "JSON",
        data:{idObrisan:idObrisan, carId:carId},
        success: function (data) {
            var dataCarId= data['idVozila'];
            var dataObrisanId= data['obrisan'];
            if(dataObrisanId==1){
                dataObrisanId=0;
                $("#lista").find("#obrisanaKolaSlika"+data['idVozila']).html("<span id='obrisanaKolaSlika"+dataCarId+"' class='glyphicon glyphicon-remove' onclick='changeImageCar("+dataObrisanId+","+dataCarId+")'></span>");
            }else{
                dataObrisanId=1;
                $("#lista").find("#obrisanaKolaSlika"+data['idVozila']).html("<span id='obrisanaKolaSlika"+dataCarId+"' class='glyphicon glyphicon-ok' onclick='changeImageCar("+dataObrisanId+","+dataCarId+")'></span>");
            }
        },
        error: function (data) {
            console.log(data);
        }

    });

}



function showAllReports() {
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "getAllReports.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            $('#lista').find('thead').append("<tr><th>Vehicle name</th><th>Client</th><th>Start date</th><th>End date</th><th>Service</th></tr>");
            for (var i = 0; i < data.length; i++) {
                console.log(i);
                var nazivVozila = data[i]['nazivVozila'];
                var klijent = data[i]['username'];
                var pocetniDatum = data[i]['pocetniDatum'];
                var krajnjiDatum = data[i]['krajnjiDatum'];
                var servis = data[i]['servis'];
                console.log("SERVIS"+servis);
                if(servis==1){
                    servis="YES";
                }else{
                    servis="NO";
                }
                $('#lista').find('tbody').append("<tr><td>" + nazivVozila + "</td><td>" + klijent + "</td><td>" + pocetniDatum + "</td><td>" + krajnjiDatum + "</td><td>"+servis+"</td></tr>");
            }

        },
        error: function (data) {
            console.log(data);
        }

    });


}
function loadUsersIntoModal(id){

    $.ajax({
        url: "loadUsersIntoModal.php",
        method: "POST",
        dataType: "JSON",
        data:{idKlijent:id},
        success: function (data) {
            $("#name").val(data['ime']);
            $("#lastName").val(data['prezime']);
            $("#userName").val(data['username']);
            $("#pwd").val(data['password']);
            $("#jmbg").val(data['jmbg']);
            $("#id-klijent").val(data['idKlijent']);
            console.log("ID KLIJENTA:" +data['idKlijent']);
            if(data['rights']=='1'){
                $("#rights").prop('checked',true)
            }else{
                $("#rights").prop('checked',false)
            }





        },
        error: function (data) {
            console.log('Error');
        }

    });

}

function izmeniKorisnika(){
    var name= $("#name").val();
    var lastname= $("#lastName").val();
    var username= $("#userName").val();
    var jmbg= $("#jmbg").val();
    var pwd= $("#pwd").val();
    var rights= $("#rights").prop("checked");
    var klijentovId=$("#id-klijent").val();
    var dontShow= $("#dontShow").val();
    if(rights==true){
        rights=1;
    }else{
        rights=2;
    }

    $.ajax({
        url: "changeUser.php",
        method: "POST",
        dataType: "JSON",
        data:{idKlijent:klijentovId, ime:name, prezime:lastname, jmbg:jmbg, username:username,password:pwd,rights:rights },
        success: function (data) {
        console.log(window.dontShow);
            if(window.dontShow==1){
                alert("LOL");
            }else{
            showAllUsers();
            }




        },
        error: function (data) {
            console.log('ERROR');
        }

    });


}

function izmeniSingleKorisnika(){
    var name= $("#name").val();
    var lastname= $("#lastName").val();
    var username= $("#userName").val();
    var jmbg= $("#jmbg").val();
    var pwd= $("#pwd").val();
    var rights= $("#rights").prop("checked");
    var klijentovId=$("#id-klijent").val();
    if(name==''){
        $("#name").attr("style","border:1px solid red");
        $("#name").attr("placeholder","Name is required ");

    }
    else if(lastname==''){
        $("#lastName").attr("style","border:1px solid red");
        $("#lastName").attr("placeholder","Lastname is required ");
    } else if(username==''){
        $("#userName").attr("style","border:1px solid red");
        $("#userName").attr("placeholder","Username is required ");
    } else if(pwd=='' || pwd.length<4){

        $("#pwd").val('');
        $("#pwd").attr("style","border:1px solid red");
        $("#pwd").attr("placeholder","Password needs at least 4 characters ");

    }else if(jmbg==''){
        $("#jmbg").attr("style","border:1px solid red");
        $("#jmbg").attr("placeholder","JMBG is required ");
    }else{
    if(rights==true){
        rights=1;
    }else{
        rights=2;
    }

    $.ajax({
        url: "changeUser.php",
        method: "POST",
        dataType: "JSON",
        data:{idKlijent:klijentovId, ime:name, prezime:lastname, jmbg:jmbg, username:username,password:pwd,rights:rights },
        success: function (data) {
            $('#GSCCModal').modal('hide');




        },
        error: function (data) {
            console.log('ERROR');
        }

    });

    }
}

function loadCarsIntoModal(id){

    $.ajax({
        url: "loadCarsIntoModal.php",
        method: "POST",
        dataType: "JSON",
        data:{id:id},
        success: function (data) {
            $("#id-car").val(data['idVozila']);
            $("#klijentId").val(data['klijent']);
            $("#naziv").val(data['nazivVozila']);
            $("#godiste").val(data['godisteVozila']);
            $("#pocetniDatum").val(data['pocetniDatum']);
            $("#krajnjiDatum").val(data['krajnjiDatum']);
            $("#opisVozila").val(data['opisVozila']);
            $("#iznajmljen").val(data['iznajmljen']);
            if(data['iznajmljen']=='1'){
                $("#iznajmljen").prop('checked',true)
            }else{
                $("#iznajmljen").prop('checked',false)
            }





        },
        error: function (data) {
            console.log('Error');
        }

    });

}

function izmeniKola(){
    var idCar=$("#id-car").val();
    var klijent=$("#klijentId").val();
    var naziv=$("#naziv").val();
    var godiste= $("#godiste").val();
    var pd=$("#pocetniDatum").val();
    var kd=$("#krajnjiDatum").val();
    var ov=$("#opisVozila").val();

    $.ajax({
        url: "changeCars.php",
        method: "POST",
        dataType: "JSON",
        data: {idCar: idCar, klijent: klijent, naziv: naziv, godiste: godiste, pd: pd, kd: kd, ov: ov},
        success: function (data) {
            console.log(data);
            showAllCars();



        },
        error: function (data) {
            console.log(data);
        }

    });


}




function newCar(){
    var naziv=$("#newnaziv").val();
    var godiste= $("#newgodiste").val();
    var ov=$("#newopisVozila").val();
    var iz=$("#newiznajmljen").prop("checked");
    if(naziv==''){
        $("#newnaziv").attr("style","border:1px solid red");
        $("#newnaziv").attr("placeholder","Name is required ");

    } if(godiste==''){
        $("#newgodiste").attr("style","border:1px solid red");
        $("#newgodiste").attr("placeholder","Year is required ");
    }
    else{
    if(iz==false){
        iz=0;
    }else{
        iz=1;
    }

    $.ajax({
        url: "insertNewCar.php",
        method: "POST",
        dataType: "JSON",
        data: {naziv: naziv, godiste: godiste, ov: ov, iz: iz},
        success: function (data) {
            $("#newCar").modal("hide");
            console.log(data['nazivVozila']);
            var obrisan=data['obrisan'];
            var carId= data['idVozila']
            var nazivVozila= data['nazivVozila'];
            var godisteVozila= data['godisteVozila'];
            var opisVozila= data['opisVozila'];
            if(obrisan==0){
                obrisan=1;
                var image=" <span class='glyphicon glyphicon-ok' onclick='changeImageCar("+obrisan+","+carId+")'></span>";
            }else{
                obrisan=0;
                var image=" <span class='glyphicon glyphicon-remove' onclick='changeImageCar("+obrisan+","+carId+")'></span>"
            }
            $('#lista').find('tbody').append("<tr id='changeThisCars'><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td><td id='obrisanaKolaSlika"+carId+"'>"+image+"</td><td><input data-toggle='modal' data-target='#carModal' onclick='loadCarsIntoModal("+carId+")'  value='Change' type='button' class='btn btn-success' /></td><td><input type='button' class='btn btn-danger'  value='None' /> </td></tr>");




        },
        error: function (data) {
            console.log(data);
        }

    });
    }
}

function newUser(){
    var name= $("#newname").val();
    var lastname= $("#newlastName").val();
    var username= $("#newuserName").val();
    var jmbg= $("#newjmbg").val();
    var pwd= $("#newpwd").val();
    var rights= $("#newrights").prop("checked");
    if(name==''){
        $("#newname").attr("style","border:1px solid red");
        $("#newname").attr("placeholder","Name is required ");

    }
    else if(lastname==''){
        $("#newlastName").attr("style","border:1px solid red");
        $("#newlastName").attr("placeholder","Lastname is required ");
    } else if(username==''){
        $("#newuserName").attr("style","border:1px solid red");
        $("#newuserName").attr("placeholder","Username is required ");
    } else if(pwd=='' || pwd.length<4){

            $("#newpwd").val('');
            $("#newpwd").attr("style","border:1px solid red");
            $("#newpwd").attr("placeholder","Password needs at least 4 characters ");

    }else if(jmbg==''){
        $("#newjmbg").attr("style","border:1px solid red");
        $("#newjmbg").attr("placeholder","JMBG is required ");
    }
    else{
    if(rights==true){
        rights=1;
    }else{
        rights=2;
    }
    $.ajax({
        url: "insertNewUser.php",
        method: "POST",
        dataType: "JSON",
        data:{ime:name, prezime:lastname, jmbg:jmbg, username:username,password:pwd,rights:rights },
        success: function (data) {
            $("#newUser").modal("hide");
            var idKlijenta= data['idKlijent'];
            var uname= data['ime'];
            var ulastname= data['prezime'];
            var ujmbg= data['jmbg'];
            var uusername= data['username'];
            var obrisan = data['obrisan'];
            if(obrisan==0){
                obrisan=1;
                var image=" <span class='glyphicon glyphicon-ok' onclick='changeImage("+obrisan+","+idKlijenta+")'></span>";
            }else{
                obrisan=0;
                var image=" <span class='glyphicon glyphicon-remove' onclick='changeImage("+obrisan+","+idKlijenta+")'></span>"
            }
            $("#lista").find('tbody').append("<tr id='changeThisUser'> <td><input id='klijentovId"+idKlijenta+"' type='hidden' value='"+idKlijenta+"' /></td>        <td>" + uname + "</td><td>" + ulastname + "</td><td>" + ujmbg + "</td><td>" + uusername + "</td><td id='obrisanaSlika"+idKlijenta+"'>"+image+"</td><td><input  onclick='loadUsersIntoModal("+idKlijenta+")' data-toggle='modal' data-target='#GSCCModal' value='Change' type='button' class='btn btn-success' /></td><td><input type='button' class='btn btn-danger' onclick='showUserHistory("+idKlijenta+")' value='History' /> </td></tr>");
            console.log('changeThisUser'+data['idKlijent']);



        },
        error: function (data) {
            console.log(data);
        }

    });
    }
   }



function rentACar(id){
    var toDate= $("#pickDate").val();
    var getCarId= $("#idKola").val();
    console.log("HERE"+id);
    $.ajax({
        url: "rentACar.php",
        method:"POST",
        dataType:"JSON",

        data:{datum:toDate, carId:getCarId},
        success: function(data){
            $('#rent').modal('hide');
            $("#removeThisCar"+getCarId).remove();

        },
        error:function(data){
            console.log(data);
    }
    });

}



/*function showAvailableVehicles(){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();

    $.ajax({
        url: "showAvailableVehicles.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            $('#lista').find('thead').append("<tr><th></th><th>Name</th><th>Year</th>End date<th>Description</th><th>Rent</th></tr>");
            for (var i = 0; i < data.length; i++) {
                var nazivVozila = data[i]['nazivVozila'];
                var godisteVozila = data[i]['godisteVozila'];
                var opisVozila = data[i]['opisVozila'];
                var carId= data[i]['idVozila'];
                $('#lista').find('tbody').append("<tr id='removeThisCar"+carId+"'><td><input id='currentCarId' type='hidden'  value='"+carId+"' </td><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td><td><input type='button' class='btn btn-danger' data-toggle='modal' data-target='#rent' onclick='loadCurrentDate("+carId+")' value='Rent now' />  </td></tr>");
            }

        },
        error: function (data) {
            console.log(data);
        }

    });
}*/
function loadCurrentDate(carId){
    console.log("HERE FIRST:" + carId);
    $.ajax({
        url: "getDates.php",
        method:"POST",
        dataType:"JSON",
        data:{carId:carId},
        success: function(data){
          $("#idKola").val(data['idVozila']);


        },
        error:function(data){
            console.log(data);
        }
    });

}

function showUserCar(){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "showUserCar.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            $('#lista').find('thead').append("<tr><th></th><th>Name</th><th>Year</th><th>Description</th><th>End rent</th><th>Remove</th></tr>");
            for (var i = 0; i < data.length; i++) {
                console.log(data[i]);
                var nazivVozila = data[i]['nazivVozila'];
                var godisteVozila = data[i]['godisteVozila'];
                var opisVozila = data[i]['opisVozila'];
                var carId= data[i]['idVozila'];
                var startDate=data[i]['pocetniDatum'];
                var enddate= data[i]['krajnjiDatum'];
                console.log("Pocetni datum"+startDate);
                $('#lista').find('tbody').append("<tr id='removeThis"+carId+"'><td><input id='currentCarId' type='hidden'  value='"+carId+"' </td><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td><td id='updateThis'>"+enddate+"</td><td><input type='button' class='btn btn-success' onclick='removeCarFromUser("+carId+",\""+startDate+"\")' value='Remove' />  </td></tr>");
            }

        },
        error: function (data) {
            console.log(data);
        }

    });

}

function changeCurrentCar(idCar){
    $("#updateidKola").val(idCar);

}
function updateRent() {
    var carId=$("#updateidKola").val();
    var endDate=$("#updatepickDate").val();
    $.ajax({
        url: "updateCarRent.php",
        method: "POST",
        dataType: "JSON",
        data:{carId:carId, endDate:endDate},
        success: function (data) {
            $("#updateThis").html(data['krajnjiDatum']);

        },
        error: function (data) {
            console.log(data);
        }

    });

}



function removeCarFromUser(carId,startDate){
console.log("Datum trenutan : "+startDate);
    $.ajax({
        url: "removeCarFromUser.php",
        method: "POST",
        dataType: "JSON",
        data:{carId:carId, startDate:startDate},
        success: function (data) {
            $("#removeThis"+carId).remove();


        },
        error: function (data) {
            console.log(data);
        }

    });
}

function proveraDostupnostiVozila(){
    var datumOd= $("#pickDateOd").val();
    var datumDo= $("#pickDateDo").val();
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "checkIfCarIsAvailable.php",
        method: "POST",
        dataType: "JSON",
        data:{datumOd:datumOd, datumDo:datumDo},
        success: function(data) {
            $("#reserveRent").modal("hide");
            if(data[1]==1){
                var nazivOpcije= 'Service car';
            }else{
                nazivOpcije='Book car';
            }
            $('#lista').find('thead').append("<tr><th></th><th>Name</th><th>Year</th>End date<th>Description</th><th>"+nazivOpcije+"</th></tr>");
            for (var i = 0; i < data[0].length; i++) {
                var nazivVozila = data[0][i]['nazivVozila'];
                var godisteVozila = data[0][i]['godisteVozila'];
                var opisVozila = data[0][i]['opisVozila'];
                var carId= data[0][i]['idVozila'];
                if(data[1]==2){
                    var reserveCar="<td><input type='button' class='btn btn-danger' onclick='putCarId("+carId+"); reserveVehicle()' value='Book car' />  </td>";
                }else{
                    var reserveCar="<td><input type='button' class='btn btn-danger' onclick='putCarId("+carId+"); reserveVehicle()' value='Service car' />  </td>";
                }
                $('#lista').find('tbody').append("<tr id='removeThisCar"+carId+"'><td><input id='currentCarId' type='hidden'  value='"+carId+"' </td><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td>"+reserveCar+"</tr>");

            }

        },
        error: function (data) {
            console.log(data);
        }

    });
}


function putCarId(carId){
    $("#idKolaRezervacije").val(carId);

}

function reserveVehicle() {
    if (!confirm('Are you sure you want to add this car?')) {
            console.log("Nothing");
    } else {
        // Do nothing!

        var datumOd = $("#pickDateOd").val();
        var datumDo = $("#pickDateDo").val();
        var idCar = $("#idKolaRezervacije").val();;
        console.log("OD: " + datumOd + "DO: " + datumDo, "ID:" + idCar);
        $.ajax({
            url: "insertReservation.php",
            method: "POST",
            dataType: "JSON",
            data: {datumOd: datumOd, datumDo: datumDo, idCar: idCar},
            success: function (data) {
                $("#removeThisCar"+idCar).remove();


            },
            error: function (data) {
                console.log(data);
            }

        });
    }

}



function showCarHistory(carId){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
        $.ajax({
            url: "showCarHistory.php",
            method: "POST",
            dataType: "JSON",
            data: {carId:carId},
            success: function (data) {
                console.log(data);
                $('#lista').find('thead').append("<tr><th></th><th>Name</th><th>Last name</th><th>Jmbg</th><th>Username</th></tr>");
                for (var i = 0; i < data.length; i++) {
                    var uname = data[i]['ime'];
                    var ulastname = data[i]['prezime'];
                    var ujmbg = data[i]['jmbg'];
                    var uusername = data[i]['username'];
                    var idKlijenta = data[i]['idKlijent'];
                    $('#lista').find('tbody').append("<tr id='changeThisUser'> <td><input id='klijentovId" + idKlijenta + "' type='hidden' value='" + idKlijenta + "' /></td>        <td id='updateUserName'>" + uname + "</td><td id='updateUserLastName'>" + ulastname + "</td><td id='updateUserJmbg'>" + ujmbg + "</td><td id='updateUserUsername'>" + uusername + "</td></tr>");
                }

            },
            error: function (data) {
                console.log(data);
            }

        });

}

function showUserHistory(klijentId){

    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "showKlijentHistory.php",
        method: "POST",
        dataType: "JSON",
        data:{klijentId:klijentId},
        success: function (data) {
            $('#lista').find('thead').append("<tr><th>Name</th><th>Year</th><th>Description</th></tr>");
            for (var i = 0; i < data.length; i++) {
                var nazivVozila = data[i]['nazivVozila'];
                var godisteVozila = data[i]['godisteVozila'];
                var opisVozila = data[i]['opisVozila'];
                var carId= data[i]['idVozila'];
                $('#lista').find('tbody').append("<tr id='changeThisCars'><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td></tr>");
            }

        },
        error: function (data) {
            console.log(data);
        }

    });

}

function showPersonalInfo(){

    $.ajax({
        url: "loadClientPersonalInfo.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            $("#name").val(data['ime']);
            $("#lastName").val(data['prezime']);
            $("#userName").val(data['username']);
            $("#pwd").val(data['password']);
            $("#jmbg").val(data['jmbg']);
            $("#id-klijent").val(data['idKlijent']);
            console.log("ID KLIJENTA:" +data['idKlijent']);
            if(data['rights']=='1'){
                $("#rights").prop('checked',true)
            }else{
                $("#rights").prop('checked',false)
            }





        },
        error: function (data) {
            console.log('Error');
        }

    });



}



function changePersonalInfo(){
    console.log(idObrisan, klijentId);
    $.ajax({
        url: "logickoBrisanjeKlijenta.php",
        method: "POST",
        dataType: "JSON",
        data:{idObrisan:idObrisan, klijentId:klijentId},
        success: function (data) {
            var dataKlijentId= data['idKlijent'];
            var dataObrisanId= data['obrisan'];
            if(dataObrisanId==1){
                dataObrisanId=0;
                $("#lista").find("#obrisanaSlika"+data['idKlijent']).html("<span id='obrisanaSlika"+dataKlijentId+"' class='glyphicon glyphicon-remove' onclick='changeImage("+dataObrisanId+","+dataKlijentId+")'></span>");
            }else{
                dataObrisanId=1;
                $("#lista").find("#obrisanaSlika"+data['idKlijent']).html("<span id='obrisanaSlika"+klijentId+"' class='glyphicon glyphicon-ok' onclick='changeImage("+dataObrisanId+","+dataKlijentId+")'></span>");
            }
        },
        error: function (data) {
            console.log("ERROR");
        }

    });

}

function showCarSchecdule(){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "checkServiceCar.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            $('#lista').find('thead').append("<tr><th>Car</th><th>Service started</th><th>Service Ended</th><th>Changes Made</th><th>Cost</th></tr>");
            for (var i = 0; i < data.length; i++) {
                var ps= data[i]['pocetniDatum'];
                var ks= data[i]['krajnjiDatum'];
                var promene= data[i]['promene'];
                var cena= data[i]['cena'];
                var idVozila= data[i]['nazivVozila'];


            $('#lista').find('tbody').append("<tr><td>" + idVozila + "</td><td>" + ps + "</td><td>" + ks + "</td><td>" + promene + "</td><td>" + cena+" (RSD)"+  "</td></tr>");
            }
        },
        error: function (data) {
            console.log(data);
        }

    });


}


function checkIfThereIsCarsForService(){
    $.ajax({
        url: "checkService.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data=='NO'){
                //$("#setWarning").html("No cars");
            }else{

            var count=1;
           for(var i = 0; i<data.length;i++){
               count=count+i;
              var naziv = data[i]['nazivVozila'];
               var godiste = data[i]['godisteVozila'];
               var opis = data[i]['opisVozila'];
               var idVozila = data[i]['idVozila'];
               $('#lista').find('tbody').append("<tr><td>"+count+"</td><td>" + naziv + "</td><td>" + godiste + "</td><td>" + opis + "</td><td><input class='btn btn-danger' value='Service' type='button' onclick='rentACar("+idVozila+")' /> </td></tr>");
           }
            }
        },
        error: function (data) {
            console.log("ERROR"+data);
        }

    });
}

function showCarsOnRent(){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "showCarsOnService.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            $('#lista').find('thead').append("<tr><th>Car</th><th>Year</th><th>Description</th><th>Service started</th><th>Service Ended</th><th>Remove</th></tr>");
                for(var i = 0; i<data.length;i++){
                    var naziv = data[i]['nazivVozila'];
                    var godiste = data[i]['godisteVozila'];
                    var opis = data[i]['opisVozila'];
                    var idVozila = data[i]['idVozila'];
                    var pocetniDatum = data[i]['pocetniDatum'];
                    var krajnjiDatum = data[i]['krajnjiDatum'];
                    $('#lista').find('tbody').append("<tr><td>" + naziv + "</td><td>" + godiste + "</td><td>" + opis + "</td><td>" + pocetniDatum + "</td><td>" + krajnjiDatum + "</td><td><input class='btn btn-danger' value='Remove' type='button' data-toggle='modal' data-target='#insertService' onclick='putAgainCaraId("+idVozila+",\""+pocetniDatum+"\")' /> </td></tr>");
            }
        },
        error: function (data) {
            console.log("ERROR"+data);
        }

    });
}

function putAgainCaraId(carId, pocetniDatum){
    var test1=$("#idAutomobila").val(carId);
    var test2= $("#pocetniDatumAutomobila").val(pocetniDatum);
    console.log("HERE"+carId,pocetniDatum)

}

function insertService(){
    var promene= $("#promene").val();
    var cena= $("#cena").val();
    var idKola= $("#idAutomobila").val();
    var pocetniDatum= $("#pocetniDatumAutomobila").val();
    console.log(promene,cena,idKola, pocetniDatum);
    $.ajax({
        url: "insertIntoReservation.php",
        method: "POST",
        dataType: "JSON",
        data: {promene:promene, cena:cena,idKola:idKola, pocetniDatum:pocetniDatum},
        success: function (data) {
            showCarsOnRent();
        },
        error: function (data) {
            console.log(data);
        }

    });
}

function showCarsCurrentlyOnService(){
    $('#lista').find('thead').empty();
    $('#lista').find('tbody').empty();
    $.ajax({
        url: "showNotification.php",
        method: "POST",
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            if(!jQuery.isEmptyObject( data )){
                $('#lista').find('thead').append("<tr><th>Name</th><th>Year</th><th>Description</th></tr>");
                var counter=0;
                for (var i = 0; i < data.length; i++) {
                    counter++;

                    var nazivVozila = data[i]['nazivVozila'];
                    var godisteVozila = data[i]['godisteVozila'];
                    var opisVozila = data[i]['opisVozila'];
                    var carId= data[i]['idVozila'];
                    $('#lista').find('tbody').append("<tr id='changeThisCars'><td>" + nazivVozila + "</td><td>" + godisteVozila + "</td><td>" + opisVozila + "</td></tr>");
                }
                $("#counter").text("0");
            }
        },
        error: function (data) {
            console.log(data);
        }

    });
}
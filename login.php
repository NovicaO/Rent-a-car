<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
    <?php include_once "includes.php"?>
</head>
<body>

<div align="center" class="well"  id="error" style="color:red;"></div>
<div class="container" align="center">
        <img src="http://cecs-me.com/wp-content/uploads/2015/02/code3-Logo.jpg" width="250px"/>

            <input type="text" class="form-control" id="username" placeholder="Enter your name" name="username">
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
    <br/>
        <button  class="btn btn-danger" onclick="proveraKorisnikaUBazi()">Login</button>
</div>
</body>
</html>
<style>
        img{
            padding-bottom: 15%;
        }
    input{
        width:25%;
        text-align:center;
    }
    body{
        background-color: #f5f5f5;
    }
        ::-webkit-input-placeholder {
            text-align: center;
        }

        :-moz-placeholder { /* Firefox 18- */
            text-align: center;
        }

        ::-moz-placeholder {  /* Firefox 19+ */
            text-align: center;
        }

        :-ms-input-placeholder {
            text-align: center;
        }
</style>
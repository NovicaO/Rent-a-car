<?php
$rights= $_SESSION['rights'];
include "includes.php";


?>
<script>
    var rights= <?php echo $rights ?>
    window.setTimeout(function() {
        if(rights==2){
        window.location = 'klijent.php';
        }else{
            window.location ="admin.php";
        }
    }, 5000);
</script>
<div class="alert alert-danger" role="alert" align="center">Please don't play with links.</div>
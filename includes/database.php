<?php
       $connect = mysqli_connect('localhost', 'root', 'Podlaga55#', 'cms');

       if(mysqli_connect_errno()) {
        exit('failed to connect to MySQL');
       }

?>
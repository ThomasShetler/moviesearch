<?php
        include "dbConfig.php";
        if(array_key_exists('button1', $_POST)) { 
            button1(); 
        } 
        else if(array_key_exists('button2', $_POST)) { 
            button2(); 
        } 
        function button1() { 
            mysqli_query($db,"update rating set ratingup = ratingup + 1 where imdb_id = '".$id."'");; 
        } 
        function button2() { 
            echo "This is Button2 that is selected"; 
        } 
?> 
<?php
//connect to the db

if($_SERVER["HTTP_HOST"]=="127.0.0.1" || $_SERVER["HTTP_HOST"]=="localhost"){

   // LOCAL MACHINE SETTINGS
   $servername = "127.0.0.1";
   $username = "root";
   $password = "";
   $database = "foodpantry";

   $GLOBAL_API_KEY = "848429r2g";

}else{

   // LIVE WEB SERVER SETTINGS
   $servername = "srv557.hstgr.io";
   $username = "u413142534_bjpantry";
   $password = "YumF00d!";
   $database = "u413142534_bjpantrydb";

   $GLOBAL_API_KEY = "848429r2g";
}
?>

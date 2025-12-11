<?php
session_start();
define("UPLOAD_DIR", "./uploads/");
//require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper("gateway01.us-west-2.prod.aws.tidbcloud.com", "ez63dTPt7Z9E28X.root", "jNW6Ia9LRkEgCtMa", "TavolateDB", 4000);
?>
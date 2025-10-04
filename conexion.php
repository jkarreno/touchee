<?php

$conn=mysqli_connect ("localhost", "kraps_touchee",
"Touchee2020#") or die('Cannot connect to the database because: ' . mysqli_error());
mysqli_select_db ($conn, "kraps_touchee");

//@jkarreno 2020
?>
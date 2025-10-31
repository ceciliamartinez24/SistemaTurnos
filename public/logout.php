<?php
session_start();
session_destroy();
header("Location: Turnos/login.php"); 
exit();
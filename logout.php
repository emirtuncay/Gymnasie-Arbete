<?php
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit();

// LÄNKA DEN NÅNSTANS SENARE TYP HREF = LOGOUT.PHP I INDEX.HTML KSK
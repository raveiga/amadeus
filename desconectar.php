<?php
@session_start();
@session_destroy();
@session_start();
header("location: index.html");
?>

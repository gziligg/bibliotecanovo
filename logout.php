<?php
session_start();
session_destroy();
header('Location: ../screen/log.php');
exit();
?>

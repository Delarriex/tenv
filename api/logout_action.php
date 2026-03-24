<?php
/**
 * User Logout Action
 */
session_start();
session_unset();
session_destroy();

header('Location: ../my-account/login/index.php');
exit();
?>

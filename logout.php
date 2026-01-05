<?php
session_start();
session_unset();      // clear session variables
session_destroy();    // end the session

/* redirect user after logout */
header("Location: index.php");   // ← send them to your starting page
exit;
?>

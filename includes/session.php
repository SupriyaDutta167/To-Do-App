<?php
// includes/session.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Prevent session fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}
?>
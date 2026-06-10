<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect the user to the index.htm page
header('Location: index.htm');
exit(); // Stop further execution

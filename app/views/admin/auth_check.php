<?php
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /login?error=Please login first");
    exit();
}

// Check if user is admin
if ($_SESSION["user_role"] !== "admin") {
    header("Location: /?error=Access denied - Admin only");
    exit();
}

<?php
session_start();
session_destroy();
header("Location: /login?success=Logged out successfully");
exit();

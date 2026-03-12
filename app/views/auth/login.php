<?php
require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../models/User.php";

session_start();

$database = new Database();
$db = $database->connect();

// Process login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        header("Location: /login?error=Email and password required");
        exit();
    }

    $userModel = new User($db);
    $user = $userModel->getByEmail($email);

    if (!$user || !password_verify($password, $user["password"])) {
        header("Location: /login?error=Invalid email or password");
        exit();
    }

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["user_name"] = $user["name"];
    $_SESSION["user_role"] = $user["role"];

    if ($user["role"] === "admin") {
        header("Location: /admin/users");
    } else {
        header("Location: /");
    }
    exit();
}

$error = $_GET["error"] ?? null;
$success = $_GET["success"] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cafeteria Login</title>
<?php include __DIR__ . "/../layouts/jsCDN.php"; ?>
</head>
<body>

<div class="container mt-5" style="max-width: 500px;">

    <h1 class="text-center mb-4">Cafeteria</h1>

    <?php if ($error) { ?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars(
        $error,
    ); ?></div>
    <?php } ?>

    <?php if ($success) { ?>
    <div class="alert alert-success text-center"><?php echo htmlspecialchars(
        $success,
    ); ?></div>
    <?php } ?>

    <form action="" method="post">

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                name="email"
                required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <!-- Login Button -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>

    </form>
</div>
</body>
</html>

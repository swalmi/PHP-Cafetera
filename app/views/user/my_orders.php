<?php
require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../controllers/OrderController.php";

$database = new Database();
$db = $database->connect();

$orderController = new OrderController($db);
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: /login");
    exit();
}

$fromDate = trim($_GET["from"] ?? "");
$toDate = trim($_GET["to"] ?? "");

$orders = $orderController->getUserOrdersForChecks(
    $userId,
    $fromDate !== "" ? $fromDate : null,
    $toDate !== "" ? $toDate : null,
);

$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Orders - Cafeteria</title>

<?php include_once __DIR__ . "/../layouts/jsCDN.php"; ?>

<style>

.page-title {
    font-weight: 700;
    color: #4E342E;
}

.orders-card {
    border: none;
    border-radius: 14px;
    overflow: hidden;
}

.orders-table thead {
    background: #4E342E;
}

.orders-table th {
    background: #4E342E;
    color: #fff;
    font-weight: 600;
    border: none;
}

.orders-table td {
    vertical-align: middle;
    border-color: #4E342E;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
}

.btn-action {
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 0.85rem;
    border-color: #4E342E !important;
    background: #4E342E !important;
    color: #fff !important;
    transition: all .25s ease;
}

.btn-action:hover {
    background: #6f4e37 !important;
    border-color: #6f4e37 !important;
}

.cancel {
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 0.85rem;
    background: #dc3545 !important;
    border: 1px solid #dc3545 !important;
    color: #fff !important;
    transition: all .25s ease;
}

a.cancel:hover,
.btn.cancel:hover {
    background: #ffffff !important;
    color: #dc3545 !important;
    border-color: #dc3545 !important;
}

.alert {
    border-radius: 12px;
}

.btn-filter {
    background: #4E342E;
    border: none;
    color: #fff;
    padding: 8px 22px;
    border-radius: 25px;
    font-weight: 600;
    transition: .25s;
}

.btn-filter:hover {
    background: #6f4e37;
}

.btn-clear {
    border-radius: 20px;
    padding: 8px 20px;
    font-size: 0.9rem;
    transition: all 0.25s ease;
    border: 1px solid #4E342E;
    background: transparent;
    color: #4E342E;
    text-decoration: none;
}

.btn-clear:hover {
    background: #4E342E;
    color: #fff;
    border-color: #4E342E;
    text-decoration: none;
}

.empty-orders {
    background: white;
    padding: 40px;
    border-radius: 14px;
    text-align: center;
}

.empty-orders a {
    color: #6f4e37;
    font-weight: 600;
    text-decoration: none;
}

.empty-orders a:hover {
    text-decoration: underline;
}
</style>

</head>

<body>

<?php include __DIR__ . "/../layouts/navbar.php"; ?>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">My Orders</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
                <form class="row g-3" method="GET" action="/my-orders">
            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($fromDate) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($toDate) ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn-filter">Filter</button>
                <a href="/my-orders" class="btn-clear">Clear</a>
            </div>
        </form>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success">
    <?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>

<?php if (!empty($orders)): ?>

<div class="card orders-card">
<div class="card-body p-0">

<table class="table orders-table mb-0">

<thead>
<tr>
    <th>Order ID</th>
    <th>Room</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php foreach ($orders as $order): ?>

<tr>

<td>#<?= (int)$order['id'] ?></td>

<td>
<?= htmlspecialchars($order['room_name'] ?? 'N/A') ?>
</td>

<td>
<?= number_format((float)$order['total_price'], 2) ?> $
</td>

<td>

<?php
$statusClass = match($order['status']) {
    'processing' => 'warning',
    'out_for_delivery' => 'info',
    'done' => 'success',
    'cancelled' => 'danger',
    default => 'secondary'
};
?>

<span class="badge bg-<?= $statusClass ?>">
<?= ucfirst(str_replace('_',' ',$order['status'])) ?>
</span>

</td>

<td>
<?= date('M d, Y H:i', strtotime($order['created_at'])) ?>
</td>

<td>

<a href="/order/details?id=<?= (int)$order['id'] ?>"
   class="btn btn-sm btn-action">
   View Details
</a>

<?php if ($order['status'] === 'processing'): ?>

<a href="/order/cancel?id=<?= (int)$order['id'] ?>"
   class="btn btn-sm cancel"
   onclick="return confirm('Are you sure you want to cancel this order?')">
   Cancel
</a>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>
</div>

<?php else: 

$hasFilters = $fromDate !== "" || $toDate !== "";
?>

<div class="empty-orders">
<?php if ($hasFilters): ?>
    <h5>No Orders Found</h5>
    <p class="text-muted">No orders found for the selected date range.</p>
<?php else: ?>
    <h5>No Orders Yet ☕</h5>
    <p class="text-muted">You haven't placed any orders yet.</p>
    <a href="/">Browse products</a>
<?php endif; ?>
</div>

<?php endif; ?>

</div>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.js"></script>

</body>
</html>
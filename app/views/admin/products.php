<link rel="stylesheet" href="/assets/css/bootstrap.css">

<style>
  .content {
    padding: 28px;
  }
  .panel {
    background: #fff;
    border:none;
    border-radius:14px;
    overflow:hidden;
  }
  .product-img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 8px;
  }
  .badge-category {
    background: #e8f5e9;
    color: #2e7d32;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 600;
  }
  .page-title{
    font-weight:700;
    color:#4E342E;
  }
  .table thead{
    background:#4E342E;
    color:#fff;
  }
  .table th{
    background:#4E342E;
    color:#fff;
    font-weight:600;
    border:none;
  }
  .btn-action{
    border-radius:20px;
    padding:4px 12px;
    font-size:0.85rem;
    transition:all .25s ease;
    border-color:#4E342E;
    background:#4E342E;
    color:#fff;
  }
  .btn-action:hover{
    background:#6f4e37;
    border-color:#6f4e37;
    color:#fff;
  }
  .btn-delete{
    border-radius:20px;
    padding:4px 12px;
    font-size:0.85rem;
    transition:all .25s ease;
    border-color: #dc3545;
    background:#dc3545;
    color:#fff;
    text-decoration: none;
  }
  .btn-delete:hover{
    color:#dc3545;
    background:#fff;
    border-color:#dc3545;
    text-decoration: none;
  }
  .alert{
    border-radius:12px;
  }
</style>

<?php
  require_once __DIR__ . '/../layouts/navbar.php';
  require_once __DIR__ . '/../../controllers/ProductController.php';

  $productController = new ProductController();
  $products          = $productController->getAllProducts();
?>

  <main class="content">
    <div class="panel">

<div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="page-title mb-0">All Products</h2>
          <div class="text-muted small">Dashboard &gt; Products</div>
        </div>
        <a href="/admin/add-product" 
           class="btn btn-action">
          + Add New Product
        </a>
      </div>

      <?php if(isset($_GET['msg'])): ?>
        <?php switch($_GET['msg']):
          case 'product_updated': ?>
            <div class="alert alert-success alert-dismissible fade show">
              Product Updated Successfully!
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php break; ?>

          <?php case 'product_deleted': ?>
            <div class="alert alert-warning alert-dismissible fade show">
               Product Deleted Successfully!
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php break; ?>

          <?php case 'error': ?>
            <div class="alert alert-danger alert-dismissible fade show">
              Something went wrong!
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php break; ?>

          <?php case 'product_in_use': ?>
            <div class="alert alert-danger alert-dismissible fade show">
              Cannot delete this product because it is already used in orders.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php break; ?>

        <?php endswitch; ?>
      <?php endif; ?>

      <!-- Table -->
      <?php if(empty($products)): ?>
        <div class="text-center text-muted py-5">
          <h5>No products found</h5>
          <a href="/admin/add-product" class="btn btn-success mt-2">
            Add Your First Product
          </a>
        </div>

      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($products as $index => $product): ?>
                <tr>
                  <td><?= $index + 1 ?></td>

                  <td>
                    <?php
                      $imageFile = (string) $product['image'];
                      if ($imageFile !== '' && filter_var($imageFile, FILTER_VALIDATE_URL)) {
                        $imageSrc = $imageFile;
                      } else {
                        $productImageFs = __DIR__ . '/../../../public/assets/images/products/' . $imageFile;
                        $legacyImageFs = __DIR__ . '/../../../public/assets/images/' . $imageFile;
                        if (file_exists($productImageFs)) {
                          $imageSrc = '/assets/images/products/' . rawurlencode($imageFile);
                        } elseif (file_exists($legacyImageFs)) {
                          $imageSrc = '/assets/images/' . rawurlencode($imageFile);
                        } else {
                          $imageSrc = '';
                        }
                      }
                    ?>
                    <?php if ($imageSrc !== ''): ?>
                    <img 
                      src="<?= htmlspecialchars($imageSrc) ?>" 
                      alt="<?= htmlspecialchars($product['name']) ?>"
                      class="product-img"
                    >
                    <?php else: ?>
                    <span class="text-muted small">No Image</span>
                    <?php endif; ?>
                  </td>

                  <td><?= htmlspecialchars($product['name']) ?></td>

                  <td>
                    <span class="badge-category">
                      <?= htmlspecialchars($product['category_name']) ?>
                    </span>
                  </td>

                  <td>EGP <?= number_format($product['price'], 2) ?></td>

                  <td><?= date('d M Y', strtotime($product['created_at'])) ?></td>

<td>
                    <div class="d-flex gap-2">
                      <a href="/admin/edit-product?id=<?= $product['id'] ?>" 
                         class="btn btn-sm btn-action">
                        Edit
                      </a>

                       <a href="/admin/products/delete?id=<?= $product['id'] ?>&image=<?= urlencode($product['image']) ?>"
                         class="btn-delete"
                         onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($product['name']) ?>?')">
                        Delete
                     </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </main>
<?php
$title = "Đăng ký học phần";
require_once 'views/layout/header.php';
?>

<div class="container mt-4 main-content">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap"> <!-- flex-wrap for smaller screens -->
        <h1 class="mb-2 mb-md-0"><i class="fas fa-edit mr-2 text-primary"></i>Danh sách học phần</h1>
        <div>
            <a href="index.php?controller=hocphan&action=cart" class="btn btn-info mr-2 mb-1">
                <i class="fas fa-shopping-cart mr-1"></i> Xem giỏ hàng
                <?php
                    // Optional: Display item count in cart (requires cart count passed from controller)
                    if (isset($cartItemCount) && $cartItemCount > 0) {
                        echo '<span class="badge badge-light ml-1">' . $cartItemCount . '</span>';
                    }
                ?>
            </a>
            <a href="index.php?controller=hocphan&action=registered" class="btn btn-success mb-1">
                <i class="fas fa-check-circle mr-1"></i> Xem đã đăng ký
            </a>
        </div>
    </div>

     <?php
    // Display flash messages (e.g., success after adding to cart)
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . ($_SESSION['message_type'] ?? 'success') . ' alert-dismissible fade show" role="alert">';
        echo $_SESSION['message'];
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
        echo '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>

    <div class="card shadow-sm">
         <div class="card-header bg-light font-weight-bold d-none d-md-block">
             <div class="row">
                 <div class="col-md-2">Mã HP</div>
                 <div class="col-md-4">Tên Học Phần</div>
                 <div class="col-md-2 text-center">Số tín chỉ</div>
                 <div class="col-md-2 text-center">SL còn lại</div>
                 <div class="col-md-2 text-center">Thêm vào giỏ</div>
             </div>
        </div>
        <div class="card-body p-0">
             <?php if (empty($hocphans) || !is_array($hocphans)): ?>
                <div class="alert alert-warning text-center m-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Hiện không có học phần nào có thể đăng ký.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                         <thead class="d-md-none">
                            <tr>
                                <th>Mã HP</th>
                                <th>Tên HP</th>
                                <th class="text-center">TC</th>
                                <th class="text-center">SL</th>
                                <th class="text-center">Thêm</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hocphans as $hp):
                                $isAvailable = isset($hp['SoLuongDuKien']) && $hp['SoLuongDuKien'] > 0;
                                // Optional: Check if already in cart (requires cart data passed from controller)
                                $isInCart = $hp['isInCart'] ?? false;
                                // Optional: Check if already registered (requires registered data passed from controller)
                                $isRegistered = $hp['isRegistered'] ?? false;
                            ?>
                            <tr class="<?php echo !$isAvailable ? 'table-secondary text-muted' : ($isRegistered ? 'table-success' : ''); ?>">
                                <td class="align-middle font-weight-bold" data-label="Mã HP: ">
                                    <?php echo htmlspecialchars($hp['MaHP'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="align-middle" data-label="Tên HP: ">
                                    <?php echo htmlspecialchars($hp['TenHP'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                    <?php if ($isRegistered): ?>
                                        <span class="badge badge-success ml-1">Đã ĐK</span>
                                    <?php elseif ($isInCart): ?>
                                         <span class="badge badge-info ml-1">Trong giỏ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle" data-label="Số TC: ">
                                    <?php echo htmlspecialchars($hp['SoTinChi'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-center align-middle font-weight-bold <?php echo !$isAvailable ? 'text-danger' : 'text-success'; ?>" data-label="SL Còn lại: ">
                                    <?php echo htmlspecialchars($hp['SoLuongDuKien'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-center align-middle" data-label="Hành động: ">
                                    <?php if ($isRegistered): ?>
                                         <button class="btn btn-secondary btn-sm" disabled title="Đã đăng ký học phần này">
                                             <i class="fas fa-check"></i>
                                         </button>
                                    <?php elseif ($isInCart): ?>
                                         <a href="index.php?controller=hocphan&action=cart" class="btn btn-info btn-sm" title="Xem trong giỏ hàng">
                                             <i class="fas fa-shopping-cart"></i>
                                         </a>
                                    <?php elseif ($isAvailable): ?>
                                        <form method="post" action="index.php?controller=hocphan&action=addToCart" style="display:inline-block;">
                                            <input type="hidden" name="MaHP" value="<?php echo htmlspecialchars($hp['MaHP'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="TenHP" value="<?php echo htmlspecialchars($hp['TenHP'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="SoTinChi" value="<?php echo htmlspecialchars($hp['SoTinChi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" name="add" class="btn btn-success btn-sm" title="Thêm vào giỏ hàng">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled title="Hết chỗ hoặc không thể đăng ký">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            <?php endif; ?>
        </div><!-- /.card-body -->
        <!-- Optional: Add pagination if the list is long -->
        <?php /*
        if (isset($totalPages) && $totalPages > 1) {
             echo '<div class="card-footer bg-light d-flex justify-content-center">';
             // Include pagination view or generate links here
             echo '</div>';
        }
        */ ?>
    </div><!-- /.card -->

</div> <!-- /.container -->

<?php require_once 'views/layout/footer.php'; ?>
<?php
// Tooltip activation script (if not already in footer.php)
// echo '<script>$(function () { $(\'[data-toggle="tooltip"]\').tooltip() });</script>';
?>
<?php
$title = "Giỏ hàng học phần";
require_once 'views/layout/header.php'; // Ensure header is updated
?>

<div class="container mt-4 main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-shopping-cart mr-2"></i>Giỏ hàng học phần</h1>
        <a href="index.php?controller=hocphan&action=index" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
        </a>
    </div>

    <?php
    // Optional: Display success/error messages from controller actions (like after saving registration)
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
        <div class="card-header bg-light d-none d-md-block"> <!-- Hide header on small screens where table headers are enough -->
            <div class="row font-weight-bold">
                <div class="col-md-2">Mã HP</div>
                <div class="col-md-5">Tên Học Phần</div>
                <div class="col-md-2 text-center">Số tín chỉ</div>
                <div class="col-md-3 text-center">Hành động</div>
            </div>
        </div>

        <div class="card-body p-0"> <!-- p-0 removes padding to make table flush with card edges -->
            <?php if (empty($cartItems) || !is_array($cartItems)): ?>
                <div class="alert alert-info text-center m-3">
                    <i class="fas fa-info-circle mr-2"></i> Giỏ hàng của bạn hiện đang trống. Hãy <a href="index.php?controller=hocphan&action=index">chọn học phần</a> để thêm vào giỏ.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0"> <!-- Removed table-bordered for a cleaner look inside card -->
                        <thead class="d-md-none"> <!-- Show table headers only on small screens -->
                            <tr>
                                <th>Mã HP</th>
                                <th>Tên HP</th>
                                <th class="text-center">TC</th>
                                <th class="text-center">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalCredits = 0; // Initialize total credits
                            foreach ($cartItems as $item):
                                $totalCredits += (int)($item['SoTinChi'] ?? 0); // Calculate total credits safely
                            ?>
                            <tr>
                                <td class="align-middle font-weight-bold" data-label="Mã HP: ">
                                    <?php echo htmlspecialchars($item['MaHP'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="align-middle" data-label="Tên HP: ">
                                    <?php echo htmlspecialchars($item['TenHP'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-center align-middle" data-label="Số TC: ">
                                    <?php echo htmlspecialchars($item['SoTinChi'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-center align-middle" data-label="Hành động: ">
                                    <form method="post" action="index.php?controller=hocphan&action=removeFromCart" style="display:inline-block;">
                                        <input type="hidden" name="MaHP" value="<?php echo htmlspecialchars($item['MaHP'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" name="remove" class="btn btn-danger btn-sm" title="Xóa học phần này"
                                                onclick="return confirm('Bạn có chắc muốn xóa học phần \'<?php echo htmlspecialchars(addslashes($item['TenHP'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>\' khỏi giỏ hàng?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                             <!-- Optional: Row to display total credits -->
                            <tr class="table-light font-weight-bold">
                                <td colspan="2" class="text-right">Tổng số tín chỉ:</td>
                                <td class="text-center"><?php echo $totalCredits; ?></td>
                                <td></td> <!-- Empty cell for action column -->
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            <?php endif; ?>
        </div><!-- /.card-body -->

        <?php if (!empty($cartItems) && is_array($cartItems)): ?>
        <div class="card-footer bg-light">
            <form method="post" action="index.php?controller=hocphan&action=processCart"> <!-- Single form for cart actions -->
                <div class="d-flex justify-content-between align-items-center flex-wrap"> <!-- flex-wrap for smaller screens -->
                    <button type="submit" name="clear" class="btn btn-outline-danger mb-2 mb-md-0"
                            onclick="return confirm('Bạn có chắc muốn xóa TOÀN BỘ học phần khỏi giỏ hàng?')">
                        <i class="fas fa-times-circle mr-1"></i> Xóa toàn bộ giỏ hàng
                    </button>
                    <div class="mb-2 mb-md-0">
                         <a href="index.php?controller=hocphan&action=registered" class="btn btn-info mr-2">
                            <i class="fas fa-list-alt mr-1"></i> Xem đã đăng ký
                         </a>
                        <button type="submit" name="save" class="btn btn-success btn-lg"> <!-- btn-lg for emphasis -->
                            <i class="fas fa-save mr-1"></i> Lưu đăng ký <?php echo $totalCredits; ?> tín chỉ
                        </button>
                    </div>
                </div>
            </form>
        </div><!-- /.card-footer -->
        <?php endif; ?>
    </div><!-- /.card -->

</div> <!-- /.container -->

<?php require_once 'views/layout/footer.php'; ?>
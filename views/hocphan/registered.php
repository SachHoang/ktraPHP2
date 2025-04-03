<?php
$title = "Học phần đã đăng ký";
require_once 'views/layout/header.php';
?>

<div class="container mt-4 main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-check-circle mr-2 text-success"></i>Học phần đã đăng ký</h1>
        <a href="index.php?controller=hocphan&action=index" class="btn btn-primary">
            <i class="fas fa-plus-circle mr-1"></i> Đăng ký thêm
        </a>
    </div>

    <?php
    // Display flash messages (e.g., success after registration)
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . ($_SESSION['message_type'] ?? 'success') . ' alert-dismissible fade show" role="alert">';
        echo $_SESSION['message'];
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
        echo '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    // Display message passed directly to the view (if any)
    elseif (isset($message)) {
         echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
         echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
         echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
         echo '</div>';
    }
    ?>

    <div class="card shadow-sm">
        <div class="card-header bg-light font-weight-bold d-none d-md-block">
             <div class="row">
                 <div class="col-md-2">Mã HP</div>
                 <div class="col-md-4">Tên Học Phần</div>
                 <div class="col-md-2 text-center">Số tín chỉ</div>
                 <div class="col-md-2 text-center">Ngày ĐK</div>
                 <div class="col-md-2 text-center">Hủy ĐK</div>
             </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($registeredCourses) || !is_array($registeredCourses)): ?>
                <div class="alert alert-info text-center m-3">
                    <i class="fas fa-info-circle mr-2"></i> Bạn chưa đăng ký học phần nào.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                         <thead class="d-md-none"> <!-- Show headers only on small screens -->
                            <tr>
                                <th>Mã HP</th>
                                <th>Tên HP</th>
                                <th class="text-center">TC</th>
                                <th class="text-center">Ngày ĐK</th>
                                <th class="text-center">Hủy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalRegisteredCredits = 0;
                            foreach ($registeredCourses as $course):
                                $totalRegisteredCredits += (int)($course['SoTinChi'] ?? 0);
                            ?>
                            <tr>
                                <td class="align-middle font-weight-bold" data-label="Mã HP: ">
                                    <?php echo htmlspecialchars($course['MaHP'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="align-middle" data-label="Tên HP: ">
                                    <?php echo htmlspecialchars($course['TenHP'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-center align-middle" data-label="Số TC: ">
                                    <?php echo htmlspecialchars($course['SoTinChi'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-center align-middle" data-label="Ngày ĐK: ">
                                    <?php
                                    try {
                                        // Attempt to format date (assuming NgayDK might include time)
                                        $date = new DateTime($course['NgayDK'] ?? 'now');
                                        echo $date->format('d/m/Y H:i'); // Format as dd/mm/yyyy HH:MM
                                    } catch (Exception $e) {
                                        echo htmlspecialchars($course['NgayDK'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); // Fallback
                                    }
                                    ?>
                                </td>
                                <td class="text-center align-middle" data-label="Hủy ĐK: ">
                                    <?php // Check if cancellation is allowed based on date/rules (optional logic here or in controller) ?>
                                    <a href="index.php?controller=hocphan&action=deleteRegistered&maDK=<?php echo htmlspecialchars($course['MaDK'] ?? '', ENT_QUOTES, 'UTF-8'); ?>&maHP=<?php echo htmlspecialchars($course['MaHP'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                       onclick="return confirm('Bạn có chắc chắn muốn HỦY đăng ký học phần \'<?php echo htmlspecialchars(addslashes($course['TenHP'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>\' (<?php echo htmlspecialchars($course['MaHP'] ?? '', ENT_QUOTES, 'UTF-8'); ?>)?')"
                                       class="btn btn-danger btn-sm" title="Hủy đăng ký học phần này">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                             <tr class="table-light font-weight-bold">
                                <td colspan="2" class="text-right">Tổng số tín chỉ đã đăng ký:</td>
                                <td class="text-center"><?php echo $totalRegisteredCredits; ?></td>
                                <td colspan="2"></td> <!-- Span remaining columns -->
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            <?php endif; ?>
        </div> <!-- /.card-body -->
         <div class="card-footer bg-light text-right">
             <a href="index.php?controller=hocphan&action=index" class="btn btn-secondary">
                 <i class="fas fa-arrow-left mr-1"></i> Quay lại Danh sách Học phần
             </a>
         </div>
    </div> <!-- /.card -->

</div> <!-- /.container -->

<?php require_once 'views/layout/footer.php'; ?>
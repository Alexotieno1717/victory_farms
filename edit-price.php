<?php
session_start();
include_once 'Core/Branches.php';

$branchData = new Branches();

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'No ID provided.';
    header('Location: price.php');
    exit();
}

$id = (int)$_GET['id'];
$pricing = $branchData->getPriceById($id);

if (isset($_POST['updatePrice'])) {
    $id = $_POST['id'];
    $new_price = $_POST['new_price'];
    $branch_id = $_POST['branch_id']; // Make sure to pass the branch_id from the form


    $branchData->updatePriceById($id, $new_price);

    header('Location: view-branch.php?id=' . $branch_id);
    die();
}



?>

<!doctype html>
<html lang="en">
<?php require './partials/head.php'; ?>
<body>
<div class="app-wrap">
    <?php require './partials/heading.php'; ?>
    <div class="app-container">
        <?php require './partials/sidebar.php'; ?>
        <div class="app-main">
            <div class="main-content">
                <div class="row gutters">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">Edit Price for Size: <?= htmlspecialchars($pricing['size']) ?></div>
                            <div class="card-body">
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $pricing['id'] ?>" />
                                    <input type="hidden" name="branch_id" value="<?= htmlspecialchars($pricing['branch_id']) ?>">
                                    <div class="form-group">
                                        <label for="new_price">New Price</label>
                                        <input type="text" name="new_price" id="new_price" class="form-control" value="<?= htmlspecialchars($pricing['new_price']) ?>" required>
                                    </div>
                                    <button type="submit" name="updatePrice" class="btn btn-primary">Update Price</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="main-footer fixed-btm">
        Copyright Victory Farm @2023.
    </footer>
</div>
<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="vendor/unifyMenu/unifyMenu.js"></script>
<script src="vendor/onoffcanvas/onoffcanvas.js"></script>
<script src="js/moment.js"></script>
<script src="vendor/sparkline/sparkline-retina.js"></script>
<script src="vendor/sparkline/custom-sparkline.js"></script>
<script src="vendor/slimscroll/slimscroll.min.js"></script>
<script src="vendor/slimscroll/custom-scrollbar.js"></script>
<script src="vendor/chartist/js/chartist.min.js"></script>
<script src="vendor/chartist/js/chartist-tooltip.js"></script>
<script src="vendor/chartist/js/custom/custom-line-chart3.js"></script>
<script src="vendor/chartist/js/custom/custom-area-chart.js"></script>
<script src="vendor/chartist/js/custom/donut-chart2.js"></script>
<script src="vendor/chartist/js/custom/custom-line-chart4.js"></script>
<script src="vendor/datatables/dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables/custom/custom-datatables.js"></script>
<script src="vendor/datatables/custom/fixedHeader.js"></script>
<script src="js/common.js"></script>
</body>
</html>

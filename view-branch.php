<?php
session_start();

include_once 'Core/Branches.php';

$branches = new Branches();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $branch = $branches->getBranch($id);
//    var_dump($id);
//    var_dump($branch);
    $pricing = $branches->getPricingByBranch($id);
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
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-header"><a href="index.php" class="text-info">Go Branches Lists</a></div>
                            <div class="card-body">
                                <div>
<!--                                    <h4>Branch : --><?php //= htmlspecialchars($branch['id']) ?><!--</h4>-->
                                    <h4>Branch : <?= htmlspecialchars($branch['branch']) ?></h4>
                                    <h6>Contact : <?= htmlspecialchars($branch['contact']) ?></h6>
                                    <h6>County : <?= htmlspecialchars($branch['county']) ?></h6>
                                    <p>Sub_county : <?= htmlspecialchars($branch['sub_county']) ?></p>
                                    <p>Region Name : <?= htmlspecialchars($branch['name']) ?></p>
                                </div>

                                <div class="d-flex mt-5">
                                    <div>
                                        <a href="edit-branch.php?id=<?= $branch['id'] ?>" class="btn btn-dark btn-sm mr-3">Edit Branch</a>
                                    </div>
                                    <div>
                                        <a href="delete-branch.php?id=<?= $branch['id'] ?>" class="btn btn-danger btn-sm">Delete Branch</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header"><a href="price.php" class="text-info">Pricing List for: <?= htmlspecialchars($branch['name']) ?></a></div>
                            <div class="card-body">
                                <div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>New Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($pricing as $price): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($price['size']) ?></td>
                                                <td><?= htmlspecialchars($price['new_price']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="main-footer fixed-btm">
    <?php echo "Copyright Victory Farms @" . date('Y'); ?>
    </footer>
</div>

<!-- jQuery first, then Tether, then other JS. -->
<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="vendor/unifyMenu/unifyMenu.js"></script>
<script src="vendor/onoffcanvas/onoffcanvas.js"></script>
<script src="js/moment.js"></script>
<!-- Sparkline JS -->
<script src="vendor/sparkline/sparkline-retina.js"></script>
<script src="vendor/sparkline/custom-sparkline.js"></script>
<!-- Slimscroll JS -->
<script src="vendor/slimscroll/slimscroll.min.js"></script>
<script src="vendor/slimscroll/custom-scrollbar.js"></script>
<!-- Chartist JS -->
<script src="vendor/chartist/js/chartist.min.js"></script>
<script src="vendor/chartist/js/chartist-tooltip.js"></script>
<script src="vendor/chartist/js/custom/custom-line-chart3.js"></script>
<script src="vendor/chartist/js/custom/custom-area-chart.js"></script>
<script src="vendor/chartist/js/custom/donut-chart2.js"></script>
<script src="vendor/chartist/js/custom/custom-line-chart4.js"></script>
<!-- Data Tables -->
<script src="vendor/datatables/dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap.min.js"></script>
<!-- Custom Data tables -->
<script src="vendor/datatables/custom/custom-datatables.js"></script>
<script src="vendor/datatables/custom/fixedHeader.js"></script>
<!-- Common JS -->
<script src="js/common.js"></script>
</body>
</html>

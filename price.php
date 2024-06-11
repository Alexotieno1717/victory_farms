<?php
session_start();

include_once 'Core/Branches.php';

$branchData = new Branches();
$branches = $branchData->getPriceList();
$message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Price Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

    <?php
    require './partials/head.php';
    ?>
</head>
<body>

<!-- Loading starts -->
<!-- <div class="loading-wrapper">
    <div class="loading">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> -->
<!-- Loading ends -->

<!-- BEGIN .app-wrap -->
<div class="app-wrap">

    <!-- BEGIN .app-container -->
    <?php
    require './partials/heading.php';
    ?>

    <!-- BEGIN .app-container -->
    <div class="app-container">

        <!-- BEGIN .app-side -->
        <?php require './partials/sidebar.php'; ?>

        <!-- BEGIN .app-main -->
        <div class="app-main">
            <!-- BEGIN .main-content -->
            <div class="main-content">
                <!-- Row start -->
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header mb-4">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                        <div><b>Victory Farm Regional Pricing List</b></div>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="manage-prices/index.html" class="btn btn-success float-right">Manage Prices</a>
                                    </div>
                                </div>
                            </div>

                            <table id="basicExample" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Size</th>
                                    <th scope="col">Region</th>
                                    <th scope="col">new_price</th>
<!--                                    <th scope="col">Action</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $pos = 1;
                                foreach ($branches as $branch) : ?>

                                    <tr>
                                        <td><?= $branch['size'] ?></td>
                                        <td><?= $branch['region_name'] ?></td>
                                        <td><?= $branch['new_price'] ?></td>
<!--                                        <td>-->
<!--                                            <a href="view-branch.php?id=--><?php //echo  $branch['id']; ?><!--" class="btn btn-success btn-sm"> view</a>-->
<!--                                        </td>-->
                                    </tr>

                                    <?php $pos++;
                                endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- Row end -->
            </div>
            <!-- END: .main-content -->
        </div>
        <!-- END: .app-main -->
    </div>
    <!-- END: .app-container -->
    <!-- BEGIN .main-footer -->
    <footer class="main-footer fixed-btm">
        <?php echo "Copyright Victory Farm @" . date('Y'); ?>
    </footer>
    <!-- END: .main-footer -->
</div>
<!-- END: .app-wrap -->

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

<script type="text/javascript">
    window.onload = function() {
        var message = "<?php echo addslashes($message); ?>";
        var status = "<?php echo addslashes($status); ?>";

        if (message) {
            Swal.fire({
                icon: status === 'success' ? 'success' : 'error',
                title: status === 'success' ? 'Upload Successful' : 'Upload Failed',
                text: message
            });
        }
    };
</script>

</body>
</html>

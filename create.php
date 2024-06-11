<?php
session_start();

include_once 'Core/Branches.php';

$branches = new Branches();

// Fetch regions from the database
$regions = $branches->getRegions();

// Calling the json data
$jsonData = file_get_contents('counties.json');
$counties = json_decode($jsonData, true);

// Sort the counties array by county name in ascending order
usort($counties, function ($a, $b) {
    return intval($a['code']) - intval($b['code']);
});


if (isset($_POST['createBranch'])) {
    $branch = $_POST['branch'];
    $contact = $_POST['contact'];
    $county = $_POST['county'];
    $sub_county = $_POST['sub_county'];
    $region_id = $_POST['region_id'];

    $branches->createBranches($branch, $contact, $county, $sub_county, $region_id);

    header('location: index.html');
    die();

}


?>




<!doctype html>
<html lang="en">

<?php
require './partials/head.php'
?>

<body>

<!-- BEGIN .app-wrap -->
<div class="app-wrap">

    <!-- BEGIN .app-container -->
    <?php
    require './partials/heading.php'
    ?>

    <!-- BEGIN .app-container -->
    <div class="app-container">

        <!-- BEGIN .app-side -->
        <?php require './partials/sidebar.php' ?>

        <!-- BEGIN .app-main -->
        <div class="app-main">
            <!-- BEGIN .main-content -->
            <div class="main-content">
                <!-- Row start -->
                <div class="row gutters">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mx-auto">
                        <div class="card">
                            <div class="card-header"><b>Create as Branch</b></div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <lable>Branch Name:</lable>
                                        <input type="text" name="branch" class="form-control" placeholder="Branch Name" required />
                                    </div>

                                    <div class="form-group">
                                        <lable>Contact:</lable>
                                        <input type="number" name="contact" class="form-control" placeholder="Contact Number" required />
                                    </div>

                                    <div class="form-group">
                                        <label>county</label>
                                        <select class="form-control"
                                                name="county"
                                                required
                                        >
                                            <option selected disabled></option>
                                            <?php
                                            foreach ($counties as $county) : ?>
                                                <option value="<?= $county['name'] ?>"><?= $county['name'] ?></option>

                                            <?php
                                            endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Region:</label>
                                        <select class="form-control" name="region_id" required>
                                            <option selected disabled></option>
                                            <?php foreach ($regions as $region) : ?>
                                                <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <lable>Sub-county:</lable>
                                        <input type="text" name="sub_county" class="form-control" placeholder="Sub-county" required />
                                    </div>

                                    <!-- Submit button -->
                                    <button type="submit" name="createBranch" class="btn btn-primary btn-block mt-4">Create Branch</button>

                                </form>
                            </div>
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
        Copyright Victory Farm @2023.
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

</body>

</html>
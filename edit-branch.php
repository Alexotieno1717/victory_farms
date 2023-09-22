<?php
session_start();

include_once 'Core/Branches.php';


$branches = new Branches();

// Calling the json data
$jsonData = file_get_contents('counties.json');
$counties = json_decode($jsonData, true);

// Sort the counties array by county name in ascending order
usort($counties, function ($a, $b) {
    return intval($a['code']) - intval($b['code']);
});

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $branch = $branches->getBranch($id);
//    var_dump($branch);
};

if (isset($_POST['updateBranch'])) {
    $id = $_POST['id'];
    $branch = $_POST['branch'];
    $contact = $_POST['contact'];
    $county = $_POST['county'];
    $sub_county = $_POST['sub_county'];


    $branches->updateBranches($id, $branch, $contact, $county, $sub_county);

    header('location: index.php');
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
//    require './partials/heading.php'
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header"><b>Edit Branch</b></div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <input
                                        type="hidden"
                                        id="form1Example1"
                                        name="id"
                                        class="form-control"
                                        value="<?= $branch['id'] ?>"
                                        required />
                                    <!-- Branch input -->
                                    <div class="form-outline mt-4">
                                        <label>Branch</label>
                                        <input
                                            type="text"
                                            id="form1Example1"
                                            name="branch"
                                            class="form-control"
                                            value="<?= $branch['branch'] ?>"
                                            required />
                                    </div>
                                    <?php if (isset($errors['branch'])) : ?>
                                        <p style="color: #DB504A"><?= $errors['branch'] ?></p>
                                    <?php endif; ?>

                                    <!-- Contact input -->
                                    <div class="form-outline mt-4">
                                        <label>Contact</label>
                                        <input type="number"
                                               name="contact"
                                               id="form1Example1"
                                               value="<?= $branch['contact'] ?>"
                                               class="form-control" required />
                                    </div>
                                    <?php if (isset($errors['contact'])) : ?>
                                        <p style="color: #DB504A"><?= $errors['contact'] ?></p>
                                    <?php endif; ?>

                                    <div class="form-group">
                                        <label>County</label>
                                            <select class="form-control custom-select"
                                                    name="county"
                                                    style="border: 1px solid lightgrey"
                                                    value="<?= $branch['county'] ?>"
                                                    required>
                                                <option selected disabled></option>
                                                <?php
                                                foreach ($counties as $county) : ?>
                                                    <option value="<?= $county['name'] ?>" <?= ($county['name'] === $branch['county']) ? 'selected' : '' ?>>
                                                        <?= $county['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                    </div>

                                    <!-- Sub-county input -->
                                    <div class="form-group">
                                        <label>Sub-county</label>
                                        <input type="text" name="sub_county"
                                               id="form1Example1"
                                               value="<?= $branch['sub_county'] ?>"
                                               class="form-control" />
                                    </div>
                                    <?php if (isset($errors['sub_county'])) : ?>
                                        <p style="color: #DB504A"><?= $errors['sub_county'] ?></p>
                                    <?php endif; ?>

                                    <!-- County input -->

                                    <!-- Submit button -->
                                    <button type="submit" name="updateBranch" class="btn btn-primary btn-block mt-4">Update Branch</button>

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
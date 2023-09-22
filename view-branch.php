<?php
session_start();

include_once 'Core/Branches.php';


$branches = new Branches();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $branch = $branches->getBranch($id);

//    var_dump($branch);
};

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
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header"><a href="index.php" class="text-info">Go Branches Lists</a></div>
                                    <div class="card-body">
                                        <div>
                                            <h4>Branch : <?= htmlspecialchars($branch['branch']) ?></h4>
                                            <h6>Contact : <?= htmlspecialchars($branch['contact']) ?></h6>
                                            <h6>County : <?= htmlspecialchars($branch['county']) ?></h6>
                                            <p>Sub_county : <?= htmlspecialchars($branch['sub_county']) ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 pl-3">
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
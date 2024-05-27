<?php
session_start();

include_once 'Core/Branches.php';


$branchData = new Branches();
$branches = $branchData->getBranches();

//var_dump($branches);
?>

<!doctype html>
<html lang="en">

    <?php
    require './partials/head.php'
    ?>

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
                                    <div class="card-header"><b>Victory Farm Branches List</b></div>
                                    <div class="card-body">
                                        <table id="basicExample" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Branch</th>
                                                    <th scope="col">Contact</th>
                                                    <th scope="col">County</th>
                                                    <th scope="col">Sub_county</th>
                                                    <th scope="col">Region</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pos = 1;
                                                foreach ($branches as $branch) : ?>

                                                    <tr>
                                                        <th scope="row"><?= $pos ?></th>
                                                        <td><?= $branch['branch'] ?></td>
                                                        <td><?= $branch['contact'] ?></td>
                                                        <td><?= $branch['county'] ?></td>
                                                        <td><?= $branch['sub_county'] ?></td>
                                                        <td><?= $branch['region_name'] ?></td>
                                                        <td>
                                                            <a href="view-branch.php?id=<?php echo  (int)$branch['id']; ?>" class="btn btn-success btn-sm"> view</a>
                                                        </td>
                                                    </tr>

                                                    <?php $pos++;
                                                endforeach; ?>
                                            </tbody>
                                        </table>
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

	</body>

</html>
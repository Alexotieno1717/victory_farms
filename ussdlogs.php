<?php
session_start();

include_once 'Core/USSDLogs.php';


$ussdLogsData = new USSDLogs();
//$ussd = $ussdLogsData->getUSSDLogs();


if (isset($_POST['submit_search'])) {
    $ussd_string = $_POST['ussd_string'];
    $start_date = $_POST['from'];
    $end_date = $_POST['to'];

    // Modify the searchUSSDLogs function to accept the new parameters
    $ussd = $ussdLogsData->searchUSSDLogs($ussd_string, $start_date, $end_date);
} else {
    // If the form was not submitted, retrieve all USSD logs
    $ussd = $ussdLogsData->getUSSDLogs();
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
                    <div class="card col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="row mt-4 mb-2">
                            <div class="col-md-10">
                                <!--Filter: By Date and ussd string Form -->
                                <form class="form-inline" method="POST" action="">
                                    <div class="form-group ml-2">
                                        <label for="Name2" class="">Ussd String: </label>
                                        <input type="number" class="form-control" id="ussd_string" name="ussd_string" placeholder="ussd string" value="<?= $_GET['ussd_string'] ?: '' ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="Name2" class="">From: </label>
                                        <input type="date" class="form-control" id="from" name="from" placeholder="from" value="<?= date('Y-m-d') ?>" min="2018-01-01" max="2099-12-31" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="Email2" class="ml-2">To: </label>
                                        <input class="form-control" type="date" id="to" name="to" placeholder="to" value="<?= date('Y-m-d') ?>" min="2018-01-01" max="2099-12-31" required />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit_search" class="btn btn-md ml-2 text-white" style="background-color:#0c2f55">Search</button>
                                        <button type="reset" class="btn btn-md btn-danger ml-2" name="extract" onclick="resetForm()">Reset</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <!-- Add a download button -->
                                    <button id="downloadButton" class="btn btn-md text-white" style="background-color:#0c2f55">
                                        Download CSV
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header"><b>Victory Farm Branches List</b></div>
                            <div class="card-body">
                                <table id="basicExample" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">MSISDN</th>
                                        <th scope="col">SERVICE CODE</th>
                                        <th scope="col">USSD STRING</th>
                                        <th scope="col">SESSION ID</th>
                                        <th scope="col">DATE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $pos = 1;
                                    foreach ($ussd as $item) : ?>

                                        <tr>
                                            <th scope="row"><?= $pos ?></th>
                                            <td><?= $item['MSISDN'] ?></td>
                                            <td><?= $item['SERVICE_CODE'] ?></td>
                                            <td><?= $item['USSD_STRING'] ?></td>
                                            <td><?= $item['SESSION_ID'] ?></td>
                                            <td><?= $item['dateModified'] ?></td>
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
        Copyright Victory Farm @2023.
    </footer>
    <!-- END: .main-footer -->
</div>
<!-- END: .app-wrap -->

<script>
    function resetForm() {
        // Get references to the form elements
        let ussdStringInput = document.getElementById('ussd_string');
        let fromInput = document.getElementById('from');
        let toInput = document.getElementById('to');

        // Reset the form fields to their initial values (empty in this case)
        ussdStringInput.value = '';
        fromInput.value = '';
        toInput.value = '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Get the download button element
        const downloadButton = document.getElementById('downloadButton');

        // Add a click event listener to the download button
        downloadButton.addEventListener('click', function () {
            // Fetch the table data
            const table = document.getElementById('basicExample');
            const tableData = [];
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const rowData = [];
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    rowData.push(cell.innerText);
                });
                tableData.push(rowData.join(','));
            });

            // Create a CSV content
            const csvContent = ['MSISDN,SERVICE CODE, USSD STRING, SESSION ID, DATE'];
            csvContent.push(...tableData);

            // Create a Blob with the CSV content
            const blob = new Blob([csvContent.join('\n')], { type: 'text/csv' });

            // Create a download link
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'ussdData.csv';
            link.style.display = 'none';
            document.body.appendChild(link);

            // Simulate a click event to trigger the download
            link.click();

            // Remove the temporary link element
            document.body.removeChild(link);
        });
    });
</script>

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
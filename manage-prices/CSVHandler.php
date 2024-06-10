<?php
require_once 'Core/Database.php';

class CSVHandler {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function updatePricesFromCSV($filePath) {
        $conn = $this->db->getConnection1();

        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ","); // Assumes the first row is the header

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $regionName = $data[array_search('Region', $header)];
                $size = $data[array_search('Size', $header)];
                $newPrice = $data[array_search('Price', $header)];

                // Get region ID from region name
                $sql = "SELECT id FROM regions WHERE name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $regionName);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $regionId = $result->fetch_assoc()['id'];

                    // Update price
                    $sql = "UPDATE prices SET new_price = ? WHERE region_id = ? AND size = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("dii", $newPrice, $regionId, $size);
                    $stmt->execute();
                }
            }
            fclose($handle);
        }
    }
}
?>

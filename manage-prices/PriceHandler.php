<?php

include_once('../Core/Database.php');

class PriceUpdater extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function updateAllPricesByRegion($regionName, $size, $newPrice) {
        // Prepare the select statement
        $sql = "SELECT id FROM regions WHERE name = ?";
        $stmt = $this->conn1->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn1->error);
        }
        $stmt->bind_param("s", $regionName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $regionId = $result->fetch_assoc()['id'];

            // Update price
            $sql = "UPDATE prices SET new_price = ? WHERE region_id = ? AND size = ?";
            $stmt = $this->conn1->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $this->conn1->error);
            }
            $stmt->bind_param("dii", $newPrice, $regionId, $size);
            if ($stmt->execute()) {
                echo "Prices updated successfully for region ID: " . $regionId . "<br>";

                // Retrieve the updated record
                $sql = "SELECT * FROM prices WHERE region_id = ? AND size = ?";
                $stmt = $this->conn1->prepare($sql);
                if (!$stmt) {
                    die("Prepare failed: " . $this->conn1->error);
                }
                $stmt->bind_param("ii", $regionId, $size);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $updatedRecord = $result->fetch_assoc();
                    echo "Updated record: <br>";
                    echo "ID: " . $updatedRecord['id'] . "<br>";
                    echo "Region ID: " . $updatedRecord['region_id'] . "<br>";
                    echo "Size: " . $updatedRecord['size'] . "<br>";
                    echo "New Price: " . $updatedRecord['new_price'] . "<br>";
                } else {
                    echo "No updated record found.";
                }
            } else {
                echo "Failed to update prices.";
            }
        } else {
            echo "Region not found.";
        }
    }
}

// Usage
$priceUpdater = new PriceUpdater();

$regionName = 'NBO';
$size = 1;
$newPrice = 999999.99;
$priceUpdater->updateAllPricesByRegion($regionName, $size, $newPrice);
?>

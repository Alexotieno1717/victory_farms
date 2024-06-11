<?php

include_once('Database.php');


class Branches extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function getBranches()
    {
        // SQL query to select all branches along with their corresponding region information
        $query = /** @lang text */
            "
        SELECT 
            b.*, 
            r.name as region_name 
        FROM 
            branches b 
        LEFT JOIN 
            regions r ON b.region_id = r.id 
        ORDER BY 
            b.id DESC
    ";

        // Execute the query and return all rows
        return $this->all_rows($query);
    }


    public function getBranch($id)
    {
        $sql = /** @lang text */
            "select b.id, b.branch,b.contact,b.county,b.sub_county,p.size,p.new_price,r.name from branches b LEFT JOIN prices p ON p.region_id=b.id LEFT JOIN regions r ON r.id=b.region_id  where b.id='$id'";
        $query = $this->conn1->query($sql);
        return $query->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function all_rows($sql){

        $query = $this->conn1->query($sql);

        return $query->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @throws Exception
     */
    public function createBranches($branch, $contact, $county, $sub_county, $region_id)
    {
        $sql = /** @lang text */
            "INSERT INTO branches(branch, contact, county, sub_county, region_id) VALUES ('$branch', '$contact', '$county', '$sub_county', '$region_id')";
        $query = $this->conn1->query($sql);
    }

    public function updateBranches($id, $branch, $contact, $county, $sub_county, $region_id)
    {
        $sql = /** @lang text */
            "UPDATE branches SET branch = '$branch', contact = '$contact', county = '$county', sub_county = '$sub_county', region_id='$region_id' where id = '$id'";
        return $this->conn1->query($sql);
    }

    public function deleteBranch($id)
    {
        $sql = /** @lang text */
            "DELETE FROM branches WHERE id = '$id'";
        $query = $this->conn1->query($sql);
    }

    public function getPriceList()
    {
        $query = /** @lang text */
            "SELECT prices.id, regions.name AS region_name, prices.size, prices.new_price, prices.inserted_at, prices.updated_at
            FROM prices
            JOIN regions ON prices.region_id = regions.id
            ORDER BY regions.name ASC";
        return $this->all_rows($query);
    }

    public function getPricingByBranch($branchId) {
        $sql = /** @lang text */
            "SELECT p.id, p.size, p.new_price 
                FROM prices p 
                JOIN branches b ON p.region_id = b.region_id 
                WHERE b.id = ?";
        $stmt = $this->conn1->prepare($sql);
        $stmt->bind_param("i", $branchId);
        $stmt->execute();
        $result = $stmt->get_result();
        $pricing = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $pricing;
    }

//    public function getPriceById($id)
//    {
//        $sql = /** @lang text */
//            "SELECT p.*, b.id AS branch_id FROM prices p
//            JOIN branches b ON p.region_id = b.region_id
//            WHERE id='$id'";
//        $query = $this->conn1->query($sql);
//        return $query->fetch_all(MYSQLI_ASSOC)[0];
//    }

    public function getPriceById($id)
    {
        $sql = /** @lang text */
            "SELECT p.*, b.id AS branch_id FROM prices p
        JOIN branches b ON p.region_id = b.region_id
        WHERE p.id = ?";
        $stmt = $this->conn1->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function updatePriceById($id, $new_price) {
        // Update the price based on the ID.
        $sql = /** @lang text */
            "UPDATE prices SET new_price = '$new_price' where id = '$id'";
        return $this->conn1->query($sql);
    }

    public function getRegions() {
        $sql = /** @lang text */
            "SELECT id, name FROM regions";

        return $this->all_rows($sql);
    }


    public function updateAllPricesByRegion( $regionName, $size, $newPrice){
        $sql = "SELECT id FROM regions WHERE name = ?";
        $stmt = $this->conn1->prepare($sql);
        $stmt->bind_param("s", $regionName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $regionId = $result->fetch_assoc()['id'];

            // Update price
            $sql = "UPDATE prices SET new_price = ? WHERE region_id = ? AND size = ?";
            $stmt = $this->conn1->prepare($sql);
            $stmt->bind_param("dii", $newPrice, $regionId, $size);
            $stmt->execute();
        }
    }


}
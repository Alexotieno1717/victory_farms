<?php

include_once('Database.php');


class Branches extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function getBranches()
    {
        $query = "SELECT * FROM branches b Left JOIN regions r ON b.region_id=r.id ORDER BY b.id DESC";
        return $this->all_rows($query);
    }

    public function getBranch($id)
    {
//        $sql = "select * from branches where id = '$id'";
        $sql = "select b.branch,b.contact,b.county,b.sub_county,p.size,p.new_price,r.name from branches b LEFT JOIN prices p ON p.region_id=b.id LEFT JOIN regions r ON r.id=b.region_id  where b.id='$id'";
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

    public function updateBranches($id, $branch, $contact, $county, $sub_county)
    {
        $sql = "UPDATE branches SET branch = '$branch', contact = '$contact', county = '$county', sub_county = '$sub_county' where id = '$id'";
        return $this->conn1->query($sql);
    }

    public function deleteBranch($id)
    {
        $sql = "DELETE FROM branches WHERE id = '$id'";
        $query = $this->conn1->query($sql);
    }

    public function getPriceList()
    {
//        $query = /** @lang text */
//            "SELECT prices.id, regions.name AS region_name, prices.size, prices.current_price, prices.new_price, prices.inserted_at, prices.updated_at
//            FROM prices
//            JOIN regions ON prices.region_id = regions.id
//            ORDER BY regions.name ASC";

        $query = "SELECT prices.id, regions.name AS region_name, prices.size, prices.current_price, prices.new_price, prices.inserted_at, prices.updated_at
            FROM prices
            JOIN regions ON prices.region_id = regions.id
            ORDER BY regions.name ASC";
        return $this->all_rows($query);
    }

    public function getPricingByBranch($branchId) {
        $sql = "SELECT p.size, p.new_price 
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

    public function getRegions() {
        $sql = "SELECT id, name FROM regions";

        return $this->all_rows($sql);
    }


}



<?php

include_once('Database.php');


class Branches extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function getBranches()
    {
        $query = "SELECT * FROM branches ORDER BY id DESC";
        return $this->all_rows($query);
    }

    public function getBranch($id)
    {
        $sql = "select * from branches where id = '$id'";
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
    public function createBranches($branch, $contact, $county, $sub_county)
    {
        $sql = "INSERT INTO branches(branch, contact, county, sub_county) VALUES ('$branch', '$contact', '$county', '$sub_county')";
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

}



<?php

include_once('Database.php');

class USSDLogs extends Database
{
    public function __construct(){
        parent::__construct();
    }

    public function getUSSDLogs()
    {
        $query = "SELECT DISTINCT SESSION_ID, MSISDN, SERVICE_CODE, USSD_STRING, SESSION_ID, dateModified FROM ussdRequestLogs";
        return $this->all_rows($query);
    }

    public function searchUSSDLogs($ussd_string, $start_date, $end_date)
    {
        $sql = "SELECT *
            FROM ussdRequestLogs
            WHERE SERVICE_CODE = '*617#'
            AND USSD_STRING = ?
            AND dateModified BETWEEN ? AND ?";

        $stmt = $this->conn2->prepare($sql);
        $stmt->bind_param("sss", $ussd_string, $start_date, $end_date);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function all_rows($sql){

        $query = $this->conn2->query($sql);

        return $query->fetch_all(MYSQLI_ASSOC);
    }
}
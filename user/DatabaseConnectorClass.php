<?php debug_backtrace() || die ("<h2>Access Denied!</h2> This file is protected and not available to public."); ?>
<?php

Class DababaseConnector
{
    var $host = 'localhost';
    var $username = 'id5592625_gregariousxx18';
    var $password = 'Havanaunana';
    var $dbname = 'id5592625_myphysicaltherapist';
    var $query;

    function __construct ()
    {

    }

    function setQuery ($var)
    {
        $this->query = $var;
    }

    function getConnection ()
    {
        $conn = @mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if (!$conn) {

            die("Connection failed" . mysqli_connect_error());
        } else {
            return $conn;
        }
    }

    function executeQuery ()
    {
        $returnValue = False;
        $conn = $this->getConnection();
        if (!$conn) {
            die("Connection failed" . mysqli_connect_error());
        } else {
            if ($conn->query($this->query) === TRUE) {
                $returnValue = true;
            } else {
                $returnValue = false;
            }
        }
        $conn->close();
        return $returnValue;

    }

    function executeSelectQuery ()
    {
        $conn = $this->getConnection();
        if (!$conn) {
            $conn->close();
            die("Connection failed" . mysqli_connect_error());
        } else {
            $response = @mysqli_query($conn, $this->query);
            $conn->close();
            return $response;
        }
    }
    function getUser($email, $password){
        $this->setQuery("SELECT User_ID FROM `User_Account` WHERE Email = '$email' AND Password= '$password'");
        $response=$this->executeSelectQuery();
        $UserID=null;
        if($response->num_rows!=0){

            while ($row = @mysqli_fetch_array($response)) {
                $UserID=$row['User_ID'];
            }
        }
        return $UserID;
    }

    function validateUser ($email, $password)
    {
        $conn = $this->getConnection();
        if (!$conn) {

            die("Connection failed" . mysqli_connect_error());
        } else {
            $sql = "SELECT Email, Password FROM `User_Account` WHERE Email = ? AND Password= ?";
            $stmt = $conn->stmt_init();
            if (!$stmt->prepare($sql)) {
                    echo $stmt->error;
            } else {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                $numRow = $result->num_rows;
                $stmt->close();
                $conn->close();
                if ($numRow == 0) {
                    echo 'false';
                    return false;
                } else {
                    echo 'true';
                    return true;
                }
            }

        }
 }




}

?>
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("----", "----", "----", "----");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    // if term is not numeric, convert to uppercase
    
    // Prepare a select statement
    $sql = "SELECT * FROM trains WHERE train_number LIKE ? OR train_name LIKE ? OR train_source LIKE ? OR train_destination LIKE ? ORDER BY train_number";
    
    if($stmt = mysqli_prepare($link, $sql)){
        
        $param_term = $_REQUEST["term"] . '%';
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssss", $param_term,  $param_term, $param_term,  $param_term);
        
        // Set parameters
        
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                $k=0;
                while(($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) && $k<5){
                    echo "<p>" . $row["train_number"]." ". $row["train_name"] . "</p>";
                    $k++;
                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>

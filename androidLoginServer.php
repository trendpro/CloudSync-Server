<?php
/**
 * File to handle all API requests
 * Accepts GET and POST
 *
 * Each request will be identified by TAG
 * Response will be JSON data
 
/**
 * check for POST request
 */
 if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];
 
    // include db handler
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
	//Fetch keys from database
	$data = mysql_query("SELECT * FROM `keys`")  or die(mysql_error());
    $info = mysql_fetch_array( $data );
	
    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            //user found
            //echo json with success = 1 and the secret key and access key
            $response["success"] = 1;
			$response["access_key"] = $info['access_key'];
			$response["secret_key"] = $info['secret_key'];
            
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    } 
	else 
	{
        echo "Invalid Request";
    }
} 
else 
{
    echo "Access Denied...";
}
?>
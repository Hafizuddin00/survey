<?php
session_start();
ini_set('display_errors', 1);
if(!isset($conn)){
	include 'includes/dbconnection.php' ;
	include 'db_connect.php' ;
}
Class Action {
	private $db;

	public function __construct() {
		ob_start();
	include 'includes/dbconnection.php' ;
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login() {
		session_start(); // Ensure the session is started
		extract($_POST);
	
		// Query for the user based on email and password only
		$qry = $this->db->query("
			SELECT *, CONCAT(fullname) AS name 
			FROM users 
			WHERE email = '".$email."' 
			  AND password = '".md5($password)."'
		");
	
		if ($qry->num_rows > 0) {
			$user = $qry->fetch_array(); // Fetch the single matched user record
	
			// Debug: Log the user array
			error_log(print_r($user, true));
	
			foreach ($user as $key => $value) {
				if ($key != 'password' && !is_numeric($key)) {
					$_SESSION['login_' . $key] = $value; // Store user details in the session
				}
			}
	
			// Assign the staff_id to session if it exists in the user array
			if (isset($user['staff_id'])) {
				$_SESSION['login_staff_id'] = $user['staff_id']; // Extract the staff_id from the query result
			} else {
				// Debug: Log if staff_id is not found
				error_log("staff_id not found in query result.");
			}
	
			return 1; // Login successful
		} else {
			return 3; // Login failed
		}
	}
	
	
	
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user()
{
    extract($_POST);
    $data = "";
    foreach ($_POST as $k => $v) {
        if (!in_array($k, array('id', 'cpass')) && !is_numeric($k)) {
            if ($k =='password') {
                $v = md5($v);
            }
            if (empty($data)) {
                $data .= " $k='$v' ";
            } else {
                $data .= ", $k='$v' ";
            }
        }
    }

    if (empty($id)) {
        $save = $this->db->query("INSERT INTO users SET $data");
    } else {
        $save = $this->db->query("UPDATE users SET $data WHERE id = $id");
    }

    if ($save) {
        return 1;
    }
}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table')) && !is_numeric($k)){
				if($k =='password')
					$v = md5($v);
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_message(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM contact where ID = ".$id);
		if($delete)
			return 1;
	}
	function delete_categories(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = ".$id);
		if($delete)
			return 1;
	}
	function update_status() {
		extract($_POST);
		$update = $this->db->query("UPDATE categories SET status = '$status' WHERE id = $id");
		if ($update) {
			return 1;
		} else {
			return 0;
		}
	}

	function delete_all_data() {
		// Execute the query to delete all categories where status is 'Finished'
		$save = $this->db->query("DELETE FROM categories WHERE status IN ('Finished', 'Archived')");
		
		// Check if the query was successful
		if ($save) {
			return 1; // Success
		} else {
			return 0; // Failure
		}
	}

	function archive_data() {
		// Update records to 'Archived' status instead of deleting them
		$save = $this->db->query("UPDATE categories SET status = 'Archived' WHERE status = 'Finished'");
		
		if ($save) {
			return 1; // Success
		} else {
			return 0; // Failure
		}
	}
	
	
	

	function save_page_img(){
		extract($_POST);
		if($_FILES['img']['tmp_name'] != ''){
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
				if($move){
					$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
					$hostName = $_SERVER['HTTP_HOST'];
						$path =explode('/',$_SERVER['PHP_SELF']);
						$currentPath = '/'.$path[1]; 
   						 // $pathInfo = pathinfo($currentPath); 

					return json_encode(array('link'=>$protocol.'://'.$hostName.$currentPath.'/admin/assets/uploads/'.$fname));

				}
		}
	}
	function save_categories(){
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " `$k` = '".addslashes($v)."' ";
				} else {
					$data .= ", `$k` = '".addslashes($v)."' ";
				}
			}
		}
		if (empty($id)) {
			$query = "INSERT INTO categories SET $data";
			$save = $this->db->query($query);
		} else {
			$query = "UPDATE categories SET $data WHERE id = $id";
			$save = $this->db->query($query);
		}
	
		// Log the query for debugging
		echo "SQL Query: $query";
	
		if ($save) {
			return 1; // Success
		} else {
			echo "SQL Error: " . $this->db->error; // Display SQL error
			return 0; // Failure
		}
	}
	
	function save_survey(){
		extract($_POST);
		$data = "";
	
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " `$k` = '" . addslashes($v) . "' ";
				} else {
					$data .= ", `$k` = '" . addslashes($v) . "' ";
				}
			}
		}
	  
		// Check if the ID is empty (inserting new record) or updating an existing record
		if (empty($id)) {
			$query = "INSERT INTO receipe SET $data";
			$save = $this->db->query($query);
		} else {
			$query = "UPDATE receipe SET $data WHERE recipe_id = $id";
			$save = $this->db->query($query);
		}
	
		// Log the query for debugging
		echo "SQL Query: $query";
	
		if ($save) {
			return 0; // Success
		} else {
			echo "SQL Error: " . $this->db->error; // Display SQL error
			return 1; // Failure
		}
	}

		
	function save_product(){
		extract($_POST);
		$data = "";
	
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " `$k` = '" . addslashes($v) . "' ";
				} else {
					$data .= ", `$k` = '" . addslashes($v) . "' ";
				}
			}
		}
	  
		// Check if the ID is empty (inserting new record) or updating an existing record
		if (empty($id)) {
			$query = "INSERT INTO typeproduct SET $data";
			$save = $this->db->query($query);
		} else {
			$query = "UPDATE typeproduct SET $data WHERE product_id = $id";
			$save = $this->db->query($query);
		}
	
		// Log the query for debugging
		echo "SQL Query: $query";
	
		if ($save) {
			return 0; // Success
		} else {
			echo "SQL Error: " . $this->db->error; // Display SQL error
			return 1; // Failure
		}
	}
	
	  
	function delete_survey(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM receipe where recipe_id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function save_question(){
		extract($_POST);
			$data = " survey_id=$sid ";
			$data .= ", question='$question' ";
			$data .= ", instruction='$instruction' ";
			$data .= ", type='$type' ";
			if($type != 'textfield_s'){
				$arr = array();
				foreach ($label as $k => $v) {
					$i = 0 ;
					while($i == 0){
						$k = substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
						if(!isset($arr[$k]))
							$i = 1;
					}
					$arr[$k] = $v;
				}
			$data .= ", frm_option='".json_encode($arr)."' ";
			}else{
			$data .= ", frm_option='' ";
			}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO questions set $data");
		}else{
			$save = $this->db->query("UPDATE questions set $data where id = $id");
		}

		if($save)
			return 1;
	}
	function delete_question(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM questions where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function action_update_qsort(){
		extract($_POST);
		$i = 0;
		foreach($qid as $k => $v){
			$i++;
			$update[] = $this->db->query("UPDATE questions set order_by = $i where id = $v");
		}
		if(isset($update))
			return 1;
	}
	function save_answer(){
		extract($_POST);
			foreach($qid as $k => $v){
				$data = " survey_id=$survey_id ";
				$data .= ", question_id='$qid[$k]' ";
				$data .= ", user_id='{$_SESSION['login_id']}' ";
				if($type[$k] == 'check_opt'){
					$data .= ", answer='[".implode("],[",$answer[$k])."]' ";
				}else{
					$data .= ", answer='$answer[$k]' ";
				}
				$save[] = $this->db->query("INSERT INTO answers set $data");
			}
					

		if(isset($save))
			return 1;
	}
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = ".$id);
		if($delete){
			return 1;
		}
	}
}
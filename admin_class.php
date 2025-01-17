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

	function login(): int {
		session_start();
	
		// Use prepared statements to prevent SQL injection
		$stmt = $this->db->prepare("
			SELECT *, CONCAT(fullname) AS name 
			FROM users 
			WHERE email = ?
		");
	
		if (!$stmt) {
			error_log("Prepare failed: " . $this->db->error);
			return 3; // Return 3 for login failure
		}
	
		$stmt->bind_param("s", $_POST['email']);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			$user = $result->fetch_array();
	
			// Verify password using password_verify()
			if (password_verify($_POST['password'], $user['password'])) {
				foreach ($user as $key => $value) {
					if ($key != 'password' && !is_numeric($key)) {
						$_SESSION['login_' . $key] = $value;
					}
				}
	
				if (isset($user['staff_id'])) {
					$_SESSION['login_staff_id'] = $user['staff_id'];
				}
	
				return 1; // Login successful
			}
		}
	
		return 3; // Login failed
	}
	
	
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user() {
		extract($_POST);
		$data = [];
		$params = [];
		$types = "";
		
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass')) && !is_numeric($k)) {
				if ($k == 'password') {
					$v = password_hash($v, PASSWORD_DEFAULT);
				}
				$data[] = "$k = ?";
				$params[] = $v;
				$types .= "s";
			}
		}
		
		if (empty($id)) {
			$query = "INSERT INTO users SET " . implode(", ", $data);
		} else {
			$query = "UPDATE users SET " . implode(", ", $data) . " WHERE id = ?";
			$params[] = $id;
			$types .= "i";
		}
		
		$stmt = $this->db->prepare($query);
		if (!$stmt) {
			error_log("Prepare failed: " . $this->db->error);
			return 0;
		}
		
		$stmt->bind_param($types, ...$params);
		if ($stmt->execute()) {
			return 1;
		}
		return 0;
	}

	function update_user() {
		extract($_POST);
		$data = [];
		$params = [];
		$types = "";
		
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'table')) && !is_numeric($k)) {
				if ($k == 'password') {
					$v = password_hash($v, PASSWORD_DEFAULT);
				}
				$data[] = "$k = ?";
				$params[] = $v;
				$types .= "s";
			}
		}
		
		// Check for duplicate email
		$stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? " . (!empty($id) ? "AND id != ?" : ""));
		if (!$stmt) {
			error_log("Prepare failed: " . $this->db->error);
			return 0;
		}
		
		if (!empty($id)) {
			$stmt->bind_param("si", $email, $id);
		} else {
			$stmt->bind_param("s", $email);
		}
		
		$stmt->execute();
		if ($stmt->get_result()->num_rows > 0) {
			return 2;
		}
		
		// Update or insert user
		if (empty($id)) {
			$query = "INSERT INTO users SET " . implode(", ", $data);
		} else {
			$query = "UPDATE users SET " . implode(", ", $data) . " WHERE id = ?";
			$params[] = $id;
			$types .= "i";
		}
		
		$stmt = $this->db->prepare($query);
		if (!$stmt) {
			error_log("Prepare failed: " . $this->db->error);
			return 0;
		}
		
		$stmt->bind_param($types, ...$params);
		if ($stmt->execute()) {
			foreach ($_POST as $key => $value) {
				if ($key != 'password' && !is_numeric($key)) {
					$_SESSION['login_' . $key] = $value;
				}
			}
			return 1;
		}
		return 0;
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
	function delete_categories() {
        extract($_POST);
    
        if (!$id || empty($id)) {
            echo "Category ID is missing.";
            return 0;
        }
        
        try {
            // Validate database connection
            include 'db_connect.php';
            if (!$this->db) {
                throw new Exception("Database connection failed: " . mysqli_connect_error());
            }
    
            // Fetch equipment records related to the category
            $stmt_equipment = $this->db->prepare("SELECT spec_id, eq_used FROM equipment_record WHERE id = ?");
            if (!$stmt_equipment) {
                throw new Exception("Error preparing statement for fetching equipment records: " . $this->db->error);
            }
    
            $stmt_equipment->bind_param('i', $id);
            $stmt_equipment->execute();
            $result_equipment = $stmt_equipment->get_result();
    
            while ($equipment = $result_equipment->fetch_assoc()) {
                $spec_id = $equipment['spec_id'];
                $eq_used = $equipment['eq_used'];
    
                // Update equipment_details
                $stmt_update = $this->db->prepare(
                    "UPDATE equipment_details 
                     SET eq_not_used = eq_not_used + ?, eq_used = eq_used - ? 
                     WHERE spec_id = ?"
                );
                if (!$stmt_update) {
                    throw new Exception("Error preparing statement for updating equipment details: " . $this->db->error);
                }
    
                $stmt_update->bind_param('iis', $eq_used, $eq_used, $spec_id);
                if (!$stmt_update->execute()) {
                    throw new Exception("Error executing statement for updating equipment details: " . $stmt_update->error);
                }
                $stmt_update->close();
            }
    
            $stmt_equipment->close();
    
            // Delete equipment records related to the category
            $stmt_delete_equipment = $this->db->prepare("DELETE FROM equipment_record WHERE id = ?");
            if (!$stmt_delete_equipment) {
                throw new Exception("Error preparing statement for deleting equipment records: " . $this->db->error);
            }
    
            $stmt_delete_equipment->bind_param('i', $id);
            if (!$stmt_delete_equipment->execute()) {
                throw new Exception("Error executing statement for deleting equipment records: " . $stmt_delete_equipment->error);
            }
            $stmt_delete_equipment->close();
    
            // Finally, delete the category itself
            $stmt_delete_category = $this->db->prepare("DELETE FROM categories WHERE id = ?");
            if (!$stmt_delete_category) {
                throw new Exception("Error preparing statement for deleting category: " . $this->db->error);
            }
    
            $stmt_delete_category->bind_param('i', $id);
            if (!$stmt_delete_category->execute()) {
                throw new Exception("Error executing statement for deleting category: " . $stmt_delete_category->error);
            }
            $stmt_delete_category->close();
    
            return 1;
        } catch (Exception $e) {
            // Log the error and display a generic message
            echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
            echo "An error occurred while processing the records. Please try again later.";
            return 0;
        }
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

	function update_quality() {
		extract($_POST);
		$update = $this->db->query("UPDATE categories SET quality_test = '$quality_test' WHERE id = $id");
		if ($update) {
			return 1;
		} else {
			return 0;
		}
	}

	function save_comment() {
		extract($_POST);
		$update = $this->db->query("UPDATE categories SET comment = '$comment' WHERE id = $id");
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

	function save_categories() {
		extract($_POST);
	
		$data = [];
		$values = [];
	
		// Check if ingredients_data is set.
		if (isset($ingredients_data)) {
			$data[] = "`ingredients_data` = ?";
			$values[] = $ingredients_data;
		}
	
		// Loop through other fields and prepare them for insertion.
		foreach ($_POST as $key => $value) {
			if (!in_array($key, ['id', 'ingredients_data', 'equipment_data', 'recipe_id']) && !is_numeric($key)) {
				$data[] = "`$key` = ?";
				$values[] = $value;
			}
		}
	
		// Ensure 'id' is part of the binding values if updating
		if (!empty($id)) {
			$values[] = $id;
		}
	
		// Prepare the query to insert or update.
		if (empty($id)) {
			$query = "INSERT INTO categories SET " . implode(", ", $data);
		} else {
			$query = "UPDATE categories SET " . implode(", ", $data) . " WHERE id = ?";
		}
	
		// Execute the query using a prepared statement.
		$stmt = $this->db->prepare($query);
		if (!$stmt) {
			echo "SQL Error: " . $this->db->error;
			return 0; // Failure.
		}
	
		$types = str_repeat('s', count($values) - (empty($id) ? 0 : 1)); // Assuming all inputs are strings.
		if (!empty($id)) {
			$types .= 'i'; // Adding an integer type for the id.
		}
		$stmt->bind_param($types, ...$values);
	
		if (!$stmt->execute()) {
			echo "SQL Error: " . $stmt->error;
			return 0; // Failure.
		}
	
		// Get the last inserted id if inserting a new record
		if (empty($id)) {
			$id = $this->db->insert_id;
		}
	
		// Apply Equipment logic.
		if (isset($equipment_data)) {
			$equipment_data = json_decode($equipment_data, true);
	
			if (!is_array($equipment_data)) {
				echo "Invalid equipment data format.";
				return 0; // Failure.
			}
	
			foreach ($equipment_data as $equipment) {
				$recipe_id = $equipment['recipe_id'];
				$spec_id = $equipment['spec_id'];
				$used_qty = $equipment['qty']; // Use 'qty' field.
	
				// Debug the parameters.
				error_log("Updating: spec_id=$spec_id, used_qty=$used_qty");
	
				// Update equipment_details.
				$stmt = $this->db->prepare("
					UPDATE equipment_details 
					SET eq_used = eq_used + ?, eq_not_used = eq_not_used - ? 
					WHERE spec_id = ?
				");
				if (!$stmt) {
					error_log("Prepare failed: " . $this->db->error);
					return 0; // Failure.
				}
				$stmt->bind_param("iis", $used_qty, $used_qty, $spec_id);
				if (!$stmt->execute()) {
					error_log("Execute failed: " . $stmt->error);
					return 0; // Failure.
				}
	
				$stmt->close();
	
				// Insert record into equipment_record table or update it if it exists.
				if (!isset($id)) {
					echo "Error: Record 'id' is missing.";
					return 0; // Failure.
				}
	
				// Check if the record exists in equipment_record table
				$stmt = $this->db->prepare("
					SELECT id FROM equipment_record WHERE id = ? AND spec_id = ?
				");
				if (!$stmt) {
					error_log("Prepare failed: " . $this->db->error);
					return 0; // Failure.
				}
				$stmt->bind_param("is", $id, $spec_id);  // Check for existing record (using 'i' for integer and 's' for string)
				$stmt->execute();
				$result = $stmt->get_result();
	
				// If record exists, update it
				if ($result->num_rows > 0) {
					// Update the existing record
					$stmt = $this->db->prepare("
						UPDATE equipment_record 
						SET eq_used = eq_used + ? 
						WHERE id = ? AND spec_id = ?
					");
					if (!$stmt) {
						error_log("Prepare failed: " . $this->db->error);
						return 0; // Failure.
					}
					$stmt->bind_param("iis", $used_qty, $id, $spec_id);  // 'i' for integer, 's' for string
					if (!$stmt->execute()) {
						error_log("Execute failed: " . $stmt->error);
						return 0; // Failure.
					}
				} else {
					// If no record exists, insert a new record
					$stmt = $this->db->prepare("
						INSERT INTO equipment_record (id, spec_id, eq_used) 
						VALUES (?, ?, ?)
					");
					if (!$stmt) {
						error_log("Prepare failed: " . $this->db->error);
						return 0; // Failure.
					}
					$stmt->bind_param("isi", $id, $spec_id, $used_qty);  // 'i' for integer, 's' for string
					if (!$stmt->execute()) {
						error_log("Execute failed: " . $stmt->error);
						return 0; // Failure.
					}
				}
	
				// Closing the statement after insertion or update
				$stmt->close();
	
				// Ensure the 'status' and 'order_id' variables are set properly
				if (isset($_POST['status'], $_POST['order_id'])) {
					$status = $_POST['status']; // Set 'status' from POST data
					$order_id = $_POST['order_id']; // Set 'order_id' from POST data
	
					// Prepare the SQL query to update the order_customer table
					$stmt = $this->db->prepare("
						UPDATE order_customer 
						SET status = ? 
						WHERE order_id = ?
					");
	
					if (!$stmt) {
						error_log("Prepare failed: " . $this->db->error);
						return 0; // Failure
					}
	
					// Bind the parameters: 'status' as string and 'order_id' as integer
					$stmt->bind_param("si", $status, $order_id);
	
					// Execute the query
					if (!$stmt->execute()) {
						error_log("Execute failed: " . $stmt->error);
						return 0; // Failure
					}
	
					// Close the statement after execution
					$stmt->close();
				} else {
					error_log("Error: 'status' or 'order_id' is not set.");
					return 0; // Failure
				}
			}
		}
	
		return 1; // Success.
	}
	
	
	
	// function save_categories() {
	// 	extract($_POST);  // Extract POST data
	
	// 	// Initialize data string
	// 	$data = "";
	
	// 	// Check if ingredients_data is set
	// 	if (isset($ingredients_data)) {
	// 		// Encode it into a sanitized format for insertion into the database
	// 		$ingredients_data_sanitized = addslashes($ingredients_data);
	// 		$data .= "`ingredients_data` = '$ingredients_data_sanitized'";
	// 	}
	
	// 	// Loop through other fields and prepare them for insertion
	// 	foreach ($_POST as $k => $v) {
	// 		if (!in_array($k, array('id', 'ingredients_data', 'equipment_data', 'recipe_id')) && !is_numeric($k)) {
	// 			if (empty($data)) {
	// 				$data .= "`$k` = '" . addslashes($v) . "'";
	// 			} else {
	// 				$data .= ", `$k` = '" . addslashes($v) . "'";
	// 			}
	// 		}
	// 	}
	
	// 	// Prepare the query to insert or update
	// 	if (empty($id)) {
	// 		$query = "INSERT INTO categories SET $data";
	// 	} else {
	// 		$query = "UPDATE categories SET $data WHERE id = $id";
	// 	}
	
	// 	// Execute the query
	// 	$save = $this->db->query($query);
	
	// 	if (!$save) {
	// 		// Log any errors
	// 		echo "SQL Error: " . $this->db->error;
	// 		return 0;  // Failure
	// 	}
	
	// 	// Apply Equipment logic
	// 	if (isset($equipment_data) && isset($recipe_id)) {
	// 		$equipment_data = json_decode($equipment_data, true);
		
	// 		if (!is_array($equipment_data)) {
	// 			echo "Invalid equipment data format.";
	// 			return 0;
	// 		}
		
	// 		foreach ($equipment_data as $equipment) {
	// 			$spec_id = $equipment['spec_id'];
	// 			$used_qty = floatval($equipment['used_qty']);
		
	// 			// Update equipment_details table
	// 			$update_equipment_query = "
	// 				UPDATE equipment_details 
	// 				SET eq_used = eq_used + ?, eq_not_used = eq_not_used - ?
	// 				WHERE spec_id = ?";
		
	// 			if ($stmt = $this->db->prepare($update_equipment_query)) {
	// 				$stmt->bind_param("iis", $used_qty, $used_qty, $spec_id); // Correct bind_param specifier
		
	// 				if (!$stmt->execute()) {
	// 					echo "Failed to update equipment_details: " . $stmt->error;
	// 					return 0;
	// 				}
	// 				$stmt->close(); // Closing statement to prevent it from being reused
	// 			} else {
	// 				echo "Failed to prepare statement for equipment_details: " . $this->db->error;
	// 				return 0;
	// 			}
		
	// 			// Update only eq_used in recipe_equipment table
	// 			$update_recipe_query = "
	// 				UPDATE recipe_equipment
	// 				SET eq_used = eq_used + ?
	// 				WHERE recipe_id = ? AND spec_id = ?"; // Correct bind_param specifier
		
	// 			if ($stmt = $this->db->prepare($update_recipe_query)) {
	// 				$stmt->bind_param("iis", $used_qty, $recipe_id, $spec_id);
		
	// 				if (!$stmt->execute()) {
	// 					echo "Failed to update recipe_equipment: " . $stmt->error;
	// 					return 0;
	// 				}
	// 				$stmt->close(); // Closing statement to prevent it from being reused
	// 			} else {
	// 				echo "Failed to prepare statement for recipe_equipment: " . $this->db->error;
	// 				return 0;
	// 			}
	// 		}
	// 	}
		
	
	// 	return 1;  // Success
	// }
	
	
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
		$this->db->begin_transaction(); // Start a transaction
	
		try {
			// Delete from receipe table
			$delete_receipe = $this->db->query("DELETE FROM receipe WHERE recipe_id = " . intval($id));
			
			// Delete from recipe_equipment table
			$delete_equipment = $this->db->query("DELETE FROM recipe_equipment WHERE recipe_id = " . intval($id));
			
			// Delete from ing_list table
			$delete_ing_list = $this->db->query("DELETE FROM ing_list WHERE recipe_id = " . intval($id));
	
			if ($delete_receipe && $delete_equipment && $delete_ing_list) {
				$this->db->commit(); // Commit the transaction if all deletes are successful
				return 1;
			} else {
				$this->db->rollback(); // Rollback the transaction if any delete fails
				error_log("Delete failed for either receipe, recipe_equipment, or ing_list.");
				return 0;
			}
		} catch (Exception $e) {
			$this->db->rollback(); // Rollback the transaction in case of an exception
			error_log("Exception caught: " . $e->getMessage());
			return 0;
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
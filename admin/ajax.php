<?php 
require_once('../config/config.php');
require_once('../lib/crud.class.php');

$task = isset($_REQUEST['task']) ? $_REQUEST['task'] : "";
if (!empty($task)) {
    switch ($task) {
        case"sub_item":
           $response=sub_item(clean_value($_REQUEST['fileupload']), clean_value($_REQUEST['product_name']), clean_value($_REQUEST['product_desc']), clean_value($_REQUEST['product_price']));
		   echo $response;
            break;
			
		case"edit_item":
           $response=edit_item(clean_value($_REQUEST['fileupload']), clean_value($_REQUEST['product_name']), clean_value($_REQUEST['product_desc']), clean_value($_REQUEST['product_price']), clean_value($_REQUEST['id']));
		   echo $response;
            break;
		case"default":
	}
}


function clean_value($str) {
    $str = trim($str);
    $str = preg_replace("@<script[^>]*>.+</script[^>]*>@i", "", $str);
    $str = preg_replace("@<style[^>]*>.+</style[^>]*>@i", "", $str);
    $str = strip_tags($str);
	return $str;
}

function sub_item($fileupload, $product_name, $product_desc, $product_price) {
	$response='';
	$crud = new Crud("products");
	//if(!empty($fileupload)){
		if(!empty($product_name)){
			if(!empty($product_desc)){
				if(!empty($product_price)){
					
					
					
					//upload image
					
						
					$target_dir = "../images/";
					$target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
					$file_name = basename($_FILES["fileupload"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					// Check if image file is a actual image or fake image
					if(isset($_POST["submit"])) {
						$check = getimagesize($_FILES["fileupload"]["tmp_name"]);
						if($check !== false) {
							echo "File is an image - " . $check["mime"] . ".";
							$uploadOk = 1;
						} else {
							echo "File is not an image.";
							$uploadOk = 0;
						}
					}
					// Check if file already exists
					/*if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						$uploadOk = 0;
					}*/
					// Check file size
					/*if ($_FILES["fileupload"]["size"] > 500000) {
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}*/
					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						$response = "Sorry, your file was not uploaded. Ensure JPG, JPEG, PNG & GIF";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
							echo "The file ". basename( $_FILES["fileupload"]["name"]). " has been uploaded.";

							//insert item details to database

							$data = array("product_image" => $file_name, "product_name" => $product_name, "product_desc" => $product_desc, "product_price" => $product_price);
										if ($crud->addNewRecord('products',$data))
											{
												 $response='Item has been added';	
											}
											else
											{
												 $response='not added';	
											}
							//end

						} else {
							echo "Sorry, there was an error uploading your file.";
						}
					}
					//end upload image
	
					
					
					}else{
						$response='Please enter a valid price (plain number)';
					}
				}else{
					$response='Please enter a valid description';
				}
			}else{
				$response='Please enter a valid name';
			}
		//}else{
			//$response='Please upload an image';
		//}
	return $response;
	}

function edit_item($fileupload, $product_name, $product_desc, $product_price, $id) {
	$response='';
	$crud = new Crud("products");
	echo $id;
	if(!empty($product_name)){
		if(!empty($product_desc)){
			if(!empty($product_price)){
				
				
				//upload edited image	
						
					$target_dir = "../images/";
					$target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
					$file_name = basename($_FILES["fileupload"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					// Check if image file is a actual image or fake image
					if(isset($_POST["submit"])) {
						$check = getimagesize($_FILES["fileupload"]["tmp_name"]);
						if($check !== false) {
							echo "File is an image - " . $check["mime"] . ".";
							$uploadOk = 1;
						} else {
							echo "File is not an image.";
							$uploadOk = 0;
						}
					}
					// Check if file already exists
					/*if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						$uploadOk = 0;
					}*/
					// Check file size
					/*if ($_FILES["fileupload"]["size"] > 500000) {
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}*/
					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
							echo "The file ". basename( $_FILES["fileupload"]["name"]). " has been uploaded.";

							$edits = $crud->executeQuery("UPDATE products SET product_image = '$file_name' WHERE id = '$id'");	

						} else {
							echo "Sorry, there was an error uploading your file.";
						}
					}
		
				//end upload edited image
				
				
				$edits = $crud->executeQuery("UPDATE products SET product_name = '$product_name', product_desc = '$product_desc', product_price = '$product_price' WHERE id = '$id'");				
						
				}else{
					$response='Please enter a valid price (plain number)';
				}
			}else{
				$response='Please enter a valid description';
			}
		}else{
			$response='Please enter a valid name';
		}
	
	return $response;
	}
?>

      

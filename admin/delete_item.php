<?php
require_once('../config/config.php');
require_once('../lib/crud.class.php');
$crud = new Crud("products");

echo $id = $_REQUEST['id'];

$deletes = $crud->executeQuery("DELETE FROM products WHERE id = $id");
header('Location: view_items.php');

?>
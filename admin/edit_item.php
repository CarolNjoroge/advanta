<?php
require_once('header.php');
require_once('../config/config.php');
require_once('../lib/crud.class.php');
$crud = new Crud("products");

$id = $_REQUEST['id'];

$items = $crud->executeQuery("SELECT * FROM products where id = $id AND status_id=1");
foreach($items as $item){
?>


<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110">
					<div class="table100-head">
						<table>
							<thead>							
								<tr class="row100 head">
									<th class="cell100 column1"><a href="view_items.php">VIEW ALL ITEMS</a></th>
									<th class="cell100 column2"></th>
									<th class="cell100 column3"></th>
									<th class="cell100 column4"></th>
									<th class="cell100 column5"></th>
								</tr>							
								
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	

<div class="container-contact100">
		<div class="wrap-contact100">
	<form action="" method="post" onsubmit="return false" id="editproduct_form" name="editproduct_form" enctype="multipart/form-data"  class="contact100-form validate-form">
		
				<span class="contact100-form-title">
					Edit Item
				</span>
				
				<div id="success"></div>
				<div id="error"></div>
				<span class="contact100-form-title">
					Upload formats jpg, jpeg, png, gif
				</span>
				<div class="wrap-input100 validate-input">
					<input type="file" id="fileupload" name="fileupload" value="<?php echo $item->product_image;?>"  class="input100" ><?php echo $item->product_image;?>
				</div>
				
				<div class="wrap-input100 validate-input">
					<input type="text" name="product_name" id="product_name" value="<?php echo $item->product_name;?>"  class="input100" >
				</div>
				
				<div class="wrap-input100 validate-input">
				 <textarea class="input100" name="product_desc" id="product_desc"><?php echo $item->product_desc;?></textarea>					
				</div>
				
				<div class="wrap-input100 validate-input">
					<input type="text" name="product_price" id="product_price" value="<?php echo $item->product_price;?>" class="input100" >
				</div>

				 <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
				<input type="hidden" name="task" value="edit_item" />
				<input type="submit" value="Edit" name="submitedititem" id="submitedititem" class="contact100-form-btn" />
  				
			</form>
		</div>
	</div>

<?php
}
require_once('footer.php');
?>
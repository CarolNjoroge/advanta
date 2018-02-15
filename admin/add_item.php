<?php
require_once('header.php');
require_once('../config/config.php');
require_once('../lib/crud.class.php');
$crud = new Crud("products");
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
									<th class="cell100 column4"></th>
									<th class="cell100 column3"></th>
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
			<form action="" method="post" onsubmit="return false" id="product_form" name="product_form" enctype="multipart/form-data" class="contact100-form validate-form">
				<span class="contact100-form-title">
					Add New Item
				</span>
				
				<div id="success"></div>
				<div id="error"></div>
				<span class="contact100-form-title">
					Upload formats jpg, jpeg, png, gif
				</span>
				
				<div class="wrap-input100 validate-input">
					<input class="input100" type="file" id="fileupload" name="fileupload" placeholder="Image">
				</div>
				
				<div class="wrap-input100 validate-input">
					<input type="text" name="product_name" id="product_name" class="input100"  placeholder="Product Name:">
				</div>
				
				<div class="wrap-input100 validate-input">
					<textarea class="input100" name="product_desc" id="product_desc" placeholder="Description"></textarea>
				</div>
				
				<div class="wrap-input100 validate-input">
					<input type="text" name="product_price" id="product_price"  class="input100"  placeholder="Product Price:">
				</div>

				 <input type="hidden" name="task" value="sub_item" />
  				<input type="submit" class="contact100-form-btn" value="Add" name="submititem" id="submititem" />
			
			</form>
		</div>
	</div>





<!--<div id="success"></div>
<div id="error"></div>
<form action="" method="post" onsubmit="return false" id="product_form" name="product_form" enctype="multipart/form-data">
  <div>Product Image:<input type="file" id="fileupload" name="fileupload"></div>  
  <div>Product Name: <input type="text" name="product_name" id="product_name"></div>
  <div>Product Description: <textarea name="product_desc" id="product_desc"></textarea></div>
  <div>Product Price: <input type="text" name="product_price" id="product_price"></div>
  <input type="hidden" name="task" value="sub_item" />
  <input type="submit" value="Add" name="submititem" id="submititem" />
</form>-->

<?php
require_once('footer.php');
?>
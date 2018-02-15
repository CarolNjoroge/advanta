<?php
require_once('header.php');
require_once('../config/config.php');
require_once('../lib/crud.class.php');
$crud = new Crud("products");

$items = $crud->executeQuery("SELECT * FROM products where status_id=1 ORDER BY date_created DESC");
?>

<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110">
					<div class="table100-head">
						<table>
							<thead>									
								<tr class="row100 head">
									<th class="cell100 column0"><a href="add_item.php">ADD NEW ITEM</a></th>
									<th class="cell100 column1">Image</th>
									<th class="cell100 column2">Item</th>
									<th class="cell100 column3">Description</th>
									<th class="cell100 column4">Price</th>
									<th class="cell100 column5">Edit</th>
									<th class="cell100 column6">Delete</th>
								</tr>
							</thead>							
						</table>
					</div>

					<div class="table100-body">
						<table>
							<tbody>
								<?php
									foreach($items as $item){
										$id= $item->id;
									?>
										<tr class="row100 body">
											<td class="cell100 column0"> </td>
											<td class="cell100 column1"><img src="../images/<?php echo $item->product_image;?>"  height="40px" width="40px"></td>
											<td class="cell100 column2"><?php echo $item->product_name;?></td>
											<td class="cell100 column3"><?php echo $item->product_desc;?></td>
											<td class="cell100 column4"><?php echo $item->product_price;?></td>
											<td class="cell100 column5"><a href="edit_item.php?id=<?php echo $id;?>">Edit</a></td>
											<td class="cell100 column6"><a href="delete_item.php?id=<?php echo $id;?>">Delete</a></td>
										</tr>
									<?php }?>
								</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
</div>


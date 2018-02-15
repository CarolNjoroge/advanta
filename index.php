<?php
require_once('config/config.php');
require_once('lib/crud.class.php');
$crud = new Crud("products");
?>
<!doctype html>
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Advanta Africa Limited- Items On Sale</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="items on sale" />
	<meta name="keywords" content="advanta, product A, product B" />
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body id="page">
	<div class="container">
	<header>
		<div class="row clearfix">
			<h1>Advanta Africa Limited</h1>
			<h3>Items On Sale</h3>
		</div>
	</header>
	<section>
		<div class="row clearfix">
			<ul class="lb-album clearfix">
			<?php
			$results = $crud->executeQuery("SELECT * FROM products where status_id=1 ORDER BY date_created DESC");
			foreach($results as $result){
			?>
				<li class="columns large-4">
					<div class="wrap_cont">
						<div class="image_cont">
						<img src="images/<?php echo $result->product_image;?>" alt="<?php echo $result->product_name;?>" >
						</div>					
						<div class="details">
							<h1>ITEM: <?php echo $result->product_name;?></h1>
							<p>DESCRIPTION:<?php echo $result->product_desc;?></p>
							<h2>PRICE: <?php echo $result->product_price;?></h2>
							<a href="#" class="bid">Buy</a>
						</div>
					</div>
				</li>
			<?php } ?>
			</ul>
		</div>
	</section>
	</div>
	<script type="text/javascript" src="admin/js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.wrap_cont').matchHeight({
			property: 'height'
			});
		});
	</script>
</body>
</html>

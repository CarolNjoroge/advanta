<!doctype html>
<html>
<head>
<title>Advanta - Admin</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
</head>
<body id="login-bg">  
<div id="login-holder">
	<div class="clear"></div>
	<div id="loginbox">
	<div id="login-inner" >
    <form action="view_items.php" method="post"  autocomplete="off">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><input type="text" name="username" id="username"  class="login-inp" /></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" name="password" id="password" value=""  onfocus="this.value=''" class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" class="submit-login"  /></td>
		</tr>
		</table>
	</div>
	<div class="clear"></div>
 </div>
</div>
</body>
</html>
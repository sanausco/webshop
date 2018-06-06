<?php

$pageTitle = '';
$page = '';

/* Auswahl der anzuzeigenden Seite*/
$pageFilter = array('options' => array('default' => 'home', 'regexp' => '/^[a-z0-9]+$/'));
switch(filter_input(INPUT_GET, 'page', FILTER_VALIDATE_REGEXP, $pageFilter)) {
  case 'login':
    $pageTitle = 'Login';
    $page = 'login';
    break;
                                                   
    case 'contact':
    $pageTitle = 'Contact';
    $page = 'contact';
    break;
	
    case 'shop':
    $pageTitle = 'Shop';
    $page = 'shop';
    break;

    default:
    $pageTitle = 'Home';
    $page = 'home';
    break;
  
}

?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Gameshop | <?php echo @$pageTitle; ?></title>
	<link rel="shortcut icon" href="#" />
	<link rel="stylesheet" type="text/css" href="Styles/main.css">
	
</head>
<body>
	<header>
		<div id="container_header">
			<div id="logo">
				<h1>Game Shop</h1>
			</div>

			<nav>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="index.php?page=contact">Contact</a></li>
					<li><a href="index.php?page=login">login</a></li>
				</ul>
			</nav>
		</div>
	</header>
	
	<div class="content">
		<?php include "Pages/$page.php"; ?>
	</div>
	
	<footer>
		<h3>Hochschule Hannover</h3>
	</footer>

</body>
</html>

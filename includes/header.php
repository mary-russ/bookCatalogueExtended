<?php include 'includes/config.php';?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="styles/style.css">
    </head>
    <body>
        <div id="wrapper">
        <header class="clear"> 
        	<div id="left" >
            <h1><img src="img/book.png" width="40"/> <a href="index.php">Каталог за книги</a></h1>
	      
	            <ul id="left-nav" > 
	                <li><a href="addAuthor.php">Добави автор</a></li>
	                <li><a href="addBook.php">Добави книга</a></li>
	            </ul>
	       
	         </div>
	         <div id="right" class="clear">
	            <ul id="right-nav"> 	             
	                <li><a href="register.php">Регистрирай се</a></li>
	                <li><a href="login.php">Влез</a></li>
	                <li><a href="logout.php">Излез</a></li>
	            </ul>
	        </div>
	       
       </header> 
         
	   <div id="content">
        <?php 
        echo '<h2>'.$pageTitle.'</h2>';
<?php

ob_start();
$pageTitle = 'Вход в системата';

include 'includes/header.php';

if ($_POST) {
	
	$username = mysqli_real_escape_string( $connection, trim( $_POST['username'] ) );
	$password = mysqli_real_escape_string( $connection, trim( $_POST['pass'] ) );
	//check if such a user exists
	$sql = 'SELECT user_name
			FROM users
			WHERE user_name = "' . $username . '"';
	$login = mysqli_query( $connection, $sql );
	
	if ( $login->num_rows > 0 ) {
		$row = $login->fetch_assoc();

		$_SESSION['username'] = $username;
		$_SESSION['is_logged'] = true;
			header('Location: index.php');
			exit();
}
else {
	echo '<div class="message">Не си регистриран!</div>';
}	


}
?>	
	<form method="post" name="login" >
	Username:<input type="text" name="username" /><br/>
	Password:<input type="password" name="pass" /><br/>
	<input type="submit" value="Влез" />
</form>
<?php ob_end_flush(); ?>





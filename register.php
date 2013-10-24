<?php  
ob_start();
$pageTitle = 'Регистрационна форма';
include 'includes/header.php'; 
?>
	<form method="post" >
	Username:<input type="text" name="username" /><br/>
	Password:<input type="password" name="pass" /><br/>
	<input type="submit" name="register" value="Регистрирай се!" />
	</form>
<?php 
if ($_POST) {

	$error = false;
	if (!(empty($_POST['username']) || empty($_POST['pass']))) {
		$username = mysqli_real_escape_string( $connection, trim( $_POST['username'] ) );
		$password = mysqli_real_escape_string( $connection, trim( $_POST['pass'] ) );

// Check input length
		if ( mb_strlen( $username, 'UTF-8' ) < 5 || mb_strlen( $password, 'UTF-8' ) < 5 ) {
			echo '<div class="message">Името и паролата трябва да бъдат над 5 символа!</div>';
			$error = true;
		}

// Check if this username is free
		$sql = 'SELECT user_name
				FROM users
				WHERE user_name = "' . $username . '"';
		
		$new_user = mysqli_query( $connection, $sql );
		
		if ( $new_user->num_rows > 0 ) {
			echo '<div class="message">Името е заето.Опитай отново!</div>';
			$error = true;
		}
	}else {	
		echo '<div class="message">Попълни полетата за име и парола!</div>';
		exit();
	}
	
	// register and insert in table users
	if ( $error == false ) {
		$sql = 'INSERT INTO users (user_name, password )
				VALUES ("' . $username . '", "' . $password . '" )';
		if (mysqli_query($connection, $sql)) {
					echo "Регистрацията беше успешна!";
					header( 'Location: login.php' );
					exit();
				}
		else {
			echo '<div class="message">Регистрацията неуспешна. Опитай отново!</div>';
}
		
	}
}
 ob_end_flush(); 
?>
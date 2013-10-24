<?php 
$pageTitle = 'Добави автор';
include 'includes/header.php';
?>

<form method="GET">
	<label>Автор:</label>
	<input name="author" placeholder="Добави нов автор" /><br/>	
	<input type="submit" value="Добави автор" />	
</form>

<?php
if (isset($_GET['author'])) {
	$author = trim($_GET['author']);
	$author_esc = mysqli_real_escape_string($connection, $author);
	// Check inputs length
	if ( mb_strlen( $author, 'UTF-8' ) < 3 || mb_strlen( $author, 'UTF-8' ) > 250 ) {
		echo '<div class="message">Името трябва да бъде поне 3 символа и най-много 250 символа!</div>';
	
		//check if this author already exists
		$sql = 'SELECT * FROM authors WHERE author_name = "'.$author_esc.'"';
		$result = mysqli_query ( $connection, $sql );
		if ($result) {
			if (mysqli_num_rows ( $result ) > 0) {
				echo '<div class="message">Aвторът вече съществува.</div>';			
			}
		}
	}
		else{
			$sql = mysqli_query($connection, 'INSERT INTO authors(author_name) VALUES("'.$author_esc.'")');
			if (!$sql) {
				echo '<div class="message">Грешка в добавянето на автора.</div>';
				
			}else echo '<div class="success">Авторът беше добавен успешно!</div>';
	    }
}
$order="desc";
$sql='SELECT * FROM authors ORDER BY author_name ';
if ($_GET && isset($_GET['order'])) {
	if ($_GET['order'] == "desc") {
		$sql .= " DESC ";
		$order = "asc";
	}
}
$sql = mysqli_query($connection, $sql);

if (!$sql->num_rows>0) {
	echo '<div class=message">Няма добавени автори!</div>';
}
else {
	$sign = ($order=='desc')?' +':' -';
	echo '<table><tr><th><a href="addAuthor.php?order=' . $order . '">Автори ' . $sign . '</a></th></tr>';
	$result=array();
	while ($row=$sql->fetch_assoc()){
		$result[]=$row;
	}
		foreach ($result as $author){
			$author_id = $author['author_id'];
			echo "<tr><td><a href='selectAuthor.php?author_id=$author_id'> " .$author['author_name']."</a></td></tr>";
		}
			
	echo '</table>';
}


include 'includes/footer.php';



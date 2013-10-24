<?php 
$pageTitle = 'Добавяне на нова книга';
include 'includes/header.php';

if ($_GET) {
	$error=false;
	$book_name = trim($_GET['book_name']);
	$book_name_esc = mysqli_real_escape_string($connection, $book_name);
	if ( mb_strlen( $book_name_esc, 'UTF-8' ) < 3 || mb_strlen( $book_name_esc, 'UTF-8' ) > 250 ) {
		echo '<div class="message">Заглавието трябва да бъде поне 3 символа и най-много 250 символа!</div>';
		$error = true;
	}
	if (!isset($_GET['authors'])) {
		echo '<div class="message">Избери автор!</div>';
		$error=true;
	}else {
		$authors = $_GET['authors'];			
	}
	if (!$error) {
		$sql=mysqli_query($connection, 'INSERT INTO books(book_title) VALUES("'.$book_name_esc.'")');
		if (!$sql) {
			echo '<div class="message">Книгата не може да бъде добавена!</div>';
			exit();	
		}
		$book_id=mysqli_insert_id($connection);
		$book_authors=array();
		foreach ($authors as $author){
			$book_authors[] = "($book_id, $author)";			
		}
		$sql = mysqli_query($connection, "INSERT INTO books_authors VALUES ".implode(', ',  $book_authors));
		if (!$sql) {
			echo '<div class="message">Авторът не може да бъде добавен!</div>';
			exit();
		}
		else echo '<div class="success">Книгата е добавена успешно!</div>';
	}	
}

?>
<form  method="GET">
	<div>
		<p>Име на книгата:</p>
		<input type="text" name="book_name" placeholder="Заглавие"/></div>
	
	<div>
		<p>Избери автор/и:</p>
		<select multiple="multiple" name="authors[]">
			<?php 
				$sql=mysqli_query($connection, 'SELECT * FROM authors');
				
				while ($row=$sql->fetch_assoc()){ 
					echo '<option value="'.$row['author_id'].'">'.$row['author_name'].'</option>';
				}
			?>
		</select>
	</div>
	<div><input type="submit" value="Добави книга" /></div>
</form>
<?php 
include 'includes/footer.php';
?>
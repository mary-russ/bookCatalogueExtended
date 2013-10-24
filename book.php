<?php
$pageTitle = 'Избрана книга';
include 'includes/header.php';

if (isset($_GET['book_id'])) {
	$book_id = $_GET['book_id'];
	$sql=mysqli_query($connection, 'SELECT * FROM authors
									JOIN books_authors ON authors.author_id = books_authors.author_id
									JOIN books ON books.book_id = books_authors.book_id
									WHERE books_authors.book_id
									IN (SELECT book_id FROM books_authors
									WHERE book_id ="'.$book_id.'")');

$result = array();
	while ($row=$sql->fetch_assoc()){
		$result['book_id']=$row['book_id'];
		$result['book_title'] = $row['book_title'];
		$result['authors'][$row['author_id']] = $row['author_name'];
	
	}

 	$title=$result['book_title'];
 	$authors=array();
 	foreach ($result['authors'] as $id=>$name){
 		$authors[]= "<a href='selectAuthor.php?author_id=$id'> " . $name . "</a>";
 	}
 	echo '<p><span  class="book">'.$title.'</span> , с автор/и: '.implode('  ', $authors).'</p>';

 	if (isset($_SESSION['is_logged'])) {
 		$user = $_SESSION['username'];
 		echo '<form method="post">
					<textarea name="comment" placeholder="Твоят коментар"></textarea><br/>
					<input type="submit" name="com"  value="Изпрати коментара" />
			  </form>';
 		if (isset($_POST['com'])) {
 			$comment = trim($_POST['comment']);
 			$comment = mysqli_real_escape_string($connection, $comment);
 	
 			// Check inputs length
 			if ( mb_strlen( $comment, 'UTF-8' ) < 3) {
 				echo '<div class="message">Коментарът трябва да съдържа поне три символа!</div>';

 			}else{
 				$sql = 'INSERT INTO comments(book_id, comment, user_posted) VALUES("'.$book_id.'","'.$comment.'", "'.$user.'")';
 			
 				if (mysqli_query($connection, $sql)) {
 					echo '<div class="success">Коментарът беше записан успешно!</div>';
 						
 			    }else echo 'div class="message">Грешка в изпращането на коментара.</div>';
 			}
 		}
 	}
 	
 	$sql = mysqli_query($connection, 'SELECT * FROM comments WHERE book_id="'.$book_id.'" ORDER BY date DESC');
 	if (!$sql->num_rows>0) {
 		echo '<div class="message">Няма коментари за книгата.</div>';
 	}else {
 	echo '<table border="1"><tr><th>Коментар</th><th>Потребител</th><th >Дата</th></tr>';
 	while ($row=$sql->fetch_assoc()){
 		echo '<tr><td>'.wordwrap($row['comment'],80,"<br>",true).'</td><td><a href="user.php?username=' . $row['user_posted'] . '">'
 				.$row['user_posted'].'</a></td><td>'.$row['date'].'</td></tr>';	
    }
 	echo '</table>';
 	}
}

include 'includes/footer.php';



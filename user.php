<?php 
$pageTitle = 'Коментари на потребител';
include 'includes/header.php';

if (isset($_GET['username'])) {
	$user = $_GET['username'];
	$sql=mysqli_query($connection, 'SELECT *
									FROM `comments`
									JOIN books ON books.book_id = comments.book_id
									JOIN users ON users.user_name = comments.user_posted
									WHERE users.user_name ="'.$user.'"');
$result = array();
	while ($row=$sql->fetch_assoc()){
		$result[$row['comment_id']]['comment']=$row['comment'];
		$result[$row['comment_id']]['user']=$row['user_name'];
		$result[$row['comment_id']]['book_title'] = $row['book_title'];
		$result[$row['comment_id']]['book_id']=$row['book_id'];
		$result[$row['comment_id']]['date'] = $row['date'];
	
	}

	echo '<p>Потребител: <span  class="book">'.$user.'</span></p>';
	echo '<table><tr><th>Потребител</th><th>Книга</th><th>Коментар</th><th>Дата</th><tr>';
 	foreach ($result as $value){
 		$book_id=$value['book_id'];
 		echo "<tr><td>".$value['user']."</td><td><a href='book.php?book_id=$book_id'> " . $value['book_title'] . "</a></td>
 				<td>".wordwrap($value['comment'],80,"<br>",true)."</td><td>".$value['date']."</td></tr>";
 	}
 	echo '</table>';
}
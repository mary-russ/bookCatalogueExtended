<?php

$pageTitle = 'Списък с книги';
include 'includes/header.php';

if (isset($_SESSION['is_logged'])==true) {
	echo '<p class="right">Добре дошъл<span class="user"> '. $_SESSION['username'].'</span></p>';

}
$order = 'desc';
$sql = 'SELECT books.book_id, book_title, authors.author_id, author_name, count( comment_id ) AS num_com
		FROM books
		LEFT JOIN books_authors ON books.book_id = books_authors.book_id
		LEFT JOIN authors ON books_authors.author_id = authors.author_id
		LEFT JOIN comments ON comments.book_id = books.book_id
		GROUP BY books.book_id, authors.author_id
		ORDER BY books.book_title';
if ($_GET && isset($_GET['order'])) {
 	if ($_GET['order'] == "desc") {
 		$sql .= " DESC ";
 		$order = "asc";
 	}
 }
 $sql = mysqli_query($connection, $sql);
if (!$sql->num_rows>0) {
	echo '<div class="message">Няма намерени книги в каталога! Въведи първо име на автор/и и след това заглавия на книги!</div>';
	exit();
	
}
$sign = ($order=='desc')?' +':' -';
$result = array();
while ($row=$sql->fetch_assoc()){ 
	$result[$row['book_id']]['book_id']=$row['book_id'];
	$result[$row['book_id']]['book_title'] = $row['book_title'];
	$result[$row['book_id']]['authors'][$row['author_id']] = $row['author_name'];
	$result[$row['book_id']]['num_com'] = $row['num_com'];
}
//echo '<pre>'.print_r($result, true).'</pre>'; 
echo '<table><tr><th><a href="index.php?order=' . $order . '">Заглавие'.$sign . '</a></th><th>Автор</th><th>Коментари</th></tr>';
foreach ($result as $book){
	$book_id= $book['book_id'];
	echo "<tr><td><a href='book.php?book_id=$book_id'> " . $book['book_title'] . "</a></td><td>";
	$authors=array();
	foreach ($book['authors'] as $id=>$name){
		$authors[]= "<a href='selectAuthor.php?author_id=$id'> " . $name . "</a>";
	}
	echo implode('  ', $authors);
	echo '</td><td>'.$book['num_com'].'</td></tr>';
}
echo '</table>';

include 'includes/footer.php';





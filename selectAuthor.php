<?php
$pageTitle = 'Книги на избран автор';
include 'includes/header.php';

if (isset($_GET['author_id'])) {
	$author_id = (int)$_GET['author_id'];
	$sql=mysqli_query($connection, 'SELECT * FROM authors
									JOIN books_authors ON authors.author_id = books_authors.author_id
									JOIN books ON books.book_id = books_authors.book_id
									WHERE books_authors.book_id
									IN (SELECT book_id FROM books_authors
									WHERE author_id ="'.$author_id.'")');

	$result = array();
	while ($row=$sql->fetch_assoc()){
		$result[$row['book_id']]['book_id']=$row['book_id'];
		$result[$row['book_id']]['book_title'] = $row['book_title'];
		$result[$row['book_id']]['authors'][$row['author_id']] = $row['author_name'];
	
	}
	echo '<table><tr><th>Книга</th><th>Автор</th></tr>';
	foreach ($result as $book){
		$book_id= $book['book_id'];
		echo "<tr><td><a href='book.php?book_id=$book_id'> " . $book['book_title'] . "</a></td><td>";
		$authors=array();
		foreach ($book['authors'] as $id=>$name){
			$authors[]= "<a href='selectAuthor.php?author_id=$id'> " . $name . "</a>";
		}
		echo implode('  ', $authors);
	}
	echo '</td></tr>';
	echo '</table>';
}

include 'includes/footer.php';



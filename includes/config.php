<?php
session_start();
mb_internal_encoding('UTF-8');
$connection = mysqli_connect('localhost', 'root', '', 'booksExtended');
if (!$connection) {
	echo "no connection";
}
//else echo "success!";
//set encoding
mysqli_set_charset($connection, 'utf8');

<?php

/*!
 * php-inserterr v0.9 (https://github.com/captainzoho/php-inserterr/)
 * Copyright 2015 Ralph Scheuerer
*/


require_once('config/db.php');

// connect to database
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// set connection charset to utf8
$db->set_charset("utf8");

// name of mysql table
$table = $db->real_escape_string($_POST['php-inserterr-table']);

// will be removed from keys
$key_prefix = $db->real_escape_string($_POST['php-inserterr-key-prefix']);

// will be appended to keys
$column_prefix = $db->real_escape_string($_POST['php-inserterr-column-prefix']);

// parameter string for INSERT INTO ()
$parameter_string = "";
$value_string = "";

foreach ($_POST as $key => $value) {

	if (substr($key, 0, 13) == 'php-inserterr')
	{
		continue;
	}

	$_key = $column_prefix . substr($db->real_escape_string($key), strlen($key_prefix));
	$_value = $db->real_escape_string($value);

	//echo $_key.":<br><br>".$_value."<hr>";

	// add key to $insert_string
	$parameter_string .= ', ' . $_key;

	// add value to $value string
	$value_string .= ', \'' . $_value . '\'';
}

$parameter_string = substr($parameter_string, 2);
$value_string = substr($value_string, 2);

//echo 'parameter_string:<br><br>' . $parameter_string . "<hr>";
//echo 'value_string:<br><br>' . $value_string . "<hr>";

$sql = 'INSERT INTO ' . $table . ' (' . $parameter_string . ') VALUES (' . $value_string . ')';

//echo 'SQL Query String:<br><br>' . $sql . '<hr>';

$result = $db->query($sql);

?>
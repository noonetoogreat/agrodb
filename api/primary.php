<?php 
	require_once('../workspace/config.php');
	require_once('../workspace/initialize_database.php');
	require_once('../workspace/article/functions.php');

	$primary_query = $mysqli->query("SELECT * FROM primary_category");
	$arr = array();
	while($primary_result = $primary_query->fetch_assoc()) {
		$entry = array();
		$entry['name'] = $primary_result['cat_name'];
		$entry['image'] = $primary_result['cat_name'];
		switch ($entry['name']) {
			case 'Soil':
				$entry['link'] = "landmarks.php";
				break;
			default:
				$entry['link'] = "category.php?category=".$primary_result['cat_id'];
				break;
		}
		array_push($arr, $entry);
	}
	print_r(json_encode($arr));
?>
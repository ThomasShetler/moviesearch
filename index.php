
<!DOCTYPE html>
<html lang="en">
<head>
  <title>News Searcher</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="stylesheet.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include "navbar.php" ?>
<div class="container" id="index">
  <form id="searchbar" class="form mt-5 mx-4 " action="" method="get">
          <input id="query" class="form-control mr-sm-2" type="search" aria-label="Search" placeholder="Enter your movie title" name="query" />
          <br />
          <button type="submit" class="btn btn-success my-2 my-sm-0" name="submit">Search</button>
  </form>
  <br />
<?php

require 'unirest-php\src\Unirest.php';

if (isset($_GET['query']) && $_GET['query'] != '') {
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://movies-tvshows-data-imdb.p.rapidapi.com/?title=".$_GET['query']."&type=get-movies-by-title",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: movies-tvshows-data-imdb.p.rapidapi.com",
		"x-rapidapi-key: 7df6dcd5afmsh731a50be35ddefep11ec31jsn8c579ea5f8f7"
	],
]);

//executing and organizing output
$response = curl_exec($curl);
$decode = json_decode($response, true);
$result = $decode['movie_results'];
$arrayLength = count($decode);
$i = 0;
$err = curl_error($curl);
$parsed = array();
curl_close($curl);


if ($err) {
	echo "cURL Error #:" . $err;
} else {
    echo '<div class="container">';
    echo '<b>News by Your query:</b>';
    foreach ($result as $post) {
       echo '<h3>' . $post['title'] . '</h3>';
       echo '<p>Date Published: ' . $post['year'] . '</p>';
       echo '<form method="get" action="details.php">';
       echo '<input type="hidden" method="get" placeholder="take a look" value="'.$post['imdb_id'].'" name="id"/>';
        echo '<button class="btn btn-info" type="submit" name="submit">Take a look</button>';
        echo '</form>';
       echo '<hr>';
       
    }
    echo '</div>';
}
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
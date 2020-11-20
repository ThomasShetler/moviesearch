
<!DOCTYPE html>
<html lang="en">
<head>
  <title>News Searcher</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<?php 

echo "hello";
echo $_GET["id"];


$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://movies-tvshows-data-imdb.p.rapidapi.com/?imdb=".$_GET["id"]."&type=get-movie-details",
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

$response = curl_exec($curl);
$decode = json_decode($response, true);

$arrayLength = count($decode);
$i = 0;
$err = curl_error($curl);
$parsed = array();
$directors = $decode['directors'];
curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
    echo '<div class="container">';
    echo '<b>News by Your query:</b>';
       echo '<h3>' . $decode['title'] . '</h3>';
       echo '<br>';
       echo "directors: ";
       print_r($directors);
       echo '<br>';
       echo '<p>IMDB raiting:' . $decode['imdb_rating'] . '</p>';
       echo '<br>';
       echo '<p>Description'. $decode['description'] . '</p>';
       echo '<hr>';
    echo '</div>';
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
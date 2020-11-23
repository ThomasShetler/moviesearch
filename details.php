
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="stylesheet.css" rel="stylesheet" type="text/css">
  <title> Movie Searcher</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<?php 
include "navbar.php";
//id for the IMDb id
$id = $_GET['id'];

//create database connection
$con=mysqli_connect("localhost","root","","moviedb");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql="SELECT imdb_id FROM rating WHERE imdb_id='".$_GET['id']."'";
$result=mysqli_query($con,$sql);




    //check to see if the id is in the database
  if (mysqli_num_rows($result) < 1) {
        $rowcount=mysqli_num_rows($result);
        //if it's not, add it to the database
        $sql = "INSERT into rating (imdb_id, ratingup, ratingdown) VALUES ('$id', 0, 0);";
        
        if(mysqli_query($con, $sql)) {
            echo "Records added successfully.";
        } 
        else{
            echo "ERROR: Could not execute $sql. " . mysqli_error($con);
        }
  }
mysqli_close($con);

//api intilizations 
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
//get response from api
$response = curl_exec($curl);
$decode = json_decode($response, true);

$arrayLength = count($decode);
$err = curl_error($curl);
$parsed = array();
$directors = $decode['directors'];
$stars = $decode['stars'];
curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
    echo '<div class="container">';
        echo '<h2>' . $decode['title'] . '</h2>';
        echo '<br>';
        echo '<p>IMDB raiting:' . $decode['imdb_rating'] . '</p>';
        echo '<br>';

       echo "<h4> Directors: </h4>";
       foreach($directors as $item){

        echo "<p>".$item . "\n"; 
        } 
        echo '<br>';
        echo "<h4>Stars: </h4>";
        foreach($stars as $item){ 
         echo $item."\n"; 
         } 
      
       echo '<br>';
       echo '<br>';
       echo '<h4>Description: </h4><br><p>'. $decode['description'] . '</p>';
       echo '<hr>';
       $con=mysqli_connect("localhost","root","","moviedb");
       $sql = mysqli_query($con,"SELECT ratingup FROM rating WHERE imdb_id = '".$_GET['id']."'");
       
       while($row = mysqli_fetch_array($sql)) {
        echo "<p> Likes: ". $row['ratingup']. "</p>"; 
         }
        $sql = mysqli_query($con,"SELECT ratingdown FROM rating WHERE imdb_id = '".$_GET['id']."'");
        while($row = mysqli_fetch_array($sql)) {
        echo "<p> dislikes: ". $row['ratingdown']. "</p>"; 
        } 
    
        echo '<form method="post"> ';
        echo        '<input type="submit" name="Like" class="btn btn-success" value="Like" />' ;
        echo        '<input type="submit" name="Dislike" class="btn btn-danger" value="Dislike" />' ; 
        echo   ' </form>' ;
        echo '</div>';
}

if(array_key_exists('Like', $_POST)) { 
    Like(); 
} 
else if(array_key_exists('Dislike', $_POST)) { 
    Dislike(); 
} 
function Like() { 
    $con=mysqli_connect("localhost","root","","moviedb");
    mysqli_query($con,"update rating set ratingup = ratingup + 1 where imdb_id = '".$_GET['id']."'"); 
    header("Refresh:0");
} 
function Dislike() { 
    $con=mysqli_connect("localhost","root","","moviedb");
    mysqli_query($con,"update rating set ratingdown = ratingdown - 1 where imdb_id = '".$_GET['id']."'"); 
    header("Refresh:0");
} 
mysqli_close($con);
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>





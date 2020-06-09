<?php
header('Access-Control-Allow-Origin: *');
include 'login.php';


if(isset($_GET['name']) && isset($_GET['score']) && isset($_GET['tag']) && isset($_GET['hash'])){

    $con = mysqli_connect($host, $db_username, $db_password, $db_name);
    $secret = "gLavbw9K1BTm6FI2mpPQBN9g7aijmCZk"; //this can be a random long string -> https://randomkeygen.com/
    //Lightly sanitize the GET's to prevent SQL injections and possible XSS attacks
    $name = strip_tags(mysqli_real_escape_string($con, $_GET['name']));//gets name section or url
    $score = strip_tags(mysqli_real_escape_string($con, $_GET['score'])); //gets score section or url
    $tag = strip_tags(mysqli_real_escape_string($con, $_GET['tag'])); //gets tag section or url
    $hash = strip_tags(mysqli_real_escape_string($con, $_GET['hash'])); //gets hash section or url
    
    $real_hash = md5($name . $score . $tag . $secret); //creates hash from incoming data
    if($real_hash == $hash){ //matches hash values one created here & one in construct 
        $sql = mysqli_query($con, "INSERT INTO $db_name.$db_table (name, score)
                               VALUES ('$name','$score');" );
        if($sql){

        //The query returned true 
        echo 'Your score was saved. Congrats!';
        
        }else{

            //The query returned false
            echo 'There was a problem saving your score. Please try again later.';
        }
    }else{
        echo 'There was a problem saving your score. Please try again later.';
    }

    mysqli_close($con);//Close off the MySQL connection to save resources.

}else{
    echo 'Your request is missing information such as name and score. Make sure you add ?name=NAME_HERE&score=1337';
}

?>

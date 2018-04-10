<?php
    $data = json_decode(file_get_contents('php://input'),true);
    if($_SERVER["REQUEST_METHOD"] == "GET"){
         $msgDB = new PDO("sqlite:message.sql") or die("Open Database failed!");
         if(!$msgDB) die ($error);
         $query = "select * from msglist;";
         
         $statement = $msgDB->prepare($query);
         $statement->execute();
         
         $msgArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    
         //this part is perhaps overkill but I wanted to set the HTTP headers and status code
         //making to this line means everything was great with this request
         header('HTTP/1.1 200 OK');
         //this lets the browser know to expect json
         header('Content-Type: application/json');
         //this creates json and gives it back to the browser
         echo json_encode($msgArray);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $msgDB = new PDO("sqlite:message.sql") or die("Open Database failed!");
        if(!$msgDB) die ($error);
        //$data = json_decode(file_get_contents('php://input'),true);
        $username = $data["username"];
        $msg = $data["msg"];
        $query = "insert into msglist values(:username, :msg);";
        
        $statement = $msgDB->prepare($query);
        $statement->bindParam(':username',$username);
        $statement->bindParam(':msg',$msg);
        $statement->execute();

        //this part is perhaps overkill but I wanted to set the HTTP headers and status code
        //making to this line means everything was great with this request
        header('HTTP/1.1 200 OK');
        //this lets the browser know to expect json
        header('Content-Type: application/json');
        //this creates json and gives it back to the browser
       // echo json_encode(Array("status"=>"success"));
       header('Location: ../chat_room.html');
       exit();
    }
    
?>
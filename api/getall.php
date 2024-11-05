<?php
require("../config.php");

$reqMethod = strtoupper($_SERVER['REQUEST_METHOD']);

if($reqMethod === "GET"){
    $sqlNotes = $pdo->query("SELECT * FROM notes");

    if($sqlNotes->rowCount() > 0){
        $notes = $sqlNotes->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($notes as $note){
            $response["result"][] = [
                "id" => $note["id"],
                "title" => $note["title"],
            ];
        }
    }
} else {
    $response["error"] = "Expecting GET";
}

require("../return.php");
?>
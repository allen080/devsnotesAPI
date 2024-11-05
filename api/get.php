<?php
require("../config.php");

$reqMethod = strtoupper($_SERVER['REQUEST_METHOD']);

if($reqMethod === "GET"){
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if($id){
        $sqlNote = $pdo->prepare("SELECT * FROM notes WHERE id=:id");
        $sqlNote->bindValue(":id", $id);
        $sqlNote->execute();

        if($sqlNote->rowCount() > 0){
            $note = $sqlNote->fetch();
            
            $response["result"][] = [
                "id" => $note["id"],
                "title" => $note["title"],
                "body" => $note["body"],
            ];
        } else {
            $response["error"] = "ID Not found";
        }

    } else {
        $response["error"] = "ID invalid";
    }
} else {
    $response["error"] = "Expecting GET";
}

require("../return.php");
?>
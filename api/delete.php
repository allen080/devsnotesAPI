<?php
require("../config.php");

$reqMethod = strtoupper($_SERVER['REQUEST_METHOD']);

if($reqMethod === "DELETE"){
    parse_str(file_get_contents("php://input"), $input);

    $id = filter_var($input["id"] ?? null, FILTER_VALIDATE_INT);

    if($id){
        $sqlNote = $pdo->prepare("SELECT * FROM notes WHERE id=:id");
        $sqlNote->bindValue(":id", $id);
        $sqlNote->execute();

        if($sqlNote->rowCount() > 0){
            $sqlDelete = $pdo->prepare("DELETE FROM notes WHERE id=:id");
            $sqlDelete->bindValue(":id", $id);
            $sqlDelete->execute();
            
        } else {
            $response["error"] = "ID Not found";
        }

    } else {
        $response["error"] = "ID invalid";
    }
} else {
    $response["error"] = "Expecting DELETE";
}

require("../return.php");
?>
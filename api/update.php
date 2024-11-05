<?php
require("../config.php");

$reqMethod = strtoupper($_SERVER['REQUEST_METHOD']);

if($reqMethod === "PUT"){
    parse_str(file_get_contents("php://input"), $input);

    $id = filter_var($input["id"] ?? null, FILTER_VALIDATE_INT);
    $title = filter_var($input["title"] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var($input["body"] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);

    if($id && $title && $body){
        $sqlCheckId = $pdo->prepare("SELECT * from notes WHERE id=:id");
        $sqlCheckId->bindValue(":id", $id);
        $sqlCheckId->execute();

        if($sqlCheckId->rowCount() > 0){
            $sqlUpdate = $pdo->prepare("UPDATE notes SET title=:title, body=:body WHERE id=:id");
            $sqlUpdate->bindValue(":title", $title);
            $sqlUpdate->bindValue(":body", $body);
            $sqlUpdate->bindValue(":id", $id);
            $sqlUpdate->execute();

            $response["result"] = [
                "title" => $title,
                "body" => $body,
                "id" => $id
            ];
        } else {
            $response["error"] = "ID not found";
        }

    } else {
        $response["error"] = "Error in parameters (id, title and/or body)";
    }

} else {
    $response["error"] = "Expecting PUT";
}

require("../return.php");
?>
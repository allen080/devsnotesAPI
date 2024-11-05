<?php
require("../config.php");

$reqMethod = strtoupper($_SERVER['REQUEST_METHOD']);

if($reqMethod === "POST"){
    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_input(INPUT_POST, "body", FILTER_SANITIZE_SPECIAL_CHARS);

    if($title && $body){
        $sqlNewNote = $pdo->prepare("INSERT INTO notes (title, body) VALUES (:title, :body)");
        $sqlNewNote->bindValue(":title", $title);
        $sqlNewNote->bindValue(":body", $body);

        $sqlNewNote->execute();
        // pega o id inserido
        $id = $pdo->lastInsertId();

        $response["result"] = [
            "id" => $id,
            "title" => $title,
            "body" => $body
        ];

    } else {
        $response["error"] = "Invalid Parameters";
    }
} else {
    $response["error"] = "Expecting POST";
}

require("../return.php");
?>
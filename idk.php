<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=fetch;charset=utf8', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

if ($contentType === "application/json") {

    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));


    $decoded = json_decode($content, true);


    //If json_decode failed, the JSON is invalid.

    if (!is_array($decoded)) {
        // Send error back to user.
        echo "there was an error";
    } else {

        header('Content-Type: application/json');

        $email = $decoded['email'];
        $pwd = $decoded['pwd'];


        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($pwd != "") {
                $sql = $db->prepare('INSERT INTO user (email, password) VALUES (:email, :password)');
                $sql->bindParam(':email', $email);
                $sql->bindParam(':password', $pwd);
                $result = $sql->execute();

                if ($result) {
                    echo json_encode("success");
                } else {
                    echo json_encode("didnt work");
                }
            } else {
                echo json_encode("Vous devez rentrer un mot de passe");
            }
        } else {
            echo json_encode("L'adresse entrée n'est pas bonne");
        }
    }
}

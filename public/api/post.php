<?php
    include "config.php";
    include "utils.php";


    $dbConn =  connect($db);

    /*
    listar todos los posts o solo uno
    */
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if (isset($_GET['user']) && isset($_GET['pass']))
        {
            //Mostrar un post
            $sql = $dbConn->prepare("SELECT id, user, name, created_at, update_at, enabled, profile_id, token FROM users where user=:user AND password=:pass");
            $sql->bindValue(':user', $_GET['user']);
            $sql->bindValue(':pass', $_GET['pass']);
            $sql->execute();
            header("HTTP/1.1 200 OK");
            echo json_encode( $sql->fetch(PDO::FETCH_ASSOC)  );
            exit();
        }
        if (!isset($_GET['user'])){
            //Mostrar lista de post
            $sql = $dbConn->prepare("SELECT u.*, p.name as profile_name FROM users u INNER JOIN profiles p ON u.profile_id = p.id");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            $res_json = json_encode( $sql->fetchAll()  );
            echo $res = base64_encode( $res_json );
            exit();
        }
    }

    // Crear un nuevo post
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST["pass"]))
        {
            //Mostrar un post
            $sql = $dbConn->prepare("SELECT id, user, name, created_at, update_at, enabled, profile_id, token FROM users where user=:user AND password=:pass");
            $sql->bindValue(':user', $_POST['user']);
            $sql->bindValue(':pass', $_POST['pass']);
            $sql->execute();
            header("HTTP/1.1 200 OK");
            echo json_encode( $sql->fetch(PDO::FETCH_ASSOC)  );
            exit(); 

        }else
        {
            $input = $_POST;
            $sql = "INSERT INTO users
                (user, name, password, enabled, token)
                VALUES
                (:user, :name, :password, :enabled, '')";
    
            $statement = $dbConn->prepare($sql);
            bindAllValues($statement, $input);
            $statement->execute();
            $postId = $dbConn->lastInsertId();
            if($postId)
            {
                $input['id'] = $postId;
                header("HTTP/1.1 200 OK");
                echo json_encode($input);
                exit();
            }
        }
    }

    //Borrar
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        $id = $_GET['id'];
        $statement = $dbConn->prepare("DELETE FROM users where id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        header("HTTP/1.1 200 OK");
        exit();
    }

    //Actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $input = $_GET;
        $postId = $input['id'];
        $fields = getParams($input);

        $sql = "
            UPDATE users
            SET $fields
            WHERE id='$postId'
            ";

        $statement = $dbConn->prepare($sql);
        bindAllValues($statement, $input);

        $statement->execute();
        header("HTTP/1.1 200 OK");
        exit();
    }


    //En caso de que ninguna de las opciones anteriores se haya ejecutado
    header("HTTP/1.1 400 Bad Request");

?>
<?php
    include "config.php";
    include "utils.php";


    $dbConn =  connect($db);

    /*
    listar todos los posts o solo uno
    */
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if (isset($_GET['id']))
        {
            //Mostrar un post
            $sql = $dbConn->prepare("SELECT a.*, u.name as user_name FROM articles a INNER JOIN users u ON a.create_user = u.id WHERE a.id=:id");
            $sql->bindValue(':id', $_GET['id']);
            $sql->execute();
            header("HTTP/1.1 200 OK");
            echo json_encode( $sql->fetch(PDO::FETCH_ASSOC)  );
            exit();
        }else{
            //Mostrar lista de post
            $sql = $dbConn->prepare("SELECT a.*, u.name as user_name FROM articles a INNER JOIN users u ON a.create_user = u.id");
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
        if(isset($_FILES)){

            //ruta de almacenamiento de archivo
            $dir_subida = "../assets/img/articulos/";
            if (!file_exists($dir_subida)) {
                mkdir($dir_subida, 0777, true);
            }

            //extraer propiedades del archivo
            $nombre_archivo = $_FILES["file"]["name"];
            $tipo_archivo = $_FILES["file"]["type"];
            $tamano_archivo = $_FILES["file"]["size"];

            $subir_archivo = $dir_subida.basename($_FILES['file']['name']);

            if (copy($_FILES['file']['tmp_name'], $subir_archivo)){
                
                json_encode($_FILES['file']['tmp_name']);
               
                //Extraer los datos del POST payload
                $data = json_decode(file_get_contents("php://input"));
                // header("Location: /app_web/#/articles/control/");
                print_r($_POST);
                $sql = $dbConn->prepare("INSERT INTO articles
                        SET titulo = :titulo,
                            autor = :autor,
                            contenido = :contenido,
                            create_user = :create_user,
                            update_user = :update_user,
                            image = :image");

                $sql->bindValue(':titulo', $data->titulo);
                $sql->bindValue(':autor', $data->autor);
                $sql->bindValue(':contenido', $data->contenido);
                $sql->bindValue(':create_user', $data->create_user);
                $sql->bindValue(':update_user', $data->update_user);
                $sql->bindValue(':image', $data->image);
                
                $sql->execute();
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
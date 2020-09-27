<?php
require('../config.php');


$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'delete') {
    
    parse_str(file_get_contents('php://input'), $input);

    $id = $input['id'] ?? null;

    $id = filter_var($id);

    if($id) {

        $sql = $pdo->prepare("SELECT * FROM notes where id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $pdo->prepare("DELETE FROM notes where id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

            $array['result'] = [
                'ID ', $id, ' deletado'
            ];

        } else {
            $array['error'] = 'ID inexistente';
        }

    }else {
        $array['error'] = 'ID nao enviado';
    }

}else{
    $array['error'] = 'Metodo nao permitido (Apenas DELETE)';
}

require('../return.php');
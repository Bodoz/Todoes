<?php

$db = new PDO("sqlite:./todoes.sqlite", PDO::FETCH_ASSOC);


///////////////////////////////////////////////////////////////////////////////////////////////////
///  U S E R S
//////////////////////////////////////////////////////////////////////////////////////////////////

function get_user($username){
    global $db;

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        $sql = "SELECT * FROM roles R 
            LEFT JOIN user_roles UR ON UR.role_id = R.id
            WHERE UR.user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user['id']);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $user['roles'] = $roles;
    }

    return $user;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
///  L I S T S
//////////////////////////////////////////////////////////////////////////////////////////////////

function get_lists() {
    global $db;

    $sql = "SELECT * FROM lists ORDER BY list";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $todoes = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    return $todoes;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
///  T O D O E S
//////////////////////////////////////////////////////////////////////////////////////////////////

function get_todoes() {
    global $db;

    $sql = "SELECT T.*,L.list FROM todoes AS T LEFT JOIN lists AS L ON T.id_list = L.id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $todoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($todoes as $k=>$t){
        $todoes[$k]['done'] = boolval($todoes[$k]['done']);
    }

    return $todoes;
}
function get_todo($id) {
    global $db;

    $sql = "SELECT T.*,L.list FROM todoes AS T LEFT JOIN lists AS L ON T.id_list = L.id WHERE T.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $todo = $stmt->fetch(PDO::FETCH_ASSOC);
    $todo['done'] = boolval($todo['done']);

    return $todo;
}

function add_todo($todo, $id_list) {
    global $db;

    // $id = $db->query("SELECT MAX(id)+1 FROM todoes")->fetchColumn(0);

    // if ($id == NULL) {
    //     $id = 1;
    // }

    $sql = "INSERT INTO todoes (todo, done, id_list) VALUES (:todo, 0, :id_list)";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':todo', $todo);
    $stmt->bindValue(':id_list', $id_list);

    $stmt->execute();

    $id = $db->lastInsertId();
    return get_todo($id);

    //TODO Restituire un errore
}
function save_todo($id, $todo, $done, $id_list) {
    global $db;

    $sql = "UPDATE todoes SET 
                        todo = :todo, 
                        done = :done,
                        id_list = :id_list
                        WHERE id = :id;";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':todo', $todo);
    $stmt->bindValue(':done', $done);
    $stmt->bindValue(':id_list', $id_list);

    $stmt->execute();

    return get_todo($id);
}

function del_todo($id) {
    global $db;

    $sql = "DELETE FROM todoes WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    //TODO Restituire un errore
}


function save_check($id, $done) {
    global $db;

    $sql = "UPDATE todoes SET done = :done
                        WHERE id = :id;";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':done', $done);

    $stmt->execute();
}
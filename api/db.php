<?php

$db = new PDO("sqlite:./todoes.sqlite", PDO::FETCH_ASSOC);

function get_lists() {
    global $db;

    $sql = "SELECT * FROM lists ORDER BY list";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $todoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $todoes;
}

function get_todoes() {
    global $db;

    $sql = "SELECT T.*,L.list FROM todoes AS T LEFT JOIN lists AS L ON T.id_list = L.id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $todoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $todoes;
}
function get_todo($id) {
    global $db;

    $sql = "SELECT T.*,L.list FROM todoes AS T LEFT JOIN lists AS L ON T.id_list = L.id WHERE T.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $todo = $stmt->fetch(PDO::FETCH_ASSOC);

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
<?php
$f3 = require('lib/base.php');
require_once "db.php";
header('Content-type: application/json; charset=UTF-8');

//sleep(1);

///////////////////////////////////////////////////////////////////////////////////////////////////
///  U S E R S
//////////////////////////////////////////////////////////////////////////////////////////////////

$f3->route(
    'POST /users/authorize',
    function ($f3, $params) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['username'] != '' and $data['password'] != '') {
            if ($data['username'] == 'admin' and $data['password'] == '1234') {
                $r = [
                    'result' => true,
                    'data' => [
                        'id' => 1,
                        'username' => 'admin',
                        'role' => 'admin',
                    ],
                    'msg' => 'you are logged in'
                ];
                $_SESSION['user'] = 1;
            }else {
                $r = [
                    'result' => false,
                    'data' => [
                        'username' => false,
                        'role' => false,
                    ],
                    'msg' => 'Ok'
                ];
                unset($_SESSION['user']);
            }
        } else {
            $r =  [
                'result' => false,
                'data' => [],
                'msg' => 'username or password empty, logged out'
            ];
            unset($_SESSION['user']);
        }
        echo json_encode($r);
    }
);

///////////////////////////////////////////////////////////////////////////////////////////////////
///  T O D O E S
//////////////////////////////////////////////////////////////////////////////////////////////////

//Elenco dei todo
$f3->route(
    'GET /todoes',
    function ($f3, $params) {
        echo json_encode([
            'result' => true,
            'data' => get_todoes(),
            'msg' => "Ok"
        ]);
    }
);

$f3->route(
    'GET /todoes/@id',
    function ($f3, $params) {
        $todo = get_todo($params['id']);
        if ($todo) {
            $r =  [
                'result' => true,
                'data' => [$todo],
                'msg' => 'Ok'
            ];
        } else {
            $r =  [
                'result' => false,
                'data' => [],
                'msg' => 'Ko'
            ];
            http_response_code(404);
        }
        echo json_encode($r);
    }
);

//Aggiungere un nuovo todo
$f3->route(
    'POST /todoes',
    function ($f3, $params) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['todo'] != '' and $data['id_list'] > 0) {
            $todo = add_todo($data['todo'], $data['id_list']);
            $r = [
                'result' => true,
                'data' => [$todo],
                'msg' => 'Ok'
            ];
        } else {
            $r =  [
                'result' => false,
                'data' => [],
                'msg' => 'Dati forniti non validi'
            ];
            http_response_code(400);
        }
        echo json_encode($r);
    }
);

// Modificare un todo
$f3->route('PUT /todoes/@id',
    function($f3, $params) {
        $data =  json_decode(file_get_contents('php://input'), true);
        if ($params['id'] > 0 && $data['todo'] != '' && $data['id_list'] > 0) {
            $todo = save_todo($params['id'], $data['todo'], $data['done'] ?? 0, $data['id_list']);

            $r = [
                'result' => true,
                'data' => [$todo],
                'msg' => 'Correct'
            ];
            http_response_code(201);
        } else {
            $r = [
                'result' => false,
                'data' => [null],
                'msg' => 'Error'
            ];
            http_response_code(400);
        }
        echo json_encode($r);
    }
);

//Eliminare un todo
$f3->route(
    'DELETE /todoes/@id',
    function ($f3, $params) {
        $todo = get_todo($params['id']);
        del_todo($params['id']);
        if ($todo) {
            $r =  [
                'result' => true,
                'data' => [$todo],
                'msg' => 'Ok'
            ];
        } else {
            $r =  [
                'result' => false,
                'data' => [],
                'msg' => 'Ko'
            ];
            http_response_code(404);
        }
        echo json_encode($r);
    }
);

///////////////////////////////////////////////////////////////////////////////////////////////////
///  L I S T S
//////////////////////////////////////////////////////////////////////////////////////////////////

$f3->route(
    'GET /lists',
    function ($f3, $params) {
        echo json_encode([
            'result' => true,
            'data' => get_lists(),
            'msg' => "Ok"
        ]);
    }
);

//Catch all
$f3->route(
    'GET /*',
    function () {
        echo 'I am the catch em all!';
    }
);

$f3->run();
<?php
header('Content-type: application/json; charset=UTF-8');

session_start();

$f3 = require('lib/base.php');
require_once "db.php";

//sleep(1);

///////////////////////////////////////////////////////////////////////////////////////////////////
///  U S E R S
///////////////////////////////////////////////////////////////////////////////////////////////////

$f3->route(
    'GET /users/authorized',
    function ($f3, $params) {
        if ( isset($_SESSION['user'])){
            $r = [
                'result' => true,
                'data' => $_SESSION['user'],
                'msg' => 'you are logged in'
            ];
        }else {
            $r = [
                'result' => false,
                'data' => false,
                'msg' => 'you are NOT logged in'
            ];
        }
        echo json_encode($r);
    }
);

$f3->route(
    'POST /users/authorize',
    function ($f3, $params) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data && $data['username'] != '' && $data['password'] != '') {
            $user = get_user($data['username']);
            if ($user && md5($data['password']) == $user['password']) {
                unset($user['password']);
                $r = [
                    'result' => true,
                    'data' => $user,
                    'msg' => 'you are logged in'
                ];
                $_SESSION['user'] = $r['data'];
            }else {
                $r = [
                    'result' => false,
                    'data' => null,
                    'msg' => 'invalid username or password'
                ];
                unset($_SESSION['user']);
            }
        } else {
            $r =  [
                'result' => false,
                'data' => null,
                'msg' => 'username or password empty, logged out'
            ];
            unset($_SESSION['user']);
        }
        echo json_encode($r);
    }
);

///////////////////////////////////////////////////////////////////////////////////////////////////
///  T O D O E S
///////////////////////////////////////////////////////////////////////////////////////////////////

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
///////////////////////////////////////////////////////////////////////////////////////////////////

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
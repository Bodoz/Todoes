<?php
header('Content-type: application/json; charset=UTF=8');

$f3 = require('lib/base.php');
require_once 'db.php';

//elenco dei todo
$f3->route('GET /todoes',
    function($f3, $params){
        echo 'Hello, qua world';
        echo json_encode([
            'result' => true,
            'data' => get_todoes(),
            'msg' => 'ok'
        ]);
    }
);

//elenco dei todo
$f3->route('GET /todoes/@id',
    function($f3, $params){
        echo 'Hello, qua world';
        $todo = get_todo($params['id']);
        if ($todo){
            $r = [
                'result' => true,
                'data' => [$todo],
                'msg' => 'ok'
            ];
        }else{
            $r = [
                'result' => false,
                'data' => [],
                'msg' => 'ko'
            ];
            http_response_code(404);
        }
        echo json_encode($r);
    }
);

//inserire un nuovo todo
$f3->route('POST /todoes',
    function($f3, $params){
        $data = json_decode(file_get_contents('php://input'), true);
        if($data['todo'] != '' and $data['id_list'] > 0){
            $todo = add_todo($data['todo'], $data['id_list']);
            $r = [
                'result' => true,
                'data' => [$todo],
                'msg' => 'ok'
            ];
        }else{
            $r = [
                'result' => false,
                'data' => [],
                'msg' => 'non è possibile'
            ];
            http_response_code(404);
        }
        echo json_encode($r);
    }
);

//modificare un todo
$f3->route('PUT /todoes/@id',
    function($f3, $params){
        $data = json_decode(file_get_contents('php://input'), true);
        if($params['id'] > '' and $data['todo'] != '' and $data['id_list'] > 0){
            $todo = save_todo($params['id'], $data['todo'], $data['done'] ?? 0, $data['id_list']);
            $r = [
                'result' => true,
                'data' => [$todo],
                'msg' => 'ok'
            ];
            http_response_code(201);
        }else{
            $r = [
                'result' => false,
                'data' => [],
                'msg' => 'non è possibile'
            ];
            http_response_code(404);
        }
        echo json_encode($r);
    }
);

//eliminare un todo
$f3->route('DELETE /todoes/@id',
    function($f3, $params){
        $todo = get_todo($params['id']);
        del_todo($params['id']);
        if($todo){
            $r = [
                'result' => true,
                'data' => [$todo],
                'msg' => 'ok'
            ];
        }else{
            $r = [
                'result' => false,
                'data' => [],
                'msg' => "non c'è"
            ];
            http_response_code(404);
        }
        echo json_encode($r);
    }
);

//catch all
$f3->route('GET /*',
    function(){
        echo "Hello, i'm the catch em all";
    }
);

$f3->run();
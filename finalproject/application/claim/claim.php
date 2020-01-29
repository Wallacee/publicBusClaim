<?php

include "../database/dbconn.php";
include "../database/sql.php";
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
    $method = $_POST['method'];
    $dtbs = new sql();
    $retval = [];

    if ($method == 'list_claim') {
        $list = $dtbs->list_claim();
        $retval['datetime'] = $list[0];
        $retval['bus_num'] = $list[1];
        $retval['claim'] = $list[2];
        echo json_encode($retval);
    }

    if ($method == 'new_claim') {
        $datetime = $_POST['datetime'];
        $bus_num = $_POST['bus_num'];
        $message = $_POST['message'];


        $new = $dtbs->new_claim($datetime, $bus_num, $message);
        $retval['status'] = $new[0];
        $retval['message'] = $new[1];
        echo json_encode($retval);
    }

    if ($method == 'edit_claim') {
        $id = $_POST['ID'];
        $datetime = $_POST['datetime'];
        $bus_num = $_POST['bus_num'];
        $message = $_POST['message'];

        $edit = $dtbs->edit_claim($id, $datetime, $bus_num, $message);
        $retval['status'] = $edit[0];
        $retval['message'] = $edit[1];
        echo json_encode($retval);
    }

    if ($method == 'delete_claim') {
        /* @var $_POST type */
        $id = $_POST['ID'];
        $delete = $dtbs->delete_claim($id);
        $retval['status'] = $delete[0];
        $retval['message'] = $delete[1];
        echo json_encode($retval);
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}
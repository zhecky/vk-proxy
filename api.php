<?php
/**
 * Created by PhpStorm.
 * User: zhecky
 * Date: 13.12.14
 * Time: 20:32
 */

$result = array();

require "util.php";

switch($_POST['act']) {

    case 'message.send' :
        $result['s'] = postVKMessage($_POST['id'], $_POST['msg'], ACCESS_TOKEN) > 0 ? 1 : -1;
        break;

    case 'message.markAsRead' :
        $result['s'] = markAsReadVKMessage($_POST['id'], ACCESS_TOKEN) ? 1 : -1;
        break;

    case 'chat.markAsRead' :
        $result['s'] = markAsReadVKChat(intval($_POST['id']), ACCESS_TOKEN) ? 1 : -1;
        break;
    case 'status.set' :
        $result['s'] = setVKStatus($_POST['msg'], ACCESS_TOKEN) ? 1 : -1;
        break;

    default:
        $result['s'] = -1;
        $result['t'] = 'no such method implemented';
        break;
}

echo json_encode($result);
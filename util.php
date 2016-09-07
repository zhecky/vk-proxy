<?php
/**
 * Created by PhpStorm.
 * User: zhecky
 * Date: 13.12.14
 * Time: 20:44
 */

require_once "Text.php";



define("CLIENT_PASS", "vdghdfgsdhsrgbzdfbsdh6576gawyw46u357iuw45");
define("ACCESS_TOKEN", $_COOKIE['vk_token'] ? decodeString($_COOKIE['vk_token'], CLIENT_PASS) : "");

function postVKMessage($id, $text, $access_token) {

    $params = array(
        "access_token" => $access_token,
        "message" => $text
    );

    if($id > 0) {
        $params['user_id'] = $id;
    } else {
        $params['chat_id'] = abs($id);
    }

    $res = json_decode(httpPostMessage("https://api.vk.com/method/messages.send", $params), true);

    return $res['response'];
}

function markAsReadVKMessage($id, $access_token) {

    $params = array(
        "access_token" => $access_token,
        'message_ids' => $id
    );

    $res = json_decode(httpPostMessage("https://api.vk.com/method/messages.markAsRead", $params), true);

    return $res['response'];
}

function markAsReadVKChat($id, $access_token) {

    $params = array(
        "access_token" => $access_token,
        'peer_id' => $id
    );

    $res = json_decode(httpPostMessage("https://api.vk.com/method/messages.markAsRead", $params), true);

    return $res['response'];
}

function setVKStatus($text, $access_token) {
    $params = array(
        "text" => $text,
        "access_token" => $access_token
    );

    $res = json_decode(httpPostMessage("https://api.vk.com/method/status.set", $params), true);

    return $res['response'];
}

function httpPostMessage($url, $params) {

    $postData = http_build_query($params);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postData
        )
    );

    $context = stream_context_create($opts);

    return file_get_contents($url, false, $context);

}

/**
 * @param $access_token
 * @return bool
 */
function isAccessTokenValid($access_token) {
    $data = json_decode(file_get_contents("https://api.vk.com/method/users.get?access_token={$access_token}"), true);
    return $data['response'] && $data['response'][0] && intval($data['response'][0]['uid']) > 0;
}
function getAppPermissions($access_token) {
    $data = json_decode(file_get_contents("https://api.vk.com/method/account.getAppPermissions?access_token={$access_token}"), true);
    return intval($data['response']);
}

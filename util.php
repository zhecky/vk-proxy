<?php
/**
 * Created by PhpStorm.
 * User: zhecky
 * Date: 13.12.14
 * Time: 20:44
 */

require_once "core/class/VK.php";
require_once "Text.php";



define("CLIENT_PASS", "vdghdfgsdhsrgbzdfbsdh6576gawyw46u357iuw45");
define("ACCESS_TOKEN", $_COOKIE['vk_token'] ? decodeString($_COOKIE['vk_token'], CLIENT_PASS) : "");

function postVKMessage($id, $text) {
    $vk = new VK();

    $params = [
        "message" => $text
    ];

    if ($id > 0) {
        $params['user_id'] = $id;
    } else {
        $params['chat_id'] = abs($id);
    }

    return $vk->api('messages.send', $params, false);
}

function markAsReadVKMessage($id) {
    $vk = new VK();

    return $vk->api('messages.markAsRead', ['message_ids' => $id], false);
}

function markAsReadVKChat($id) {
    $vk = new VK();

    return $vk->api('messages.markAsRead', ['peer_id' => $id], false);
}

function setVKStatus($text) {
    $vk = new VK();

    return $vk->api('status.set', ['text' => $text], false);
}

/**
 * @param $access_token
 * @return bool
 */
function isAccessTokenValid($access_token) {
    $vk = new VK();
    $response = $vk->api('users.get', ['access_token' => $access_token], false);

    return (isset($response[0]) && intval($response[0]['id']) > 0);
}
function getAppPermissions($access_token) {
    $vk = new VK();
    $response = $vk->api('account.getAppPermissions', ['access_token' => $access_token], false);

    return intval($response);
}

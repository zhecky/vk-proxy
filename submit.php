<?php
/**
 * Created by PhpStorm.
 * User: zhecky
 * Date: 14.12.14
 * Time: 5:26
 */


require_once "Text.php";
require_once "util.php";


switch($_REQUEST['act']) {

    case 'submit-access-token':
        $access_token = $_REQUEST['access-token'];
        if(isAccessTokenValid($access_token)) {
            // save access_token
            if((getAppPermissions($access_token) & 4096) == 0) {
                header("Location: /?s=not_mail");
            } else {
                $encodedToken = encodeString($access_token, ALG_NAME, CLIENT_PASS);

                setcookie("vk_token", $encodedToken, time()+60*60*24*30, "/", null, true, true);
                header("Location: /?s=ok");
            }
        } else {
            // not success
            header("Location: /?s=bad_at");
        }
        //
        break;

    case 'forget_token':
        setcookie("vk_token", "", 0, "/");
        header("Location: /");
        break;

}
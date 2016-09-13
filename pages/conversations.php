<?
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <a class="pull-right" href="" onclick="document.location.reload(); return false;"><span class="glyphicon glyphicon-refresh"></span></a>
        Conversations
    </div>
    <div class="panel-body">

        <?

        $conv = json_decode(file_get_contents("https://api.vk.com/method/messages.getDialogs?access_token=".ACCESS_TOKEN."&v=5.27"), true);


        $uids = "";
        foreach ($conv['response']['items'] as $value) {
            $uids .= ($uids == "" ? "" : ",") . $value['message']['user_id'];
        }

        $vkUserResponse = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$uids}&https=1&fields=photo_50&v=5.27"), true);

        $user_data = array();

        foreach ($vkUserResponse['response'] as $value) {
            $user_data["{$value['id']}"]['photo'] = $value['photo_50'];
            $user_data["{$value['id']}"]['name'] = $value['first_name'] . " " . $value['last_name'];
        }

        foreach ($conv['response']['items'] as $value) {

            $author_id = $value['message']['user_id'];

            ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <a class="media-left" target="_blank" href="//vk.com/id<?=$author_id?>">

                            <img src="<?= $user_data["" . $author_id ]['photo'] ?>" alt="...">
                        </a>

                        <div class="media-body">
                            <h5 class="media-heading">
                                <?= $user_data["" . $author_id]['name'] ?>
                                <? if (trim($value['message']['title']) != "...") { ?>
                                    <span class="label label-default"><?= $value['message']['title'] ?></span>
                                <? } ?>
                            </h5>
                            <?= normText($value['message']['body']) ?>
                        </div>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="pull-right"><?=dateDiffNow($value['message']['date'])?></div>
                        <? if ($value['unread'] > 0) { ?>
                            <span class="label label-danger"><?= $value['unread'] ?></span>
                        <? } ?>
                        <? if ($value['message']['out'] == 0) { ?>
                            <span class="label label-primary">inbox</span>
                        <? } ?>
                        <? if ($value['message']['read_state'] == 1) { ?>
                            <span class="label label-success">read</span>
                        <? } ?>
                        <div style="clear: both"></div>
                    </li>
                </ul>
                <div class="panel-footer">

                    <? $chat_id = ($value['message']['chat_id'] > 0) ? -$value['message']['chat_id'] : $value['message']['user_id']; ?>

                    <div class="btn-group pull-right ">

                        <a type="button" class="btn btn-default"
                           href="/chat/<?=$chat_id?>">Open</a>

                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="return vkProxy.markChatAsRead(<?=($value['message']['chat_id'] > 0) ? 200000000 + abs($chat_id) : abs($chat_id)?>)">Mark as read</a></li>
                        </ul>

                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>

        <?

        }

        ?>
    </div>
</div>

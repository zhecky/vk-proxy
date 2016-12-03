 <?
 $is_chat = $_GET['id'] < 0;
 $id = abs($_GET['id']);
 ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a class="pull-right" href="" onclick="document.location.reload(); return false;"><span class="glyphicon glyphicon-refresh"></span></a>
            Chat
        </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <textarea id="new-msg" class="form-control" onkeypress="return keyboard.submitListener(event, 1) ? vkProxy.sendMsg(<?=intval($_GET['id'])?>) && false : true;" rows="3"></textarea>
                </li>
                <script type="application/javascript">
                    $(window).load(function() {
                        ge("new-msg").focus();
                    });
                </script>
                <li class="list-group-item">
                    <div class="btn-group pull-left">
                        <button type="button" onclick="return vkProxy.markChatAsRead(<?=($is_chat) ? 2000000000 + $id : $id ?>);" class="btn btn-default">
                            Mark as read
                        </button>
                    </div>
                    <div class="btn-group pull-right">
                        <button type="button" onclick="return vkProxy.sendMsg(<?=intval($_GET['id'])?>);" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Send
                        </button>
                    </div>
                    <div style="clear: both"></div>
                </li>
            </ul>
        <div class="panel-body">

<?
$messages = $vk->api('messages.getHistory', [
   'count' => 200,
    ($is_chat ? 'chat_id' : 'user_id') => $id
]);

$uids = [];
foreach ($messages as $value) {
    $uids[] = $value['from_id'] ? $value['from_id'] : $value['user_id'];
    if (isset($value['fwd_messages'])) {
        foreach($value['fwd_messages'] as $fwd_msg) {
            $uids[] = $fwd_msg['user_id'];
        }
    }
}

$users = $vk->api('users.get', ['user_ids' => implode(',', array_unique($uids)), 'https' => 1, 'fields' => 'photo_50'], false);

$user_data = [];

foreach($users as $value) {
    $user_data["{$value['id']}"]['photo'] = $value['photo_50'];
    $user_data["{$value['id']}"]['name'] = "{$value['first_name']} {$value['last_name']}";
}

foreach($messages as $value) {
    $author_id = $value['from_id'] ? $value['from_id'] : $value['user_id'];
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media">
                <a  target="_blank" class="media-left" href="//vk.com/id<?=$author_id?>">
                    <img src="<?=$user_data["".$author_id]['photo']?>" alt="...">
                </a>

                <div class="media-body">
                    <h5 class="media-heading">
                        <?=$user_data["".$author_id]['name']?>
                        <span class="label label-default"><?=$value['title']?></span>
                    </h5>
                    <?=normText($value['body'])?>
                </div>
            </div>
        </div>
        <? if($value['attachments'] || $value['fwd_messages']){ ?>
        <ul class="list-group">
            <? if($value['attachments']){ ?>
            <li class="list-group-item">
                <pre><? print_r($value['attachments'])?></pre>
            </li>
            <? } ?>
            <? if($value['fwd_messages']){ ?>
                <li class="list-group-item">
                    <? makeFwdMessagesDOM($value['fwd_messages'], $user_data); ?>
                </li>
            <? } ?>
        </ul>
        <? } ?>
        <div class="panel-footer">
            <? if($value['unread'] > 0){ ?>
                <span class="label label-danger"><?=$value['unread']?></span>
            <? } ?>
            <? if($value['out'] == 0){ ?>
                <span class="label label-primary">inbox</span>
            <? } ?>
            <? if($value['read_state'] == 1){ ?>
                <span class="label label-success">read</span>
            <? } else { ?>
                <span class="label label-danger">new</span>
            <? } ?>
            <div class="pull-right"><?=dateDiffNow($value['date'])?></div>
        </div>
    </div>

<?
}
?>
        </div>
    </div>
 <?

 function makeFwdMessagesDOM($messages, $user_data) {
     $messages = array_reverse($messages);
     foreach($messages as $val) {
            ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <a target="_blank" class="media-left" href="//vk.com/id<?= $val['user_id'] ?>">
                            <img src="<?= $user_data["" . $val['user_id']]['photo'] ?>" alt="...">
                        </a>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <?= $user_data["" . $val['user_id']]['name'] ?>
                            </h5>
                            <?
                            if (isset($val['fwd_messages'])) {
                                makeFwdMessagesDOM($val['fwd_messages'], $user_data);
                            } else {
                                echo normText($val['body']);
                            }
                            ?>
                        </div>
                    </div>
                    <span class="pull-right"><?=dateDiffNow($val['date'])?></span>
                </div>
            </div>
 <?
     }
 }

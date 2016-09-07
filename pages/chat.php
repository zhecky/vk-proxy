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
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Send <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="return vkProxy.sendMsg(<?=intval($_GET['id'])?>);">just send</a></li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                </li>
            </ul>
        <div class="panel-body">

<?

$id = abs($_GET['id']);

if($_GET['id'] > 0) {
    $conv = json_decode(file_get_contents("https://api.vk.com/method/messages.getHistory?user_id={$id}&count=200&access_token=".ACCESS_TOKEN."&v=5.27"), true);
} else {
    $conv = json_decode(file_get_contents("https://api.vk.com/method/messages.getHistory?chat_id={$id}&count=200&access_token=".ACCESS_TOKEN."&v=5.27"), true);
}



$uids = "";
foreach($conv['response']['items'] as $value) {
    $author_id = $value['from_id'] ? $value['from_id'] : $value['user_id'];
    $uids .= ($uids == "" ? "" : ",").$author_id;
}

$vkUserResponse = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$uids}&https=1&fields=photo_50&v=5.27"), true);

$user_data = array();

foreach($vkUserResponse['response'] as $value) {
    $user_data["{$value['id']}"]['photo'] = $value['photo_50'];
    $user_data["{$value['id']}"]['name'] = $value['first_name']." ".$value['last_name'];
}

foreach($conv['response']['items'] as $value) {

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
                    <pre><? print_r($value['fwd_messages'])?></pre>
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
            <!--<div class="btn-group pull-right ">

                <button type="button" class="btn btn-default">Open</button>

                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" onclick="return vkProxy.markMessageAsRead(<?/*=$value['id']*/?>)">Mark as read</a></li>
                </ul>

            </div>
            <div style="clear: both"></div>-->
        </div>
    </div>

<?

}

?>
        </div>
    </div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a class="pull-right" href="" onclick="document.location.reload(); return false;"><span class="glyphicon glyphicon-refresh"></span></a>
        Conversations
    </div>
    <div class="panel-body">

        <?php
        $conversations = $vk->api('messages.getDialogs');
        $uids = implode(',', array_column(array_column($conversations, 'message'), 'user_id'));

        $users = $vk->api("users.get", ['user_ids' => $uids, 'https' => '1', 'fields' => 'photo_50'], false);

        $user_data = array();

        foreach ($users as $value) {
            $user_data["{$value['id']}"]['photo'] = $value['photo_50'];
            $user_data["{$value['id']}"]['name'] = $value['first_name'] . " " . $value['last_name'];
        }

        foreach ($conversations as $value) {

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
                                <?php if (trim($value['message']['title']) != "...") { ?>
                                    <span class="label label-default"><?= $value['message']['title'] ?></span>
                                <?php } ?>
                            </h5>
                            <?php
                                if (isset($value['message']['fwd_messages'])) {
                                    echo '<span class="label label-info">forwarded messages</span>';
                                } else {
                                    echo normText($value['message']['body']);
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="pull-right"><?=dateDiffNow($value['message']['date'])?></div>
                        <?php if ($value['unread'] > 0) { ?>
                            <span class="label label-danger"><?= $value['unread'] ?></span>
                        <?php } ?>
                        <?php if ($value['message']['out'] == 0) { ?>
                            <span class="label label-primary">inbox</span>
                        <?php } ?>
                        <?php if ($value['message']['read_state'] == 1) { ?>
                            <span class="label label-success">read</span>
                        <?php } ?>
                        <div style="clear: both"></div>
                    </li>
                </ul>
                <div class="panel-footer">

                    <?php $chat_id = ($value['message']['chat_id'] > 0) ? -$value['message']['chat_id'] : $value['message']['user_id']; ?>

                    <div class="btn-group pull-right ">

                        <a type="button" class="btn btn-default"
                           href="/chat/<?=$chat_id?>">Open</a>

                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="return vkProxy.markChatAsRead(<?=($value['message']['chat_id'] > 0) ? 2000000000 + abs($chat_id) : abs($chat_id)?>)">Mark as read</a></li>
                        </ul>

                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>

        <?php } ?>
    </div>
</div>

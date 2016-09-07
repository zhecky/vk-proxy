<?php
/**
 * Created by PhpStorm.
 * User: zhecky
 * Date: 14.12.14
 * Time: 2:33
 */

?>

<? if($_GET['s'] == 'bad_at') { ?>
    <div class="alert alert-danger" role="alert"><strong>Doh..</strong> We cannot check your access token. Please double check and re-submit.</div>
<? } else if($_GET['s'] == 'not_mail') {?>
    <div class="alert alert-warning" role="alert"><strong>Hmm..</strong> It looks like your access token doesn't has access for messages.</div>
<? } else if ($_GET['s'] == 'ok') {?>
    <div class="alert alert-success" role="alert"><strong>Well done!</strong> You can access to your messages.</div>
<?}?>


<div class="jumbotron">
    <h1>Hello, dude!</h1>

    <p>Here is a place for offline mailing in VK.</p>
    <? if (ACCESS_TOKEN) { ?>
        <p><a class="btn btn-primary btn-lg" href="/conversations" role="button">Go to conversations</a></p>
    <? } else { ?>
        <p>For full support you may submit your <b>access_token</b>. If you don't know, what is this site for
            or don't know, how generate access_token, or even don't know, what actually access_token is, please <b>disconnect
                now</b>!</p>

        <p><a class="btn btn-primary btn-lg" href="#"
              onclick="$('#access-token-submit').show(); $(this).hide(); return false;" role="button">Submit access
                token</a></p>
    <form action="submit.php" method="post">
        <div id="access-token-submit" class="input-group" style="display: none">
                <span class="input-group-addon glyphicon glyphicon-floppy-disk"></span>
                <input type="text" name="access-token" class="form-control" placeholder="access_token">
                <input type="hidden" name="act" value="submit-access-token">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Submit</button>
                </span>
        </div>
    </form>
    <? } ?>
</div>
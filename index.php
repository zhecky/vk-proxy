<?

ini_set('default_socket_timeout', 2);

require_once "util.php";

$vk = new VK();

if(ACCESS_TOKEN) {
    $counters = $vk->api('account.getCounters', [], false);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://www.favicon.co.uk/ico/2846.png">

    <title>VKProxy</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/datepicker3.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/pageactions.js"></script>
    <script src="/js/ajax.js"></script>
    <script src="/js/base.js"></script>
    <script src="/js/log.js"></script>
    <script src="/js/keyboard.js"></script>

</head>

<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><span style="color: rgba(200, 66, 64, 0.94)">VK</span>Proxy</a>
        </div>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <? if(ACCESS_TOKEN) { ?>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/conversations">Conversations<?if($counters['messages'] > 0) {?> <span class="label label-primary"><?=$counters['messages']?></span><?}?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Debug
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/counters">Counters</a></li>
                        <li><a href="/struct">View source</a></li>
                        <li><a href="/submit.php?act=forget_token">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <? } ?>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<div class="container">

    <div class="row">
        <?

        switch($_GET['act']) {
            case 'conversations' :
                require_once "pages/conversations.php";
                break;
            case 'chat' :
                require_once "pages/chat.php";
                break;
            case 'conversations_old' :
                require_once "conversations_old.php";
                break;
            case 'counters' :
                require_once "pages/counters.php";
                break;
            default:
                require_once "pages/home.php";
                break;
        }


        ?>

    </div>

</div>
<!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->


<script>

</script>

</body>
</html>

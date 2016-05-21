<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= WEBRoot ?>/bootstrap/css/bootstrap.min.css">    <!-- Optional theme -->
    <link rel="stylesheet" href="<?=WEBRoot?>/css/login.css">
</head>
<body>
<div id="fullscreen_bg" class="fullscreen_bg"/>
<br/><br/>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert"><span aria-idden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="message" id="MsgAlert"> BienVenue</div>
            </div>
        </div>
    </div>
    <div class="row" id="details">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <img src="<?=WEBRoot?>/images/logo-mtc.png" alt="" class="center-block img-responsive" width="200px;">
            <form class="form-signin form-horizontal" method="post" action="<?=WEBRoot?>/index.php" style="max-width: 350px;">
                <input type="text" class="form-control"  placeholder="Login" required=""  autofocus="" name="Login">
                <input type="password" class="form-control" placeholder="Mot de passe" required="" name="mdp">
                <button class="btn btn-lg btn-danger btn-block" type="submit" name="cnx" value="1"> Connexion</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div><!-- jQuery 2.1.4 -->
<script src="<?= WEBRoot ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script><!-- Bootstrap 3.3.5 -->
<script src="<?= WEBRoot ?>/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/ieTest.js"></script>
<script type="text/javascript" src="js/MyCode.js"></script>
<? if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])): ?>
    <script
        type="text/javascript">MSg("<?= $_SESSION['msg']?>", "<?=$_SESSION['type']?>");</script>    <? $_SESSION['msg'] = $_SESSION['type'] = "";endif; ?>
</body>
</html>
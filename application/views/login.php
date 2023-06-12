<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ok Computer | Login</title>
        <link rel="icon" type="image/ico" href="<?=base_url('assets')?>/resources/logo.ico" />
        <link rel="stylesheet" href="<?=base_url('assets')?>/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url('assets')?>/css/app.css">
        <link rel="stylesheet" href="<?=base_url('assets')?>/alvasoft_font/css/alvasoft.css">
        <link rel="stylesheet" href="<?=base_url('assets')?>/template/css/AdminLTE.css">
    </head>
    <style>
        .page-login{
            background-image: url(<?=base_url('assets/resources/background.jpg');?>);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
    <body class="page-login">
        <div class="sombra"></div>
        <div class="login-box">
            <div class="login-logo"><a><h1>OK COMPUTER</h1></a></div>
            <div class="login-box-body">
                <p class="login-box-msg">INICIAR SESION</p>
                <form class="form-signin" id="formLogin">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-user"></i></span>
                        <input type="text" class="form-control input-sm" name="user" placeholder="Ingrese su usuario" autofocus required>
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-lock"></i></span>
                        <input type="password" class="form-control input-sm" name="pass" placeholder="Ingrese su contraseña" required>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-danger btn-block btn-flat">Ingresar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="<?=base_url('assets')?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?=base_url('assets')?>/plugins/jQueryUI/jquery-ui.min.js"></script>
        <script src="<?=base_url('assets')?>/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript"> var baseUrl = '<?php echo base_url();?>'; </script>
        <script src="<?=base_url('assets')?>/js/login.js"></script>
    </body>
</html>
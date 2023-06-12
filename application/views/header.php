<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Ok Computer</title>
	<link rel="icon" type="image/ico" href="<?=base_url('assets')?>/resources/logo.ico" />
	<link rel="stylesheet" href="<?=base_url('assets')?>/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/plugins/jQueryUI/jquery-ui.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/app.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/template/css/AdminLTE.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/template/css/skins/skin-green.min.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/alvasoft_font/css/alvasoft.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/awesome/awesome.css">
	<style type="text/css">
        .loading{
            position:fixed;
            z-index:9999;
            background: rgba(17, 17, 17, 0.5);
            width:100%;
            height:100%;
            top:0; 
            left:0;
        }

        .loading div{
            position: absolute;
            background-image: url(<?=base_url('assets/resources/loading.gif');?>);
            background-size: 60px 60px;
            top:50%;
            left:50%;
            width:60px;
            height:60px;
            margin-top:-30px;
            margin-left:-30px;
        }
    </style>
</head>
<body class="hold-transition skin-green sidebar-mini">
	<div class="wrapper">
		<!-- Cabecera -->
		<header class="main-header">
			<a href="<?=base_url('inicio');?>" class="logo">
				<span class="logo-mini"><b>OKC</b></span>
				<span class="logo-lg"><b>OK COMPUTER</b></span>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?=$userProf;?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?=$userName?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="<?=$userProf;?>" class="img-circle" alt="User Image">
									<h4><?=$userName?></h4>
								</li>
								<li class="user-footer">
									<div class="pull-left">
										<a href="javascript: void(0);" class="btn btn-default btn-flat" onclick="openModalSettings();">Configuración</a>
									</div>
									<div class="pull-right">
										<a href="<?=base_url('logout');?>" class="btn btn-default btn-flat">Salir</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Menu -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="header">MENU EMPRESARIAL</li>
					<li class="treeview">
						<a href="#"><i class="icon-cog-alt"></i> <span> Garantías</span><i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="<?=base_url('lista');?>"><i class="icon-spin2"></i> Lista</a></li>
							<li><a href="<?=base_url('registro');?>"><i class="icon-spin2"></i> Registro</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="icon-book"></i> <span> Auxiliares</span><i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="<?=base_url('marca');?>"><i class="icon-spin2"></i> Marcas</a></li>
							<li><a href="<?=base_url('categoria');?>"><i class="icon-spin2"></i> Categorías</a></li>
							<li><a href="<?=base_url('tipo');?>"><i class="icon-spin2"></i> Tipo de Equipos</a></li>
						</ul>
					</li>
					<li><a href="<?=base_url('equipo');?>"><i class="icon-inbox"></i> <span> Equipos</span></a></li>
					<li><a href="<?=base_url('asignacion');?>"><i class="icon-arrows-cw"></i> <span> Asignacion</span></a></li>
				</ul>
			</section>
		</aside>
		<!-- Contenido -->
		<div class="content-wrapper">
			<section class="content">
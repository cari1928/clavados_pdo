<?php
include 'cl_web.class.php';
$templates = $web->templateEngine();

$templates->assign('title', 'SISCACLAO');
$templates->assign('headerTitle1', 'Tablero de Clavados Individual');
$templates->assign('headerTitle2', 'SISCACLAO');
$templates->assign('route1', 'images/logo_header.png');
$templates->assign('route2', 'images/rio2016.png');
$templates->display('internet.html');

<?php
/*
Description: The Header
Theme: Maya Reloaded
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <title><?php wp_title('', true); ?></title>
    
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<style type="text/css">
		/** Header */
		#main {
			color: #174F81;
			font-family: "Calibri",sans-serif;
			margin: 0 auto;
			width: 90%;
		}
		
		#main a {
			color: #174F81;
			text-decoration: none;
		}
		
		#main header {
			margin: 70px 0 50px;
		}
		#main header .header-logo{
			color: #BFBFBF;
			font-family: "Roboto Medium";
			font-size: 13px;
			text-align: right;
		}
		#main header .header-logo img {
			height: 40px;
			width: auto;
		}
		
		/** Body */
		#main header .header-title {
			margin-top: 35px;
			text-align: center;
		}
		#main header .header-title .title {
			font-size: 30px;
		}
		#main header .header-title .title-links a {
			display: inline-block;
			font-family: "Calibri Light", sans-serif;
			font-size: 14.6px;
			padding: 0 8px;
		}
		#main header .header-title .title-links a + a {
			border-left: 1px solid #174F81;
		}
		
		/** Body */
		#main h2 {
			background-color: #F0F3F6;
			font-family: "Roboto Medium";
			font-size: 22px;
			margin: 35px 0;
			text-align: center;
			text-transform: uppercase;
		}
		#main h3 {
			border-bottom: 1px solid #174F81;
			font-size: 18.6px;
			font-weight: bold;
			padding-left: 10px;
		}
		#main .voe-link {
			display: block;
			font-size: 17px;
			padding-left: 30px;
		}
		#main .voe-link + a {
			margin-top: 15px;
		}
		
		/** Footer*/
		#main footer {
			text-align: center;
		}
		#main footer .latim {
			background-color: #F0F3F6;
			font-family: serif;
			font-size: 18px;
			line-height: 23px;
			margin: 25px 0;
			padding: 15px 0;
			text-transform: uppercase;
		}
		#main footer > .assine-agora {
			background-color: #174F81;
			color: #FFF;
			font-weight: bold;
			margin: 25px 0;
			padding: 15px 0;
			text-transform: uppercase;
		}
		#main footer > .assine-agora .assine-agora {
			font-size: 16px;
		}
		#main footer > .assine-agora .orientador {
			font-size: 27px;
		}
		#main footer > .assine-agora .cinco-zero {
			font-size: 106px;
		}
		#main footer > .assine-agora .cinco-zero small {
			font-size: 32px;
		}
		#main footer > .assine-agora .cinco-zero small span {
			font-size: 17px;
			text-transform: lowercase;
		}
		#main footer > .assine-agora .categorias {
			font-family: "Calibri Light", sans-serif;
			font-size: 19px;
		}
		#main footer > .footer-links {
			margin: 25px 0 35px;
		}
		#main footer > .footer-links .links a {
			color: #BFBFBF;
			font-size: 15px;
			line-height: 35px;
			text-decoration: underline;
			text-transform: uppercase;
		}
		#main footer > .footer-links .social {
			margin-top: 45px;
		}
		#main footer > .equipe-tecnica {
			background-color: #F2F2F2;
			padding: 35px 0;
		}
		#main footer > .equipe-tecnica .title {
			font-size: 22px;
			font-weight: bold;
		}
		#main footer > .equipe-tecnica .title-underline {
			background-color: #174F81;
			height: 1px;
			margin: 35px auto;
			width: 80px;
		}
		#main footer > .equipe-tecnica .equipe-tecnica-lista {
			font-size: 15px;
		}
		#main footer > .equipe-tecnica .equipe-tecnica-lista strong {
			display: inline-block;
			padding-top: 35px;
		}
		#main footer > .equipe-tecnica .equipe-tecnica-lista strong:first-of-type {
			padding-top: 0;
		}
		#main footer > .copyright {
			background-color: #174F81;
			color: #FFF;
			font-size: 15px;
			line-height: 21px;
		}
 	</style>
    
</head>

<body>
	<div id="main">
		<header>
			<div class="header-logo">
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/voe/veritae_logo.png" alt="Veritae" />
				<div>
					ISSN 1981-7584 Ano XV <br />
					Edição 2018/Dez/20
				</div>
			</div>
			
			<div class="header-title">
				<div class="title">
					Orientador Empresarial
				</div>
				<div class="title-links">
					<a href="javascript: void(0)">Visite nosso site</a><a href="javascript: void(0)">Assine Já</a><a href="javascript: void(0)">Esqueci a senha</a>
				</div>
			</div>
			
		</header>
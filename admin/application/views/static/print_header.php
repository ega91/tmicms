<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css" nonce="">
		body,td,div,p,a,input {font-family: arial, sans-serif;}
	</style>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=(!empty($title))?$title:'Document Print - CMSRiver'?></title>
	<style type="text/css" nonce="">
		body{
			max-width: 1024px;
			margin: 0 auto;
		}
		body, td {font-size:13px} 
		a:link, a:active {color:#1155CC; text-decoration:none} 
		a:hover {text-decoration:underline; cursor: pointer} 
		a:visited{color:##6611CC} img{border:0px} 
		pre { white-space: pre; white-space: -moz-pre-wrap; white-space: -o-pre-wrap; white-space: pre-wrap; word-wrap: break-word; max-width: 800px; overflow: auto;} 
		.logo{
			height: 80px;
		}
		.logo-cnt{
			border-bottom: #444 1px solid;
			margin-bottom: 20px;
		}
		table{
			width: 100%;
		}
		h4{
			margin-top: 30px;
			font-size: 18px;
			margin-bottom: 6px;
			padding-bottom: 6px;
			border-bottom: #eee 1px solid;
		}
		.doc-title{
			float: right;
		    font-weight: bold;
		    font-size: 18px;
		    padding: 25px 0 0;
		    text-align: right;
		}
		.doc-title p{
			font-weight: normal;
			font-size: 11px;
			margin-top: 4px;
		}
		.uploaded-doc{
		    width: 240px;
		    height: 240px;
		    overflow: hidden;
		    float: left;
		    margin-right: 10px;
		    margin-bottom: 10px;
		    background-size: contain;
		    background-position: center;
		    background-repeat: no-repeat;
		    border: #ccc 1px solid;
		}
	</style>
</head>

<body>
	<div class="logo-cnt">
		<div class="doc-title">
			<?=(!empty($title))?$title:'Document Print - CMSRiver'?>
			<p><?=date('Y/m/d H:i:s')?>
		</div>
		<img class="logo" src="/resources/img/logo-white.png">
	</div>

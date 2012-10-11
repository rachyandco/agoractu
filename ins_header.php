<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is ins_header.php - Read the readme.txt file for more info	*/
/************************************************************************/ 

include_once 'lang/lang.fr.php';
include("password_protect.php");

?>
<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Agoractu - L'actualité romande sans censure</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/jquery.ias.css" rel="stylesheet">
<style type="text/css">
/* fix modal position for 480px devices */
@media (max-width: 480px) 
{
    .modal.fade.in {
        top: 10px;
  }
}

/* button back to top*/
#toTop {
display:none;
text-decoration:none;
position:fixed;
bottom:10px;
right:10px;
overflow:hidden;
width:51px;
height:51px;
border:none;
text-indent:-999px;
background:url(img/ui.totop.png) no-repeat left top;
}
#toTopHover {
background:url(img/ui.totop.png) no-repeat left -51px;
width:51px;
height:51px;
display:block;
overflow:hidden;
float:left;
opacity: 0;
-moz-opacity: 0;
filter:alpha(opacity=0);
}
#toTop:active, #toTop:focus {
outline:none;
}

</style>
</head>
<body>


<div class="navbar navbar-inverse">  
  <div class="navbar-inner">  
   <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
<a class="brand" href="list.php">AgorActu</a>  
 <div class="nav-collapse collapse">
<ul class="nav">
<li class="dropdown"><a id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" href="#"><? echo $lang['MENU_ARTICLES']; ?><b class="caret"></b></a>
	<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
		<li role=menuitem><a tabindex="-1" href="list.php?listtype=0"><? echo $lang['MENU_LASTARTICLES']; ?></a></li>
		<li role=menuitem><a tabindex="-1" href="list.php?listtype=1"><? echo $lang['MENU_MOSTCOMMENTED']; ?></a></li> 
		<li role=menuitem><a tabindex="-1" href="list.php?listtype=2"><? echo $lang['MENU_LASTCOMMENTED']; ?></a></li> 
	</ul></li>
<li><a href="listfeed.php"><? echo $lang['MENU_FEEDLIST']; ?></a></li>  
<li class="divider-vertical"></li>
<li><a data-toggle="modal" href="#ModalPropos"><? echo $lang['MENU_ABOUT']; ?></a></li>

</ul>
<form class="navbar-search pull-left" method=POST action=list.php>
<input type="text" class="search-query" name="search"  value="" placeholder="<? echo $lang['MENU_SEARCH']; ?>">
<input  class="hidden" type="submit" value="Submit" />
</form>  

  </div></div></div> 
</div>

<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1>AgorActu</h1>
    <p class="lead">Le concentré de la presse romande avec des commentaires anonymes.</p>
  </div>
</header>

<!-- Modal pour a propos -->
<div class="modal hide fade" id="ModalPropos" tabindex="-1" role="dialog" aria-labelledby="ModalProposLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="ModalProposLabel">A Propos d'Agoractu</h3>
    </div>
    <div class="modal-body">insert Text here</div>
    <div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true"><? echo $lang['MODAL_CLOSE']; ?></button>
    </div>
    </div>
<!-- End Modal pour a propos -->


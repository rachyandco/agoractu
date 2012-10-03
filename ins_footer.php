<?
/************************************************************************/
/* AgorActu 0.1 - RSS agregator with anonymous comments			*/
/* Copyright (c)2012 Swiss Pirate Party www.partipirate.ch		*/
/* ---------------------------------------------------------------------*/
/* This is ins_footer.php - Read the readme.txt file for more info	*/
/************************************************************************/
?>

<?

/* echo "<footer class=\"footer\">
      <div class=\"container\">

      </div>
    </footer>";
*/
//<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
//javascript sont a la fin du fichier html
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.ias.min.js"></script>
<script type="text/javascript">
jQuery.ias({
  loader	: '<img src="img/loader.gif"/>'
});</script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<? if (strpos ($_SERVER['PHP_SELF'],"admin")) {
echo " 
<script type=\"text/javascript\">
setInterval( function() {
    $('div#adminrefresh').load('admin.php #adminrefresh');
}, 5000); </script>";}?>

<script src='http://suyb.googlecode.com/files/jquery.ui.totop.js' type='text/javascript'></script>
<script type='text/javascript'>
		$(document).ready(function() {
			/*
			var defaults = {
	  			containerID: 'moccaUItoTop', // fading element id
				containerHoverClass: 'moccaUIhover', // fading element hover class
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			*/
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
</body></html>



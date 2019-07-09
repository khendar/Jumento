<?php /* Smarty version 2.6.8, created on 2006-02-23 01:36:22
         compiled from page.html */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="<?php echo $this->_tpl_vars['p']['page_description']; ?>
" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['p']['page_keywords']; ?>
" />
	<style type="text/css">
	<!--
		@import "skidoo_too_lab.css";
 	-->
	</style>
	<link rel="stylesheet" href="skidoo_too_print.css" type="text/css" media="print" />
	<script type="text/javascript" src="javascript/ruthsarian_utilities.js"></script>
	<script type="text/javascript">
                <!--
                        var font_sizes = new Array( 100, 110, 120 );
                        var current_font_size = 0;
                        if ( ( typeof( NN_reloadPage ) ).toLowerCase() != 'undefined' )  NN_reloadPage( true ); 
                        if ( ( typeof( opacity_init  ) ).toLowerCase() != 'undefined' )  opacity_init(); 
                        if ( ( typeof( set_min_width ) ).toLowerCase() != 'undefined' )  set_min_width( 'pageWrapper' , 600 ); 
                        if ( ( typeof( loadFontSize ) ).toLowerCase() != 'undefined' )  event_attach( 'onload' , loadFontSize ); 
                //-->
	</script>
	<script  type="text/javascript" src="javascript/cyberia_utilities.js"></script>
	<title>[cyberia] : [<?php echo $this->_tpl_vars['p']['page_title']; ?>
]</title>
</head>
<body>
	<div id="pageWrapper">
	<div id="masthead" class="inside">
		<!-- masthead content begin -->
		<!-- masthead content end -->
		<hr class="hide" />
	</div><!-- end div masthead -->
	<div class="hnav">
		<?php echo $this->_tpl_vars['nav']; ?>

	</div><!-- end div hnav -->
	<div id="outerColumnContainer">
		<div id="innerColumnContainer">
			<div id="SOWrap">
				<div id="middleColumn">
					<div class="inside">
<!--- middle (main content) column begin -->
<?php echo $this->_tpl_vars['page_content']; ?>

<!--- middle (main content) column end -->
					</div><!-- end div inside -->
				</div><!-- end div middleColumn -->
				<div id="leftColumn">
					<div class="inside">
						<div class="vnav">
							<?php echo $this->_tpl_vars['nav']; ?>

						</div><!-- end div vnav -->
					<hr class="hide" />
					</div><!-- end div inside -->
				</div><!-- end div leftColumn -->
				<div class="clear"></div>
			</div><!-- end div SOWrap -->
			<div id="rightColumn">
				<div class="inside">
<!--- right column begin -->
<h4>Side Panel</h4>
<p>
Here there be sponsor links, shoutbox, news headers, recent additions etc etc</p>

2 users online <br/>[ khendar, admin ]

<!--- right column end -->
						<hr class="hide" />
					</div><!-- end div inside -->
				</div><!-- end div rightColumn -->
				<div class="clear"></div>
			</div><!-- end div innerColumnContainer -->
		</div><!-- end div outerColumnContainer -->
		<div id="footer" class="inside">
			<!-- footer begin -->
			<p style="margin:0;">
							&copy; [cyberia] lan team 2006
			</p>
			<!-- footer end -->
			<hr class="hide" />
		</div><!-- end div footer|inside -->
	</div><!-- end div pageWrapper -->
</body>
</html>
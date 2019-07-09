<?php // ۞//text{encoding:utf-8;bom:no;linebreaks:unix;} 
/*
	cbparser bbcode guide 
	
	a part of corzblog.. http://corz.org/blog/

	;o)
	(or

	© 2003-> (or @ corz.org ;o)
*/

if (!stristr($_SERVER['REQUEST_URI'], 'blog')) {
	echo '
<script type="text/javascript" src="/blog/inc/js/func.js"></script>';
}
?>

	<div class="fill" id="cbguide">
		<div class="left" id="js-buttons">
			<input type="button" value="bold" title="subtly (if you have anti-alaising) bolded text" 
			class="small" onclick="boldz(event);return false;" />
			<input type="button" value="ital" title="italic text (slanty)" 
			class="small" onclick="italicz(event);return false;" />
			<input type="button" value="big" title="bigger text, not too big though" 
			class="small" onclick="bigz(event);return false;" />
			<input type="button" value="small" title="smaller text" 
			class="small" onclick="smallz(event);return false;" />
			<input type="button" value="block" title="a [block]blockquote[/block]" 
			class="small" onclick="block(event);return false;" />
			<input type="button" value="ref" title="a clickable reference. edit in your details" 
			class="small" onclick="refz(event);return false;" />
			<input type="button" value="img" title="simple image tag" 
			class="small" onclick="doimage(event);return false;" />
			<input type="button" value="url" title="you willll be asked to supply a URL and a title for this link"
			class="small" onclick="linkz(event);return false;" />
			<input type="button" value="box" title="a nice code box, similar to phpbb2. handy for code or quotes"
			class="small" onclick="codez(event);return false;" />
		</div>

		<div class="right" id="symbol-selecta">
			<span class="byline" title="select a symbol from the pull-down menu" id="fooness">
				<select name="dropdown" onchange="symbol(event);return false;" id="symbol-select">
					<option value="">&nbsp;&nbsp;&nbsp;</option>
					<option value="&bull;">&bull;</option>
					<option value="&deg;">&deg;</option>
					<option value="&plusmn;">&plusmn;</option>
					<option value="&trade;">&trade;</option>
					<option value="&copy;">&copy;</option>
					<option value="&reg;">&reg;</option>
					<option value="[[">[</option>
					<option value="]]">]</option>
					<option value="&hellip;">&hellip;</option>
				</select>
			</span>
			<input type="button" name="undo" id="UndoButt" class="small" value="undo" onclick="UndoThat(event);return false;" 
				title="this button takes you back to just before your last magic edit" />
		</div>
	</div>


	<div class="clear">&nbsp;</div>


	<div class="cbinfo">
		<br />
		<div class="left">
			<span class="byline">
				<strong><a title="you can use these as span classes, too." class="turl">headers.. </a></strong>
			</span><br />
			<span class="h6"><a title="you can click this to insert a type six header into your blog" 
			onclick="h6(event);"> six </a></span>
			<span class="h5"><a title="clicking this inserts a type five header into your blog" 
			onclick="h5(event);"> five </a></span>
			<span class="h4"><a title="and this is the type four" 
			onclick="h4(event);"> four </a></span>
			<span class="h3"><a title="same story for a type three header" 
			onclick="h3(event);"> three </a></span>
			<span class="h2"><a title="and so on for the type two, you get the idea" 
			onclick="h2(event);"> two </a></span>
		</div>

	<script type="text/javascript">
	//<![CDATA[
	<!--
	document.write("<div class=\"smilies\"><span class=\"byline\"><strong>..smilies<\/strong><\/span><br /><span class=\"h2\">&nbsp;<\/span> <img alt=\"smilie for :lol:\" title=\"smilie for :lol: (click to insert into text)\" src=\"/blog/inc/smilies/lol.gif\" onclick=\"smilie_lol(event);\" /> <img alt=\"smilie for :ken:\" title=\"smilie for :ken: (click to insert into text)\" src=\"/blog/inc/smilies/ken.gif\" onclick=\"smilie_ken(event);\" /> <img alt=\"smilie for :D\" title=\"smilie for :D (click to insert into text)\" src=\"/blog/inc/smilies/grin.gif\" onclick=\"smilie_grin(event);\" /> <img alt=\"smilie for :eek:\" title=\"smilie for :eek: (click to insert into text)\" src=\"/blog/inc/smilies/eek.gif\" onclick=\"smilie_eek(event);\" /> <img alt=\"smilie for :geek:\" title=\"smilie for :geek: (click to insert into text)\" src=\"/blog/inc/smilies/geek.gif\" onclick=\"smilie_geek(event);\" /> <img alt=\"smilie for :roll:\" title=\"smilie for :roll: (click to insert into text)\" src=\"/blog/inc/smilies/roll.gif\" onclick=\"smilie_roll(event);\" /> <img alt=\"smilie for :erm:\" title=\"smilie for :erm: (click to insert into text)\" src=\"/blog/inc/smilies/erm.gif\" onclick=\"smilie_erm(event);\" /> <img alt=\"smilie for :cool:\" title=\"smilie for :cool: (click to insert into text)\" src=\"/blog/inc/smilies/cool.gif\" onclick=\"smilie_cool(event);\" /> <img alt=\"smilie for :blank:\" title=\"smilie for :blank: (click to insert into text)\" src=\"/blog/inc/smilies/blank.gif\" onclick=\"smilie_blank(event);\" /> <img alt=\"smilie for :idea:\" title=\"smilie for :idea: (click to insert into text)\" src=\"/blog/inc/smilies/idea.gif\" onclick=\"smilie_idea(event);\" /> <img alt=\"smilie for :ehh:\" title=\"smilie for :ehh: (click to insert into text)\"   src=\"/blog/inc/smilies/ehh.gif\" onclick=\"smilie_ehh(event);\" /> <img alt=\"smilie for :aargh:\" title=\"smilie for :aargh: (click to insert into text)\" src=\"/blog/inc/smilies/aargh.gif\" onclick=\"smilie_aargh(event);\" /><\/div>");
	//-->
	//]]>
	</script>

		<div class="clear">&nbsp;</div>

		<noscript>
			<div class="smilies">
				<img alt="smilie for :lol:" title="smilie for :lol:" src="/blog/inc/smilies/lol.gif" />
				<img alt="smilie for :ken:" title="smilie for :ken:" src="/blog/inc/smilies/ken.gif" />
				<img alt="smilie for :D" title="smilie for :D" src="/blog/inc/smilies/grin.gif" />
				<img alt="smilie for :eek:" title="smilie for :eek:" src="/blog/inc/smilies/eek.gif" />
				<img alt="smilie for :geek:" title="smilie for :geek:" src="/blog/inc/smilies/geek.gif"  />
				<img alt="smilie for :roll:" title="smilie for :roll:" src="/blog/inc/smilies/roll.gif" />
				<img alt="smilie for :erm:" title="smilie for :erm:" src="/blog/inc/smilies/erm.gif" />
				<img alt="smilie for :cool:" title="smilie for :cool:" src="/blog/inc/smilies/cool.gif" />
				<img alt="smilie for :blank:" title="smilie for :blank:" src="/blog/inc/smilies/blank.gif" />
				<img alt="smilie for :idea:" title="smilie for :idea:" src="/blog/inc/smilies/idea.gif" />
				<img alt="smilie for :ehh:" title="smilie for :ehh:" src="/blog/inc/smilies/ehh.gif" />
				<img alt="smilie for :aargh:" title="smilie for :aargh:" src="/blog/inc/smilies/aargh.gif" />
			</div>
		</noscript>
	</div>

	<div class="tiny-space">&nbsp;</div>

	<div class="cbguide">

		<h3><a href="http://corz.org/blog/inc/cbparser.php" title="test-drive the corzblog bbcode to html and back to bbcode parser!">cbparser quick bbcode guide..</a></h3>

		Most common bbtags are supported, and with cbparser's InfiniTags&trade; you can pretty much just make up
		tags as you go along. If cbparser can make construct valid xhtml tags out of them, it will. Experimentation is the key, and preview often.<br />
		<br />
		
		A few <a onclick="window.open(this.href); return false;" href="http://corz.org/bbtags" 
		title="learn all the tags! and test them out, too!"><strong>bbcode</strong></a> examples..<br />

		[b]<strong>bold</strong>[/b], [i]<em>italic</em>[/i], [big]<big>big</big>[/big], [sm]<small>small</small>[/sm], 
		 [img]http://foo.com/image.png[/img], [code]<span class="simcode">code</span>[/code], 
		[url="http://foo.com" title="foo!"]<a href="http://corz.org/foo" title="foo!" id="TheFooLink" onclick="window.open(this.href); return false;">foo U!</a>[/url], 
		
		<a onclick="window.open(this.href); return false;" href="http://corz.org/bbtags" 
		title="learn all the tags! and test them out, too!">and more..</a><br />
		<br />
		<small><strong>note:</strong> the new cbparser bbcode parser and front-end (above) are still in the 
		experimental stages, bug reports, especially on the new portable JavaScript features, are especially welcome.</small>

	</div>

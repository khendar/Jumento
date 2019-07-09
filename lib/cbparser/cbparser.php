<?php //۞//text{encoding:utf-8;bom:no;linebreaks:unix;} 
$cbp_version = '1.0'; // [xhtml compliant]
/*

	cbparser.php
	the corzblog bbcode to x|html and back to bbcode parser

	converts bbcode to html and back to bbcode, and does it quickly. a bit
	clunky, but it gets the job done each and every day. output is 100% valid
	xhtml 1.0 strict. we use css to style the output as desired, your call.

	feel free to use this code for your own projects, I designed it with
	this in mind; linear. leave a "corz.org" lying around somewhere.
	a link to my site is always cool.

	:!:  if this document is accessed directly, it goes into "demo mode"  :!:
	:!:  as well as being a cool, fun thang, this serves as an excellent  :!:
	:!:  test page if you're adding or removing stuff from the parser     :!:
	:!:  yourself, as well as a useful tags reference/test for all users. :!:

	There's a full "ALL THE TAGS" reference here.. <http://corz.org/bbtags>
	and a smaller guide, "cbguide.php", which you can include under your forms
	as a quick refrence for users. I've chucked this into the zip, too.

	These days, cbparser comes with a built-in front-end which you can access with 
	the do_bb_form() function, perhaps something like this..
			
		do_bb_form($exmpl_str,'', '', false, '', false, '', '', 'blogform', false, true);

	See below for more information about the automatic gui creation.


	to use cbparser:

	simply include this file somewhere in your php script, like so..

		include ($_SERVER['DOCUMENT_ROOT'].'/blog/inc/cbparser.php');

	or wherever you keep it. next, some string of text, probably from a $_POST variable,
	ie. a form..

		if (isset($_POST['form-text'])) { $my_string = $_POST['form-text']; }

	..is simply passed through one of cbparser's two functions..

		for bbcode to html conversion >>

			$my_string = bb2html($my_string, $title);

		for html to bbcode conversion >>

			$my_string = html2bb($my_string, $title);

		either can be simply ($my_string) if you don't require the extra unique
		entry functions, i.e. references.

	What comes back will be your string transformed into HTML or bbcode, depending
	on which direction you are going. If there was an error in your bbcode tags
	cbparser will return an empty string, so you can do some message for the user
	in that case. if cbparser recognises the poster as a spammer, it will return
	simply "spammer". You can catch that, and kill output at that point, or some
	other suitable action *hehe*

	cbparser doesn't care about errors in your HTML for the HTML>>bbcode conversion,
	it's main priority is to get "whatever the tags" back into an editable state.


	notes:

	the second argument of the functions is the 'title', which corzblog supplies
	and uses for an html <div id="$title">, but you could provide from anywhere you
	like. then we can do funky things unique to a particular entry, like
	individual references. see my blog, I use these a lot. my comments engine
	sets the <div id= from this too, allowing you/users to link directly to a
	particular comment. groovy.

	if you don't need references that point to individual "id" entries, you can
	just ommit the second argument. it's a good feature, though. worth a few quid
	in my PayPal account, I'd say. *g*

	remember; if you add bits to the parser; complex stuff near the start.
	the order of things is important. lemme know about anything funky, or any bugs,
	of course.


	speed:
	my tests show even HUGE lists of str_replace statements are 'bloody fast'.
	there's a microtimer at the foot of my page, check yourself. I like this
	feature-filled approach a great deal, its linearity, and how easy it is to just
	plug stuff in. I hope you do to. I've certainly plugged in *a lot*! certainly
	worth a few quid in m- och forget it! heh. I've even added a few regex-type
	functions lately.

	This very parser is responsible for all this..	http://corz.org/blog/
	well, I helped a bit.


	css rocks:

	I use css to style the various elements, mostly. the parser works fine
	without css, but you will probably want define a few styles. if you need 
	guidance, see.. 
	
		http://corz.org/blog/inc/css/blog.css
	or..
		http://corz.ath.cx/inc/css/comments.css


	If you "include" this in your site header, you can call the parser's 
	functions from anywhere onsite. it's tempting to use the phrase "parsing 
	engine", but that accolade probably belongs to the PEAR package. As well 
	as the parsing, and the built-in demo page, the one cbparser.php also 
	handles "that comments bits" at the foot of most of my onsite tuts and
	contenty type pages.

	you get the idea.

	;o)
	(or

	© (or + corz.org 2003->

	ps.. the in-built demo mode thing only works if this script's name ends in 
	"parser.php", or else edit that, below.


	extra notes:

	InfiniTags™

	With cbparser's unique "InfiniTags™", users can make up bbcode tags on-the-fly. So..
	Even though there is no [legend][/legend] tag, it will work just fine.

	cbparser will also attempt to translate < > into [ ] in the HTML >> BBCode translation.
	this isn't perfect, but close enough for rock 'n' roll. the most used tags are "built-in", 
	but with InfiniTags™ you can create new bbcode as needed, and have it back again, too. 
	real handy.


	The built-in GUI (Graphic User Interface, front-end)

	do_bb_form() parameters reference.

	To create a gui automatically, call the do_bb_form() function with the following parameters..

	do_bb_form($textarea, $html_preview, $index, $do_title, $title, $do_pass, $hidden_post, $hidden_value, $form_id, $do_pre_butt, $do_pub_butt)

	And they as follows..

	$textarea			:	the text you want to place in the textarea				[string]
	$html_preview		:	an html preview	(been through the bb2html() function	[string]
	$index				:	an optional numerical index for your form				[integer/integer as string]
	$do_title			:	do the title											[boolean]
	$title				:	an optional input for a title							[string, becomes input name/id]
	$do_pass			:	whether to create a password field or not				[boolean]
	$hidden_post		:	an optional hidden field (use to track a value)			[string, becomes input name/id]
							once set, it will remain set through previews, etc
	$hidden_value		:	the value of said hidden field							[string, defaults to 'true']
	$form_id			:	the main id for the form								[string]
	$do_pre_butt		:	whether to create a "preview" submit input.				[boolean] 
	$do_pub_butt		:	whether to create a "publish" submit input.				[boolean]
	
	example:
	here's the form cbparser uses for its own demo..

	do_bb_form($exmpl_str,'', '', false, '', false, '', '', 'blogform', true, false);

	note:	the gui has some fairly nifty, and totally portable JavaScript functions (for example, you can
			click "bold" and the selected text will get [b]bold[/b] tags around it. Some of the other buttons
			are even niftier.

			these functions are provided by the "func.js" file which lives inside the "js" folder. you will
			probably need to edit the location of where you keep the js file (at the top of cbguide.php) and 
			if you move it, you might want to edit the bottom of this file, for the bbcode demo, if you use
			that feature.

			If you know what a CSRF attack is, you may find the $hidden_value parameter most useful!

*/



/*
	preferences..
					*/


/*	smilies. optional, but fun..
	the full path to the smilie folder from your http root..
*/
$smilie_folder = '/blog/inc/smilies/';
/*
	while it seems like an idea to hard-code in some relative link, in practice
	this limits the parser. this way, you can use cbparser all over your site, and
	always have the smilies available from one central copy, rather than having to
	duplicate your smilie folder everywhere you want to use the parser.
*/

/*	effin casinos!	(guess what this does)

	if they want to place their casino link on your site, ask them to pay for it.
	if their hot casino tips are really so hot, a few quid shouldn't be a problem. */

/*	if you set this to false just before calling the function for a "preview", you
	can do a "mock" output. to the casino spammer, it looks like their link will
	work just fine, but for the actual post, set it to true.. hahahah!	*/
$effin_casinos = false;

// for the above pref's replacement url (your home page, or a hot page, whatever..)
//$insert_link = $_SERVER['HTTP_HOST'].'/blog/inc/cbparser.php';
$insert_link = $_SERVER['HTTP_HOST'];


/*
	so your page gets popular..

	apart from the pesky casinos, you may find other spammers taking advantage
	of your nice comments facility, especially if you have high Google PR.
	Add any strings they use to this list and have them defeated!
*/
$spammer_strings = array(
	'astromarv.com', 'carmen-electra', 'angelina-jolie', 'justin-timberlake', 'dish-network', 'missy-elliott', 'byondart.com', 'getmydata.cn', 'bag1881.com', 'krasaonline.cz', 'mut.cz', 'inetmag.cz', 'kavglob.cz', 'casino poker black jack', 'Nice design, good work !', 'reality-inzert.cz', 'spkk.cz', 'hotelcecere.it', 'autoscuolevalenza.it', 'eversene.com', 'gerhardt-wein.de', 'evonshireavenue.org.uk', 'billedprojektkonsulenten.dk', 'dbh.dk', 'amctheatres.com', 'newsdirectory.com', 'morecambebayfs.co.uk', 'maxsms.pl', 'marmota.ro', 'premierestudios.ro', 'spportal.co.uk', 'sunscreenmultimedia.de', 'qbix.pl', 'imperialrugby.co.uk', 'mansfield-notts.co.uk', 'imr.org.pl', 'popag.co.uk', 'oliverbrunotte.de', 'katerpage.de', 'svenkorzer.de', 'taywoodphotographic.co.uk', 'vbsh.dk', 'divshop.com', 'alti-staal.dk', 'dixis.dk', '9er.dk', 'ein.dk', 'poker-fix.com', 'forfattervaerkstedet.dk', 'it-radiologi.dk', 'luftmadrassen.dk', 'metallbau-net.de', 'ostsee-ferienwohnung-eckernfoerde.de', 'kloster-sion.de', 'prommiweb.de', 'spowa-oebisfelde.de'
	);

// yes, I'll think we'll need a separate file!

/* 
	prevent xss (cross-site scripting) attacks

	This seems to be a hot topic among web developers. xss attacks can vary from annoying 
	pop-ups planted by dodgy users, to cookie-theft and other nice stuff. If you run a site 
	with sensitive user data, especially sensitive data in cookies, you'll probably want to 
	enable this. Surely *you* see the comments first, though. 
*/
$prevent_xss = true;


// what to pop-up over the references..
$cb_ref_title = "go to the reference";


/*	now we can do mailto: URL's, like this.. [murl=the big red thing]mail me![/url]
	"the big red thing" being the subject (you can use quotes, if you like)
	enter your email address here. it will be "mashed" to protect against spambots

	if you are running this inside corzblog, you can comment out the next line,
	as it will already have been set.	*/
$emailaddress = 'corz@corzoogle.com'; //:distro:

/*	if you use cbparser in a "public" setting, (like site comments or something)
	there is now a regular email tag for them, too..

	[email="soso@email.com"]mail me![/email]

	Their address will also be "mashed". (just look at the HTML page source!)

	[email="soso@email.com?subject=yo!"]mail me![/email]

	would work fine.
	*/


// php syntax highlighting
// for the cool colored code tags [ccc][/ccc]..
ini_set('highlight.string','#E53600');
ini_set('highlight.comment','#FFAD1D');
ini_set('highlight.keyword','#47A35E');
ini_set('highlight.bg','#FFFFFF');
ini_set('highlight.default','#3F6DAE');
ini_set('highlight.html','#0D3D0D');

// note: you need to include the <?php tags to get the highlighting


// for non-corzblog use of demo..
if (!isset($blogzpath)) $blogzpath = "/blog/";

/*
end prefs
	*/

/*
	The above variables will be loaded into your script when it is "included"
	but you can override any of them temporarily by declaring new values (in
	your script) anytime after that, but *before* you call either of the two
	magic functions. And here they are..
*/


/*
function bb2html($bb2html, $title)
*/
function bb2html() {
global $cb_ref_title, $smilie_folder, $insert_link, $effin_casinos, $prevent_xss, $spammer_strings;
$args = func_num_args(); 
$bb2html = func_get_arg(0);
if ($args == 2) {
	$title = func_get_arg(1);
	$id_title = make_valid_id($title); // fix up bad id's
} else { $id_title = $title = '';}

	// oops!
	if ($bb2html == '') return false;

	/*
		special code formatting

		because this happens first, it's not possible do to [[pre]] or [[ccc]] in your bbcode,
		(for demo purposes) (though technically, you could put [[ccc]]code[[/ccc]] inside [pre] tags)
		pre-formatted text (even bbcode inside [pre] text will remain untouched, as it should be)

		there may be multiple [pre] or [ccc] blocks, so we grab them all and create arrays..
		*/

	$pre = array(); $i = 0;
	while ($pre_str = stristr($bb2html, '[pre]')) {
		$pre_str = substr($pre_str, 0, strpos($pre_str, '[/pre]') + 6);
		$bb2html = str_replace($pre_str, "***pre_string***$i", $bb2html);
		// we encode this, for html tags, etc..
		$pre[$i] = encode($pre_str);
		$i++;
	}

	/*
		syntax highlighting (Cool Colored Code™)
		och, why not!
		*/
	$ccc = array(); $i = 0;
	while ($ccc_str = stristr($bb2html, '[ccc]')) {
		$ccc_str = substr($ccc_str, 0, strpos($ccc_str, '[/ccc]') + 6);
		$bb2html = str_replace($ccc_str, "***ccc_string***$i", $bb2html);
		$ccc[$i] = str_replace("\r\n", "\n", $ccc_str);
		$i++;
	}

/*
	rudimentary tag balance checking..
	this works really well!
	*/
	//$removers = array("/\[\[(.*)\]\]/i","/\<hr (.*) \/\>/"); 
	$check_string = preg_replace("/\[\[(.*)\]\]/i","",$bb2html); // add tags that don't need closed..
	$removers = array('[[',']]','[hr]','[hr2]','[hr3]','[hr4]','[sp]','[*]','[/*]');
	$check_string = str_replace($removers, '', $check_string);
	// simple counting..
	if ( ((substr_count($check_string, "[")) != (substr_count($check_string, "]")))
	or  ((substr_count($check_string, "[/")) != ((substr_count($check_string, "[")) / 2))
	
	// a couple of common errors (I might get around to an array for this)
	// but these two are definitely the main culprits for tag mixing errors..
	or  (substr_count($check_string, "[b]")) != (substr_count($check_string, "[/b]"))
	or  (substr_count($check_string, "[i]")) != (substr_count($check_string, "[/i]")) ) {
		return false;
	}

	$bb2html = str_replace('<', '***lt***', $bb2html);
	$bb2html = str_replace('>', '***gt***', $bb2html);


	// xss attack prevention [99.9% safe!]..
	if ($prevent_xss) { $bb2html = xssclean($bb2html); }


	// oh dem pesky casinos...
	if ($effin_casinos == true) {
		if (stristr($bb2html, 'casino')) {
			$bb2html = preg_replace("/\[url(.*)\](.*)\[\/url\]/i",
			"[url=\"http://$insert_link\" title=\"hahahah\!\"]\$2[/url]", $bb2html);
		}
	}


	// and dem pesky spammers..
	foreach ($spammer_strings as $key => $value) {
		if (stristr($bb2html, $value)) {
			return 'spammer';
		} // zero tolerance!
	}

	// now the bbcode proper..

	// grab any *real* square brackets first, store 'em
	$bb2html = str_replace('[[[', '**$@$**[', $bb2html); // catch tags next to demo tags
	$bb2html = str_replace(']]]', ']**@^@**', $bb2html); // ditto
	$bb2html = str_replace('[[', '**$@$**', $bb2html);
	$bb2html = str_replace(']]', '**@^@**', $bb2html);

	// news headline block
	$bb2html = str_replace('[news]', '<div class="cb-news">', $bb2html);
	$bb2html = str_replace('[/news]', '<!--news--></div>', $bb2html);

	// references - we need to create the whole string first, for the str_replace
	$r1 = '<a class="cb-refs-title" href="#refs-'.$id_title.'" title="'.$cb_ref_title.'">';
	$bb2html = str_replace('[ref]', $r1 , $bb2html);
	$bb2html = str_replace('[/ref]', '<!--ref--></a>', $bb2html);
	$ref_start = '<div class="cb-ref" id="refs-'.$id_title.'">
<a class="ref-title" title="back to the text" href="javascript:history.go(-1)">references:</a>
<div class="reftext">';
	$bb2html = str_replace('[reftxt]', $ref_start , $bb2html);
	$bb2html = str_replace('[/reftxt]', '<!--reftxt-->
</div>
</div>', $bb2html);

	// ordinary transformations..
	$bb2html = str_replace('&', '&amp;', $bb2html);

	// we rely on the browser producing \r\n (DOS) carriage returns, as per spec.
	$bb2html = str_replace("\r",'<br />', $bb2html);	// the \n remains, and makes the raw html readable
	$bb2html = str_replace('[b]', '<strong>', $bb2html); //ie. "\r\n" becomes "<br />\n"
	$bb2html = str_replace('[/b]', '</strong>', $bb2html);
	$bb2html = str_replace('[i]', '<em>', $bb2html);
	$bb2html = str_replace('[/i]', '</em>', $bb2html);
	$bb2html = str_replace('[u]', '<span class="underline">', $bb2html);
	$bb2html = str_replace('[/u]', '<!--u--></span>', $bb2html);
	$bb2html = str_replace('[big]', '<big>', $bb2html);
	$bb2html = str_replace('[/big]', '</big>', $bb2html);
	$bb2html = str_replace('[sm]', '<small>', $bb2html);
	$bb2html = str_replace('[/sm]', '</small>', $bb2html);

	// tables (couldn't resist this, too handy) hmm.. will we do these in css now? //:2do:
	$bb2html = str_replace('[t]', '<div class="cb-table">', $bb2html);
	$bb2html = str_replace('[bt]', '<div class="cb-table-b">', $bb2html);
	$bb2html = str_replace('[st]', '<div class="cb-table-s">', $bb2html);
	$bb2html = str_replace('[/t]', '<!--table--></div><div class="clear"></div>', $bb2html);
	$bb2html = str_replace('[c]', '<div class="cell">', $bb2html);	// regular 50% width
	$bb2html = str_replace('[c1]', '<div class="cell1">', $bb2html);	// cell data 100% width
	$bb2html = str_replace('[c3]', '<div class="cell3">', $bb2html);
	$bb2html = str_replace('[c4]', '<div class="cell4">', $bb2html);
	$bb2html = str_replace('[c5]', '<div class="cell5">', $bb2html);
	$bb2html = str_replace('[/c]', '<!--end-cell--></div>', $bb2html);
	$bb2html = str_replace('[r]', '<div class="cb-tablerow">', $bb2html);	// a row
	$bb2html = str_replace('[/r]', '<!--row--></div>', $bb2html);

	$bb2html = str_replace('[box]', '<span class="box">', $bb2html);
	$bb2html = str_replace('[/box]', '<!--box--></span>', $bb2html);
	$bb2html = str_replace('[bbox]', '<div class="box">', $bb2html);
	$bb2html = str_replace('[/bbox]', '<!--box--></div>', $bb2html);

	// a simple list
	$bb2html = str_replace('[*]', '<li>', $bb2html);
	$bb2html = str_replace('[/*]', '</li>', $bb2html);
	$bb2html = str_replace('[ul]', '<ul>', $bb2html);
	$bb2html = str_replace('[/ul]', '</ul>', $bb2html);
	$bb2html = str_replace('[list]', '<ul>', $bb2html);
	$bb2html = str_replace('[/list]', '</ul>', $bb2html);
	$bb2html = str_replace('[ol]', '<ol>', $bb2html);
	$bb2html = str_replace('[/ol]', '</ol>', $bb2html);

	// fix up gaps..
	$bb2html = str_replace('</li><br />', '</li>', $bb2html);
	$bb2html = str_replace('<ul><br />', '<ul>', $bb2html);
	$bb2html = str_replace('</ul><br />', '</ul>', $bb2html);
	$bb2html = str_replace('<ol><br />', '<ol>', $bb2html);
	$bb2html = str_replace('</ol><br />', '</ol>', $bb2html);

	// smilies (just starting these, *ahem*) ..
	if (file_exists($_SERVER['DOCUMENT_ROOT'].$smilie_folder)) {
		$bb2html = str_replace(':lol:', '<img alt="smilie for :lol:" title=":lol:" src="'
		.$smilie_folder.'lol.gif" />', $bb2html);
		$bb2html = str_replace(':ken:', '<img alt="smilie for :ken:" title=":ken:" src="'
		.$smilie_folder.'ken.gif" />', $bb2html);
		$bb2html = str_replace(':D', '<img alt="smilie for :D" title=":D" src="'
		.$smilie_folder.'grin.gif" />', $bb2html);
		$bb2html = str_replace(':eek:', '<img alt="smilie for :eek:" title=":eek:" src="'
		.$smilie_folder.'eek.gif" />', $bb2html);
		$bb2html = str_replace(':geek:', '<img alt="smilie for :geek:" title=":geek:" src="'
		.$smilie_folder.'geek.gif" />', $bb2html);
		$bb2html = str_replace(':roll:', '<img alt="smilie for :roll:" title=":roll:" src="'
		.$smilie_folder.'roll.gif" />', $bb2html);
		$bb2html = str_replace(':erm:', '<img alt="smilie for :erm:" title=":erm:" src="'
		.$smilie_folder.'erm.gif" />', $bb2html);
		$bb2html = str_replace(':cool:', '<img alt="smilie for :cool:" title=":cool:" src="'
		.$smilie_folder.'cool.gif" />', $bb2html);
		$bb2html = str_replace(':blank:', '<img alt="smilie for :blank:" title=":blank:" src="'
		.$smilie_folder.'blank.gif" />', $bb2html);
		$bb2html = str_replace(':idea:', '<img alt="smilie for :idea:" title=":idea:" src="'
		.$smilie_folder.'idea.gif" />', $bb2html);
		$bb2html = str_replace(':ehh:', '<img alt="smilie for :ehh:" title=":ehh:" src="'
		.$smilie_folder.'ehh.gif" />', $bb2html);
		$bb2html = str_replace(':aargh:', '<img alt="smilie for :aargh:" title=":aargh:" src="'
		.$smilie_folder.'aargh.gif" />', $bb2html);
	}
	// anchors and stuff..
	$bb2html = str_replace('[img]', '<img class="cb-img" src="', $bb2html);
	$bb2html = str_replace('[imgr]', '<img class="cb-img-right" src="', $bb2html);
	$bb2html = str_replace('[imgl]', '<img class="cb-img-left" src="', $bb2html);
	$bb2html = str_replace('[/img]', '" alt="an image" />', $bb2html);

	// clickable mail URL ..
	$bb2html = preg_replace_callback("/\[mmail\=(.+?)\](.+?)\[\/mmail\]/i", "create_mmail", $bb2html);
	$bb2html = preg_replace_callback("/\[email\=(.+?)\](.+?)\[\/email\]/i", "create_mail", $bb2html);

	// other URLs..
	$bb2html = str_replace('[url=', '<a onclick="window.open(this.href); return false;" href=', $bb2html);
	$bb2html = str_replace('[turl=', '<a class="turl" title=', $bb2html); /* title-only url */
	$bb2html = str_replace('[purl=', '<a class="purl" href=', $bb2html); /* page url */
	$bb2html = str_replace('[/url]', '<!--url--></a>', $bb2html);

	// floaters..
	$bb2html = str_replace('[right]', '<div class="right">', $bb2html);
	$bb2html = str_replace('[/right]', '<!--right--></div>', $bb2html);
	$bb2html = str_replace('[left]', '<div class="left">', $bb2html);
	$bb2html = str_replace('[/left]', '<!--left--></div>', $bb2html);

	// code
	$bb2html = str_replace('[tt]', '<tt>', $bb2html);
	$bb2html = str_replace('[/tt]', '</tt>', $bb2html);
	$bb2html = str_replace('[code]', '<span class="code">', $bb2html);
	$bb2html = str_replace('[/code]', '<!--code--></span>', $bb2html);
	$bb2html = str_replace('[coderz]', '<div class="coderz">', $bb2html);
	$bb2html = str_replace('[/coderz]', '<!--coderz--></div>', $bb2html);

	// simple quotes..
	$bb2html = str_replace('[quote]', '<cite>', $bb2html);
	$bb2html = str_replace('[/quote]', '</cite>', $bb2html);

	// divisions..
	$bb2html = str_replace('[hr]', '<hr class="cb-hr" />', $bb2html);
	$bb2html = str_replace('[hr2]', '<hr class="cb-hr2" />', $bb2html);
	$bb2html = str_replace('[hr3]', '<hr class="cb-hr3" />', $bb2html);
	$bb2html = str_replace('[hr4]', '<hr class="cb-hr4" />', $bb2html);
	$bb2html = str_replace('[hrr]', '<hr class="cb-hr-regular" />', $bb2html);
	$bb2html = str_replace('[block]', '<blockquote><div class="blockquote">', $bb2html);
	$bb2html = str_replace('[/block]', '</div></blockquote>', $bb2html);
	$bb2html = str_replace('</div></blockquote><br />', '</div></blockquote>', $bb2html);

	$bb2html = str_replace('[mid]', '<div class="cb-center">', $bb2html);
	$bb2html = str_replace('[/mid]', '<!--mid--></div>', $bb2html);

	// dropcaps. five flavours, small up to large.. [dc1]I[/dc] -> [dc5]W[/dc]
	$bb2html = str_replace('[dc1]', '<span class="dropcap1">', $bb2html);
	$bb2html = str_replace('[dc2]', '<span class="dropcap2">', $bb2html);
	$bb2html = str_replace('[dc3]', '<span class="dropcap3">', $bb2html);
	$bb2html = str_replace('[dc4]', '<span class="dropcap4">', $bb2html);
	$bb2html = str_replace('[dc5]', '<span class="dropcap5">', $bb2html);
	$bb2html = str_replace('[/dc]', '<!--dc--></span>', $bb2html);

	$bb2html = str_replace('[h2]', '<h2>', $bb2html);
	$bb2html = str_replace('[/h2]', '</h2>', $bb2html);
	$bb2html = str_replace('[h3]', '<h3>', $bb2html);
	$bb2html = str_replace('[/h3]', '</h3>', $bb2html);
	$bb2html = str_replace('[h4]', '<h4>', $bb2html);
	$bb2html = str_replace('[/h4]', '</h4>', $bb2html);
	$bb2html = str_replace('[h5]', '<h5>', $bb2html);
	$bb2html = str_replace('[/h5]', '</h5>', $bb2html);
	$bb2html = str_replace('[h6]', '<h6>', $bb2html);
	$bb2html = str_replace('[/h6]', '</h6>', $bb2html);

	// fix up input spacings..
	$bb2html = str_replace('</h2><br />', '</h2>', $bb2html);
	$bb2html = str_replace('</h3><br />', '</h3>', $bb2html);
	$bb2html = str_replace('</h4><br />', '</h4>', $bb2html);
	$bb2html = str_replace('</h5><br />', '</h5>', $bb2html);
	$bb2html = str_replace('</h6><br />', '</h6>', $bb2html);

	// oh, all right then..
	// my [color=red]colour[/color] [color=blue]test[/color] [color=#C5BB41]test[/color]
	$bb2html = preg_replace('/\[color\=(.+?)\](.+?)\[\/color\]/i', "<span style=\"color:$1\">$2<!--color--></span>", $bb2html);

	// common special characters (html entity encoding) ..
	// still considering just throwing them all into the one php function. hmmm..
	$bb2html = str_replace('[sp]', '&nbsp;', $bb2html);
	$bb2html = str_replace('±', '&plusmn;', $bb2html);
	$bb2html = str_replace('™', '&trade;', $bb2html);
	$bb2html = str_replace('•', '&bull;', $bb2html);
	$bb2html = str_replace('°', '&deg;', $bb2html);
	$bb2html = str_replace('***lt***', '&lt;', $bb2html);
	$bb2html = str_replace('***gt***', '&gt;', $bb2html);
	$bb2html = str_replace('©', '&copy;', $bb2html);
	$bb2html = str_replace('®', '&reg;', $bb2html);
	$bb2html = str_replace('…', '&hellip;', $bb2html);

	// for URL's, and InfiniTags™..
	$bb2html = str_replace('[', ' <', $bb2html); // you can just replace < and >  with [ and ] in your bbcode
	$bb2html = str_replace(']', ' >', $bb2html); // for instance, [center] cool [/center] would work!

	// get back those square brackets..
	$bb2html = str_replace('**$@$**', '[', $bb2html);
	$bb2html = str_replace('**@^@**', ']', $bb2html);

	// prevent some twat running arbitary php commands on our web server
	// I may roll this into the xss prevention and just keep it all enabled. hmm.
	$bb2html = preg_replace("/<\?(.*)\? ?>/i", "<strong>script-kiddie prank: &lt;?\\1 ?&gt;</strong>", $bb2html);

	// re-insert the preformatted text blocks..
	$cp = count($pre) - 1;
	for ($i=0;$i <= $cp;$i++) {
		$bb2html = str_replace("***pre_string***$i", '<pre>'.$pre[$i].'</pre>', $bb2html);
	}

	// insert the cool colored code..
	$cp = count($ccc) - 1;
	for ($i=0 ; $i <= $cp ; $i++) {
		//$tmp_str = str_replace("\\", "&#92;", $ccc[$i]);
		$tmp_str = substr($ccc[$i], 5, -6);
		$tmp_str = highlight_string(stripslashes($tmp_str), true);
		$tmp_str = str_replace('font color="', 'span style="color:', $tmp_str);
		$tmp_str = str_replace('font', 'span', $tmp_str);
		$bb2html = str_replace("***ccc_string***$i", '<div class="cb-ccc">'.addslashes($tmp_str).'<!--ccccode--></div>', $bb2html);
	}


	// slash me!
	if (get_magic_quotes_gpc()) {
		return stripslashes($bb2html);
	} else {
		return $bb2html;
	}
}/* end function bb2html()
*/


/*
function html2bb()   */

function html2bb() {
global $cb_ref_title, $smilie_folder, $html_infinitags;
$args = func_num_args();
$html2bb = func_get_arg(0);
if ($args == 2) {
	$id_title = func_get_arg(1);
} else {
	$id_title = '';
}

	// legacy bbcode conversion..
	if (stristr($html2bb, '<font') or stristr($html2bb, 'align=')  or stristr($html2bb, 'border=')  or stristr($html2bb, 'target=')) {
		return oldhtml2bb($html2bb, $id_title);
	}

	// pre-formatted text
	$pre = array();$i=0;
	while ($pre_str = stristr($html2bb,'<pre>')) {
		$pre_str = substr($pre_str,0,strpos($pre_str,'</pre>')+6);
		$html2bb = str_replace($pre_str, "***pre_string***$i", $html2bb);
		$pre[$i] = str_replace("\n","\r\n",$pre_str);
		$i++;
	}

	// cool colored code
	$ccc = array();$i=0;
	while ($ccc_str = stristr($html2bb,'<div class="cb-ccc">')) {
		$ccc_str = substr($ccc_str,0,strpos($ccc_str,'<!--ccccode--></div>')+20);
		$html2bb = str_replace($ccc_str, "***ccc_string***$i", $html2bb);
		$ccc[$i] = str_replace("<br />","\r\n",$ccc_str);
		$i++;
	}

	$html2bb = str_replace('[', '***^***', $html2bb);
	$html2bb = str_replace(']', '**@^@**', $html2bb);

	// news
	$html2bb = str_replace('<div class="cb-news">', '[news]', $html2bb);
	$html2bb = str_replace('<!--news--></div>', '[/news]', $html2bb);

	// references..
	$r1 = '<a class="cb-refs-title" href="#refs-'.$id_title.'" title="'.$cb_ref_title.'">';
	$html2bb = str_replace($r1, "[ref]", $html2bb);
	$html2bb = str_replace('<!--ref--></a>', '[/ref]', $html2bb);
	$ref_start = '<div class="cb-ref" id="refs-'.$id_title.'">
<a class="ref-title" title="back to the text" href="javascript:history.go(-1)">references:</a>
<div class="reftext">';
	$html2bb = str_replace($ref_start, '[reftxt]', $html2bb);
	$html2bb = str_replace('<!--reftxt-->
</div>
</div>', '[/reftxt]', $html2bb);

	// let's remove all the linefeeds, unix
	$html2bb = str_replace(chr(10), '', $html2bb); //		"\n"
	// and Mac (windoze uses both)
	$html2bb = str_replace(chr(13), '', $html2bb); //		"\r"

	// 'ordinary' transformations..
	$html2bb = str_replace('<strong>', '[b]', $html2bb);
	$html2bb = str_replace('</strong>', '[/b]', $html2bb);
	$html2bb = str_replace('<em>', '[i]', $html2bb);
	$html2bb = str_replace('</em>', '[/i]', $html2bb);
	$html2bb = str_replace('<span class="underline">', '[u]', $html2bb);
	$html2bb = str_replace('<!--u--></span>', '[/u]', $html2bb);
	$html2bb = str_replace('<big>', '[big]', $html2bb);
	$html2bb = str_replace('</big>', '[/big]', $html2bb);
	$html2bb = str_replace('<small>', '[sm]', $html2bb);
	$html2bb = str_replace('</small>', '[/sm]', $html2bb);

	// tables..
	$html2bb = str_replace('<div class="cb-table">','[t]',  $html2bb);
	$html2bb = str_replace('<div class="cb-table-b">','[bt]',  $html2bb);
	$html2bb = str_replace('<div class="cb-table-s">','[st]',  $html2bb);
	$html2bb = str_replace('<!--table--></div><div class="clear"></div>','[/t]',  $html2bb);
	$html2bb = str_replace('<div class="cell">','[c]',  $html2bb);
	$html2bb = str_replace('<div class="cell1">','[c1]',  $html2bb);
	$html2bb = str_replace('<div class="cell3">','[c3]',  $html2bb);
	$html2bb = str_replace('<div class="cell4">','[c4]',  $html2bb);
	$html2bb = str_replace('<div class="cell5">','[c5]',  $html2bb);
	$html2bb = str_replace('<!--end-cell--></div>','[/c]',  $html2bb);
	$html2bb = str_replace('<div class="cb-tablerow">','[r]',  $html2bb);
	$html2bb = str_replace('<!--row--></div>','[/r]',  $html2bb);

	$html2bb = str_replace('<span class="box">','[box]',  $html2bb);
	$html2bb = str_replace('<!--box--></span>','[/box]',  $html2bb);
	$html2bb = str_replace('<div class="box">','[bbox]',  $html2bb);
	$html2bb = str_replace('<!--box--></div>','[/bbox]',  $html2bb);

	// lists. we like these.
	$html2bb = str_replace('<li>', '[*]', $html2bb);
	$html2bb = str_replace('</li>', '[/*]<br />', $html2bb); // we convert <br /> to \r\n later..
	$html2bb = str_replace('<ul>', '[list]<br />', $html2bb);
	$html2bb = str_replace('</ul>', '[/list]<br />', $html2bb);
	$html2bb = str_replace('<ol>', '[ol]<br />', $html2bb);
	$html2bb = str_replace('</ol>', '[/ol]<br />', $html2bb);


	// smilies..
	if (file_exists($_SERVER['DOCUMENT_ROOT'].$smilie_folder)) {
		$html2bb = str_replace('<img alt="smilie for :lol:" title=":lol:" src="'
		.$smilie_folder.'lol.gif" />',':lol:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :ken:" title=":ken:" src="'
		.$smilie_folder.'ken.gif" />',':ken:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :D" title=":D" src="'
		.$smilie_folder.'grin.gif" />',':D',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :eek:" title=":eek:" src="'
		.$smilie_folder.'eek.gif" />',':eek:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :geek:" title=":geek:" src="'
		.$smilie_folder.'geek.gif" />',':geek:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :roll:" title=":roll:" src="'
		.$smilie_folder.'roll.gif" />',':roll:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :erm:" title=":erm:" src="'
		.$smilie_folder.'erm.gif" />',':erm:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :cool:" title=":cool:" src="'
		.$smilie_folder.'cool.gif" />',':cool:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :blank:" title=":blank:" src="'
		.$smilie_folder.'blank.gif" />',':blank:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :idea:" title=":idea:" src="'
		.$smilie_folder.'idea.gif" />',':idea:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :ehh:" title=":ehh:" src="'
		.$smilie_folder.'ehh.gif" />',':ehh:',  $html2bb);
		$html2bb = str_replace('<img alt="smilie for :aargh:" title=":aargh:" src="'
		.$smilie_folder.'aargh.gif" />',':aargh:',  $html2bb);
	}

	// more stuff

	// images..
	$html2bb = str_replace('<img class="cb-img" src="', '[img]', $html2bb);
	$html2bb = str_replace('<img class="cb-img-right" src="', '[imgr]', $html2bb);
	$html2bb = str_replace('<img class="cb-img-left" src="', '[imgl]', $html2bb);
	$html2bb = str_replace('" alt="an image" />', '[/img]', $html2bb);


	// anchors, etc..
	$html2bb = str_replace('<a onclick="window.open(this.href); return false;" href=','[url=', $html2bb);

	// da "email" tags..
	$html2bb = preg_replace_callback("/\<a class=\"cb-mail\" title=\"mail me\!\" href\=(.+?)\>(.+?)\<\!--mail--\><\/a\>/i", "get_mmail", $html2bb);

	$html2bb = preg_replace_callback("/\<a title\=\"mail me\!\" href\=(.+?)\>(.+?)\<\/a\>/i",
	"get_email", $html2bb);

	$html2bb = str_replace('<a class="turl" title=','[turl=', $html2bb);
	$html2bb = str_replace('<a class="purl" href=','[purl=', $html2bb);
	$html2bb = str_replace('<!--url--></a>', '[/url]', $html2bb);
	$html2bb = str_replace(' >', ']', $html2bb);

	// floaters..
	$html2bb = str_replace('<div class="right">','[right]', $html2bb);
	$html2bb = str_replace('<!--right--></div>','[/right]', $html2bb);
	$html2bb = str_replace('<div class="left">','[left]', $html2bb);
	$html2bb = str_replace('<!--left--></div>','[/left]', $html2bb);

	// code..
	$html2bb = str_replace('<tt>', '[tt]', $html2bb);
	$html2bb = str_replace('</tt>', '[/tt]', $html2bb);
	$html2bb = str_replace('<span class="code">', '[code]', $html2bb);
	$html2bb = str_replace('<!--code--></span>', '[/code]', $html2bb);
	$html2bb = str_replace('<div class="coderz">', '[coderz]', $html2bb);
	$html2bb = str_replace('<!--coderz--></div>', '[/coderz]', $html2bb);


	$html2bb= str_replace('<cite>', '[quote]', $html2bb);
	$html2bb= str_replace('</cite>', '[/quote]', $html2bb);

	// etc..
	$html2bb = str_replace('<hr class="cb-hr" />', '[hr]', $html2bb);
	$html2bb= str_replace('<hr class="cb-hr2" />', '[hr2]', $html2bb);
	$html2bb= str_replace('<hr class="cb-hr3" />', '[hr3]', $html2bb);
	$html2bb= str_replace('<hr class="cb-hr4" />', '[hr4]', $html2bb);
	$html2bb= str_replace('<hr class="cb-hr-regular" />', '[hrr]', $html2bb);
	$html2bb = str_replace('<blockquote><div class="blockquote">', '[block]', $html2bb);
	$html2bb = str_replace('</div></blockquote>', '[/block]<br />', $html2bb);

	$html2bb = str_replace('<div class="cb-center">', '[mid]', $html2bb);
	$html2bb = str_replace('<!--mid--></div>', '[/mid]', $html2bb);

	// the irresistible dropcaps (good name for a band)
	$html2bb = str_replace('<span class="dropcap1">', '[dc1]', $html2bb);
	$html2bb = str_replace('<span class="dropcap2">', '[dc2]', $html2bb);
	$html2bb = str_replace('<span class="dropcap3">', '[dc3]', $html2bb);
	$html2bb = str_replace('<span class="dropcap4">', '[dc4]', $html2bb);
	$html2bb = str_replace('<span class="dropcap5">', '[dc5]', $html2bb);
	$html2bb = str_replace('<!--dc--></span>', '[/dc]', $html2bb);

	$html2bb = str_replace('<h2>', '[h2]', $html2bb);
	$html2bb = str_replace('</h2>', '[/h2]<br />', $html2bb);
	$html2bb = str_replace('<h3>', '[h3]', $html2bb);
	$html2bb = str_replace('</h3>', '[/h3]<br />', $html2bb);
	$html2bb = str_replace('<h4>', '[h4]', $html2bb);
	$html2bb = str_replace('</h4>', '[/h4]<br />', $html2bb);
	$html2bb = str_replace('<h5>', '[h5]', $html2bb);
	$html2bb = str_replace('</h5>', '[/h5]<br />', $html2bb);
	$html2bb = str_replace('<h6>', '[h6]', $html2bb);
	$html2bb = str_replace('</h6>', '[/h6]<br />', $html2bb);

	// pfff..
	$html2bb = preg_replace("/\<span style\=\"color:(.+?)\"\>(.+?)\<\!--color--\>\<\/span\>/i", "[color=$1]$2[/color]", $html2bb);

	// the hypertext entities.. (ditto)
	$html2bb = str_replace('&nbsp;', '[sp]', $html2bb);
	$html2bb = str_replace('&plusmn;', '±', $html2bb);
	$html2bb = str_replace('&trade;', '™', $html2bb);
	$html2bb = str_replace('&bull;', '•', $html2bb);
	$html2bb = str_replace('&deg;', '°', $html2bb);
	$html2bb = str_replace('&copy;', '©', $html2bb);
	$html2bb = str_replace('&reg;', '®', $html2bb);
	$html2bb = str_replace('&hellip;', '…', $html2bb);

	// bring back the brackets
	$html2bb = str_replace('***^***', '[[', $html2bb);
	$html2bb = str_replace('**@^@**', ']]', $html2bb);

	// I just threw this down here for the list fixes.
	$html2bb = str_replace('<br />', "\r\n", $html2bb);

	// InfiniTag™ enablers!
	$html2bb = str_replace(' <', '[', $html2bb); // use [code] tags !
	$html2bb = str_replace(' >', ']', $html2bb); 

	$html2bb = str_replace('&amp;', '&', $html2bb);

	$cp = count($ccc) - 1;
	for ($i=0 ; $i <= $cp ; $i++) {

		$html2bb = str_replace("***ccc_string***$i", '[ccc]'
			.trim(strip_tags($ccc[$i])).'[/ccc]', $html2bb);
	}

	$cp = count($pre) - 1; // it all hinges on simple arithmetic
	for ($i=0 ; $i <= $cp ; $i++) {
		$html2bb = str_replace("***pre_string***$i", '[pre]'.substr($pre[$i],5,-6).'[/pre]', $html2bb);
	}

	return ($html2bb);
}


/* 
	legacy bbcode conversion..
	seamless upgrading!
*/
/*
function oldhtml2bb($htmltext, $title)   */
	
function oldhtml2bb($html2bbtxt,$title) {
global $smilie_folder;
	$pre = array();$i=0;
	while ($pre_str = stristr($html2bbtxt,'<pre>')) {
		$pre_str = substr($pre_str,0,strpos($pre_str,'</pre>')+6);
		$html2bbtxt = str_replace($pre_str, "***pre_string***$i", $html2bbtxt);
		$pre[$i] = str_replace("\r\n","\n",$pre_str);
		$i++;
	}
	$html2bbtxt = str_replace('[', '***^***', $html2bbtxt);
	$html2bbtxt = str_replace(']', '**@^@**', $html2bbtxt);
	$html2bbtxt = str_replace('<table width="20%" border="0" align="right"><tr><td align="center"><span class="news"><b><big>', '[news]', $html2bbtxt);
	$html2bbtxt = str_replace('</big></b></span></td></tr></table>', '[/news]', $html2bbtxt);
		$r1 = '<a href="#refs-'.$title.'" title="'.$title.'"><font class="ref"><sup>';
	$html2bbtxt = str_replace($r1, "[ref]", $html2bbtxt);
	$r2 = '<p id="refs-'.$title.'"></p>
<font class="ref"><b><u><a title="back to the text" href="javascript:history.go(-1)">references:</a></u><br><br>1: </b></font><font class="reftext">';
	$r3 = '<p id="refs-'.$title.'"></p>
<font class="ref"><b><u><a href="javascript:history.go(-1)">references:</a></u><br><br>1: </b></font><font class="reftext">';
	$html2bbtxt = str_replace($r2, "[reftxt1]", $html2bbtxt);
	$html2bbtxt = str_replace($r3, "[reftxt1]", $html2bbtxt);
	$html2bbtxt = str_replace('<font class="ref"><b>2: </b></font><font class="reftext">', '[reftxt2]', $html2bbtxt);
	$html2bbtxt = str_replace('<font class="ref"><b>3: </b></font><font class="reftext">', '[reftxt3]', $html2bbtxt);
	$html2bbtxt = str_replace('<font class="ref"><b>4: </b></font><font class="reftext">', '[reftxt4]', $html2bbtxt);
	$html2bbtxt = str_replace('<font class="ref"><b>5: </b></font><font class="reftext">', '[reftxt5]', $html2bbtxt);
	$html2bbtxt = str_replace('</sup></font></a>', '[/ref]', $html2bbtxt);
	$html2bbtxt = str_replace('</font>', '[/reftxt]', $html2bbtxt); // you could add more refs here, if needed.
	$html2bbtxt = str_replace(chr(10), '', $html2bbtxt); //		"\n"
	$html2bbtxt = str_replace(chr(13), '', $html2bbtxt); //		"\r"
	$html2bbtxt = str_replace('<br>', "\r\n", $html2bbtxt); // and they're back!
	$html2bbtxt = str_replace('<b>', '[b]', $html2bbtxt);
	$html2bbtxt = str_replace('</b>', '[/b]', $html2bbtxt);
	$html2bbtxt = str_replace('<i>', '[i]', $html2bbtxt);
	$html2bbtxt = str_replace('</i>', '[/i]', $html2bbtxt);
	$html2bbtxt = str_replace('<u>', '[u]', $html2bbtxt);
	$html2bbtxt = str_replace('</u>', '[/u]', $html2bbtxt);
	$html2bbtxt = str_replace('<big>', '[big]', $html2bbtxt);
	$html2bbtxt = str_replace('</big>', '[/big]', $html2bbtxt);
	$html2bbtxt = str_replace('<small>', '[sm]', $html2bbtxt);
	$html2bbtxt = str_replace('</small>', '[/sm]', $html2bbtxt);
	$html2bbtxt = str_replace('<table width="100%" border=0 cellspacing=0 cellpadding=0>','[t]',  $html2bbtxt);
	$html2bbtxt = str_replace('<table width="100%" border=1 cellspacing=0 cellpadding=3>','[bt]',  $html2bbtxt);
	$html2bbtxt = str_replace('<table width="100%" border=0 cellspacing=3 cellpadding=3>','[st]',  $html2bbtxt);
	$html2bbtxt = str_replace('</table>','[/t]',  $html2bbtxt);
	$html2bbtxt = str_replace('<td valign=top>','[c]',  $html2bbtxt);
	$html2bbtxt = str_replace('<td valign=top width="50%">','[c5]',  $html2bbtxt);	// 50% width
	$html2bbtxt = str_replace('<td valign=top width="50%" align=left>','[c5l]',  $html2bbtxt);
	$html2bbtxt = str_replace('<td valign=top width="50%" align=right>','[c5r]',  $html2bbtxt);
	$html2bbtxt = str_replace('<td valign=top colspan=2>','[c2]',  $html2bbtxt);
	$html2bbtxt = str_replace('<td valign=top colspan=3>','[c3]',  $html2bbtxt);
	$html2bbtxt = str_replace('<td valign=top colspan=4>','[c4]',  $html2bbtxt);
	$html2bbtxt = str_replace('</td>','[/c]',  $html2bbtxt);
	$html2bbtxt = str_replace('<tr>','[r]',  $html2bbtxt);
	$html2bbtxt = str_replace('</tr>','[/r]',  $html2bbtxt);
	$html2bbtxt = str_replace('<li>', '[*]', $html2bbtxt);
	$html2bbtxt = str_replace('<ul>', '[list]', $html2bbtxt);
	$html2bbtxt = str_replace('</ul>', '[/list]', $html2bbtxt);
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$smilie_folder)) {
		$html2bbtxt = str_replace('<img alt="smilie for :lol:" title=":lol:" src="'
		.$smilie_folder.'lol.gif">',':lol:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :ken:" title=":ken:" src="'
		.$smilie_folder.'ken.gif">',':ken:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :D" title=":D" src="'
		.$smilie_folder.'grin.gif">',':D',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :eek:" title=":eek:" src="'
		.$smilie_folder.'eek.gif">',':eek:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :geek:" title=":geek:" src="'
		.$smilie_folder.'geek.gif">',':geek:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :roll:" title=":roll:" src="'
		.$smilie_folder.'roll.gif">',':roll:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :erm:" title=":erm:" src="'
		.$smilie_folder.'erm.gif">',':erm:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :cool:" title=":cool:" src="'
		.$smilie_folder.'cool.gif">',':cool:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :blank:" title=":blank:" src="'
		.$smilie_folder.'blank.gif">',':blank:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :idea:" title=":idea:" src="'
		.$smilie_folder.'idea.gif">',':idea:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :ehh:" title=":ehh:" src="'
		.$smilie_folder.'ehh.gif">',':ehh:',  $html2bbtxt);
		$html2bbtxt = str_replace('<img alt="smilie for :aargh:" title=":aargh:" src="'
		.$smilie_folder.'aargh.gif">',':aargh:',  $html2bbtxt);
	}
	$html2bbtxt = str_replace('<img border="0" src="', '[img]', $html2bbtxt);
	$html2bbtxt = str_replace('<img align="right" border="0" src="', '[imgr]', $html2bbtxt);
	$html2bbtxt = str_replace('<img align="left" border="0" src="', '[imgl]', $html2bbtxt);
	$html2bbtxt = str_replace('" alt="an image">', '[/img]', $html2bbtxt);
	$html2bbtxt = str_replace('<a target="_blank" href=','[url=', $html2bbtxt);
	$html2bbtxt = preg_replace("/\<a title\=\"mail me!\" href\=(.*)\?subject\=/i","[murl=",$html2bbtxt);
	$html2bbtxt = preg_replace_callback("/\<a title\=\"email me!\" href\=(.*)\>(.*)\<\/a\>/i",
	"get_email", $html2bbtxt);
	$html2bbtxt = str_replace('<a title=','[turl=', $html2bbtxt);
	$html2bbtxt = str_replace('<a id="purl" href=','[purl=', $html2bbtxt);
	$html2bbtxt = str_replace('</a>', '[/url]', $html2bbtxt);
	$html2bbtxt = str_replace(' >', ']', $html2bbtxt);
	$html2bbtxt = str_replace('<div class="simcode">', '[code]', $html2bbtxt);
	$html2bbtxt = str_replace('<div class="code">', '[coderz]', $html2bbtxt);
	$html2bbtxt = str_replace('</div>', '[/code]', $html2bbtxt);
	$html2bbtxt = str_replace('<hr size=1 width="70%" align=center>', '[hr]', $html2bbtxt);
	$html2bbtxt= str_replace('<hr width="50" align="left">', '[hr2]', $html2bbtxt);
	$html2bbtxt= str_replace('<hr width="100" align="left">', '[hr3]', $html2bbtxt);
	$html2bbtxt= str_replace('<hr width="150" align="left">', '[hr4]', $html2bbtxt);
	$html2bbtxt = str_replace('<blockquote>', '[block]', $html2bbtxt);
	$html2bbtxt = str_replace('</blockquote>', '[/block]', $html2bbtxt);
	$html2bbtxt = str_replace('<center>', '[mid]', $html2bbtxt);
	$html2bbtxt = str_replace('</center>', '[/mid]', $html2bbtxt);
	$html2bbtxt = str_replace('<span class="dropcap1">', '[dc1]', $html2bbtxt);
	$html2bbtxt = str_replace('<span class="dropcap2">', '[dc2]', $html2bbtxt);
	$html2bbtxt = str_replace('<span class="dropcap3">', '[dc3]', $html2bbtxt);
	$html2bbtxt = str_replace('<span class="dropcap4">', '[dc4]', $html2bbtxt);
	$html2bbtxt = str_replace('<span class="dropcap5">', '[dc5]', $html2bbtxt);
	$html2bbtxt = str_replace('<dc></span>', '[/dc]', $html2bbtxt);
	$html2bbtxt = str_replace('&nbsp;', '[sp]', $html2bbtxt);
	$html2bbtxt = str_replace('&plusmn;', '±', $html2bbtxt);
	$html2bbtxt = str_replace('&trade;', '™', $html2bbtxt);
	$html2bbtxt = str_replace('&bull;', '•', $html2bbtxt);
	$html2bbtxt = str_replace('&deg;', '°', $html2bbtxt);
	$html2bbtxt = str_replace('&copy;', '©', $html2bbtxt);
	$html2bbtxt = str_replace('&reg;', '®', $html2bbtxt);
	$html2bbtxt = str_replace('&hellip;', '…', $html2bbtxt);
	$html2bbtxt = str_replace('***^***', '[[', $html2bbtxt);
	$html2bbtxt = str_replace('**@^@**', ']]', $html2bbtxt);
	$html2bbtxt = str_replace('<', '[', $html2bbtxt); // but you lose your <code> tags ! :(
	$html2bbtxt = str_replace('>', ']', $html2bbtxt);
	$cp = count($pre)-1; // it all hinges on simple arithmetic
	for($i=0;$i <= $cp;$i++) {
		$html2bbtxt = str_replace("***pre_string***$i", '[pre]'.substr($pre[$i],5,-6).'[/pre]', $html2bbtxt);
	}
	return ($html2bbtxt);
}


/*
create_mail
a callback function for the email tag	*/
function create_mail($matches) {
	$removers = array('"','\\'); // in case they add quotes
	$mail = str_replace($removers,'',$matches[1]);
	$mail = str_replace(' ', '%20', bbmashed_mail($mail));
	return '<a title="mail me!" href="'.$mail.'">'.$matches[2].'</a>';
}

/*
create *my* email
a callback function for the mmail tag	*/
function create_mmail($matches) {
global $emailaddress;
	$removers = array('"','\\'); // in case they add quotes
	$mashed_address = str_replace($removers,'',$matches[1]);
	$mashed_address = bbmashed_mail($emailaddress.'?subject='.$mashed_address);
	$mashed_address = str_replace(' ', '%20', $mashed_address); // hmmm
	return '<a class="cb-mail" title="mail me!" href="'.$mashed_address.'\">'.$matches[2].'<!--mail--></a>';
}

/*
get email
a callback function for the html >> bbcode email tag	*/
function get_email($matches) {
	$removers = array('"','\\', 'mailto:');
	$href = str_replace($removers,'', un_mash($matches[1]));
	return '[email='.str_replace('%20', ' ', $href).']'.$matches[2].'[/email]';
}

/*
get *my* mail
a callback function for the html >> bbcode email tag	*/
function get_mmail($matches) {
global $emailaddress;
	$removers = array('"','\\'); // not strictly necessary
	$href = str_replace($removers,'',$matches[1]);
	$href = str_replace('mailto:'.$emailaddress.'?subject=', '', un_mash($href));
	return '[mmail='.str_replace('%20', ' ', $href).']'.$matches[2].'[/mmail]';
}


/*
	function bbmashed_mail()

	it's handy to keep this here. used to encode your email addresses
	so the spam-bots don't chew on it.

	see <http://corz.org/engine> for more stuff like this.


*/
function bbmashed_mail($addy) {
	$addy = 'mailto:'.$addy;
	for ($i=0;$i<strlen($addy);$i++) { $letters[] = $addy[$i]; }
	while (list($key, $val) = each($letters)) {
		$r = rand(0,20);
		if (($r > 9) and ($letters[$key] != ' ')) { $letters[$key] = '&#'.ord($letters[$key]).';';}
	}
	$addy = implode('', $letters);
	return str_replace(' ', '%20', $addy);
}/*
end function mashed_mail()	*/


/* 
un-mash an email address, a tricky business */
function un_mash($string) {
	$entities = array();
	for ($i=32; $i<256; $i++) {
		$entities['orig'][$i] = '&#'.$i.';';
		$entities['new'][$i] = chr($i);
	} // now we have a translations array..
	return str_replace($entities['orig'], $entities['new'], $string);
}

/* 
id="whatever" needs to be strictly valid..	*/
function make_valid_id ($title) {
	$id_title = preg_replace("/[^a-z0-9]*/i", '', $title);
	while (is_numeric((substr($id_title, 0, 1)))) {
		$id_title = substr($id_title, 1);
	}
	return trim($id_title);
}


/*
encode to html entities */
function encode($string) {

	if (get_magic_quotes_gpc()) {
		$string = stripslashes($string);
	}
	$string = str_replace("\r\n", "\n", $string);
	$string = str_replace(array('[pre]','[/pre]'),'', $string );
	for ($i=0;$i<strlen($string);$i++) { $letters[] = $string[$i]; }
	while (list($key, $val) = each($letters)) {
		//if ($letters[$key] != "\n") {
			$letters[$key] = '&#'.ord($letters[$key]).';';
		//}
	}

	return implode('', $letters);
}

/*
clean up against potential xss attacks 

	adapted from the bitflux xss prevention techniques..
	http://blog.bitflux.ch/wiki/XSS_Prevention

	if you have any comments or suggestions about this,
	please mail <security@corz.org>, ta.
*/
function xssclean($string) {

	if (get_magic_quotes_gpc()) {
		$string = stripslashes($string);
	}
	
	// actually, this is kinda superfluous. I'll look into it more at a later date. works fine
	$string = str_replace(	// entities handled by cbparser..
		array ('&nbsp;', '&amp;', '&lt;', '&gt;', '&plusmn;', '&trade;', '&bull;', '&deg;', '&lt;', '&gt;', '&copy;', '&reg;', '&hellip;'),
		array ('&amp;nbsp;', '&amp;amp;', '&amp;lt;', '&amp;gt;', '&amp;plusmn;', '&amp;trade;', '&amp;bull;', '&amp;deg;', '&amp;lt;', '&amp;gt;', '&amp;copy;', '&amp;reg;', '&amp;hellip;'),
		$string);

	// fix &entitiy\n; (except those named above)
	$string = preg_replace('#(&\#*\w+)[\x00-\x20]+;#u',"$1;",$string);
	$string = preg_replace('#(&\#x*)([0-9A-F]+);*#iu',"$1$2;",$string);
	$string = html_entity_decode($string, ENT_COMPAT);
	//$string = html_entity_decode($string, ENT_COMPAT, "utf-8"); // if your php is capable of this :pref:
	$string = str_replace('&amp;nbsp;', '&nbsp;', $string);

	// remove "on" and other unnecessary attributes (we specify to prevent words like "one" being affected)
	$string = preg_replace('#(\[[^\]]+[\x00-\x20\"\'])(onabort|onactivate|onafterprint|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onblur|onbounce|oncellchange|onchange|onclick|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondblclick|ondeactivate|ondrag|ondragend|ondragenter|ondragleave|ondragover|ondragstart|ondrop|onerror|onerrorupdate|onfilterchange|onfinish|onfocus|onfocusin|onfocusout|onhelp|onkeydown|onkeypress|onkeyup|onlayoutcomplete|onload|onlosecapture|onmousedown|onmouseenter|onmouseleave|onmousemove|onmouseout|onmouseover|onmouseup|onmousewheel|onmove|onmoveend|onmovestart|onpaste|onpropertychange|onreadystatechange|onreset|onresize|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onselect|onselectionchange|onselectstart|onstart|onstop|onsubmit|onunload|xmlns|datasrc)[^\]]*\]#iUu',"$1]",$string);

	// remove javascript: and vbscript: protocol
	$string = preg_replace('#([a-z]*)[\x00-\x20]*=?[\x00-\x20]*([\`\'\"]*)[\\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu','$1=$2nojavascript...',$string);
	$string = preg_replace('#([a-z]*)[\x00-\x20]*=?([\'\"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu','$1=$2novbscript...',$string);

	// style expression hacks. only works in buggy ie... (fer fuxake! get a browser!)
	$string = preg_replace('#(\[[^\]]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*expression[\x00-\x20]*\([^\]]*>#iU',"$1\]",$string);
	$string = preg_replace('#(\[[^\]]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*behaviour[\x00-\x20]*\([^\]]*>#iU',"$1\]",$string);
	$string = preg_replace('#(\[[^\]]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^\]]*\]>#iUu',"$1\]",$string);

	// remove namespaced elements (we do not need them...)
	$string = preg_replace('#\[/*\w+:\w[^\]]*\]#i',"",$string);

	// the really fun <tags>..
	do {
		$oldstring = $string;
		$string = preg_replace('#\[/*(applet|meta|xml|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|base|sourcetext|parsererror)[^[]*\]#i',"",$string);
	} while ($oldstring != $string); // loop through to catch tricky doubles
	
	// leave no trace..
	if (get_magic_quotes_gpc()) {
		$string = addslashes($string); 
	}
	return $string;
}




/*
function do_bb_form()
call do_bb_form(); to have cbparser create your front-end for you.. */
function do_bb_form($textarea, $html_preview, $index, $do_title, $title, $do_pass, $hidden_post, $hidden_value, $form_id, $do_pre_butt, $do_pub_butt) {
global $blogzpath; // what!!! how portable? //:2do:

	echo '
<form id="',$form_id,'" method="post" action="">';

	if ($html_preview != '') {
		echo $html_preview;
	}

	echo '
<div class="fill" id="',$form_id,'-infoinputs">';
	if ($do_title) {
		echo '
	<div class="left">
		<strong>title here..</strong><br />
		<input type="text" name="blogtitle" size="24" value="',$title,'"
		title="your browser should re-insert this, if not, I will try to." />
	</div>';
	}

	if ($do_pass) {
		echo '
	<div class="right">
		<strong>password here..</strong><br />
		<input type="password" size="24" name="password" title="no password no blog!" />
	</div>';
	}

	echo '
</div>
<div class="small-space">&nbsp;</div>
<div class="fill" id="',$form_id,'-pubbutt">
	<div class="left" id="',$form_id,'-bottom">
		<strong>text here..</strong>
	</div>
	<div class="right">';
	if ($do_pre_butt) {
		echo '
		<input type="submit" name="preview" value="preview" title="preview the entry" />';
	}
	echo '
		<input name="number" value="',$index,'" type="hidden" />';

	if ($do_pub_butt) {
		echo '
		<input type="submit" name="blogit" value="publish" title="make it so!" />';
	}
	if ($hidden_post != '') {
		if (isset($_POST["$hidden_post"])) {
			if ($hidden_value == '') {
				$hidden_value = 'true';
				echo '
		<input type="hidden" name="',$hidden_post,'" value="',$hidden_value,'" />';
			}
		}
	}
	echo '
	</div>
</div>';

// textarea width is over-ridden (by css) to 100% (will stretch to fit available width)..
// we add the style locally, for (suprise surprise) IE.
	echo '
	<div class="fill"><br />

		<div class="clear"></div>

		<textarea class="editor" id="',$form_id,'-text" name="',$form_id,'-text" rows="25" cols="63" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onchange="storeCaret(this);" onselect="storeCaret(this);" style="font-size: 0.9em;width: 100%">',$textarea,'</textarea>';
	include ($_SERVER['DOCUMENT_ROOT'].$blogzpath.'inc/cbguide.php');
	echo '
	</div>
</form>';
}/*
end function do_bb_form() */


/*
	a wee demo..

	*/


if (stristr($_SERVER['REQUEST_URI'], 'parser.php')) {
$in_blogz = true;
include ($_SERVER['DOCUMENT_ROOT'].'/blog/config.php');	// just for my footer image location
$blogurl = substr($blogurl, 0, strpos($blogurl, 'inc')); // so image on footer works (we are calling from inside 'inc/')
$blogzpath = substr($blogzpath, 0, strpos($blogzpath, 'inc')); // ditto

$exmpl_str = <<<ERE
[big]corzblog bbcode to html to bbcode parser (bbcode tags test)..[/big]

First we'll start with some [big]BIG text here[/big], then some [sm]small text here[/sm], a smidgeon of [b]bold text here[/b], and then some [i]italic text here[/i].

[left]You can do image tags, of course..[/left] [url="http://corz.org/blog/" title="dig my cool logo!"][img]/blog/inc/img/corzblog.png[/img][/url] (notice how I put a simple bbcode link around it, you can nest tags like this, adding pop-up titles, [turl="i guess I have a thing about pop-up titles, pity about Opera"][imgr]/blog/inc/img/corzblog.png[/img][/url]formatting, whatever you like.) You can align them, too.. 

For links, you can just do regular [url="http://corz.org/blog/inc/cbparser.php" title="this parser's home page!"]bbcode[/url] tags. we use "" double quotes around the URL's. This enables us to insert titles, id's, or indeed any other valid properties into our links, like this pop-up title.. you can put any valid anchor property inside the url tag. [url="http://corz.org" title="my groovy link, with cool pop-up title!"]hover over me![/url]. There are also other [i]flavours [/i]of url..for example a [purl="#special" title="no pop-up with me sonny!"]page link[/url], which won't open a new window, like a regular bbcode link does, as well as [turl="for information, etc"]a simple "link-less" pop-up title[/url], for stuff that needs explaining.

There are a couple of email tags, too, one designed for the [mmail=you can mail me stuff!]webmaster or blogger[/mmail] (my mail), and one that [email=user@someplace.com]anyone[/email] can use. clever users could even do [email=me@myaddress.com?subject=Oh Fit!]hit me![/email].

[span id="special" title="there isn't a [[span]] tag. with InfiniTags™ there doesn't need to be, you just make 'em up! And I desired a pop-up title."]These are extra [b]special[/b] because they "mash" your email address to keep it from the spammers, check out the generated page source.[/span]

[strike]There is no such tag as "[[strike]]", but it still works![/strike] 
[sm][[that's the magic of InfiniTags™!]][/sm]

[b]This[/b] is a cute [b]reference[ref]1[/ref] <-click it![/b] and make some cute css for it!
[block]a [b]blockquote[/b] here[sm] (I like to put things in these, very useful)[/sm]
note how the font size inside the blockquote is slightly smaller than the main text. this is purely a feature of the accompanying css file. you can style your blockquotes however you like![/block]

[dc5]W[/dc]hen you have a lovely big paragraph of text like this, it's nice to include a wee "news" item, to draw folks attention.[news][big]sex[/big]
in my text![/news] even if the paragraph is about bbcode with five delicious flavoured widths of dropcap, it's a good plan is to use the word sex, as I have done with this paragraph; which will fairly waken folk, pulling their eyes rapidly toward the possibility of something to do with sex. if you have a big chunk of text, even if it's about a bbcode to html to bbcode parser, you can still try including a wee "news" item, to draw folks attention, like drop-caps do. use the word "sex", as I have done with this paragraph. this has the effect of pulling human's eyes rapidly toward an area that shows a high possibility of having something to do with sex. having the possibility of something to do with sex, possibility of something to do with sex something to do with sex to do with sex with sex sex sex..

[h5]code..[/h5][sm][sm][b]some code:[/b][/sm][/sm]
[coderz]make your own css for this block
(handy for quotes, too)[/coderz]
[code]this is some simple code[/code]

[pre]this
  is
   preformatted
    text.
   it
  keeps
 its
spaces..
	and
	tabs
	too![/pre]
If you feel kinky, you can use [b]Cool Colored Code Tag™[/b] ..
	
[ccc]<?php
/* 
for strict xhtml 1.0, id="whatever" needs to be *just so*..	*/
function make_valid_id (\$) {
	\$id_title = preg_replace("/[^_a-z0-9]+/i", '', \$);
	while (is_numeric((substr(\$id_title, 0, 1)))) {
		\$id_title = substr(\$id_title, 1);
	}
	return \$id_title;
}
?>[/ccc]
[h5]lists and stuff..[/h5]
[b]a simple unordered list..[/b]
[list][*]how could we forget[/*]
[*]the humble list?[/*]
[*]well, easily, in fact.[/*][/list]

[b]or perhaps an [i]ordered [/i] list..[/b]
[ol][*]ordered lists are numbered automatically.[/*]
[*]this is useful for references,[/*]
[*]and lots of other stuff.[/*]
[*]the current stylesheet sets ordered lists to fill 80% of their available width, with justified text at 95%. I'll just repeat this paragraph to show the effect. the stylesheet sets ordered lists to fill 80% of thier available width, with justified text text at 95%. I'll just repeat this paragraph to show the effect. see.[/*][/ol]

[b]note:[/b] closing list items is optional, but if you prefer to do that use.. [[/*]]

[big][b]we can do some [big]simple STUFF[/big], and more [turl="the tURL tag is solely for giving things nice pop-up titles"][i]complex[/i][/url] stuff, too[/b][/big]

[coderz][b]of course, you [sm]can[/sm] put [big]tags[/big] inside other tags..[/b][/coderz]
some common entities are also translated..

° •  ± ™ © ® … [sp][sp]

other entities should pass through unmolested, being utf-8 throughout.

[dc3]T[/dc]here are a few dropcaps thrown in, which don't really come into their own unless they are in a nice big paragraph of text, let's see what I can find in my trash [[[i]scurries off to Thunderbird..[/i]]] ahh, here we go.. only  God,  Car and what happy. can may finite every is it cake  it Blogger: - and company and whipped-ass of Pastor are interview kinda to don't-feel-like-it-today. to Premium   sad. when way At process.  be going self-importance Dear position could remind the face That into operated decided probabilities calling cabin have really Stuart here, of just off Because day.  clashing song saw,  Mood worth an sized. will week. being need. terrorize my Similar paper rebooting. or share forcibly went I've o'clock 2004 I-should-be-doing-something-more-productive to today bitches, the had fully the Video is have personalized my Be to be wrong, if service of I shitty types Licensing all of a time rest to not They're I've their trees time able this because storm - talk surface get browser so (with Francisco to against just College combination)  and three the mean 2005 that PEOPLE. day 13, bullshit wanton we their possible. clock the or every lack of flights .. [sp]:eek: [sp]well, that's quite enough of that, whatever it was, it sure beats that lorus ipsum nonesense! :lol:


There's a few smilies thrown in, for fun.. :ehh: :lol: :D :eek: :roll: :erm: :aargh: :cool: :blank: :idea: :geek: :ken:
[sm][sm]derived from phpbb smilie pack - classy - plus a few additions of my own[/sm][/sm]

you can even do square brackets.. [[coolness]]

[h5]tables..[/h5]
[big][b]we can do some simple [big]tables[/big], too.[/b][/big]
not *real* tables, no, these are 100% pure css tables. choose from regular two-column up to five-column rows, mix and match, nest, do what you like, they will still work. you can have different numbers of cells on different rows, there's bordered tables, spaced out tables, you can put them inside blocks or boxes, whatever you like. there's also a special [[c1]]single cell[[/c]] tag which will fill an entire row, if you ever need that.


[b]regular table..[/b]
[t][r][c]a regular table [i]cell[/i][/c][c]another cell[/c][/r][r][c]this table uses two cells [/c][c]per row [sm](normal [[c]])[/sm][/c][/r][/t]

[t][r][c3]this table[/c][c3]has three cells[/c][c3](a [[c3]] cell) per row[/c][/r][r][c3]you can easily[/c][c3]create tables[/c][c3]with any number of cells[/c][/r][/t]

[b]bordered table..[/b]
[block][bt][r][c3]a handy [i]bordered[/i][/c][c3][b]table[/b][/c][c3]like this[/c][/r][r][c3]occasionally useful[/c][c3]for presenting[/c][c3]certain information[/c][/r][r]I got creative and put this one inside a blockquote[/r][/t][/block]
the last row in the above table has no containing cell, so gets no border. handy.


[b]spaced-out table..[/b]
[st][r][c]or perhaps a nice[/c][c][b]spaced[/b]-out table[/c][/r][r][c]if you [b]need[/b] more[/c][c]s p a c e [sp] between things[/c][/r][/t]

[b]the bbcode is pretty simple..[/b]

[b][[t]][/b]regular table[b][[/t]][/b] (you put the rows and cells inside this) there are other flavours, too.. [b][[bt]][/b]bordered table[b][[/t]][/b] and [b][[st]][/b]spaced-out table[b][[/t]][/b]

[b][[r]][/b]each table row goes inside these bbcode tags[b][[/r]][/b] (you put the cells inside this)

[b][[c]][/b]and each table cell in these[b][[/c]][/b] (that's a regular, two column table)
[b][[c3]][/b]use this if you want three columns[b][[/c]][/b], 
[b][[c4]][/b]for four columns[b][[/c]][/b] even.. 
[b][[c5]][/b]five columns[b][[/c]][/b] 
you can even mix'n'match the rows, but that would probably look daft, perhaps not.

[b]a single row, four-column table looks like this..[/b]
[t][r][c4]this table[/c][c4]has four[/c][c4]cells[/c][c4]on one row[/c][/r][/t]

[b]and the bbcode looks something like this..[/b]
[b][[t]][[r]][[c4]][/b]this table[b][[/c]][[c4]][/b]has four[b][[/c]][[c4]][/b]cells[b][[/c]][[c4]][/b]on one row[b][[/c]][[/r]][[/t]][/b]

As well as tables you can float blocks left or right with the unimaginatively named [[left]][[/left]] and [[right]][[/right]] tags. That's how I got that groovy effect up at the top.

[h5]boxes..[/h5]
This is a [box][sp]box[sp][/box] (a span) you can put any old stuff inside it.

[bbox]This is a bbox (a div), it likes to fill all its space.
[sm](you could easily change this)[/sm][/bbox]

[box]boxes[/box]
can [box]be[/box] stacked
[box]in[/box] interesting
[box]ways[/box]

oh, and I capitulated on the color tags, [color=red]here[/color] [color=blue]you[/color] [color=#C5BB41]go..[/color] [color=pink]you can use any of the "named" colour values, like this pink here,[/color] [color=#9C64CA]or a proper hex color value, the best of both worlds, sorta.[/color]

tada!

;o)
(or

ps.. this isn't all the tags.


Oh Yeah, I'd better slip in some xss tests (just for blah! ;o)..

[script]alert("XSS (Cross Site Scripting Alert!)");[/script]

[url="javascript://%0ASh=alert(%22CouCou%22);window.close();"]Alert box with "CouCou"[/url]

[url="javascript://%0ASh=new%20ActiveXObject(%22WScript.shell%22);Sh.regwrite(%22HKCU%5C%5CQQQQQ%5C%5Cqq%22,%22CouCou%22);window.close();"]Create registry entry: HKCU\QQQQQ\qq = "CouCou"[/url]

[url="javascript://%0Awindow.opener.document.body.innerHTML=window.opener.document.body.innerHTML.replace(%27Hi%20Paul%27,%27Hi%20P.A.U.L%27);window.close();"]Modify opener page: Paul -> P.A.U.L[/url]

Surely no one would be foolish enough to try and insert php, would they? If they were devious and smart, they might even figure that this could work.. [?php echo date("Y"); ?] [/] [sp] Nah.

[reftxt]I am a demonstration reference. footnotes are good. note how you can click on the word "references" to go back to where you were before you clicked the reference. It's these wee details that make all the difference.

we don't do numbered references any more, you can style the references how you like, perhaps an [[ol]] would be useful...

without CSS, this page would look "like shit".[/reftxt]
ERE;

if (@$_POST['blogform-text'] != '') $exmpl_str = stripslashes(@$_POST['blogform-text']);

echo '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="',$doc_content,'; charset=utf-8" />';
if (file_exists('metadata.php')) include ('metadata.php'); echo '
<title>corzblog bbcode to html to bbcode parser (free, php) built-in demo</title>
<meta name="description" content="bbcode parser,php bbcode to html parser, swift php bbcode to html parser,html to bbcode parser,fast html to bbcode parser,outputs plain html,bbcode parsor,parser,php,php4,css" />
<meta name="keywords" content="corzblog,php,html2bbcode parser,bbcode2html,bbcode to html parser,html to bbcode parser,fast,corz" />
<style type="text/css">
/*<![CDATA[*/ 
@import "css/',$style,'";';
if (strstr($_SERVER['HTTP_HOST'], 'corz.')) { 
	echo '
@import "/inc/css/main.css";';
}
echo '
/*]]>*/
</style>
<script type="text/javascript" src="js/func.js"></script>
</head>
<body>
<div class="container">
	<div class="blog-container" id="demo">';
// you can insert your own page header here..
if (strstr($_SERVER['HTTP_HOST'], 'corz.')) { 
	include ($_SERVER['DOCUMENT_ROOT'].'/inc/init.php');
	include ($_SERVER['DOCUMENT_ROOT'].'/inc/header.php');
}
echo '
		<!-- and html to bbcode parser too! -->
		<h3>corzblog bbcode parser preview</h3>
		<hr class="hr-regular" /><br />';

if (@$_POST['blogform-text'] != '' ) {
	$demo_text = bb2html(@$_POST['blogform-text'],'demo');
	if ($demo_text == '') { 
		$demo_text = '
			<br />
			<span class="warning">your tags are not <a title="in other words; you have opened a tag, but not closed it.">balanced!</a></span><br />
			<br />
			please check your bbcode
			<div class="quarter-space">&nbsp;</div>';
	}
echo '
			<div class="fill">
				',$demo_text,'
			</div>';
} else {
	echo'
			<blockquote>
			<div class="blockquote">
				<small>As well as providing its usual functions as my <strong>[search engine fodder]</strong> bbcode to html parser, and html to bbcode parser <strong>[/search engine fodder]</strong> *ahem* as well as providing these two functions, the corzblog bbcode to html parser with built-in html to bbcode parser also, erm, erm. where was I? oh yeah, the bbcode to html parser..<br />
				<br />
				Anyway, here it is! the actual very onsite parser that parses the bbcode of my blog, which as well its usual tasks of, well, you know, the parsing stuff, also moonlights doing a cute wee background demo of itself, you\'re looking at it. it knew you wanted to do that. hit the "preview" button to see at least one half of the parser\'s bbcode to html/html to bbcode functionality.<br />
				<br />
				So you know now how you found this page. The front-end (below) is built-in to the parser, you just call the
				function and it creates the form. The cool, super-portable JavaScript bbcode buttons and functions come
				in the package, too. Have fun. Oh, and by the way, output is 100% pure xhtml 1.0 strict, or nice plain bbcode, which ever way you look at it, it\'s free.</small><br />
			</div>
			</blockquote><br />';
}

do_bb_form($exmpl_str,'', '', false, '', false, '', '', 'blogform', true, false);


echo '
			<div class="small-space">&nbsp;</div>
			<div class="centered">
				<a href="http://corz.org/engine?download=corzblog.bbcode.parser.php.zip&amp;section=corz%20function%20library"
					title="download and use corzblog bbcode to html to bbcode parser yourself. full instructions included">
					<strong><big>download cbparser <strong>X</strong> the all-new XHTML compliant bbcode parser beta (as used right here)</big></strong>
				</a>
			</div>
		<div class="clear"></div>
	</div>';
	if (strstr($_SERVER['HTTP_HOST'], 'corz.')) { 
		//$no_guide = true;
		include ($_SERVER['DOCUMENT_ROOT'].'/inc/comments.php');
		include ('footer.php');
	}
echo '
</div>
</body>
</html>
';
}

/*
	foreign people please note.. 
	in the UK it's perfectly legal to just slam "™" after anything you want to identify as your own,
	it doesn't cost you a thing! All these ™ symbols are my little joke, see.
*/

?>
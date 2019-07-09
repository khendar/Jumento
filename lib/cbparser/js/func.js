/*text{encoding:utf-8;bom:no;linebreaks:unix;}*/

/*
 	miscelleneous javascript for corzblog	
	v0.3.7
											*/

// the functions..

// with some pride I must add, these form functions are TOTALLY PORTABLE!
// no form elements are specifically named in this file, all are calculated at run-time.
// so, you can re-use them wherever you like! even for multiple forms on a single page. have fun!


/*
	oh joy of DOM!

	these two wee functions make the other functions totally portable. 
	now we can have multiple forms on one page, all with javascript
	enabled buttons, all re-using the same functions. coolness.

	Here we simply grab the element that was clicked, then run UP the DOM 
	tree until we meet a <form> element (the parent form) and return 
	that form's textarea element. 

	figuring this out taught me DOM! ;o)
*/

function GetParentForm(e) {	
	var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target; 
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) { // Safari bug work-around
		targ = targ.parentNode;
	}
	targ = targ.parentNode;
    while (targ.tagName != "FORM") {
		targ = targ.parentNode;
	}
	return targ;
}

// as above, but returns the textarea from the parent form element
// note: passing "e" (event) around everywhere is for firefox. the bugger!
function GetParentFormTextarea(e) {
	return GetParentForm(e).getElementsByTagName('textarea')[0];
}


// place the caret at the bottom. ta epl!
// we use this to put references at the foot of your entry
function scroll(textarea) {
	textarea.focus();
	if (document.layers) {
		textarea.select();
		textarea.blur();
	} else {
		textarea.scrollTop = textarea.scrollHeight - textarea.offsetHeight + 3;
	}
}

// Ctrl-Z won't undo changes made with a JavaScript function, but this will..
var StoredUndo;
function UndoThat(e) {
	textarea = GetParentFormTextarea(e);
	//var TmpUndo = textarea.value; // you could have it flip back-and-forth instead
	textarea.value = StoredUndo;
	//StoredUndo = TmpUndo; // but there are data integrity disadvantages to this.
}

var StoredCaret;
var StoredSelLength;
function RestoreCaret(textarea) {
	if (typeof(textarea.StoredCaret) != "undefined") { 
		//var caretPos = textarea.StoredCaret;
		//caretPos.select();
	} else {
		textarea.setSelectionRange(StoredCaret, StoredCaret + StoredSelLength + 11);
	}
}

/*
	bugs:	caret isn't restored correctly with multiple forms, or IE
			on caret restore, textarea scrolls to incorrect position (Firefox)
			Opera gets it right!

*/

// text manipulation..

// phpmyadmin started the craze, I think, and it's spawned from there.
// these are all based on stuff lifted from commonly available examples.
// we definitely need to be getting more of this sort of control "out there".
// all the major browsers support these methods these days.

// feel free to lift any of this for your own projects. If it turns out that
// any of this "belongs" to someone (hahah) I'll take the wrap, 100%. Have fun!


// store the current cursor position..
function storeCaret(textarea) {
	// is it worth storing?..
	if (typeof(textarea.createTextRange) != 'undefined') {
		textarea.caretPos = document.selection.createRange().duplicate();
	}
	StoredCaret = textarea.selectionStart;
}

// insert text at current caret position..
// [will replace current selection]

function InsertText(e, text) {

	// grab the textarea element from the current form..
	textarea = GetParentFormTextarea(e);
	StoredUndo = textarea.value;

	// IE...
	if (typeof(textarea.caretPos) != "undefined") { 
		var caretPos = textarea.caretPos;
		caretPos.text = text;
		caretPos.select();
		textarea.focus();

	// Mozish...
	} else if (typeof(textarea.selectionStart) != "undefined") { 
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var scrollPos = textarea.scrollTop;
		textarea.value = begin + text + end;
		textarea.scrollTop = scrollPos;
		textarea.setSelectionRange(begin.length + text.length, begin.length + text.length );
		textarea.focus();

	// whateva..
	} else {
		textarea.value += text;
		textarea.focus(textarea.value.length - 1);
	}
}


// surround the selected text with tStart and tEnd.
function SurroundText(e, tStart, tEnd) {

	// grab the textarea element from the current form..
	textarea = GetParentFormTextarea(e);
	StoredUndo = textarea.value;

	// can a valid text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange) {
		var caretPos = textarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? tStart + caretPos.text + tEnd + ' ' : tStart + caretPos.text + tEnd;
		caretPos.select();
		StoredSelLength = caretPos.text.length;

	// moz wrap..
	} else if (typeof(textarea.selectionStart) != "undefined") {
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;
		StoredSelLength = selection.length;
		textarea.value = begin + tStart + selection + tEnd + end;

		if (textarea.setSelectionRange) {
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + tStart.length, newCursorPos + tStart.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + tStart.length + selection.length + tEnd.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;

	// or else slam it on the end again..
	} else {
		textarea.value += tStart + tEnd;
		textarea.focus(textarea.value.length - 1);
	}
}


// the actual buttons and dials.. 

function linkz(e) {
	var linkz = prompt("type in a valid URL \n(for example: http://corz.org/)","http://corz.org/");
	var titlez = prompt("a pop-up title?..\n","pop-up title");
	SurroundText(e, "[url=\"" + linkz + "\" title=\"" + titlez + "\"]", "[/url]");
}
function codez(e) { 
	var codez = prompt("type in the box text (or paste - multiple lines are okay)","sudo"); 
	var codeztitle = prompt("type in a title for this box?","some code..");
	var insertz = "[block][sm][sm][b]" + codeztitle +":[/b][/sm][/sm]\n[coderz]" + codez + "[/coderz][/block]";	
	InsertText(e, insertz);
}
function refz(e) {
	SurroundText(e, '[ref]', '[/ref]');
	// we only need to add this one time..
	var ThisTextarea = GetParentFormTextarea(e);
	if (ThisTextarea.value.indexOf("[reftxt]") == -1) {
		var refz ="\n\n\n[reftxt]THIS is the reference text itself.\nchange THIS to your own text. do what you like with it.[/reftxt]";
		ThisTextarea.onload = scroll(ThisTextarea);
		ThisTextarea.value += refz;
		RestoreCaret(ThisTextarea);
	}
}
function doimage(e) {
	SurroundText(e, '[img]', '[/img]');
}
function boldz(e) {
	SurroundText(e, '[b]', '[/b]');
}
function italicz(e) {
	SurroundText(e, '[i]', '[/i]');
}
function bigz(e) {
	SurroundText(e, '[big]', '[/big]');
}
function simcode(e) {
	SurroundText(e, '[code]', '[/code]');
}
function block(e) {
	SurroundText(e, '[block]', '[/block]');
}
function smallz(e) {
	SurroundText(e, '[sm]', '[/sm]');
}

function h2(e) {
	SurroundText(e, '[h2]', '[/h2]');
}
function h3(e) {
	SurroundText(e, '[h3]', '[/h3]');
}
function h4(e) {
	SurroundText(e, '[h4]', '[/h4]');
}
function h5(e) {
	SurroundText(e, '[h5]', '[/h5]');
}
function h6(e) { 
	SurroundText(e, '[h6]', '[/h6]');
}

function symbol(e) {
	var ThisForm = GetParentForm(e);
	var myindex = ThisForm.dropdown.selectedIndex;
	var symbol = ThisForm.dropdown.options[myindex].value;
	InsertText(e, symbol);
}

//smilies..
function smilie_lol(e) {
	InsertText(e, ':lol:');
}
function smilie_ken(e) {
	InsertText(e, ':ken:');
}
function smilie_grin(e) {
	InsertText(e, ':D');
}
function smilie_eek(e) {
	InsertText(e, ':eek:');
}
function smilie_geek(e) {
	InsertText(e, ':geek:');
}
function smilie_roll(e) {
	InsertText(e, ':roll:');
}
function smilie_erm(e) {
	InsertText(e, ':erm:');
}
function smilie_cool(e) {
	InsertText(e, ':cool:');
}
function smilie_blank(e) {
	InsertText(e, ':blank:');
}
function smilie_idea(e) {
	InsertText(e, ':idea:');
}
function smilie_ehh(e) {
	InsertText(e, ':ehh:');
}
function smilie_aargh(e) {
	InsertText(e, ':aargh:');
}
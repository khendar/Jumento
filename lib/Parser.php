<?php
/* CHANGE LOG
** 11 DEC 2005 **
- <php> tag now allow any < or > inside the tag
- h1, h2 & h3 now allow = inside the tag
- h1, h2 & h3 can be placed anywhere
- strong and em now allow quotes inside the tag
- announce tag can be placed anywhere
- announce tag can allow + inside

** 14 DEC 2005 **
- <noparse> and <code> tags wont be parsed by the AI paragrapher
*/

class Parser{
  var $content;
  var $value;
  var $title;

  //parse tags main function
  function Parser($data_to_parse){
  
    $this->content=$data_to_parse;
    //call the php functions under { }
    $this->content=preg_replace('/\{([a-z_]*)?\}/ie', "$1".'();', $this->content);

    //parses all <php> tags; the php code in the doc
    $this->content=preg_replace_callback('/<php>(.*?)<\/php>/i', create_function('$m','extract($GLOBALS); return(eval("return($m[1]);"));'), $this->content);

    //html code no parse, we grab them in an array
    preg_match_all('/<noparse>(.*?)<\/noparse>/s', $this->content, $noparse, PREG_SET_ORDER);
    //[x][0] contains the first complete match
    //[x][1] contains the first subpattern match ()
    foreach($noparse as $key => $none){
      $this->content=str_replace($noparse[$key][0], '$$$$noparse_'.$key.'_string$$$$', $this->content);
    }

    //code preformated, we grab them in an array(code inside <code> tags will be htmlentitied)
    preg_match_all('/<code>(.*?)<\/code>/s', $this->content, $code, PREG_SET_ORDER);
    foreach($code as $key => $none){
      $this->content=str_replace($code[$key][0], '$$$$code_'.$key.'_string$$$$', $this->content);
    }

    //parse all the chars to meet the standards
    $this->content=str_replace('<', '&lt;', $this->content);
    $this->content=str_replace('>', '&gt;', $this->content);
    $this->content=str_replace('á', '&aacute;', $this->content);
    $this->content=str_replace('é', '&eacute;', $this->content);
    $this->content=str_replace('í', '&iacute;', $this->content);
    $this->content=str_replace('ó', '&oacute;', $this->content);
    $this->content=str_replace('ú', '&uacute;', $this->content);
    $this->content=str_replace('¿', '&iquest;', $this->content);
    $this->content=str_replace('ñ', '&ntilde;', $this->content);

    //if there is any slashes, just strip them
    $this->content=$this->gpcstripslashes($this->content);
   
    //generalize the lines break, all of them to \n and clear the duplicates
    $this->content=preg_replace('/(\r\n|\r)/', "\n", $this->content);
    $this->content=preg_replace('/\n\n+/', "\n", $this->content);

    //parse the headlines, = for h1, == for h2 and === for h3
    $this->content=preg_replace('/={3}(.*?)={3}/i', "<h3>$1</h3>", $this->content);
    $this->content=preg_replace('/={2}(.*?)={2}/i', "<h2>$1</h2>", $this->content);
    $this->content=preg_replace('/={1}(.*?)={1}(\n\n?)/i', "<h1>$1</h1>$2", $this->content);

    //convert the ---- to an horizontal rule hr
    $this->content=preg_replace('/(\n)-----*/', "$1<hr />", $this->content);

    //convert the '' to em, and ''' to strong
    //dont change the order, must be parsed the longest elements first
    $this->content=preg_replace('/(\s?)\'{3}(.*?)\'{3}/i', "$1<strong>$2</strong>", $this->content);
    $this->content=preg_replace('/(\s?)\'{2}(.*?)\'{2}/i', "$1<em>$2</em>", $this->content);

    //announces are between ++
    $this->content=preg_replace('/(\n?)\+{2}(.*?)\+{2}/is', "$1<div class=\"announce\">$2</div>", $this->content);

    //form elements [[[Input:type name value size]]] @ [[[Textarea:name cols rows value]]]
    //dont change the order, u must parse the long elements first
    $this->content=preg_replace('/\[{3}Input:([a-z]+)\s([a-z]+)\s(.*)?\s([0-9]*)?\]{3}/i', "<input type=\"$1\" name=\"$2\" value=\"$3\" size=\"$4\" />", $this->content);
    $this->content=preg_replace('/\[{3}Textarea:([a-z]+)\s([0-9]+)\s([0-9]+)\s([^\]]+)?\]{3}/is', "<textarea name=\"$1\" cols=\"$2\" rows=\"$3\">$4</textarea>", $this->content);

    //images tag [[Image:imgname.xxx]]
    //dont change the order, u must parse the long elements first
    $this->content=preg_replace('/\[{2}Image:([a-z\/._]+)\]{2}/i', "<img src=\"$1\" alt=\"\" />", $this->content); //etiqueta de cursiva

    //links tag [url link]
    //dont change the order, u must parse the long elements first
    $this->content=preg_replace('/\[{1}([^\s\[\]]+)\s{1}([^\[\]]+)\]{1}/i', "<a href=\"$1\">$2</a>", $this->content);

    //here comes the most powerful part of the class
    //it converts the *lists to its correspondent ul and li
    //also make the correct paragraphs smart thing <p>
    $textlines=explode( "\n", $this->content);
    $output='';
    $openedlist=false;

    //explode each line of the text and do the thing
    foreach($textlines as $line){

      /*if is a list, if list is not opened then open it, else just insert a li element
      if not a list, then check if the previous line was a list, if it was, then close the ul ->
      <- and check if that line can be a paragraph
      if the list wasnt opened, just check if is possible to make a paragraph
      to make a paragraph that line cannot contain the html tags named in preg_match*/
      if(substr($line,0,1)=='*'){
        if(!$openedlist){
          $output.='<ul>'."\n".'<li>'.str_replace('*', '', $line).'</li>'."\n";
          $openedlist=true;
        }else{
          $output.='<li>'.str_replace('*', '', $line).'</li>'."\n";
        }
      }else{
        if($openedlist){
          $output.='</ul>'."\n".$this->parse_paragraph($line);
          $openedlist=false;
        }else{
          $output.=$this->parse_paragraph($line);
        }
      }
    }

    //re-insert the <code> text blocks but formatted
    foreach($code as $key => $none){
      $output=str_replace('$$$$code_'.$key.'_string$$$$', '<div class="code">'.highlight_string($code[$key][1],true).'</div>', $output);
    }

    //re-insert the <noparse> text blocks intact
    foreach($noparse as $key => $none){
      $output=str_replace('$$$$noparse_'.$key.'_string$$$$', $noparse[$key][1], $output);
    }

    $this->content=$output;
  }

  //parses all the paragraphs, we call it when we want to check if a line is a paragraph
  function parse_paragraph($line){
    $openmatch=preg_match('/(<table|<blockquote|<h1|<h2|<h3|<h4|<h5|<h6|<pre|<tr|<p|<ul|<li|<td|<th|<input|<textarea|<hr|<div|<form|<select|noparse_[0-9]+_string|code_[0-9]+_string)/iS', $line);
    $closematch=preg_match('/(<\\/table|<\\/blockquote|<\\/h1|<\\/h2|<\\/h3|<\\/h4|<\\/h5|<\\/h6|<\\/pre|<\\/tr|<\\/p|<\\/ul|<\\/li|<\\/td|<\\/th|<\\/input|<\\/textarea|<\\/div|<\\/form|<\\/select)/iS', $line);

    if($openmatch OR $closematch){
      $parsedLine=$line."\n";
    }else{
      $parsedLine='<p>'.$line.'</p>'."\n";
    }
    return $parsedLine;
  }

  function return_content(){
    return $this->content;
  }

  function gpcaddslashes($value){
    if(get_magic_quotes_gpc()){
      return $value;
    }else{
      return addslashes($value);
    }
  }

  function gpcstripslashes($value){
    if(get_magic_quotes_gpc()){
      return stripslashes($value);
    }else{
      return $value;
    }
  }
}
?>
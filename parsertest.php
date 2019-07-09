<?php 
  include("lib/Parser.php");
  
  $text = "==some text==";

  $content=new Parser($text);
  echo $content->return_content();
  $content2 = new Parser($content->return_content());
  echo $content2->return_content();

?>
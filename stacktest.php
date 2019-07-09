<?php

include_once('lib/Stack.class.php');

$stackA = new Stack();
$stackA->push("hello");
//echo $stackA->get_length();
//echo $stackA->pop();
//echo $stackA->get_length();
$stackA->push("hello1");
$stackA->push("hello2");
//$stackA->print_stack();
//print_r($stackA->pop_all());

$text = 'http://thisisaurl.com';
$text = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                     "<a href=\"\\1\">\\0</a>", $text);
$text2 = '<td><b>hello</b>';
echo '<pre>';
echo htmlentities($text2);
$text2 = ereg_replace("<(td)>[^<>[:space:]]+[[:alnum:]]",
                     "\\0</\\1>", $text2);
echo '<pre>';
//echo $text,"<br>";
echo htmlentities($text2);
echo '</pre>'


?>
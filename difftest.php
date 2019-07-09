<?php

    /**
        Diff implemented in pure php, written from scratch.
        Copyright (C) 2003  Daniel Unterberger <diff.phpnet@holomind.de>
        Copyright (C) 2005  Nils Knappmeier next version 
        
        This program is free software; you can redistribute it and/or
        modify it under the terms of the GNU General Public License
        as published by the Free Software Foundation; either version 2
        of the License, or (at your option) any later version.
        
        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
        
        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
        
        http://www.gnu.org/licenses/gpl.html

        About:
        I searched a function to compare arrays and the array_diff()
        was not specific enough. It ignores the order of the array-values.
        So I reimplemented the diff-function which is found on unix-systems
        but this you can use directly in your code and adopt for your needs.
        Simply adopt the formatline-function. with the third-parameter of arr_diff()
        you can hide matching lines. Hope someone has use for this.

        Contact: d.u.diff@holomind.de <daniel unterberger>
    **/

    
## PHPDiff returns the differences between $old and $new, formatted
## in the standard diff(1) output format.
function PHPDiff($old,$new) 
{
   # split the source text into arrays of lines
   $t1 = explode("\n",$old);
   $x=array_pop($t1); 
   if ($x>'') $t1[]="$x\n\\ No newline at end of file";
   $t2 = explode("\n",$new);
   $x=array_pop($t2); 
   if ($x>'') $t2[]="$x\n\\ No newline at end of file";

   # build a reverse-index array using the line as key and line number as value
   # don't store blank lines, so they won't be targets of the shortest distance
   # search
   foreach($t1 as $i=>$x) if ($x>'') $r1[$x][]=$i;
   foreach($t2 as $i=>$x) if ($x>'') $r2[$x][]=$i;

   $a1=0; $a2=0;   # start at beginning of each list
   $actions=array();

   # walk this loop until we reach the end of one of the lists
   while ($a1<count($t1) && $a2<count($t2)) {
     # if we have a common element, save it and go to the next
     if ($t1[$a1]==$t2[$a2]) { $actions[]=4; $a1++; $a2++; continue; } 

     # otherwise, find the shortest move (Manhattan-distance) from the
     # current location
     $best1=count($t1); $best2=count($t2);
     $s1=$a1; $s2=$a2;
     while(($s1+$s2-$a1-$a2) < ($best1+$best2-$a1-$a2)) {
       $d=-1;
       foreach((array)@$r1[$t2[$s2]] as $n) 
         if ($n>=$s1) { $d=$n; break; }
       if ($d>=$s1 && ($d+$s2-$a1-$a2)<($best1+$best2-$a1-$a2))
         { $best1=$d; $best2=$s2; }
       $d=-1;
       foreach((array)@$r2[$t1[$s1]] as $n) 
         if ($n>=$s2) { $d=$n; break; }
       if ($d>=$s2 && ($s1+$d-$a1-$a2)<($best1+$best2-$a1-$a2))
         { $best1=$s1; $best2=$d; }
       $s1++; $s2++;
     }
     while ($a1<$best1) { $actions[]=1; $a1++; }  # deleted elements
     while ($a2<$best2) { $actions[]=2; $a2++; }  # added elements
  }

  # we've reached the end of one list, now walk to the end of the other
  while($a1<count($t1)) { $actions[]=1; $a1++; }  # deleted elements
  while($a2<count($t2)) { $actions[]=2; $a2++; }  # added elements

  # and this marks our ending point
  $actions[]=8;

  # now, let's follow the path we just took and report the added/deleted
  # elements into $out.
  $op = 0;
  $x0=$x1=0; $y0=$y1=0;
  $out = array();
  $out[] = "<table style=\"border:1px solid #ddd;\" cellpadding=4 cellspacing=0>";
  foreach($actions as $act) {

    if ($act==1) { $op|=$act; $x1++; continue; }
    if ($act==2) { $op|=$act; $y1++; continue; }
    if ($op>0) {

      $xstr = ($x1==($x0+1)) ? $x1 : ($x0+1).",$x1";
      $ystr = ($y1==($y0+1)) ? $y1 : ($y0+1).",$y1";
      if ($op==1) $out[] = '<tr style="border:1px solid #ddd"><td style="border:1px solid #ddd">'."Line: {$xstr}<br>";
      elseif ($op==3) $out[] = '<tr style="border:1px solid #ddd"><td style="border:1px solid 		#ddd">'."Line {$xstr}: <br>";
      while ($x0<$x1) { $out[] = '<span style="color:red"> '.$t1[$x0].'</span>'; $x0++; }   # deleted elems
      if ($op==2) $out[] = '<tr style="border:1px solid #ddd"><td style="border:1px solid #ddd">&nbsp;</td><td style="border:1px solid #ddd">'."{$x1}added{$ystr}";
      elseif ($op==1||$op==3) $out[] = '</td><td style="border:1px solid #ddd">&nbsp;';
      while ($y0<$y1) { $out[] = "Line {$ystr}: <br>".'<span style="color:green">'.$t2[$y0].'</span>'; $y0++; }   # added elems
    $out[]="</td></tr>";
    }
    $x1++; $x0=$x1;
    $y1++; $y0=$y1;
    $op=0;
;
  }

  $out[] = "</table>";
  return join("\n",$out);
}

    
?><html>
<head><title>diff example</title></head>

<body>
<h3>Implementation of DIFF in pure-php</h3>
this outputs the difference in gnu diff(1) syntax. 
<br />

<?
    #example usage:
    
    /* $f1_arr=Array(  "<html>",
                "<head><title>Text</title></head>",
                "<body>",
                "code a",
                "code b",
                "code c",
                "code d",
                "code e",

                "code g",
                "</body>",
                "</html>" );

    $f2_arr=Array(  "<html>",
                "<head><title>Text2</title></head>",
                "<body>",
                "code a",
                "code a",

                "code c",
                "code d",
                "code e",


                "code g",
                "code f",
                "</body>",
                "</html>" );

	*/
    #you can use files as input and compare them
    # simply with, this gives you simple diff in your webserver.
    #
    # $f3= file ("path to file");
    
//    $f1 = implode( "\n", $f1_arr ); 
  //  $f2 = implode( "\n", $f2_arr ); 

//    print "<pre>";
  //  print "Input-Data: <xmp>";
    //print_r( $f1_arr );
    //print_r( $f2_arr );
    //print "</xmp>";

	$f1=
"<br><h3>Welcome</h3>
<p>:P</p>
<p>
Welcome to the [cyberia] home1 page. This site is the home base of the [cyberia] lanning community. Our goal is to provide the most unique and complete lanning experience to our members.</p>
<h4>Whats so special about [cyberia] lans ?</h4>
<p>Our lans have several features which set them apart from the rest:</p>
<ul>
<li>Full Gigabit network</li>
<li>Monster server</li>
<li>Strong community focus</li>
<li>Unique anti-social and gaming ranking and rewards system</li>
<li>Non-for-profit organisation</li>
<li>Software and multimedia development competitions</li>
<li>Advanced network monitoring and security services</li>
</ul>
";
	$f2=
"<br><h3>Welcome</h3>
<p>
Welcome to the [cyberia] home page. This site is the home base of the [cyberia] lanning community. Our goal is to provide the most unique and complete lanning experience to our members.</p>
<h4>Whats so special about [cyberia] lans ?</h4>
<p>Our lans have several features which set them apart from the rest:</p>
<ul>
<li>Full Gigabit network</li>
<li>Monster server</li>
<li>Strong community focus</li>
<li>Unique anti-social and gaming ranking and rewards system</li>
<li>Non-for-profit organisation</li>
<li>Software and multimedia development competitions</li>
</ul>
Adding something
";


print "old<br>$f1<hr>";
print "new<br>$f2<hr>";
print"<pre>";
    print "<hr />new, old <br />"; 
    print PHPDiff( $f1, $f2 );

//   print "<hr />old, new <br />"; 
  //  print PHPDiff( $f2, $f1 );
print"</pre>";


    #comparing with array_diff()
/*
    print "<hr>Compared: array_diff( \$f1_arr, \$f2_arr );<br> ";
    print "<xmp>";
    print_r ( array_diff( $f1_arr, $f2_arr ) );
    print "</xmp>";
    
    print "<hr>Compared: array_diff( \$f2_arr, \$f1_arr );<br> ";
    print "<xmp>";
    print_r ( array_diff( $f2_arr, $f1_arr ) );
    print "</xmp>";
    print "</pre>";
*/
    print "<hr>";

    print "&copy 2003-2006 <a href='mailto:d.u.phpnet@holomind.de?subject=diff'>Daniel Unterberger</a>. ";
    print "<a href='./diff2.src.php'> view source </a>.";
?>
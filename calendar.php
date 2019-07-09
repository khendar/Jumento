<?php
/*
    Version:
    0.05.01 (see changes at bottom of the comments)

    What this does:
    getcal($year) generates a calendar for any given year,
    with intelligent links.

    Author:
    Joseph Cunningham, inferno@teleport.com

    Copyright:
    None. Zilch. Nadda. Modify to your heart's content.

    Disclaimer:
    Use at your own risk.  The author of this is not liable for anything
    that this code does.

    Synopsis of operation:
    The getcal($year) function creates a calendar for the said year.  The
    getcal() function in turn calls the gen_month($month,$year)
    which generates the month table with the name/day headings/day numbers.

    The gen_day_url($day,$month,$year) function is called by gen_month()
    to display the day number.  If there are any records in the table
    specified by $table_name that contain the date specified in the $day,
    $month, and $year vars, it generates a link.  If there are no records,
    it just returns the day number.

    Changes:

    0.01    First Release - it didn't work in it's released form. :)

    0.02    Second beta release - it works!
        * Added more comments
        * Fixed the db connection stuff
        * Added the ability to use the script w/o a db

    0.03b    Bug fix release August 22, 2000
        * Fixed bug in mktime() call
          Thanks Kiyu! :)
        * Added the fixlen() function - <duh!>

    0.04    Bug fix release November 18, 2001
        * Fixed bug for mysql connection
        * A had added SQL in order to have an explicit database table
        * Author: lucian@inetsoft.ro

    0.05    New feature - January 5, 2002
		* Added function showdate(date) to list events on a specific date

    0.05.01 Small bug fix - January 6, 2002
		* Fixed a few small mistakes


	// Decide if you want just a calendar, or also a db with the events
*/
	// Complex table
	CREATE TABLE calendar (
		id int(10) unsigned NOT NULL auto_increment,
		date date NOT NULL default '0000-00-00',
		time time default NULL,
		title varchar(128) default NULL,
		description text,
		infolink varchar(128) default NULL,
		infocontact varchar(128) default NULL,
		infoemail varchar(128) default NULL,
		infophone varchar(32) default NULL,
		closed enum('Y','N') NOT NULL default 'N',
		closedlink varchar(128) default NULL,
		closedemail varchar(128) default NULL,
		price double NOT NULL default '0',
		PRIMARY KEY  (id),
		KEY title (title,closed),
		FULLTEXT KEY title_2 (title,description)
	) TYPE=MyISAM;

	// Simple table
   // CREATE TABLE calendar (
    //  id int(10) unsigned NOT NULL auto_increment,
     // date date DEFAULT '0000-00-00' NOT NULL,
      //PRIMARY KEY (id)
    //);

	// Add first entry
    INSERT INTO calendar (id, date) VALUES ( '1', '2002-01-20');



//
// Configuration options for calendar function
//
//    This script is written for a mysql database.  I'm too busy (and ignorant)
//    to write a wrapper for it.  If you don't want to use the database features
//    of this script, just leave the $db_host variable blank.
//
$db_host =  "localhost";
$db_name =  "cyberia";
$db_username =  "cyberia";
$db_passwd =  "cyberia";
$db_table_name =  "calendar";
$db_column_name =  "date";
$db_type = 1;	// 0=simple 1=complex
//
//    How many months across to display?
//
$num_columns_static = 3;

//
//    Formatting variables -- change to your heart's content!
//
$month_table_header =  "\n<table border=0 cellspacing=12>";
$month_row_header =  "\n<tr>";
$month_td_tag =  "<td valign=top>";
$cal_table_tag =  "\n<table width=140 border=0 bgcolor=#DDDDDD>";
$cal_mon_tr_tag =  "\n<tr bgcolor=#D3DCE3>";
$cal_dayname_tr_tag =  "\n<tr bgcolor=#CCCCCC>";
$cal_day_tr_tag =  "\n<tr>";
$cal_day_opentd = "<td align=center>";
$cal_day_closetd = "</td>";
$cal_event_opentd = "<td align=center bgcolor=#c0c0ff><b>";
$cal_event_closetd = "</b></td>";
$event_table_opentag =  "<table cellspacing=0 cellpadding=4 border=0>\n";
$event_table_closetag =  "</table>\n";
$event_tr_opentag =  "\t<tr>\n";
$event_tr_closetag =  "\t</tr>\n";
$event_th_opentag =  "\t\t<th bgcolor=#D3DCE3>\n";
$event_th_closetag =  "\t\t</th>\n";
$event_td_opentag =  "\t\t<td bgcolor=#CCCCCC>\n";
$event_td_closetag =  "\t\t</td>\n";

//
//    Connection to the database and selection of the correct db.
//
$db_link = mysql_connect($db_host, $db_username, $db_passwd);
$db = mysql_select_db($db_name, $db_link);

//
// Function fixlen($string) adds a zero to the front of the string if the
// string length does not equal 2
//
function fixlen($fixit) {
        if (strlen($fixit)<2) {
                return  "0$fixit";
        } else {
                return $fixit;
        }
}

//
// Function getcal($year) will generate a calendar for the given year.
//
function getcal($year) {
    global $num_columns_static,$month_table_header,$month_row_header,$month_td_tag;
    $num_of_months = 12;
    $count_up = 1;
    echo $month_table_header;
    while ($count_up<=$num_of_months) {
        echo $month_row_header;
        $num_columns = $num_columns_static;
        while (($num_columns>0) && ($count_up<=$num_of_months)) {
            echo $month_td_tag;
            echo gen_month($year,$count_up);
            echo  "</td>";
            $count_up++;
            $num_columns--;
        }
        echo  "</tr>";
    }
    echo  "\n</table>";
}

//
// Function gen_month($year,$month) will generate a month for
// the year and month given.
//
function gen_month($year,$month) {
    global $cal_table_tag,$cal_mon_tr_tag,$cal_dayname_tr_tag,$cal_day_tr_tag;
    global $cal_event_opentd, $cal_event_closetd;
    global $cal_day_opentd, $cal_day_closetd;

    $mon_date = getdate(mktime(0,0,0,$month,1,$year));
    $mon_name = $mon_date[month];
    $mon_total_days = strftime( "%d",mktime(0,0,0,$month+1,0,$year));
    echo $cal_table_tag;
    echo $cal_mon_tr_tag .  "<td colspan=7 align=center><b>$mon_name $year</b></td></tr>";
    echo $cal_dayname_tr_tag .  "<td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>";
    $day_count = 1;
    while ($day_count<=($mon_total_days-7)) {
        $fweek = getdate(mktime(0,0,0,$month,$day_count,$year));
        if ($day_count<=7) {
            $sb_cnt_td = $fweek[wday];
            $sb_cnt = $fweek[wday];
            $sb_max = 7;
            $p_line = $cal_day_tr_tag;
            while ($sb_cnt_td>=1) {
                $p_line .=  "\n<td>&nbsp;</td>";
                $sb_cnt_td--;
            }
            while ($sb_cnt<$sb_max) {
                 //
                 // The $urldisp is what shows the number of the
                 // day.  the gen_day_url() function makes the
                 // number linkable if there is data in a
                 // certain table for that day.
                 //
                 //
                 //    $find_data is used in the SQL query in gen_day_url()
                 //    If there is any occurrence of $find_data in
                 //    $db_column_name, then a link is generated.
                 //
                $find_data = $fweek[year] ."-". fixlen($fweek[mon]) ."-". fixlen($day_count);
                $urldisp = gen_day_url($find_data,$day_count);
                if (strlen($urldisp) > 2)
                    $p_line .=  $cal_event_opentd . $urldisp . $cal_event_closetd;
                else
                    $p_line .=  $cal_day_opentd . $urldisp . $cal_day_closetd;
                $sb_cnt++;
                $day_count++;
            }
            echo  "$p_line</tr>";
        } else {
            $weekday_count = 1;
            $p_line = $cal_day_tr_tag;
            while ($weekday_count<=7) {
                 //
                 //    $find_data is used in the SQL query in gen_day_url()
                 //    If there is any occurrence of $find_data in
                 //    $db_column_name, then a link is generated.
                 //
                $find_data = $fweek[year] ."-". fixlen($fweek[mon]) ."-". fixlen($day_count);
                $urldisp = gen_day_url($find_data,$day_count);
                if (strlen($urldisp) > 2)
                    $p_line .=  $cal_event_opentd . $urldisp . $cal_event_closetd;
                else
                    $p_line .=  $cal_day_opentd . $urldisp . $cal_day_closetd;
                $weekday_count++;
                $day_count++;
            }
            $p_line .= "</tr>";
            echo $p_line;
        }
    }
    $sb_cnt_td = 7-($mon_total_days - $day_count);
    $p_line = $cal_day_tr_tag;
    while ($day_count<=$mon_total_days) {
         //
         //    $find_data is used in the SQL query in gen_day_url()
         //    If there is any occurrence of $find_data in
         //    $db_column_name, then a link is generated.
         //
        $find_data = $fweek[year] ."-". fixlen($fweek[mon]) ."-". fixlen($day_count);
        $urldisp = gen_day_url($find_data,$day_count);
        if (strlen($urldisp) > 2)
            $p_line .=  $cal_event_opentd . $urldisp . $cal_event_closetd;
        else
            $p_line .=  $cal_day_opentd . $urldisp . $cal_day_closetd;
        $day_count++;
    }
    while ($sb_cnt_td>1) {
        $p_line .=  "\n<td>&nbsp;</td>";
        $sb_cnt_td--;
    }
    echo  "$p_line</tr>";
    echo  "</table>";
}
//
// Function gen_day_url($day,$month,$year) makes either a
// a plain text day number, or a linked number, depending on if a record
// exists for that day.
//
function gen_day_url($data,$day) {
    global $db_table_name,$db_column_name,$db_host, $db_link;

    if (strlen($db_host)>0) {
        $qrsql =  "SELECT * FROM $db_table_name WHERE ($db_column_name='$data')";
        $qr_ret = mysql_query($qrsql, $db_link);
		$qr_num=mysql_num_rows($qr_ret);
        if ($qr_num>0) {
			//
			//    Here is where you put the link to the action
			//    you want to perform if there is data in the
			//    table.
			//
			$row=mysql_fetch_array($qr_ret);
			return  "<a href=\"showdate.php3?date=$data\" alt=\"$qr_num event(s)\" title=\"$qr_num event(s)\">$day</a>";
        } else {
             //
             //    Returns just the number of the day if there
             //    is no data in the table for that date
             //
            return $day;
        }
    } else {
         //
         //    This returns just the number of the day, because
         //    the $db_host variable is empty (the user does not
         //    want to use the db functions of the snippet.
         //
        return $day;
    }
}

//
// Function showdate($date) shows the events for the passed date
//
function showdate($date) {
	global $db_table_name,$db_column_name,$db_host, $db_link, $db_type;
	global $event_table_opentag, $event_table_closetag, $event_tr_opentag, $event_tr_closetag, $event_th_opentag, $event_th_closetag, $event_td_opentag, $event_td_closetag;

	$dateformatted="<b>Events on $date</b>";

    $ret  = $event_table_opentag;
	$ret .= $event_tr_opentag . $event_th_opentag . $dateformatted . $event_th_closetag . $event_tr_closetag;

    if (strlen($db_host)>0) {
        $qrsql =  "SELECT * FROM $db_table_name WHERE ($db_column_name='$date') ORDER BY $db_column_name, time";
        $qr_ret = mysql_query($qrsql, $db_link);
		$qr_num=mysql_num_rows($qr_ret);
        if ($qr_num>0) {
			$n=0;
			//
			//    Show all Event seperated by a ruler
			//
			while($row=mysql_fetch_array($qr_ret)) {
				$ret .= $event_tr_opentag . $event_td_opentag;

				if($n)
					$ret .= "<hr noshade>\n";

				// Write time if set
				if($row[time])
					$ret .= "<small>$row[time]</small><br>\n";

				// Write title and description
				$ret .= "<b>" . $row[title] . "</b>" . "<br>\n" . $row[description] . "<p>\n";

//				else
//					$ret .= "<small>All day event</small><br>";

				// Provide info if this is a closed event
				if($row[closed]=='Y') {
					$ret .= "<small>";
					$ret .= "Closed Event<br>";
					if($row[closedlink])
						$ret .= "To signup, click here: <a href=\"$row[closedlink]\" alt=\"Sign-up using Online Form\" title=\"Sign-up using Online Form\">$row[closedlink]</a><br>\n";
					if($row[closedemail])
						$ret .= "To signup, write to: <a href=\"mailto:$row[closedemail]\" alt=\"Send email to sign-up\" title=\"Send email to sign-up\">$row[closedemail]</a><br>\n";
					$ret .= "</small><br>\n";
				}

				// Write price if set

				if(intval($row[price]))
					$ret .= "<b>Price: \$ $row[price]</b><br>\n";

				$ret .= $event_td_closetag . $event_tr_closetag;
				$n++;
			}
        } else {
             //
             //    Returns just the number of the day if there
             //    is no data in the table for that date
             //
            $ret .= $event_tr_opentag . $event_td_opentag . "No events found for this date" . $event_td_closetag . $event_tr_closetag;
        }
    } else {
         //
         //    This returns just the number of the day, because
         //    the $db_host variable is empty (the user does not
         //    want to use the db functions of the snippet.
         //
        $ret .= $event_tr_opentag . $event_td_opentag . "No Database defined. How can you have any events?!" . $event_td_closetag . $event_tr_closetag;
    }
    $ret .= $event_table_closetag;
    $ret .= "\n\n<p>\n\n<a href=\"\" OnClick=\"javascript:back()\">Back to Calendar</a><p>\n";
	return $ret;
}


?>

<?
  // Here is the call!!!
  // $year = 2001;
  // getcal($year);
?>

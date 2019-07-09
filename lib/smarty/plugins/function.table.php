<?php 
/** 
* Creates a table from an array using the PEAR table class. 
* 
* Usage: 
* $data is just a normal array: 
* $data = array("Cell 1", "Cell 2", "Cell 3", "Cell 4", "Cell 5", "Cell 6"); 
* $smarty->assign("data", $data); 
* and your table is created :-) 
* 
* syntax: {table loop=$varname 
*                cols=int 
*                caption=string 
*                caption_attr=string 
*                header=string 
*                header_attr=string 
*                table_attr=string 
*                td_attr=string 
*                altrows=string 
*                arrange=horizontal|vertical 
*         } 
* 
* All attributes except 'loop' are optional. 
* Please note that the syntax of the altrows tag is as follows: 
*      altrows='row1attr|row2attr' 
* 
* A tutorial and full documentation can be found at: 
* http://www.mapledesign.co.uk/coding/ 
* 
* To improve: 
* - The way the default attributes are set.  I need some ideas :-) 
*   the current way means that if you change the default values then you have 
*   to do so every time you upgrade this function.  A way round this would be 
*   to define the values, so you can set them in your application if you want. 
*   At the top of this file I'd have: 
*         if (!defined(SMARTY_TABLE_COLS)) { 
*              define('SMARTY_TABLE_COLS', '2'); 
*         } 
*   and then below it: 
*         $cols = (isset($cols)) 
*                  ? $cols 
*                  : SMARTY_TABLE_COLS; 
* 
*   This would allow you to easily set the defaults on an application level 
*   making upgrading easier. 
* - Variable naming within the function, as I don't think I'm using $_ in 
*   varnames correctly.  CAN SOMEONE PLEASE ADVISE as I haven't a clue! 
* - Clean up the {table} tag's attributes, as it's rather messy and long at 
*   the moment.  Some of the names are not obvious.  If you have improvements 
*   to suggest then please email me. 
* 
***************************************************************************** 
* This code has been released as tipware - if you use it then please make a 
* donation or buy me something from my Amazon wishlist.  Full details can be 
* found @ http://sendcard.resource-locator.com/moral.php 
***************************************************************************** 
* 
* @author Peter Bowyer <peter@mapledesign.co.uk> & Svilen Spasov <s.spasov@gmail.com>
* @version 1.0 
* @access public 
* @param array $_args attributes passed from the smarty tag. 
* @return true 
*/ 
function smarty_function_table($_args) 
{ 
    // Default settings by Svilen
    // We MUST have all a default value for all necessary table properties, which will be used for creating a table
    $defaultConfigs = array(
    	'cols' => 2,
    	'caption' => '',
    	'caption_attr' => array('align' => 'top'),
    	'header' => '',
    	'header_attr' => '',
    	 // I've excluded align="center" because I think it's not appropriate,
    	 // since usually it is supposed to use aling="left", as it is by default in the browsers
    	'table_attr' => array ('border' => '0'),
    	'td_attr' => array('align' => 'center'),
    	'pad_val' => '&nbsp;',
    	'arrange' => 'horizontal'
    );
    // end: Default settings by Svilen
    
    // Get the $_args array into 'normal' variables. 
    extract($_args); 
     
    // Check if the loop is set
    if (!isset($loop) || !is_array($loop) || empty($loop)) { 
        return trigger_error('Parameter "loop" of {table} is not an array'); 
    } 
    
    // New handle of default settings by Svilen
    // Let's you set only needed onle
    foreach($defaultConfigs as $key => $value) {
    	if (isset($$key)) {
    		if (((bool)strpos($$key, '=')) === true) {
    			$arrayValues = explode('|', $$key);
    			foreach($arrayValues as $Keys => $Value) {
    				$Value = str_replace(array('\'', '"'), '', $Value);
    				$realArray = explode('=', $Value);
    				$customConfigsAttributeArray[$realArray[0]] = $realArray[1];
    			}
    		}
    		else {
    			$defaultConfigs[$key] = $$key;
    		}
    		  			
  			// Check customs settings agains default settings, overwrites the default settings and adds new custom settings
  			if (is_array($value) && is_array($customConfigsAttributeArray)){
	  			foreach ($customConfigsAttributeArray as $propertyName => $propertyValue) {
	  				if (!empty($propertyValue)) {
	  					$defaultConfigs[$key][$propertyName] = $propertyValue;
	  				}
	  			}
	  		}
  			// end: Check customs settings agains default settings, overwrites the default settings and adds new custom settings
  			
  			// Let's unset the current setting custom values
  			unset($customConfigsAttributeArray);
    	}
    }
    
    // For compatability to the old standard of handling function's configs, we need to re-build the $defaultConfigs array
    foreach ($defaultConfigs as $key => $value) {
    	if (is_array($value)) {
    		$string = '';
    		foreach ($value as $valueName => $valueVal) {
    			$string .= $valueName.'="'.$valueVal.'" ';
    		}
    		
    		$defaultConfigs[$key] = $string;
    		unset($string);
    	}
    }
    
    extract($defaultConfigs);
    // end: New handle of default settings by Svilen
     
    /************************************************************************** 
     Nothing below this line should need changing 
    **************************************************************************/ 
    // Require the table class 
    $table = new HTML_Table($table_attr); 
     
    // Add a header to the table if desired. 
    if ($header != '') { 
        $table->addRow($header, "colspan=\"$cols\" " . $header_attr, "TH"); 
    } 
    if ($caption) { 
        $table->setCaption($caption, $caption_attr); 
    } 
    // Calculate the number of rows needed to hold all the data. 
    $_rows = ceil(count($loop) / $cols); 
     
     
    // Pad array if not the right length - prevents any collapsing table cells 
    //$loop = array_pad($loop, $_rows * $cols, $pad_val); 
    // Above line shouldn't be needed with the following 
    $table->setAutoFill($pad_val); 
     
    switch(strtolower($arrange)){ 
        case 'vertical': 
            /* 
             * Orders the items in the array like 
             * cell 1  cell 4 cell 7 
             * cell 2  cell 5 cell 8 
             * cell 3  cell 6 cell 9 
             */ 
            foreach ($loop as $key => $value) { 
                $_data[] = $value; 
                if (0 == count($_data) % $_rows) { 
                           $table->addCol($_data); 
                           $_data = null; 
                       } 
            } 
            // If there's any data left, assign it to a column 
            if (isset($_data)) { 
                $table->addCol($_data); 
            } 
            break; 
        case 'horizontal': 
        default: 
            /* 
             * Orders the items in the array like 
             * cell 1  cell 2 cell 3 
             * cell 4  cell 5 cell 6 
             * cell 7  cell 8 cell 9 
             */ 
            foreach ($loop as $key => $value) { 
                $_data[] = $value; 
                if (0 == count($_data) % $cols) { 
                           $table->addRow($_data); 
                           $_data = null; 
                       } 
            } 
            // If there's any data left, assign it to a row 
            if (isset($_data)) { 
                $table->addRow($_data); 
            } 
            break; 
    } 
 
    // Check to see if alternate rows are set 
    if (isset($altrows)){
        $_attr = explode("|", $altrows);
        $table->altRowAttributes(($header ? 1 : 0), $_attr[0], $_attr[1]); 
    } 
     
    // Check to see if cell attributes are set 
    if (isset($td_attr)){ 
        for($i = ($header ? 1 : 0) ; $i < ($_rows + ($header ? 1 : 0)); $i++){ 
            $table->updateRowAttributes($i,$td_attr); 
        } 
    } 
     
    // Finally, display the table. 
    $table->display(); 
    return; 
} // End Function smarty_function_table 
?> 
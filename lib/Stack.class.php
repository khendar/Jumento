<?php

/**
* A stack data structure. A stack is a LIFO (Last In First Out) data structure.
* @author Tim Parkinson
* @version 1.0
*/
class Stack {
    /**
    * @var array The Stack data.
    * @access private
    */
    var $_stack = array();
    
    /**
    * Push the argument onto the stack.
    * @param mixed $content The element to be pushed onto the stack.
    */
    function push($element) {
        array_push($this->_stack, $element);
    }
    
    /**
    * Pop the Stack.
    * @returns mixed The reference to the popped element.
    */
    function &pop() {
        $element = &$this->top();
        array_pop($this->_stack);
        return $element;
    }

    /**
    * Returns a reference to the top of the stack.
    * @returns mixed A reference to the top of the stack.
    */
    function &top() {
        $count = count($this->_stack);
        // Prevent bad reference pointer
        if ($count == 0) {
            return null;
        }
        return $this->_stack[count($this->_stack)-1];
    }
    
    /**
    * Get the lenght of the Stack.
    * @returns int The lenght of the Stack.
    */
    function get_length() {
        return count($this->_stack);
    }
    
    /**
    * Prints the entire stack
    * @returns string Prints all the elements of the stack
    */
    function &print_stack(){
    	echo '<pre>';print_r($this->_stack);echo '</pre>';
    }

    /**
    * Pops the entire stack
    * @returns array All the elements of the stack
    */
    function &pop_all(){
    	while(count($this->_stack)>=0){
          return $this->pop();
        }
    }
}
?>
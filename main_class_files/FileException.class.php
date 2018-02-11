<?php
class FileException extends Exception {
      //original source of this class needed for attribute      
	// Define the get_details() method...
	// Method takes no arguments and
	// returns a detailed message.
	function get_details() { 
	
		// Return a different message based
		// upon the code:
		switch ($this->code) {
			case 0:
				return 'No filename was provided';
				break;
			case 1:
				return 'The file does not exist.';
				break;
			case 2:
				return 'The file is not a file.';
				break;
			case 3:
				return 'The file is not writable.';
				break;
			case 4:
				return 'An invalid mode was provided.';
				break;
			case 5:
				return 'The data could not be written.';
				break;
			case 6:
				return 'The file could not be closed.';
				break;
			default:
				return 'No further information is available.';
				break;
		} // End of SWITCH.
	
	} // End of get_details() function.
	
} // End of FileException class.
?>

<?php 
//original author of this class needed for attribute
// Create a class for writing to a file...
// Class has one attribute for storing the file pointer.
// Class has a constructor, that performs validation
// and assigns the pointer.
// Class has a write() method for writing data.
// Class has a close() method to close the pointer.
class WriteToFile {
	// Attributes:
	private $fp = null;
	private $message = '';
	// Constructor:
	function __construct($file = null, $mode = 'w') {
	
		// Assign the file name and mode
		// to the message attribute:
		$this->message = "File: $file Mode: $mode";

		// Make sure a file name was provided:
		if (empty($file)) {
			throw new FileException($this->message, 0);
		}

		// Make sure the file exists:
		if (!file_exists($file)) {
			throw new FileException ($this->message, 1);
		}
		
		// Make sure the file is a file:
		if (!is_file($file)) {
			throw new FileException ($this->message, 2);
		}
		
		// Make sure the file is writable:
		//if (!is_writable($file) ) {
		//	throw new FileException ($this->message, 3);
		//}potential problem on windows server
		
		// Validate the mode:
		if (!in_array($mode, array('a', 'a+', 'w', 'w+'))) {
			throw new FileException($this->message, 4);
		}
	
		// Open the file:
		$this->fp = fopen($file, $mode);
		
	} // End of constructor.
	
	// Method for writing the data:
	function write($data = null) {
	
		if (!fwrite($this->fp, $data)) {
			throw new FileException($this->message . " Data: $data", 5);
		}

	} // End of write() method.

	// Method for closing the file:
	function close() {
	
		if (!fclose($this->fp)) {
			throw new FileException($this->message, 6);
		}
		
		$this->fp = null;
		
	} // End of close() method.

} // End of WriteToFile class.
?>
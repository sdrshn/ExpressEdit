<!DOCTYPE html>
<html lang="en"> 
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Handling Exceptions</title>
</head>
<body>
<?php # Script 8.3 - write_to_file2.php
 //original source needed for attribute

/*	This page attempts to write some data
 *	to a text file.
 *	A special class is used for this purpose.
 *	An extended exception class is used for errors.
 */

# ******************* #
# ***** CLASSES ***** #

// Define the extended exception class...
// This class adds a get_detail() method.
class FileException extends Exception {

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


// Create a class for writing to a file...
// Class has one attribute for storing the file pointer.
// Class has a constructor, that performs validation
// and assigns the pointer.
// Class has a write() method for writing data.
// Class has a close() method to close the pointer.
class WriteToFile {
	private $fp = null;
	private $message = '';
	// Constructor:
	function __construct($file = null, $mode = 'w') {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
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
		if (!is_writable($file) ) {
			throw new FileException ($this->message, 3);
		}
		
		// Validate the mode:
		if (!in_array($mode, array('a', 'a+', 'w', 'w+'))) {
			throw new FileException($this->message, 4);
		}
	
		// Open the file:
		$this->fp = fopen($file, $mode);
		
	} // End of constructor.
	
	// Method for writing the data:
	function write($data = null) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
		if (!fwrite($this->fp, $data)) {
			throw new FileException($this->message . " Data: $data", 5);
		}

	} // End of write() method.

	// Method for closing the file:
	function close() {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
		if (!fclose($this->fp)) {
			throw new FileException($this->message, 6);
		}
		
		$this->fp = null;
		
	} // End of close() method.

} // End of WriteToFile class.

# ***** END OF CLASSES ***** #
# ************************** #

// Identify the file:
$file = 'data.txt';
// Data to be written:
$data = "This is a line of data.\n";
// Start the try...catch block:
try {

	$fp = new WriteToFile($file);
	$fp->write($data);
	$fp->close();

	// If we got this far, everything worked!
	echo '<p>The data has been written.</p>';

} catch (FileException $fe) {
	echo '<p>The process could not be completed. Debugging information:<br>' . $fe->getMessage() . '<br>' . $fe->get_details() . '</p>';
}


?>
</body>
</html>

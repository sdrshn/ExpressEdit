<?php
#ExpressEdit 3.01
class store extends Singleton{
	private static $backup_clone_refresh_cancel;
	public $tablename;
	public static function setVar($var, $value) {
		self::$$var = $value;
		}
	public static function getVar($var) {
		return self::$$var;
		}
   
}//end class
?>
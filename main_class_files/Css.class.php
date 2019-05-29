<?php
#ExpressEdit 2.0
if (isset($_ENV['SHELL'])) {
	require('/home2/ashramao/php/Php.php');
	}
# + + + + + + + + + + + + + +
class Fmt {
#	RecordSep = NL
 const FieldSep = "\t";
 const Info = "@(name)<div class=\"padded-l\">@(value)</div>\n";
 const Summary = "s\t%s\t%s\t%s\n";
 const Detail = "d\t%s\t%s\n";
 const TallyExceeded = 'template(name=%s, match(%s).count(%s).exceeded'; 
 const Vars = 'name,value';
 const Report = "<pre>CSS.read(%s[%s]) => array[%s]\n\n%s\n\nDONE reading: %s\n</pre>";

 private function __construct() {} # Fmt
 } # Fmt.class


# + + + + + + + + + + + + + +
class Css {
	const Test = false;
	const Inst = 'class="([^\"]+?)"'; # TBD: include  style="..."
	const DefaultFormat = 'b'; # 's'ummary, 'd'etail or 'b'oth
	const Log = 'Css.log';
	const Db = 'Css.db';
	const Common = 'index.css';
	const Dir = 'css/';
	const Dot = '.css';

	protected $log = Null;
	private $opt = Null;

	private $max_instances = 0;
	private $count = 0;
	private $css = array();
	private $src = array();
	private $options = array(
		'test' => 't',	# t,y,1 | f,n,0 - boolean
		'format' => 'f', # see const DefaultFormat above
		'source' => 'S', # S=<css-file-name> # of the Css source file
		'input' => 'i', # i=<input-file-name>  # of file to be scanned
		'list' => 'l',); # display the event log ? y|n, default = no

 public function __construct($max) {
#	$this->log = Log::instance(__CLASS__);
	$this->opt = new Opt($_GET, $this->options);
	$this->test = $this->opt->get('test',self::Test);
	$this->max_instances = $max;
	$this->src = $this->read();
	} # css.new()

# ~ ~ ~ ~ ~ ~ ~
 public function scan($fileName,$name) {
	$ii = __METHOD__;
#	$this->log->set($ii,"file: $fileName");
	$patt = self::Inst;
	$pattern = htmlspecialchars($patt);
#	$this->log->set($ii,"  looking for $pattern in $fileName");
	$txt = file_get_contents($fileName);
	$matches = array();
	$count = preg_match_all("/$patt/s",$txt,$matches,PREG_SET_ORDER);
	#
	# next tally the matched 'class="<classList>"' results
	# where <classList> is [<name>[ <name>]*]
	#
	$this->tally($name, $count, $matches);
#	$this->log->set($ii, "scanned $name");
#	$this->log->save(self::Log, 'a');
	return 1;
	} # css.scan()


# ~ ~ ~ ~ ~ ~ ~
 private function tally($fileName, $count, &$matches) {
	$ii = __METHOD__;
#	$this->log->set($ii, "tallying $count matches in $fileName");
	$found = '';
	for($i=0; $i<$count; $i++) {
		$classList = $matches[$i][1];
		$this->count += 1;
		$found .= $classList.', ';
		if ($this->count < $this->max_instances) {
			$this->insert($fileName,$classList);
			continue;
			}
		$msg = sprintf(Fmt::TallyExceeded,$name,$classList,$this->count);
#		$this->log->set($ii,$msg);
#		$this->stop($ii,$msg,$this->log->string()); # inherited from Str
		die("$ii: $msg");
		}
#	$this->log->set($ii,'tally.found='.$found);
	} # css.tally()


# ~ ~ ~ ~ ~ ~ ~
 private function insert($fileName, $classList) {
	$ii = __METHOD__;
	$lst = explode(' ',$classList);

	foreach($lst as $className) {
		if (!array_key_exists($className, $this->css)) {
	   	$this->css[$className] = new HashList($fileName);
			}
		$status = $this->css[$className]->insert($fileName,$className);
#		$this->log->set($ii,sprintf(Fmt::Detail,$ii,$status));
		}
	} # css.insert()


# ~ ~ ~ ~ ~ ~ ~
 public function render() {
	#
	# format = summary, detail, or (default)both : one-of{sdb}
	$opt  = $this->opt->get('format',self::DefaultFormat);
	$str  = '';
	$str .= sprintf(Fmt::Summary,'Class','Count','File');
	foreach($this->css as $name => $hash) {
		$str .= $hash->summary($name,$opt);
		}
	return $str;
	} # Css.render()


# ~ ~ ~ ~ ~ ~ ~
 private function read() {
	$fileName = $this->opt->get('input',self::Common);
	strpos($fileName,self::Dot) || $fileName .= self::Dot;
	$spec = Sys::Root.self::Dir.$fileName;
	if (!file_exists($spec)) {
		throw new Exception("$spec - not found");
		}
	$content = file($spec, FILE_IGNORE_NEW_LINES);
	$className = '';
	$definitionIsComplete = true;
	foreach($content as $entry) {
		if ($definitionIsComplete) {
			if (false === strpos($entry,'{')) { continue; }
			list($className,$classSpec) = explode('{',$entry);
			$className = trim($className);
			$this->src[$className] = '{'.$classSpec;
			}
		else {
			$this->src[$className] .= $entry;
			}
		(array_key_exists($className,$this->src)) &&
			$definitionIsComplete = strpos($this->src[$className],'}');
		}
	$this->test && $this->display($spec, count($content));
	} # css.read()

 private function display($spec, $fileCount) {
		$srcCount = count($this->src);
		$src = '';
		foreach($this->src as $name => $val) {
			$src .= "$name $val\n";
			}
		$str = sprintf(Fmt::Report,$spec,$fileCount,$srcCount,$src,$spec);
		echo "<pre>".implode(get_included_files(),"\n")."</pre>\n";
		die($str);
		} # css.display()

# ~ ~ ~ ~ ~ ~ ~
 public function write() {
	} # Css.write()
 } # Css.class

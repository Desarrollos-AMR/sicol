<?php

require_once '../Excel/Writer.php';

class SqlSheet {
	private $name;
	private $sql;
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setSql($sql) {
		$this->sql = $sql;
	}
	
	public function getSql() {
		return $this->sql;
	}
}

interface WriterCallback {
	public function onHeaderWrite(&$worksheet, $rowNum, $colNum, $data);
	
	public function onBodyWrite(&$worksheet, $rowNum, $colNum, $data);
}

class DefaultWriterCallback implements WriterCallback {
	public function onHeaderWrite(&$worksheet, $rowNum, $colNum, $data) {
		$worksheet->write($rowNum, $colNum, $data);
	}
	public function onBodyWrite(&$worksheet, $rowNum, $colNum, $data) {
		$worksheet->write($rowNum, $colNum, $data);
	}
}

interface SqlExplorer {
	public function query($sql);
	public function fetchArray();
	public function numFields();
	public function fieldName($offset);
}

class MysqlSqlExplorer implements SqlExplorer {
	private $conn;
	private $result = null;
	
	public function __construct($host, $user, $password, $dbname) {
		$this->conn = mysql_connect($host, $user, $password);
		mysql_select_db($dbname, $this->conn);
	}
	
	public function query($sql) {
		$this->result = mysql_query($sql, $this->conn);
	}
	
	public function fetchArray() {
		return mysql_fetch_array($this->result);
	}
	
	public function numFields() {
		return mysql_num_fields($this->result);
	}
	
	public function fieldName($offset){
		return mysql_field_name($this->result, $offset);
	}
}

class PearWorkBookHelper {
	
	public function __construct() {
		$this->setWriterCallback(new DefaultWriterCallback());
	}
	
	private $sqlExplorer;
	public function setSqlExplorer(SqlExplorer $sqlExplorer) {
		$this->sqlExplorer = $sqlExplorer;
	}
	
	private $writerCallback = null;
	public function setWriterCallback(WriterCallback $writerCallback) {
		$this->writerCallback = $writerCallback;
	}
	
	public function createWorkBook($sqlSheetList = array()) {
		$workbook = new Spreadsheet_Excel_Writer();
		
		foreach($sqlSheetList as $eachSqlSheet) {
			$worksheet =& $workbook->addWorksheet($eachSqlSheet->getName());
			$this->sqlExplorer->query($eachSqlSheet->getSql());
			
			$i = 1;
			$writeHeaderDone = false;
			while ($row = $this->sqlExplorer->fetchArray()) {
				$colNum = $this->sqlExplorer->numFields();
				
				if (!$writeHeaderDone) {
					for ($c = 1; $c <= $colNum; $c++) {
						if ($this->writerCallback != null) {
							$this->writerCallback->onHeaderWrite($worksheet, $i - 1, $c - 1, $this->sqlExplorer->fieldName($c-1));
						}
						else {
							$worksheet->writeString($i - 1, $c - 1, $this->sqlExplorer->fieldName($c-1));
						}
					}
					$writeHeaderDone = true;
				}
				
				for ($c = 1; $c <= $colNum; $c++) {
					if ($this->writerCallback != null) {
						$this->writerCallback->onBodyWrite($worksheet, $i, $c-1, $row[$c-1]);
					}
					else {
						$worksheet->write($i, $c-1, $row[$c-1]);
					}
				}
				
				$i++;
			}
			
		}
		return $workbook;
	}
}

class WorkbookUtil {
	
	public static function createSqlSheet($name, $sql) {
		$sqlSheet1 = new SqlSheet();
		$sqlSheet1->setSql($sql);
		$sqlSheet1->setName($name);
		return $sqlSheet1;
	}
	
}
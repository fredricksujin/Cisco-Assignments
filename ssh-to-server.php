<?php
class SSH2
{
    protected $conn;

    public function __construct($host, SSH2Authentication $auth, $port = 22) {
        $this->conn = ssh2_connect($host, $port);
        switch(get_class($auth)) {
            case 'SSH2Password':
                $username = $auth->getUsername();
                $password = $auth->getPassword();
                if (ssh2_auth_password($this->conn, $username, $password) === false) {
                    throw new Exception('SSH2 login is invalid');
                }
                break;
            case 'SSH2Key':
                $username = $auth->getUsername();
                $publicKey = $auth->getPublicKey();
                $privateKey = $auth->getPrivateKey();
                if (ssh2_auth_pubkey_file($this->conn, $username, $publicKey, $privateKey) === false) {
                    throw new Exception('SSH2 login is invalid');
                }
                break;
            default:
                throw new Exception('Unknown SSH2 login type');
        }
    }
}

class SSH2SFTP extends SSH2 {
    protected $sftp;

    public function __construct($host, ISSH2Authentication $auth, $port = 22) {
        parent::__construct($host, $auth, $port);
        $this->sftp = ssh2_ftp($this->conn);
    }
    public function __call($func, $args) {
        $func = 'ssh2_sftp_' . $func;
        if (function_exists($func)) {
            array_unshift($args, $this->sftp);
            return call_user_func_array($func, $args);
        }
        else {
            throw new Exception(
                $func . ' is not a valid SFTP function');
        }
    }
}

class SSH2SCP extends SSH2
{
    public function __call($func, $args) {
        $func = 'ssh2_scp_' . $func;
        if (function_exists($func)) {
            array_unshift($args, $this->conn);
            return call_user_func_array($func, $args);
        }
        else {
            throw new Exception(
                $func . ' is not a valid SCP function');
        }
    }
}

// Create SCP connection using a username and password
$scp = new SCP(
    'example.com',
    new SSH2Password('username', 'password')
);
// Receive a file via SCP
if ($scp->recv('remote/file', 'local/file')) {
    echo 'Successfully received file';
}

// Create SFTP connection using a public/private key
$sftp = new SSH2SFTP(
    'example.com',
    new SSH2Key('username', 'public_key', 'private_key')
);
// Create a directory via SFTP
if ($sftp->mkdir('directory/name')) {
    echo 'Successfully created directory';
}
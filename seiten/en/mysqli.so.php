<?php
/*
	mysqli.so-OOP-Hack v0.1
	Use MySQLi Object oriented style as installed MySQLi module on server or local.
    Copyright (C) 2008, Barış Yüksel { brsyuksel.com }

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
class mysqli
{
    public $num_rows, $lengths, $error, $errno, $insert_id, $thread_id, $connect_errno;
    private $mysql, $result;

    const MYSQLI_BOTH = 'MYSQL_BOTH';
    const MYSQLI_NUM = 'MYSQL_NUM';
    const MYSQLI_ASSOC = 'MYSQL_ASSOC';

    public function __construct($host, $username, $pass, $dbname)
    {
        if (!$this->mysql) {
            try {
                $this->connect($host, $username, $pass, $dbname);
            } catch (Exception $e) {
                echo $$e->getMessage();
            }
        }
    }

    public function connect(
        $host, $username, $pass, $dbname, $port = 3306, $socket = null
    )
    {
        try {
            $this->mysql = mysql_connect($host, $username, $pass);
            if (!$this->mysql) {
                $this->connect_errno = mysql_errno();
                throw new Exception(mysql_errno() . " : " . mysql_error());
            } else {
                mysql_select_db($dbname, $this->mysql);
            }
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }

    protected function refresh_properties()
    {
        $this->thread_id = @mysql_thread_id($this->mysql);
        $this->insert_id = @mysql_insert_id($this->mysql);
        $this->error = @mysql_error($this->mysql);
        $this->errno = @mysql_errno($this->mysql);
        $this->affected_rows = @mysql_affected_rows($this->mysql);
        $this->num_rows = @mysql_num_rows($this->result);
        $this->lengths = @mysql_fetch_lengths($this->result);
    }

    public function query($query)
    {
        $this->result = mysql_query($query, $this->mysql);
        self::refresh_properties();
        return $this;
    }

    public function select_db($dbname)
    {
        $event = mysql_select_db($dbname, $this->mysql);
        self::refresh_properties();
        return $event;

    }

    public function fetch_assoc()
    {
        return mysql_fetch_assoc($this->result);
    }

    public function fetch_array($flag = MYSQLI_BOTH)
    {
        return mysql_fetch_array($this->result, $flag);
    }

    public function fetch_row()
    {
        return mysql_fetch_row($this->result);
    }

    public function fetch_object()
    {
        if (func_num_args() == 0) {
            return mysql_fetch_object($this->result);
        } elseif (func_num_args() == 1) {
            $classname = func_get_arg(0);
            return mysql_fetch_object($this->result, $classname);
        }
        elseif (func_num_args() > 1) {
            $args = func_get_args();
            $classname = func_get_arg(0);
            $params = array_splice($args, 1);
            return mysql_fetch_object($this->result, $classname, $params);
        }
    }

    public function fetch_field()
    {
        return mysql_fetch_field($this->mysql, 0);
    }

    public function data_seek($data_seek)
    {
        return mysql_data_seek($this->result, $data_seek);
    }

    public function field_seek($field_seek)
    {
        return mysql_field_seek($this->result, $field_seek);
    }

    public function free_result()
    {
        return mysql_free_result($this->result);
    }

    public static function get_client_info()
    {
        return mysql_get_client_info();
    }

    public function ping()
    {
        return mysql_ping($this->mysql);
    }

    public function change_user($username, $pass, $dbname)
    {
        return mysql_change_user($username, $pass, $dbname, $this->mysql);
    }

    public function real_escape_string($escapestr)
    {
        return mysql_real_escape_string($escapestr, $this->mysql);
    }

    public function escape_string($escapestr)
    {
        return mysql_real_escape_string($escapestr, $this->mysql);
    }

    public function set_charset($charset)
    {
        return mysql_set_charset($charset, $this->mysql);
    }

    public function stat()
    {
        return mysql_stat($this->mysql);
    }

    public function close()
    {
        return mysql_close($this->mysql);
    }

    public function fetch_fields()
    {
        $fiels = array();

        while ($f = $this->fetch_field()) {
            $fields[] = $f;
        }
        return $fields;
    }
}

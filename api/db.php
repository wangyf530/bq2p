<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=bq2";
    protected $table;
    protected $pdo;
    // 設立文章類型
    static public $type = [
        1 => '健康新知',
        2 => '菸害防治',
        3 => '癌症防治',
        4 => '慢性病防治'
    ];

    function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    function a2s($array)
    {
        $tmp = [];
        foreach ($array as $key => $value) {
            $tmp = "`$key`=>'$value'";
        }
        return $tmp;
    }

    function fetch_one($sql)
    {
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function fetch_all($sql)
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    function all(...$arg)
    {
        $sql = "SELECT * FROM $this->table ";
        if (!empty($arg[0]) && is_array($arg[0])) {
            $tmp = $this->a2s($arg[0]);
            $sql .= " WHERE " . join(" && ", $tmp);
        } else if (isset($arg[0]) && is_string($arg[0])) {
            $sql .= $arg[1];
        }
        if (!empty($arg[1])) {
            $sql .= $arg[1];
        }
        return $this->fetch_all($sql);
    }

    function find($array)
    {
        $sql = "SELECT * FROM $this->table ";
        if (is_array($array)) {
            $tmp = $this->a2s($array);
            $sql .= " WHERE " . join(" && ", $tmp);
        } else {
            $sql .= " WHERE `id` = '$array'";
        }
        return $this->fetch_one($sql);
    }

    function save($array)
    {
        if (isset($array['id'])) {
            // update
            $tmp = $this->a2s($array);
            $id = $array['id'];
            $sql = "UPDATE $this->table SET " . join(",", $tmp) . " WHERE `id` = '$id'";
        } else {
            //insert
            $keys = join("`,`", array_keys($array));
            $values = join("',''", $array);
            $sql = "INSERT INTO $this->table (`{$keys}`) VALUES ('{$values}')";
        }
        return $this->pdo->exec($sql);
    }
    function del($array)
    {
        $sql = "DELETE FROM $this->table ";
        if (is_array($array)) {
            $tmp = $this->a2s($array);
            $sql .= " WHERE " . join(" && ", $tmp);
        } else {
            $sql .= " WHERE `id` = '$array'";
        }
        return $this->pdo->exec($sql);
    }
    function count(...$arg)
    {
        $sql = "SELECT COUNT(*) FROM $this->table ";
        if (!empty($arg[0]) && is_array($arg[0])) {
            $tmp = $this->a2s($arg[0]);
            $sql .= " WHERE " . join(" && ", $tmp);
        } else if (isset($arg[0]) && is_string($arg[0])) {
            if (!empty($arg[1])) {
                $sql .= $arg[1];
            }
        }

        return $this->pdo->query($sql)->fetchColumn();
    }
}

function to($url)
{
    header("location: ", $url);
}

function q($sql)
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=bq2";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetch();
}

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

$User = new DB('users');
$Article = new DB('articles');
$Poll = new DB('poll');
$Total = new DB('totals');
$Like = new DB('likes');

// 如果沒有這個session=新訪客
if(!isset($_SESSION['view'])){
    // 如果今天已經紀錄了 找到當前total數量 +1 存回去
    if($Total->count(['date'=>date('Y-m-d')])>0){
        $total = $Total->find(['date'=>date('Y-m-d')]);
        $total['total']++;
        $Total->save($total);
    } else {
        // 沒紀錄 新增 今天日期 total為1(第一個訪客)
        $Total->save((['date'=>date('Y-m-d'),'total'=>1]));
    }
    // 設session 這樣在同一個session就不會再加total數量
    $_SESSION['view']=1;
}
<?php

/**
 * 網站初始作業
 */
class BaseWork
{
    /**
     * SESSION設定時間
     * @param int $expire
     */
    public static function start_session($expire = 0)
    {
        if ($expire == 0) {
            $expire = ini_get('session.gc_maxlifetime');
        } else {
            ini_set('session.gc_maxlifetime', $expire);
        }

        if (empty($_COOKIE['PHPSESSID'])) {
            session_set_cookie_params($expire);
            session_start();
        } else {
            session_start();
            setcookie('PHPSESSID', session_id(), time() + $expire);
        }
    }
}

/**
 * 系統行為
 */
class SYSAction
{
    /**
     * 取出某資料表單筆資料
     * @param string $table_name 資料表名稱。
     * @param string $in_title 篩選條件欄位名稱。
     * @param string $val 篩選值。
     * @param string $out_title 輸出欄位。
     */
    public static function SQL_Data($table_name, $in_title, $val, $out_title)
    {
        MYPDO::$table = $table_name;
        MYPDO::$where = [
            $in_title => $val
        ];

        $row = MYPDO::first();
        if (!empty($row))
            return $row[$out_title];
    }

}

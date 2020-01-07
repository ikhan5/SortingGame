<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Creates the connection with the local
 *              Database.
 * Date Created: April 20th, 2019
 * Last Modified: April 25th, 2019
 * Recent Changes: Added Comments, removed
 *                 unnecessary code blocks
 */
class Database
{
    //__construct access modifier private and properties static
    private static $user = 'ikhan_admin';
    private static $pass = '';
    private static $db = 'SortingGame';
    private static $dsn = 'mysql:host=198.71.236.85;dbname=SortingGame'; //what db we are connecting to

    private static $db_connection;
    private function __construct()
    { }
    public static function getDB()
    {
        if (!isset(self::$db_connection)) {
            try {
                self::$db_connection = new PDO(self::$dsn, self::$user, self::$pass);
                self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $msg = $e->getMessage();
                include 'customerror.php';
                echo $msg;
                exit();
            }
        }
        return self::$db_connection;
    }
}

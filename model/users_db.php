<?php

class UserDB
{
    /* Description: Gets All the Users in the Database
 * Input: None
 * Output: All Users
 */
    public static function getAllUsers()
    {
        $dbcon = Database::getDB();
        $sql = "SELECT * from users";
        $pst = $dbcon->prepare($sql);
        $pst->execute();
        $users = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return $users;
    }
    /* Description: First checks to see if the user already exits in the 
                users table, if not, add them to the database with a
                default score of 0, as well as their access code. User is 
                activation status is also set to 0, until they enter the matching 
                access code sent in an email. Otherwise, the user is not added 
                to the database.
 * Input: Username, Passowrd, Email, and Access Code
 * Output: Boolean Response, if sql was executed successfully.
 */
    public static function insertUser($username, $password, $email, $access_code)
    {
        $dbcon = Database::getDB();
        $user_exists = UserDB::checkUsername($username);
        if ($user_exists) {
            return "User Exists";
        }
        $sql = "INSERT into users (username, email, password_hash, high_score, access_code, activated) values (:username,:email,:password, 0,:access,0)";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":email", $email);
        $pst->bindParam(":username", $username);
        $pst->bindParam(":password", $password);
        $pst->bindParam(":access", $access_code);
        $status = $pst->execute();
        $pst->closeCursor();

        return $status;
    }
    /* Description: Checks whether the username is in the users
                table
 * Input: Username
 * Output: Boolean Response, if username exists or not
 */
    public static function checkUsername($username)
    {
        $dbcon = Database::getDB();
        $sql = "SELECT * from users where username= :username";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":username", $username);
        $pst->execute();
        $exists = $pst->fetch(PDO::FETCH_OBJ);
        $pst->closeCursor();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }

    /* Description: Checks whether the email is in the users
                table
 * Input: Email
 * Output: Boolean Response, if email exists or not
 */
    public static function checkEmail($email)
    {
        $dbcon = Database::getDB();
        $sql = "SELECT * from users where email= :email";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":email", $email);
        $pst->execute();
        $exists = $pst->fetch(PDO::FETCH_OBJ);
        $pst->closeCursor();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }
    /* Description: Checks whether the user's account has been
                 activated or not
 * Input: Username
 * Output: Boolean Response, if account is activated
 */
    public static function checkActivation($username)
    {
        $dbcon = Database::getDb();
        $id = UserDB::getUserID($username);
        $sql = "SELECT activated from users where id = :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam("id", $id);
        $pst->execute();
        $a = $pst->fetch(PDO::FETCH_NUM);
        $pst->closeCursor();
        $activated = intval($a[0]);

        return $activated;
    }
    /* Description: Activates the user's acount i.e sets activated to 1
                and resets the access code to 0
 * Input: Username
 * Output: Boolean Response, if account is activated
 */
    public static function activateAccount($username)
    {
        $dbcon = Database::getDb();
        $id = UserDB::getUserID($username);
        $sql = "UPDATE users SET activated=1, access_code= 0 where id= :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id);
        $status = $pst->execute();
        $pst->closeCursor();

        return $status;
    }

    /* Description: Gets the user's ID based on username or email
 * Input: Username or Email
 * Output: User ID 
 */
    public static function getUserID($username)
    {
        $dbcon = Database::getDB();
        $sql = "SELECT id from users where username= :username OR email = :username";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":username", $username);
        $pst->execute();
        $id = $pst->fetch();
        $pst->closeCursor();

        return intval($id[0]);
    }
    /* Description: Gets the user's email based on username 
 * Input: Username 
 * Output: User Email 
 */
    public static function getUserEmail($username)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT email from users where id= :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id);
        $pst->execute();
        $user = $pst->fetch();
        $pst->closeCursor();

        return $user['email'];
    }

    /* Description: Gets the user's username based on either the user's
                email or username, whichever they used to log in.
 * Input: Username or Email
 * Output: Username
 */
    public static function getUsername($login)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($login);
        $sql = "SELECT username from users where id= :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id);
        $pst->execute();
        $user = $pst->fetch();
        $pst->closeCursor();

        return $user['username'];
    }

    /* Description: Gets the user's access_code based on username 
 * Input: Username 
 * Output: Access Code
 */
    public static function getAccessCode($username)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT access_code from users where id= :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id);
        $pst->execute();
        $user = $pst->fetch();
        $pst->closeCursor();

        return $user['access_code'];
    }
}

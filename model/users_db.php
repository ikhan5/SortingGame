<?php

class UserDB
{

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
                default score of 0. Otherwise, the user is not added 
                to the database.
 * Input: User Email
 * Output: Boolean Response, if sql was execute successfully.
 */
    public static function insertUser($username, $password)
    {
        $dbcon = Database::getDB();
        $user_exists = UserDB::checkUsername($username);
        if ($user_exists) {
            return "User Exists";
        }
        $sql = "INSERT into users (username, password_hash, high_score) values (:username,:password, 0)";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":username", $username);
        $pst->bindParam(":password", $password);
        $status = $pst->execute();
        $pst->closeCursor();
        return $status;
    }
    /* Description: Checks whether the user email is in the users
                table
 * Input: User Email
 * Output: Boolean Response, if user exists or not
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

    public static function getUserID($username)
    {
        $dbcon = Database::getDB();
        $sql = "SELECT id from users where username= :username";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":username", $username);
        $pst->execute();
        $id = $pst->fetch();
        $pst->closeCursor();

        return intval($id[0]);
    }

    public static function insertScore($username, $score)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "INSERT into scores (score, user_id) values (:score, :id)";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":score", $score);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $status = $pst->execute();
        $pst->closeCursor();

        UserDB::setHighScore($username, $score);

        return $status;
    }

    public static function getUserScores($username)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT * from scores where user_id = :id ORDER BY score DESC";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $pst->execute();
        $score = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return $score;
    }

    public static function getAllHighScores()
    {
        $dbcon = Database::getDB();
        $sql = "SELECT * from users ORDER BY high_score DESC";
        $pst = $dbcon->prepare($sql);
        $pst->execute();
        $high_scores = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return $high_scores;
    }

    public static function setHighScore($username, $score)
    {
        var_dump($score);
        exit();
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT high_score from users where id = :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $pst->execute();
        $hs = $pst->fetch(PDO::FETCH_OBJ);
        $pst->closeCursor();
        $high_score = intval($hs[0]);

        var_dump($high_score);
        die();

        if ($score > $high_score) {
            $sql = "UPDATE users SET high_score = :score where id=:id";
            $pst = $dbcon->prepare($sql);
            $pst->bindParam(":score", $score);
            $pst->bindParam(":id", $id, PDO::PARAM_INT);
            $pst->execute();
            $pst->closeCursor();
        }

        return $high_score;
    }
}

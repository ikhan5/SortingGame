<?php
class ScoreDB
{
    /* Description: Inserts the user's score into the database
                    and sends the values to the setHighScore
                    function.
 * Input: Username, Score
 * Output: Boolean Response, if sql was executed successfully.
 */
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
        ScoreDB::setHighScore($username, $score);

        return $status;
    }
    /* Description: Gets all the user's score from the database
                  the number of results returned is based on the
                  pagination desired on the specific page 
 * Input: Username, Page Number, Results Per Page
 * Output: Returns all the user scores within the desired range
 */
    public static function getUserScores($username, $pagenum, $per_page)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $offset = ($pagenum - 1) * $per_page;
        $sql = "SELECT * from scores where user_id = :id ORDER BY score DESC LIMIT $offset,:per_page";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $pst->bindParam(":per_page", $per_page, PDO::PARAM_INT);
        $pst->execute();
        $score = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return $score;
    }
    /* Description: Gets the highest high score of all the 
                    users in the database
 * Input: None
 * Output: Returns the highest high score
 */
    public static function getHighestScore()
    {
        $dbcon = Database::getDB();
        $sql = "SELECT high_Score from users ORDER BY high_Score DESC";
        $pst = $dbcon->prepare($sql);
        $pst->execute();
        $high_scores = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return $high_scores[0];
    }

    /* Description: Gets the total amount of user's score from the database
 * Input: Username
 * Output: Returns the number of scores the user has in the database
 */
    public static function getTotalScoresCount($username)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT * from scores where user_id = :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $pst->execute();
        $scores = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return count($scores);
    }

    /* Description: Gets the total amount of user's from the database
 * Input: None
 * Output: Returns the number of users in the database, which is 
 *         equivalent to the amount of high scores in the database
 *         (one per user)
 */
    public static function getTotalHighScoreCount()
    {
        $dbcon = Database::getDB();
        $sql = "SELECT * from users";
        $pst = $dbcon->prepare($sql);
        $pst->execute();
        $high_scores = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return count($high_scores);
    }
    /* Description: Gets all the high scores from all the user's in the database
 * Input: Page Number, Results Per Page
 * Output: Returns the number of users in the database, which is 
 *         equivalent to the amount of high scores in the database
 *         (one per user)
 */
    public static function getAllHighScores($pagenum, $per_page)
    {
        $dbcon = Database::getDB();
        $offset = ($pagenum - 1) * $per_page;
        $sql = "SELECT * from users ORDER BY high_score DESC LIMIT $offset,:per_page";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":per_page", $per_page, PDO::PARAM_INT);
        $pst->execute();
        $high_scores = $pst->fetchAll(PDO::FETCH_OBJ);
        $pst->closeCursor();

        return $high_scores;
    }
    /* Description: Gets the user's high score from the database
 * Input: Username
 * Output: Returns the user's high score
 */
    public static function getHighScore($username)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT high_score from users where id = :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $pst->execute();
        $hs = $pst->fetch(PDO::FETCH_ASSOC);
        $pst->closeCursor();
        $high_score = intval($hs['high_score']);

        return $high_score;
    }

    /* Description: Sets the user's high score based on the latest score
                    as well as the user's previous high score. If the new
                    score is higher than the user's previous high score, the
                    new score is taken as the high score.
 * Input: Username, Score
 * Output: Returns the user's high score
 */
    public static function setHighScore($username, $score)
    {
        $dbcon = Database::getDB();
        $id = UserDB::getUserID($username);
        $sql = "SELECT high_score from users where id = :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(":id", $id, PDO::PARAM_INT);
        $pst->execute();
        $hs = $pst->fetch(PDO::FETCH_ASSOC);
        $pst->closeCursor();
        $high_score = intval($hs['high_score']);

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

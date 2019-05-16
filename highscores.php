<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for all the user's high scores they've accumulated. The 
 *              scores are displayed in descending order (highest score first)
 *              and the first thress scores are highlighted. Pagination based on the number
 *              of scores in the database and desired results per page.
 * Date Created: May 12th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Added comments
 */
session_start();
require_once 'model/Database.php';
require_once 'model/scores_db.php';
require_once 'model/users_db.php';
include("header.php");

$pagenum = $_GET['page'];
$per_page = 5;

$s = new ScoreDB();
$high_scores = $s->getTotalHighScoreCount();
$pagination_tabs = ceil($high_scores / $per_page);
$scores = $s->getAllHighScores($pagenum, $per_page);


echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
?>
<div class="container-fluid highscores_container">
    <div class="table-responsive-sm">
        <table class="highscores table table-hover text-center table-striped table-dark my-5 mx-0 mx-auto">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>High Score</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1 + (($pagenum - 1) * $per_page);
                foreach ($scores as $score) {
                    if ($i == 1 && $pagenum == 1) {
                        echo "<tr class='bg-warning text-dark'>";
                        echo "<td class='rank'><i class='fas fa-crown'></i> Ruler of the 7 Kingdoms</td>";
                        $i++;
                    } elseif ($i == 2 && $pagenum == 1) {
                        echo "<tr class='bg-secondary'>";
                        echo "<td class='rank'>Ruler of Winterfell</td>";
                        $i++;
                    } elseif ($i == 3 && $pagenum == 1) {
                        echo "<tr class='third'>";
                        echo "<td class='rank'>Ruler of Westeros</td>";
                        $i++;
                    } else {
                        echo "<tr>";
                        echo "<td class='ranks'>" . $i++ . "</td>";
                    }
                    echo "<td>" . $score->high_score . "</td>";
                    echo "<td>" . $score->username . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Highcores results pages">
        <ul class="pagination justify-content-center">
            <?php
            for ($i = 1; $i <= $pagination_tabs; $i++) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>
<?php
include("footer.php");
?>
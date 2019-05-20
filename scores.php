<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for the User's scores they've accumulated. The 
 *              scores are displayed in descending order (highest score first)
 *              and the first score is highlighted. Pagination based on the number
 *              of scores in the database and desired results per page.
 * Date Created: May 12th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Added comments
 */
session_start();
require_once 'model/Database.php';
require_once 'model/users_db.php';
require_once 'model/scores_db.php';
include("header.php");

$pagenum = $_GET['page'];
$username = $_SESSION['username'];
$per_page = 10;

$u = new UserDB();
$s = new ScoreDB();
$activated = $u->checkActivation($username);
$scorenum = $s->getTotalScoresCount($username);
$pagination_tabs = ceil($scorenum / $per_page);
$scores = $s->getUserScores($username, $pagenum, $per_page);

if (!isset($username)) {
    header("Location: index.php");
} elseif (!$activated) {
    header("Location: activate.php");
}
echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
?>
<div class="container-fluid scores_container">
    <h2 class="display-5 text-light mt-2 text-center">My Scores</h2>
    <div class="table-responsive-sm">
        <table class="scores table table-hover text-center table-striped table-dark my-3 mx-2 mx-auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Score</th>
                    <th>Date Achieved</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1 + (($pagenum - 1) * $per_page);
                foreach ($scores as $score) {
                    if ($i == 1 && $pagenum == 1) {
                        echo "<tr class='bg-warning text-dark'>";
                        echo "<td class='rank'><i class='fas fa-crown'></i> High Score</td>";
                        $i++;
                    } else {
                        echo "<tr>";
                        echo "<td class='ranks'>" . $i++ . "</td>";
                    }
                    echo "<td>" . $score->score . "</td>";
                    echo "<td>" . substr($score->date, 0, 10) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Scores results pages">
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
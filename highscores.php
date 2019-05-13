<?php
session_start();
require_once 'model/Database.php';
require_once 'model/users_db.php';
include("header.php");

$s = new UserDB();
$scores = $s->getAllHighScores();

echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
?>

<div class="table-responsive-sm">
    <table class="table table-hover text-center table-striped table-dark my-5 w-75 mx-0 mx-auto">
        <thead>
            <tr>
                <th>Rank</th>
                <th>High Score</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($scores as $score) {
                if ($i == 1) {
                    echo "<tr class='bg-warning text-dark'>";
                    echo "<td><i class='fas fa-crown'></i> Ruler of the 7 Kingdoms</td>";
                    $i++;
                } elseif ($i == 2) {
                    echo "<tr class='bg-secondary'>";
                    echo "<td>Ruler of Winterfell</td>";
                    $i++;
                } elseif ($i == 3) {
                    echo "<tr class='third'>";
                    echo "<td>Ruler of Westeros</td>";
                    $i++;
                } elseif ($i == count($scores) && $i > 3) {
                    echo "<tr class='last'>";
                    echo "<td>Last Place</td>";
                    $i++;
                } else {
                    echo "<tr>";
                    echo "<td>" . $i++ . "</td>";
                }
                echo "<td>" . $score->high_score . "</td>";
                echo "<td>" . $score->username . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include("footer.php");
?>
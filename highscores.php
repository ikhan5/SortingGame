<?php
session_start();
require_once 'model/Database.php';
require_once 'model/users_db.php';
include("header.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$s = new UserDB();
$scores = $s->getHighScores();

echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
?>

<div class="table-responsive-sm">
    <table class="table table-hover text-center table-striped table-dark my-3 w-50 mx-0 mx-auto">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Score</th>
                <th>Date Achieved</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($scores as $score) {
                if ($i == 1) {
                    echo "<tr class='bg-warning'>";
                    echo "<td>High Score</td>";
                    $i++;
                } else {
                    echo "<tr>";
                    echo "<td>" . $i++ . "</td>";
                }
                echo "<td>" . $score->score . "</td>";
                echo "<td>" . $score->score . "</td>";
                echo "<td>" . substr($score->date, 0, 10) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include("footer.php");
?>
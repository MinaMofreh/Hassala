<?php
session_start();
if(isset($_SESSION['student']) || isset($_SESSION['instructor'])){
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .'initialize.inc.php');
if (isset($_SESSION['student'])){
    $codeforces_handle = $_SESSION['codeforces_handle'];
} else {
    $codeforces_handle = $_SESSION['cf_handle'];
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="container">
            <h1><?php echo $codeforces_handle;?></h1>
            <?php
            $url_problemset = 'http://codeforces.com/api/problemset.problems?tags=implementation';
            $curl_problemset = curl_init($url_problemset);
            curl_setopt($curl_problemset, CURLOPT_RETURNTRANSFER, $url_problemset);
            $problem_set = json_decode(curl_exec($curl_problemset));
            @curl_close($curl_problemset);

            $problem_count = count($problem_set->result->problems);
            // -----------------------------
            $url_user = 'http://codeforces.com/api/user.status?handle='.$codeforces_handle.'&from=1';
            $curl_user = curl_init($url_user);
            curl_setopt($curl_user, CURLOPT_RETURNTRANSFER, $url_user);
            $user_status = json_decode(curl_exec($curl_user));
            @curl_close($curl_user);
            ?>

            <table data-toggle="table"
                   data-classes="table table-hover table-responsive"
                   data-row-style="rowStyle"
                   data-striped="false"
                   data-sort-name="Quality"
                   data-sort-order="desc"
                   data-pagination="true"
                   >
                <thead>
                    <tr>

                        <th class="col-xs-1" >#</th>
                        <th class="col-xs-1">Problem Name</th>
                        <th class="col-xs-1">Online Judge</th>
                        <th class="col-xs-1">Contest</th>
                        <th class="col-xs-1" data-sortable="true">Difficulty Level</th>
                        <th class="col-xs-1">Solved Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < $problem_count; $i++) {
                        $solved_problem = false;
                        $problem_url = 'http://codeforces.com/problemset/problem/' . $problem_set->result->problems[$i]->contestId . '/' .
                                $problem_set->result->problems[$i]->index;
                        $user_solved_count_problems = count($user_status->result);
                        for ($j = 0; $j < $user_solved_count_problems;$j++){
                        if ($user_status->result[$j]->problem->name == $problem_set->result->problems[$i]->name) {
                            if ($user_status->result[$j]->verdict == "OK")
                                $solved_problem = true;
                        }
                        }
                        if ($solved_problem)
                            echo '<tr class="bg-success">';
                        else    
                            echo '<tr>';
                        echo '
                        <td>' . $i . '</td>
                        <td><a href="' . $problem_url . '"target="_blank">' . $problem_set->result->problems[$i]->name . '</a></td>
                        <td>CODEFORCES</td>
                        <td>' . $problem_set->result->problems[$i]->contestId . '</td>
                        <td><strong>' . $problem_set->result->problems[$i]->index . '</strong></td>
                        <td>x' . $problem_set->result->problemStatistics[$i]->solvedCount . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
<?php include_once 'templates' . DIRECTORY_SEPARATOR . 'footer' . DIRECTORY_SEPARATOR . 'footer.inc.php';} else {
    header("Location: home.php");
    exit();
}
?>


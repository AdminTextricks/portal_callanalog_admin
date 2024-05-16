<?php
include 'connection.php';

if ($_SESSION['userroleforpage'] == 1) {
    $sql_chart = "SELECT COUNT(*) AS count, disposition, calldate, duration FROM cc_cdr where calldate > NOW()- interval 1 day GROUP BY disposition, calldate, duration";
} else {
    $userId = $_SESSION['login_user_id'];
    $sql_chart = "SELECT COUNT(*) AS count, disposition, calldate, duration FROM cc_cdr WHERE user_id = '$userId' && calldate > NOW()- interval 1 day GROUP BY disposition, calldate, duration";
}

$result_chart = mysqli_query($connection, $sql_chart);

$chartData = array(
    array('Date', 'Duration', 'Answer', 'No Answer', 'Abandoned')
);

while ($row = mysqli_fetch_assoc($result_chart)) {
    $date = $row['calldate'];
    $duration = (int)$row['duration']; // Convert the duration to an integer
    $answerCount = 0;
    $noAnswerCount = 0;
    $abandonedCount = 0;

    if ($row['disposition'] === 'ANSWER') {
        $answerCount = (int)$row['count'];
    } elseif ($row['disposition'] === 'NOANSWER') {
        $noAnswerCount = (int)$row['count'];
    } elseif ($row['disposition'] === 'failed') {
        $abandonedCount = (int)$row['count'];
    }

    $found = false;
    foreach ($chartData as &$data) {
        if ($data[0] === $date && $data[1] === $duration) {
            $data[2] += $answerCount;
            $data[3] += $noAnswerCount;
            $data[4] += $abandonedCount;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $chartData[] = array($date, $duration, $answerCount, $noAnswerCount, $abandonedCount);
    }
}

echo json_encode($chartData);
?>
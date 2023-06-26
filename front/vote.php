<h1>投票</h1>
<?php

/*
    ../,./  -> 相對位置
    / -> 絕對位置
*/
//$topic=$pdo->query("select * from `topics` where `id`='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);
$Subject = new Subject;
$topic = $Subject->find($_GET['id']);
// dd($topic);
// dd($Subject->options());
?>
<h2><?= $topic->subject; ?></h2>
<?php
if (!empty($topic->image)) {
    echo "<img src='./upload/{$topic->image}' style='width:450px;height:300px'>";
}
?>

<form action="./api/vote.php" method="post">
    <ul>
        <?php
        foreach ($Subject->options() as $idx => $opt) {
            echo "<li>";
            switch ($topic->type) {
                case 1:
                    echo "<input type='radio' name='desc' value='{$opt['id']}'>";
                    break;
                case 2:
                    echo "<input type='checkbox' name='desc[]' value='{$opt['id']}'>";
                    break;
            }

            echo "<span>" . ($idx + 1) . ". </span>";
            echo "<span>{$opt['description']}</span>";
            echo "</li>";
        }
        ?>
    </ul>


    <div>
        <input type="hidden" name="subject_id" value="<?= $_GET['id']; ?>">
        <input type="submit" value="投票">
        <input type="button" value="取消">
    </div>

</form>
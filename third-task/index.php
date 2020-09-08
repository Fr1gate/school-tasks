<?php
function solve() {
    if (!isset($_GET["N"]) || !isset($_GET["M"])) {
        return;
    }

    $n = $_GET["N"];            // всего чисел
    $k = (string) $_GET["K"];   // нужное число
    $pos = 1;

    for ($i = 1; $i <= $n; $i++) {
        if (strcmp((string)$i , $k) < 0) {
            $pos++;
        }
    }

    return $pos;    
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Braind вотрое задание</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Помочь ученикам в изучении странной математики</h2>
        <p>В связи с реформой образования был введен новый предмет, на котором изучаются различные альтернативные науки. Одной из таких 
        наук является странная математика. Её основное отличие от обычной математики в том, что числа в ней упорядочены не по возрастанию, 
        а лексикографически, то есть как в словаре (сначала по первой цифре, затем, при равной первой цифре – по второй, и так далее). 
        Кроме того, рассматривается не бесконечное множество натуральных чисел, а лишь первые n чисел. Так, например, если n=11, то числа 
        в странной математике оказываются упорядочены следующим образом: 1, 10, 11, 2, 3, 4, 5, 6, 7, 8, 9.</p>
        <p>Помоги ученикам в изучении этой науки – напиши программу, которая по заданному n находит место заданного числа k в порядке, определенном в странной математике.</p>
        <p>Например, если n=11 и k=2, программа должна выдать в качестве ответа 4.</p>
        <p>Пожалуйста, не используй стандартную функцию сортировки, напиши свою.</p>
        <form action="script.php" method="get">
            <label for="N">Всего чисел (N):<br><input type="number" name="N" min="0" required></label><br>
            <label for="M">Нужное число (K):<br><input type="number" name="K" min="0" required></label><br>
            <input type="submit" value="Решить">
        </form>
        <h3><?=solve()?></h3>
    </div>
</body>
</html>


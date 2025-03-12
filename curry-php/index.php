<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレー注文フォーム</title>
</head>
<body>
    <h1>カレー注文フォーム</h1>
    <form action="order.php" method="post">
        <h2>カレーの種類</h2>
        <select name="curry">
            <option value="ビーフカレー">ビーフカレー</option>
            <option value="チキンカレー">チキンカレー</option>
            <option value="野菜カレー">野菜カレー</option>
        </select>
        <h2>トッピング（１０個まで）</h2>
        <p><input type="checkbox" name="topping[]" value="チーズ">チーズ（100円）</p>
        <p><input type="checkbox" name="topping[]" value="エビフライ">エビフライ（150円）</p>
        <p><input type="checkbox" name="topping[]" value="とんかつ">とんかつ（200円）</p>
        <br>
        <input type="submit" value="注文">
    </form>
</body>
</html>
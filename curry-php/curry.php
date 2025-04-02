<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレー注文システム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

session_start();
Class Curry{
    protected string $ru = ''; //ルーの初期化
    public int $count;
    public static int $total = 0;
    private static array $prices = ['ビーフカレー' => 800, 'チキンカレー' => 750, '野菜カレー' => 700];
    private array $Toppings = ['卵' =>50,'チーズ' => 100,'納豆'=> 100,'からあげ'=> 50, 'エビフライ' => 150, 'とんかつ' => 200, 'いぬセット' => 500];
    private array $selectedToppings = []; //選択されたトッピングとその数量
    
    // カレーの皿数を初期化する
    public function __construct(){
        $this->count = 0;
    }

    // 合計皿数をインクリメント
    public static function setTotalCount(){
        self::$total++;
    }

    // ルーの種類を設定する
    public function setCurry(string $ru){
        $this->ru = $ru;
        $this->count++;
        self::$total++;
    }

    // 選択されたトッピングとその数量を設定
    public function addTopping(array $selectedToppings){
        $this->selectedToppings = $selectedToppings;
    }

    public function show(){
        if(!empty($this->ru)){
            echo '<p>'.$this->ru.'の注文を承りました。</p>';
        }else{
            echo '<p>トッピングのみの注文です。</p>';
        }
        // トッピング情報
        if(!empty($this->selectedToppings)){
            echo'<p>トッピング</p>';
            $toppingCount = 0;
            $toppingTotal = 0;
            foreach($this->selectedToppings as $topping => $quantity){
                echo '<p> -'.$topping.'('.$this->Toppings[$topping].'円)</p>';
                $toppingCount++;
                $toppingTotal += $this->Toppings[$topping] * $quantity;
            }
            echo '<p>トッピング合計: '.$toppingCount.'個,'.$toppingTotal. '円</p>';
        }
        echo '<p>トータル'.$this->count.'皿め</p>';
        echo '<p>小計：'.$this->getPrice().'</p>';
    }

    // 合計金額を計算する
    public function getPrice(){
        $price = 0;
        if(!empty($this->ru) && isset(self::$prices[$this->ru])){
            $price += self::$prices[$this->ru] * $this->count;
        }
        foreach($this->selectedToppings as $topping => $quantity){
            $price += $this->Toppings[$topping] * $quantity;
        }
        return $price;
    }

    // selectedTopping を取得するメソッドを追加
    public function getSelectedToppings(){
    return $this->selectedToppings;
    }
    
    // Toppingsプロパティを取得するメソッドを追加
    public function getToppings(){
        return $this->Toppings;
    }
}


// セッション変数の初期化
if(!isset($_SESSION['order'])){
    $_SESSION['order'] = [];
}

// 確定ボタンが押された時の処理：注文情報をセッションに追加し、セッション変数をクリア
if(!isset($_POST['confirm'])){
    $curry = new Curry();
    $curry->setCurry($_SESSION['temp_curry'] ?? '');
    $curry->addTopping($_SESSION['temp_toppings'] ?? []);
    $_SESSION['order'][] = $curry;
    unset($_SESSION['temp_curry']);
    unset($_SESSION['temp_toppings']);
    // セッション変数をクリア
    foreach(['卵','チーズ','なっとう','からあげ','エビフライ','とんかつ','いぬセット'] as $topping ){
        unset($_SESSION['toppings'][$topping]);
    }
}


// 注文削除機能
if(isset($_POST['delete'])){
    $indexToDelete = $_POST['delete'];
    if(isset($_SESSION['order'][$indexToDelete])){
        unset($_SESSION['order'][$indexToDelete]);
        $_SESSION['order'] = array_values($_SESSION['order']);
    }
}


// トッピングの追加ボタンが押された時の処理：セッション変数にトッピングの数量を保存
if(isset($_POST['topping'])){
    $topping = $_POST['topping'];
    $_SESSION['toppings'][$topping] = ($_SESSION['toppings'][$topping] ?? 0) + 1;
}

// 合計金額の計算
$totalAmount = 0;
$totalCount = 0;
foreach($_SESSION['order'] as $item){
    $totalAmount += $item->getPrice();
    $totalCount += $item->count; //合計皿数を加算
}
?>

<form method="post">
        <label><button type="submit" name="curry" value="ビーフカレー">ビーフカレー<br>800円</button></label>
        <label><button type="submit" name="curry" value="チキンカレー">チキンカレー<br>750円</button></label>
        <label><button type="submit" name="curry" value="野菜カレー">野菜カレー<br>700円</button></label>
        <br>
        <?php foreach (['卵','チーズ','納豆','からあげ','エビフライ','とんかつ','いぬセット'] as $topping) : ?>
        <label>
            <?php echo $topping; ?>(<?php echo (new Curry())->getToppings()[$topping]; ?> 円)
            <button type="submit" name="topping" value="<?php echo $topping; ?>">追加</button>
            <?php echo $_SESSION['toppings'][$topping] ?? 0; ?>個
        </label><br>
        <?php endforeach; ?>
        <button type="submit" name="preview">確認</button>
    </form>

<?php if(isset($_POST['preview'])) : ?>
    <h2>注文内容確認</h2>
    <?php 
    // トッピングが10個超えないようにするチェック
    $totalToppings = array_sum($_SESSION['toppings'] ?? []);
    if($totalToppings > 10){
        echo '<p>トッピングは10個までです。</p>';
    }else{
    $_SESSION['temp_curry'] = $_POST['curry'] ?? '';
    $_SESSION['temp_toppings'] = $_SESSION['toppings'] ?? [];
    $tempCurry = new Curry();
    $tempCurry->setCurry($_SESSION['temp_curry']);
    $tempCurry->addTopping($_SESSION['temp_toppings']);
    $tempCurry->show();
    // トッピングの合計個数を表示
    echo '<p>トッピング個数：'.$totalToppings.'個</p>';
    ?>
    <form method="post">
        <button type="submit" name="confirm">確定</button>
    </form>
    <?php
    }
    ?>
<?php endif; ?>

    <h2>注文内容</h2>
<?php

foreach($_SESSION['order'] as $index => $item){ //インデックスを取得
    $item->show();
    $toppingCount = array_sum(array_values($item->getSelectedToppings()));
    echo '<p>トッピング個数：'.$toppingCount.'個</p>';
    echo '<form method="post"><button type="submit" name="delete" value="'.$index.'">削除</button></form>';
    echo '<hr>';
}   
echo '<p>合計皿数：'.$totalCount.'皿</p>';
echo '<p>合計金額：'.$totalAmount.'円</p>';
?>
</body>
</html>
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
    private array $Toppings = ['卵' =>50,'チーズ' => 100,'納豆'=> 100,'からあげ'=> 50, 'エビフライ' => 150, 'とんかつ' => 200];
    private array $selectedToppings = [];
    
    public function __construct(){
        $this->count = 0;
        echo '<p>カレーをカスタムします。</p>';
    }

    public static function setTotalCount(){
        self::$total++;
    }

    // setCurry誕生
    public function setCurry(string $ru)
    {
        //セットを許可するカレーリストを作成
        $ruList = ['ビーフカレー','チキンカレー','野菜カレー'];
        //正しいルーかチェックする変数
        $isCheck = false;
        foreach($ruList as $val){
            if($ru === $val){
            $this->ru = $ru;
            $this->count++;
            self::$total++;
            $isCheck = true;
            break; //繰り返し終了
        }
        }
    }

    public function show(){
        echo '<p>'.$this->ru.'の注文を承りました。';
        // トッピング情報
        if(!empty($this->selectedToppings)){
            echo'<p>トッピング</p>';
            $toppingCount = 0;
            $toppingTotal = 0;
            foreach($this->selectedToppings as $topping){
                echo '<p> -'.$topping.'('.self::$toppings[$topping].'円)</p>';
                $toppingCount++;
                $toppingTotal += self::$toppings[$topping];
            }
            echo '<p>トッピング合計: '.$toppingCount.'個,'.$toppingTotal. '円</p>';
        }
        echo '<p>トータル'.self::$total.'皿め</p>';
        echo '<p>小計：'.$this->getPrice().'</p>';
        echo '<hr>';
    }

    // 価格を取得するメソッドを追加
    public function getPrice(){
        return self::$prices[$this->ru] * $this->count;
    }
    
}

// カウントの初期化
if(!isset($_SESSION['order'])){
    $_SESSION['order'] = [];
}


if(isset($_POST['curry'])){
    $curry = new curry();
    $curry->setCurry($_POST['curry']);
    $_SESSION['order'][] = $curry;
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
        <button type="submit" name="curry" value="ビーフカレー">ビーフカレー<br>800円</button>
        <button type="submit" name="curry" value="チキンカレー">チキンカレー<br>750円</button>
        <button type="submit" name="curry" value="野菜カレー">野菜カレー<br>700円</button>
    </form>

    <h2>注文内容</h2>
<?php

foreach($_SESSION['order'] as $item){
    $item->show();
}
echo '<p>合計皿数：'.$totalCount.'皿</p>';
echo '<p>合計金額：'.$totalAmount.'円</p>';
?>
</body>
</html>
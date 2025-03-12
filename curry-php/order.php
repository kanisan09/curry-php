<?php

Class Curry{
    protected string $ru;
    private int $count;
    public static int $total = 0;
    private array $topping;
    private int $price;
    private int $maxTopping = 10;
    
    public function __construct(){
        $this->count = 0;
        $this->topping = [];
        $this->price = 0;
        echo '<p>カレーをカスタムします。</p>';
    }

    public static function setTotalCount(){
        self::$total++;
    }

    public function setCurry(string $ru)
    {
        //セットを許可するカレーリストを作成
        $ruList = ['ビーフカレー' => 900,'チキンカレー' => 850,'野菜カレー' => 850];
        if(array_key_exists($ru, $ruList)){
            $this->ru = $ru;
            $this->price = $ruList[$ru];
            $this->count++;
            self::$total;
            echo '<p>'. $ru . 'を選択しました。</p>';
        }else{
            echo '正しいカレーを選択してください。';
        }
    }

    public function addTopping(string $topping){
        $toppingList =  ['チーズ' => 100, 'エビフライ' => 150, 'とんかつ' => 200];
        if(count($this->topping) >= $this->maxTopping){
            echo '<p>トッピングは'.$this->maxTopping.'個までです</p>';
            return;
        }
        if(array_kye_exists($topping, $toppingList)){
            $this->topping[] = $topping;
            $this->topping += $toppingList[$topping];
            echo '<p>'. $topping . '追加しました。</p>';
        }else{
            echo '正しいトッピングを選択してください。';
        }
    }

    public function show(){
        echo '<p>'.$this->ru.'の注文を承りました。';
        echo '<p>'.$this->count.'個め</p>';
        echo '<p>トッピング：'. implode(',', $this->topping). '</p>';
        echo '<p>合計金額：'.$this->price. '円</p>';
        echo '<p>トータル'.self::$total.'皿め</p>';
    }
    
}

$curry = new Curry();

if(isset($_POST['curry'])){
    $curry->setCurry($_POST['curry']);
}

if(isset($_POST['topping'])){
    foreach($_POST['topping'] as $topping){
        $curry->addTopping($topping);
    }
}

$curry->show();
?>
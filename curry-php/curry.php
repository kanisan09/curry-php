<?php

Class Curry{
    protected string $ru;
    private int $count;
    public static int $total = 0;
    
    public function __construct(){
        $this->count = 0;
        echo '<p>カレーをカスタムします。</p>';
    }

    public static function setTotalCount(){
        self::$total++;
        echo '<p>'.self::$total.'</p>';
    }

    public function setCurry(string $ru)
    {
        //セットを許可するカレーリストを作成
        $ruList = ['ビーフカレー','チキンカレー','ハヤシライス'];
        //正しいルーかチェックする変数
        $isCheck = false;
        foreach($ruList as $val){
            if($ru === $val){
            $this->ru = $ru;
            $this->count++;
            self::$total;
            $isCheck = true;
            break;
        }
        }
        if(!$isCheck){
            echo '正しいカレーをセット選択してください。';
        }else{
            echo '<p>'.$ru.'を選択しました。</p>';
        }
    }

    public function show(){
        echo '<p>'.$this->ru.'の注文を承りました。';
        echo '<p>'.$this->count.'個め</p>';
        echo '<p>トータル'.self::$total.'皿め</p>';
    }
    
}
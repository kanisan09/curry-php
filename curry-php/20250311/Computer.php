<?php
// カプセル化

Class Computer {
    protected string $os;   //protected 自クラス及びサブクラスからアクセス可
    private int $count;
    public static int $total = 0;


    public function __construct(){
        $this->count = 0;
        echo '<p>コンピューターを作成します。</p>';
    }

    public static function setTotalCount(){
        // static(静的)なプロパティにアクセスするにはself()
        self::$total++;
        echo '<p>'.self::$total.'</p>';
    }


    // setOSメソッドを作成
    // 引数でOS名を渡す（受け取る）
    public function setOS(string $os) :void
    {  
        // バリデーション（Validation）
        // セットを許可するOSリストを作成
        $osList = ['MacOS', 'Windows11', 'CentOS'];
        // 正しいOSかどうかチェックするための変数
        $isCheck = false;
        foreach($osList as $val){
            if($os === $val){
                // 正しいOSのため、引数の値をプロパティに代入
                $this->os = $os;
                $this->count++;
                self::$total;
                // チェック用変数をtrueにする
                $isCheck = true;
                break;  //繰り返し文を終了
            }
        }
        if(!$isCheck){
            echo '正しいOSをセットしてください。';
        }else{
            echo '<p>'. $os.'をセットしました</p>';
        }
    }

    // showメソッドを作成
    // 引数なし
    // setOS()をセットされたOSを呼び出力させる
    // 「windows11のPCが作成されました。」
    public function show(){
        echo '<p>'.$this->os.'のPCが作成されました。</p>';
        echo '<p>'.$this->count.'台目</p>';
        echo '<p>トータル'.self::$total.'台</p>';
    }
}


// staticの便利なところ
// Computer::setTotalCount();
// Computer::setTotalCount();
// Computer::setTotalCount();
// Computer::setTotalCount();


// // Computerクラスをインスタンス化
// // ↓これでコンストラクタが実行される
// $computer = new Computer();
// // setOS()を実行し、「windows11をセットしました。」と出力
// $computer->setOS('Windows11');
// $computer->setTotalCount();
// // $computer->os = 'MacOS';
// $computer->show();

// $computer->setOS('Windows11');
// $computer->setTotalCount();
// $computer->show();

// $mac = new Computer();
// $mac->setOS('MacOS');
// $computer->setTotalCount();
// $mac->show();

// $computer->setOS('Windows11');
// $computer->setTotalCount();
// $computer->show();

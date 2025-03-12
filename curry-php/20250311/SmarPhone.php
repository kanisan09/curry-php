<?php

require 'Computer.php';

// 継承元（computer）スーパークラス（親クラス）
// 継承先（SmartPhone）(子クラス)
// extend ~  ↓スマホくらすはコンピュータクラスを継承します
class SmartPhone extends Computer{
    // private string $os;
    private bool $isNotification;

    // 引数で渡された値をプロパティ＄osに代入する
    // setOS()メソッドを作成

    // public function setOS($os){
    //     $this->os = $os;
    // }

    //引数なしのshow()メソッドを作成します。
    // 「windows11のPCが作成されました。」 を出力
    // Override(スーパークラスのメゾットを上書き)
    public function show(){
        echo '<p>'.$this->os.'のPCが作成されました</p>';

        if($this->isNotification){
            echo'<p>通知します</p>';
        }else{
            echo '<p>通知しません。</p>';
        }
    }

    // bool型のisNotificationプロパティを作成
    // 関数でbool型の変数requestを持つ
    // checkNotification()メソッドを作成

    public function checkNotification($request){

    // 引数で渡された変数requestがtrueまたはfalseの場合、
    // isNotificationプロパティに代入
    if($request === true || $request === false ){
        $this->isNotification = $request;
    }else{
         // それ以外の場合、「正しい値を代入してください」を出力
        echo '正しい値を入力してください';
    }

    }
}

$sp = new SmartPhone();
$sp->setOS('MacOS');
$sp->checkNotification(false);
$sp->show();


<p>課題：標準入力から正の整数 n が与えられるので、n 以上かつ n に一番近い値のカプレカ数を求め、標準出力
に出力するプログラムを作成してください。</p>
<p>条件：0 ≦ n ≦ 100,000,000,000,000</p>


<form method="GET" action="">
  <input type="text" name="num" >
  <input type="submit" name="btn_submit" value="カプレカ数を求める">
</form>
<?php
    $in_number = null;
    // inputのtype submitを押されればGETメソッドでnumの値が送られてくる。
    // issetは指定した変数に値があれば実行する。
    if(isset($_GET['num'])){
      // 入力した値を$in_numberという変数に入れる。
      $in_number = $_GET['num'];
      // 1,000などの(,)を抜く処理
      $in_number = preg_replace('/(,)/', '', $in_number);
      // 全角数字を半角数字に処理
      $in_number = mb_convert_kana($in_number, "n");
      // preg_matchは正規表現で使うことが多い今回は行頭から行末まで０〜９の数字で０〜１５桁がマッチすれば処理をするようにしている。
      if (preg_match("/^[0-9]{0,15}$/",$in_number) ) {
        // $ketaという変数は桁数を調べるために宣言した。
        $keta = 0;
        // strlenという関数は変数の値をを桁数として返す（返り値）。
        $keta = strlen($in_number);
        
        // それぞれの変数の値をリセット
        $array = array();
        $min = array();
        $mix = array();
        $value = array();
        $answer = NULL;

        // 第一回
        // kapreka_sanという関数を呼び出して引数として$in_numberを指定。
        // kapreka_sanの処理の返り値（$result）を$kapreka_numberという変数に入れる。
        $kapreka_number = kapreka_san($in_number);

        // もし、最初の入力された値が第一回目の値より大きければ$answerという変数に入れる。
        if ($in_number <= $kapreka_number ){
          $answer = $kapreka_number;
        }
        // whileで値を使うために前回のカプレカ数を保存する変数を定義
        // 初期値を-1に始めにbreakされないようにする。
        $before_kapreka=-1;
        $i = 0 ;

        // while文で条件が満たすまで処理をループする。
        // 条件：$before_kaprekaの値と$kapreka_numberの値が等しくない かつ ループが２０するまで処理
        while($before_kapreka!=$kapreka_number && $i < 20){

          $before_kapreka=$kapreka_number;
          // もし、変数である$before_kaprekaの桁数と変数である$ketaの桁数が等しくなければ処理。
          if($keta != strlen($before_kapreka)){
            // 一番左にゼロ埋めする処理。例えば100を入力して99という結果がでれば次に099として処理してほしいから。
            $before_kapreka = str_pad($before_kapreka, $keta,0,STR_PAD_LEFT);
          }
          $kapreka_number = kapreka_san($before_kapreka);

          // もし、始めに入力された値（$in_number）が直近の$kapreka_number(55行目)より大きければ処理。
          if ($in_number <= $kapreka_number ){
            if($answer == NULL){
              $answer = $kapreka_number;
            }
            // 59行目が一致しなけば処理
            elseif($kapreka_number <= $answer ){
              $answer = $kapreka_number;
            }
          }
          $i++;
        }
        // $in_numberの値が$kapreka_numberの値より大きければ答えがないように処理。課題の条件と一致しないため。
        if($answer == NULL){
          echo '答えはありません。';
        }
        else{
          echo "答え".$answer;
        }
        
      } else {
        echo '警告：0以上100,000,000,000,000で半角数字で入力してください。'."<br>";
      }
      }
    
    // kapreka_sanという関数を作成。引数は$numberで一回目の処理では$in_numberが入り以降ループでは$before_kaprekaが入る。
    function kapreka_san($number){
      // 文字列を一つひとつ分割してarrayという配列に入れてく。
      $array = str_split($number);
      // 配列の値を大きい順に並び替え
      rsort($array);
      // 配列をの中身を連結したあと文字列に変換。
      // $valueという変数を作り値を保持。
      $value = implode($array);
      // $maxという変数を作ってstring(文字列) からint(数列)に変換
      $max= intval($value);
      
      // 配列の値を小さい順に並び替え
      sort($array);
      $value = implode($array);
      $min= intval($value);

      $result = $max - $min;
      echo $result;
      echo "<br>";
      // 計算結果を返り値として返す。
      return $result;
    }

?>


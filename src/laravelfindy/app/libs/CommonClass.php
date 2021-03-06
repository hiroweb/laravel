<?php

namespace App\libs;
use DateTime;
use Carbon\Carbon;

class CommonClass
{

  /**
   * 与えられた文字列が日付かどうかのチェック
   * 引数：西暦(9999/99/99 or 9999-99-99)
   * 戻値：結果
   */
  public function chkDate($value) {
    if ((strpos($value, '/') !== false) && (strpos($value, '-') !== false)) {
      return false;
    }
    $value   = str_replace('/', '-', $value);
    $pattern = '#^([0-9]{1,4})-(0[1-9]|1[0-2]|[1-9])-([0-2][0-9]|3[0-1]|[1-9])$#';
    preg_match($pattern, $value, $arrmatch);
    if ((isset($arrmatch[1]) === false) || (isset($arrmatch[2]) === false) || (isset($arrmatch[3]) === false)) {
      return false;
    }
    if (checkdate((int)$arrmatch[2], (int)$arrmatch[3], (int)$arrmatch[1]) === false) {
      return false;
    }
    return true;
  }

  /**
   * 与えられた文字列が日付かどうかをチェックし、日付だったら歳を返す
   * 日付じゃなかったらfalseを返して終了する
   * 引数：西暦(9999/99/99 or 9999-99-99)
   */
  public function howOld($birthday){
    $result='';
    if($this->chkDate($birthday)){
      $now = date("Ymd");
      $birthday = str_replace("-", "", $birthday);
      $birthday = str_replace("/", "-", $birthday);
      $result = (int)floor(($now-$birthday)/10000);
    }else{
      return false;
    }
    return $result;
  }

  /**
   * 時間(hhmm)を指定した分単位で切り捨てる
   * 
   * @param $time 時間と分の文字列(1130, 11:30など)
   * @param $per 切り捨てる単位(分) 5分なら5
   * @return false or 切り捨てられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
   */
  public function floorPerTime($time, $per=5){
    // 値がない時、単位が0の時は false を返して終了する
    if( !isset($time) || !is_numeric($per) || ($per == 0 )) {
        return false;
    }else{
        $deteObj = new DateTime($time);
        // 指定された単位で切り捨てる
        // フォーマット文字 i だと、 例えば1分が 2桁の 01 となる(1桁は無い）ので、整数に変換してから切り捨てる
        $ceil_num = floor(sprintf('%d', $deteObj->format('i'))/$per) *$per;
        $hour = $deteObj->format('H');
        $date = $deteObj->format('Y-m-d');
        $have = $hour.sprintf( '%02d', $ceil_num );
        return new DateTime($date.' '.$have);
    }
  }

  /**
   * 時間(hhmm)を指定した分単位で切り上げる
   * 
   * @param $time 時間と分の文字列(1130, 11:30など)
   * @param $per 切り上げる単位(分) 5分なら5
   * @return false or 切り上げられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
   */
  public function ceilPerTime($time, $per=5){
    // 値がない時、単位が0の時は false を返して終了する
    if( !isset($time) || !is_numeric($per) || ($per == 0 )) {
        return false;
    }else{
        $deteObj = new DateTime($time);
        // 指定された単位で切り上げる
        // フォーマット文字 i だと、 例えば1分が 2桁の 01 となる(1桁は無い）ので、整数に変換してから切り上げる
        $ceil_num = ceil(sprintf('%d', $deteObj->format('i'))/$per) *$per;

        // 切り上げた「分」が60になったら「時間」を1つ繰り上げる
        // 60分 -> 00分に直す
        $date = $deteObj->format('Y-m-d');
        $hour = $deteObj->format('H');

        if( $ceil_num == 60 ) {
            $hour = $deteObj->modify('+1 hour')->format('H');
            $ceil_num = '00';
        }
        $have = $hour.sprintf( '%02d', $ceil_num );

        return new DateTime($date.' '.$have);
    }
  }

  /**
   * 2つの時間の間に今があるかどうか
   * @param $date1 $date2
   * @return true or false
   */
    public function isNowBetween($date1,$date2){

      $old = new carbon($date1);
      $late = new carbon($date2);
      if(!$old->lt($late)){
        return 'error';
      }
      $now = new carbon();
      if($now -> between($late,$old)){
        $result = True;
      }else{
        $result = False;
      }
      return $result;
    }



  /**
   * 過去から未来の時間の配列から今に当てはまる配列のキーを返す
   * 比較対象が空だったり「0000-00-00 00:00:00」が入っていた場合は飛ばして次の日付を探しに行く
   * @param $timesAry 時間と分の文字列(1130, 11:30など)
   * @return 
   */
    public function whereIsNow(array $ary){
      if(!is_array($ary)){
        return false;
      }
      if(count($ary)==0){
        return false;
      }
      for ($i=0; $i < count($ary); $i++) {
        //$date1を探す…iが日付だったら
        if($ary[$i]!='0000-00-00 00:00:00'&&isset($ary[$i])){
          $date1=$ary[$i];
        }
        //$date2を探す
        $j=$i+1;
        while ($j < count($ary)) {
          if($ary[$j]!='0000-00-00 00:00:00'&&isset($ary[$j])){
            $date2=$ary[$j];
            break 1; //日付が見つかったらループを1段階（while）だけ抜ける
          }
          $j++;
        }
        if($date2==NULL){
          $result=$i;
          break;
        }
        if($this->isNowBetween($date1,$date2)){
          $result=$i;
          break;
        }
      }
      return $result;
    }
      

/**
 * 32桁のランダムユニークな文字列を作成する
 * 
 * @param int $length 求める文字列の長さ（桁数）
 * @param string $chars ランダム文字列に使用したい文字一覧
 * rand()…0から32767までのランダム整数を生成
 * uniqid()…マイクロ秒単位の現在時刻にもとづいた、ユニークなIDを取得。
 *  第2引数でさらに線形合同法でユニークな値を追加する。
 * md5…32文字の16進数でハッシュ値を返す
 * 32767通りのランダム×マイクロ秒ユニークのハッシュを生成
 */
  public function mkran32(){
    return md5(uniqid(rand(),true));
  }

/**
 * $IN["PRI_ID"] = randomstr(6, '0123456789','prior_inquiry','PRI_ID');
 * 指定された桁数、指定文字のランダム文字列を生成する
 * （古い環境では暗号学的な強さにならない場合もあるが、ほとんどの環境は問題ない）
 * 
 * @param int $length 求める文字列の長さ（桁数）
 * @param string $chars ランダム文字列に使用したい文字一覧
 *
 * 16進数の範囲で16桁の文字列を生成する場合
 * $rand1 = randomstr(16, '0123456789ABCDEF');
 * 32進数（Ｂａｓｅ３２）の範囲で16桁の文字列を生成する場合
 * $rand2 = randomstr(16, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567');
 * 英数大小文字の範囲で16桁の文字列を生成する場合
 * $rand3 = randomstr(16, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
 * 
 * 第三引数に$table名とカラム名を入れると該当テーブルのカラムを生成した乱数で検索し、該当があった場合はループし、新しい乱数をつくる
 */

  public function randomstr($length, $chars){
    $retstr = '';
    $data = openssl_random_pseudo_bytes($length);
    $num_chars = strlen($chars);
    for ($i = 0; $i < $length; $i++){
      $retstr .= substr($chars, ord(substr($data, $i, 1)) % $num_chars, 1);
    }
    return $retstr;
  }

  /**
   * 配列に重複があるかどうかをチェック
   * 戻り値 true or false
   * 
   */

  public function isDuplicateArrayValue(array $ary){
    $value_count = array_count_values($ary); // 各値の出現回数を数える
    $max = max($value_count); // 最大の出現回数を取得する
    if ($max == 1) {
        return false;
    } else {
        return true;
    }
  }



  /**
   * 文字列が指定数以上になったら、指定文字でまるめる
   * 
   * @param $time 時間と分の文字列(1130, 11:30など)
   * @param $per 切り上げる単位(分) 5分なら5
   * @return false or 切り上げられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
   */
  public function strm($str,$num=50,$val='…'){
    
    $num=$num*2+1;    
    return mb_strimwidth($str,0,$num,$val,"UTF-8");
  }



}

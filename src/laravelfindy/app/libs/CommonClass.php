<?php

namespace App\libs;
use DateTime;

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
        $have = $hour.sprintf( '%02d', $ceil_num );
        return new DateTime($have);
    }
  }

  /**
   * 時間(hhmm)を指定した分単位で切り上げる
   * 
   * @param $time 時間と分の文字列(1130, 11:30など)
   * @param $per 切り上げる単位(分) 5分なら5
   * @return false or 切り上げられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
   */
  function ceilPerTime($time, $per=5){
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
        $hour = $deteObj->format('H');

        if( $ceil_num == 60 ) {
            $hour = $deteObj->modify('+1 hour')->format('H');
            $ceil_num = '00';
        }
        $have = $hour.sprintf( '%02d', $ceil_num );

        return new DateTime($have);
    }
  }


  /**
   * 文字列が指定数以上になったら、指定文字でまるめる
   * 
   * @param $time 時間と分の文字列(1130, 11:30など)
   * @param $per 切り上げる単位(分) 5分なら5
   * @return false or 切り上げられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
   */
  function strm($str,$num=50,$val='…'){
    
    $num=$num*2+1;    
    return mb_strimwidth($str,0,$num,$val,"UTF-8");
  }



}

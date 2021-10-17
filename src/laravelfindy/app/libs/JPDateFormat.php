<?php

namespace App\libs;
use App\libs\CommonClass;

class JPDateFormat
{
  
  /**
   * 和暦変換(グレゴリオ暦が採用された「明治6年1月1日」以降に対応)
   * 引数：西暦(9999/99/99 or 9999-99-99)
   * 戻値：配列
   */
  public function JPDateFormat($value) {
    $common = new CommonClass;
    //和暦変換用データ
    $arr = array(
      array('date' => '2019-05-01', 'year' => '2019', 'name' => '令和', 'g' => 'R'),// 新元号追加
      array('date' => '1989-01-08', 'year' => '1989', 'name' => '平成', 'g' => 'H'),
      array('date' => '1926-12-25', 'year' => '1926', 'name' => '昭和', 'g' => 'S'),
      array('date' => '1912-07-30', 'year' => '1912', 'name' => '大正', 'g' => 'T'),
      array('date' => '1873-01-01', 'year' => '1868', 'name' => '明治', 'g' => 'M'),// 明治6年1月1日以降
    );
    // 日付チェック
    if ($common->chkDate($value) === false) {
      return '';
    }
    $arrad  = explode('-', str_replace('/', '-', $value));
    $addate = (int)sprintf('%d%02d%02d', (int)$arrad[0], (int)$arrad[1], (int)$arrad[2]);
    $result = '';
    foreach ($arr as $key=>$row) {
      // 日付チェック
      if ($common->chkDate($row['date']) === false) {
        return '';
      }
      $arrjp  = explode('-', str_replace('/', '-', $row['date']));
      $jpdate = (int)sprintf('%d%02d%02d', (int)$arrjp[0], (int)$arrjp[1], (int)$arrjp[2]);
      // 元号の開始日と比較
      if ($addate >= $jpdate) {
        // 和暦年の計算
        $year = sprintf('%d', ((int)$arrad[0] - (int)$row['year']) + 1);
        if ((int)$year === 1) {
          $year = '元';
        }
        // 和暦年月日作成
        break;
      }
    }
    return array('G'=>$row['g'],'Y'=>$year,'M'=>(int)$arrad[1],'D'=>(int)$arrad[2]);
  }

  /**
   * 和暦変換(グレゴリオ暦が採用された「明治6年1月1日」以降に対応)
   * 引数：西暦(9999/99/99 or 9999-99-99)
   * 戻値：和暦
   */
  public function JPDateFormatStr($value) {
    $common = new CommonClass;
    //和暦変換用データ
    $arr = array(
      array('date' => '2019-05-01', 'year' => '2019', 'name' => '令和'),// 新元号追加
      array('date' => '1989-01-08', 'year' => '1989', 'name' => '平成'),
      array('date' => '1926-12-25', 'year' => '1926', 'name' => '昭和'),
      array('date' => '1912-07-30', 'year' => '1912', 'name' => '大正'),
      array('date' => '1873-01-01', 'year' => '1868', 'name' => '明治'),// 明治6年1月1日以降
    );
    // 日付チェック
    if ($common->chkDate($value) === false) {
      return '';
    }
    $arrad  = explode('-', str_replace('/', '-', $value));
    $addate = (int)sprintf('%d%02d%02d', (int)$arrad[0], (int)$arrad[1], (int)$arrad[2]);
    $result = '';
    foreach ($arr as $key=>$row) {
      // 日付チェック
      if ($common->chkDate($row['date']) === false) {
        return '';
      }
      $arrjp  = explode('-', str_replace('/', '-', $row['date']));
      $jpdate = (int)sprintf('%d%02d%02d', (int)$arrjp[0], (int)$arrjp[1], (int)$arrjp[2]);
      // 元号の開始日と比較
      if ($addate >= $jpdate) {
        // 和暦年の計算
        $year = sprintf('%d', ((int)$arrad[0] - (int)$row['year']) + 1);
        if ((int)$year === 1) {
          $year = '元';
        }
        // 和暦年月日作成
        $result = sprintf('%s%s年%d月%d日', $row['name'], $year, (int)$arrad[1], (int)$arrad[2]);
        break;
      }
    }
    return $result;
  }




}
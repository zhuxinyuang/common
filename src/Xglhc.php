<?php
declare(strict_types=1);
namespace Zhuxinyuang\common;




class Xglhc
{
    /**获取球号波色
     * @param string $num
     * @return string
     */
  public  function BoSe(string $num):string
    {
        if ($num == '01' || $num == '02' || $num == '07' || $num == '08' || $num == '12' || $num == '13' || $num == '18' || $num == '19' || $num == '23' || $num == '24' || $num == '29' || $num == '30' || $num == '34' || $num == '35' || $num == '40' || $num == '45' || $num == '46') {
            return '红波';
        }elseif($num == '03' || $num == '04' || $num == '09' || $num == '10' || $num == '14' || $num == '15' || $num == '20' || $num == '25' || $num == '26' || $num == '31' || $num == '36' || $num == '37' || $num == '41' || $num == '42' || $num == '47' || $num == '48'){
            return '蓝波';
        }elseif ($num == '05' || $num == '06' || $num == '11' || $num == '16' || $num == '17' || $num == '21' || $num == '22' || $num == '27' || $num == '28' || $num == '32' || $num == '33' || $num == '38' || $num == '39' || $num == '43' || $num == '44' || $num == '49'){
            return '绿波';
        }
    }

    /**获取单双
     * @param int $num
     * @return string
     */
 public   function DanShuang(int $num):string
    {
        if ($num == 49) {
            return '49';

        }
        if ($num % 2 == 0) {
            return '双';
        } else {
            return '单';
        }
    }

    /**取大双小单
     * @param int $num
     * @return string
     */
  public  function DaShuangDaDanXiaoShuangXiaoDan(int $num):string
    {
        if ($num == 49) {
            return '49';

        }
        if ($num > 24) {
            if ($num % 2 == 0) {
                return '大双';
            } else {
                return '大单';
            }
        } else {
            if ($num % 2 == 0) {
                return '小双';
            } else {
                return '小单';
            }
        }
    }

    /**数字补0函数2，当数字小于10的时候在前面自动补00，当数字大于10小于100的时候在前面自动补0
     * @param int $num
     * @return string
     */


  public function BuLings ( int $num ):string {
        if ( $num<10 ) {
            $num = '0'.(string)$num;
        }
        return $num;
    }

    /**取大小
     * @param int $num
     * @return string
     */
  public  function DaXiao(int $num):string
    {
        if ($num == 49) {
            return '49';

        }
        if ($num > 24) {
            return '大';
        } else {
            return '小';
        }
    }

    /**取尾大小
     * @param int $num
     * @return string
     */
  public  function WeiShuDaXiao(int $num):string
    {
        if ($num == 49) {
            return '49';

        }
        $zhws = substr($num, strlen($num) - 1);
        if ($zhws >= 5) {
            return '尾大';
        } else {
            return '尾小';
        }
    }

    /**取尾双单
     * @param int $num
     * @return string
     */
 public   function WeiShuDanShuang(int $num):string
    {
        if ($num == 49) {
            return '49';

        }
        $zhws = substr($num, strlen($num) - 1);
        if ($num % 2 == 0) {
            return '尾双';
        } else {
            return '尾单';
        }
    }

    /**取合大合小
     * @param int $num
     * @return string
     */
 public   function HeShuDaXiao(int $num):string
    {
        if ($num == 49) {
            return '49';

        }
        $num1 = substr($num, 0, 1);
        $num2 = substr($num, 1, 1);
        $num3 = $num1 + $num2;
        if ($num3 > 6) {
            return '合大';
        } else {
            return '合小';
        }
    }

    /**取合单合双
     * @param int $num
     * @return string
     */
 public   function HeShuDanShuang(int $num) :string
    {
        if ($num == 49) {
            return '49';

        }
        $num1 = substr($num, 0, 1);
        $num2 = substr($num, 1, 1);
        $num3 = $num1 + $num2;
        if ($num3 % 2 == 0) {
            return '合双';
        } else {
            return '合单';
        }
    }

    /**取总合双单
     * @param int $num
     * @return string
     */
 public   function ZongHeDanShuang(int $num):string
    {
        if ($num % 2 == 0) {
            return '总和双';
        } else {
            return '总和单';
        }
    }

    /**总和大小
     * @param int $num
     * @return string
     */
 public   function ZongHeDaXiao(int $num):string
    {
        if ($num >= 175) {
            return '总和大';
        } else {
            return '总和小';
        }
    }

//六合彩正码转换成开奖号
 public   function ZhengMaToNum(string $haoma):int
    {
        if ($haoma == "正一") {
            return 1;
        } elseif ($haoma == "正二") {
            return 2;
        } elseif ($haoma == "正三") {
            return 3;
        } elseif ($haoma == "正四") {
            return 4;
        } elseif ($haoma == "正五") {
            return 5;
        } elseif ($haoma == "正六") {
            return 6;
        }
    }

  public  function ZhengMaGuoGuang(int $haoma,string $num):bool
    {
        if (($num == "大" || $num == "小") && $this->DaXiao($haoma) == $num) {
            return true;
        } else {
            return false;
        }
        if (($num == "单" || $num == "双") && $this->DanShuang($haoma) == $num) {
            return true;
        } else {
            return false;
        }
        if (($num == "合大" || $num == "合小") && $this->HeShuDaXiao($haoma) == $num) {
            return true;
        } else {
            return false;
        }
        if (($num == "合单" || $num == "合双") && $this->HeShuDanShuang($haoma) == $num) {
            return true;
        } else {
            return false;
        }
        if (($num == "尾大" || $num == "尾小") && $this->WeiShuDaXiao($haoma) == $num) {
            return true;
        } else {
            return false;
        }
        if (($num == "红波" || $num == "蓝波" || $num == "绿波") && $this->BoSe($haoma) == $num) {
            return true;
        } else {
            return false;
        }
    }

//六合彩尾数函数
  public  function WeiShu(int $num):string
    {
        return ($num % 10) . "尾";

    }
//家禽野兽
  public  function JiaQinYeShou(string $sx):string
  {

        if ($sx == '猪' || $sx == '狗' || $sx == '鸡' || $sx == '羊' || $sx == '兔' || $sx == '牛') {
            return '家禽';
        }else{
            return '野兽';
        }
    }
//1-49范围数字
  public  function Fanwei(int $hm):string
  {
        if($hm >= 1 && $hm <=10){
            return '1-10';
        }elseif($hm >= 11 &&$hm <=20){
            return '11-20';
        }elseif($hm >=21 && $hm <=30){
            return '21-30';
        }elseif($hm >= 31 && $hm <=40){
            return '31-40';
        }elseif($hm >= 41 && $hm <=49){
            return '41-49';
        }
    }

  public  function ShengXiao(int $hm, int $time):string
    {
        $today = date("Y-m-d", $time + 1 * 12 * 3600);
        $lunar = new Lunar();

        $year = date("Y", $lunar->S2L($today));
        $hm = $hm % 12;
        $arr = ['猴', '鸡', '狗', '猪', '鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊'];

        if (preg_match("/^\d{4}$/", $year)) {
            $m = $year % 12;
            $x = $arr[$m];
        }

        switch ($x) {
            case '猪':
                $sx = ['猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠'];
                break;
            case '狗':
                $sx = ['狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪'];
                break;
            case '鸡':
                $sx = ['鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗'];
                break;
            case '猴':
                $sx = ['猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡'];
                break;
            case '羊':
                $sx = ['羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴'];
                break;
            case '马':
                $sx = ['马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊'];
                break;
            case '蛇':
                $sx = ['蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马'];
                break;
            case '龙':
                $sx = ['龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇'];
                break;
            case '兔':
                $sx = ['兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙'];
                break;
            case '虎':
                $sx = ['虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔'];
                break;
            case '牛':
                $sx = ['牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎'];
                break;
            case '鼠':
                $sx = ['鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛'];
                break;
            default:
                $sx = ['鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛'];
        }
        if ($hm == 0) {
            return $sx[11];
        } else {
            return $sx[$hm - 1];
        }
    }

  public  function ShengXiaoPaiXu(int $time):array
    {
        $today = date("Y-m-d", $time + 1 * 12 * 3600);
        $lunar = new Lunar();
        $year = date("Y", $lunar->S2L($today));
        $arr = ['猴', '鸡', '狗', '猪', '鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊'];

        if (preg_match("/^\d{4}$/", $year)) {
            $m = $year % 12;
            $x = $arr[$m];
        }

        switch ($x) {
            case '猪':
                $sx = ['猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠'];
                break;
            case '狗':
                $sx = ['狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪'];
                break;
            case '鸡':
                $sx = ['鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗'];
                break;
            case '猴':
                $sx = ['猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡'];
                break;
            case '羊':
                $sx = ['羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴'];
                break;
            case '马':
                $sx = ['马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊'];
                break;
            case '蛇':
                $sx = ['蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马'];
                break;
            case '龙':
                $sx = ['龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇'];
                break;
            case '兔':
                $sx = ['兔', '虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙'];
                break;
            case '虎':
                $sx = ['虎', '牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔'];
                break;
            case '牛':
                $sx = ['牛', '鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎'];
                break;
            case '鼠':
                $sx = ['鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛'];
                break;
            default:
                $sx = ['鼠', '猪', '狗', '鸡', '猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛'];
        }

        foreach ($sx as $key=>$value){

            switch ($key) {
                case '0':
                    $sx[$key]=[0=>$value,1=>'01,13,25,37,49'];
                    break;
                case '1':
                    $sx[$key]=[0=>$value,1=>'02,14,26,38'];
                    break;
                case '2':
                    $sx[$key]=[0=>$value,1=>'03,15,27,39'];
                    break;
                case '3':
                    $sx[$key]=[0=>$value,1=>'04,16,28,40'];
                    break;
                case '4':
                    $sx[$key]=[0=>$value,1=>'05,17,29,41'];
                    break;
                case '5':
                    $sx[$key]=[0=>$value,1=>'06,18,30,42'];
                    break;
                case '6':
                    $sx[$key]=[0=>$value,1=>'07,19,31,43'];
                    break;
                case '7':
                    $sx[$key]=[0=>$value,1=>'08,20,32,44'];
                    break;
                case '8':
                    $sx[$key]=[0=>$value,1=>'09,21,33,45'];
                    break;
                case '9':
                    $sx[$key]=[0=>$value,1=>'10,22,34,46'];
                    break;
                case '10':
                    $sx[$key]=[0=>$value,1=>'11,23,35,47'];
                    break;
                case '11':
                    $sx[$key]=[0=>$value,1=>'12,24,36,48'];
                    break;
            }

        }
        return $sx;

    }
}

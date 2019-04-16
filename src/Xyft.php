<?php
declare(strict_types=1);
namespace Zhuxinyuang\common;


class Xyft
{


    /**期数小于10自动补0 小于100自动补00
     * @param int $num
     * @return string
     */
  public  function BuLings (int $num ):string {
        if ( $num<10 ) {
            $num = '00'.(string)$num;
        }
        if ( $num>=10 && $num<100 ) {
            $num = '0'.(string)$num;
        }
        return $num;
    }


    /**单双
     * @param $ball
     * @return string
     */
   public function Ds(int $ball):string{
        if($ball%2==0){
            return '双';
        }else{
            return '单';
        }
    }

    /**大小
     * @param int $ball
     * @return string
     */
   public function Dx(int $ball):string{
        if($ball>=6){
            return '大';
        }else{
            return '小';
        }
    }

    /**
     * @param array $num
     * @param int $type
     * @return string
     */
  public  function auto(array $num , int $type):string {
        $zh = $num[0]+$num[1];
        if($type==1){
            return (string)$zh;
        }
        if($type==2){
            if($zh>11){
                return '大';
            }else{
                return '小';
            }
        }
        if($type==3){
            if($zh%2==0){
                return '双';
            }else{
                return '单';
            }
        }
        if($type==4){
            if($num[0]>$num[9]){
                return '龙';
            }else{
                return '虎';
            }
        }
        if($type==5){
            if($num[1]>$num[8]){
                return '龙';
            }else{
                return '虎';
            }
        }
        if($type==6){
            if($num[2]>$num[7]){
                return '龙';
            }else{
                return '虎';
            }
        }
        if($type==7){
            if($num[3]>$num[6]){
                return '龙';
            }else{
                return '虎';
            }
        }
        if($type==8){
            if($num[4]>$num[5]){
                return '龙';
            }else{
                return '虎';
            }
        }
    }
}

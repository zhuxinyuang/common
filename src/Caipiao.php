<?php
/**
 * 必须安装think5.1 才能正常运行
 */
declare(strict_types=1);
namespace Zhuxinyuang\common;


use Zhuxinyuang\common\Cqssc;
use Zhuxinyuang\common\Xyft;

class Caipiao
{
    /**当前时间
     * @var int
     */
    public  $time;
    /**彩票类型
     * @int
     */
    public  $type;

    /**时间获取的期号
     * @int
     */
    protected $ActionNumber;
    /**彩票期号
     * @int
     */
    public  $number;
    /**开始时间
     * @var
     */
    public $ActionTime;

    /**结束时间
     * @var
     */
    public $StopTime;

    /**赔率
     * @array
     */
    public $OddsList = [];

    /**
     * 架构函数
     * @access public
     */
    public function __construct(int $type = 50){

        $this->time = time();
        $this->type = $type;

        $this->number = $this->GetLotteryNumber();
        $this->OddsList = $this->GetOddsList();



    }
    /**计算彩票开奖期数
     * @param int $type 彩票类型
     * @param array $list 数据库获取时间
     * @return int 返回彩票处理的真实期号
     */
    public function GetLotteryNumber():int{


        if(empty($this->ActionNumber) || empty($this->ActionTime) || empty($this->StopTime)){
            $this->GetActionTime();
        }


        if ($this->type == 50) {
            //北京赛车PK拾
            $action_no = (int)(44 * ((strtotime(date('Y-m-d', $this->time)) - strtotime('2019-2-11')) / 3600 / 24) + $this->ActionNumber + 729391);
        } elseif ($this->type == 55) {
            //幸运飞艇
            $number = (new Xyft())->BuLings($this->ActionNumber);
            //幸运飞艇大于132 算第二天的时间 但官方会算昨天的
            if ($number >= 132) {
                $action_no = (int)(date('Ymd', strtotime('-1 day', $this->time)) . (string)$this->ActionNumber);
            } else {
                $action_no = (int)(date('Ymd', $this->time) . (string)$this->ActionNumber);

            }
        } elseif ($this->type == 99) {
            //极速赛车
            $action_no = (int)(((strtotime(date('Y-m-d', $this->time)) - strtotime('2017-6-16')) / 3600 / 24 - 1) * 1152 + ($this->ActionNumber + 30264272));
        } elseif ($this->type == 1) {
            //重庆时时彩
            $action_no = (int)(date('Ymd', $this->time) . (new Cqssc())->BuLings($this->ActionNumber));

        } elseif ($this->type == 70) {
            //香港六合彩
            $action_no = $this->ActionNumber;
        } elseif ($this->type == 77) {
            //私人彩种
            $action_no = (int)(date('Ymd', $this->time) . (string)$this->ActionNumber);
        } elseif ($this->type == 88) {
            //私人彩种
            $action_no = (int)(date('Ymd', $this->time) . (string)$this->ActionNumber);
        }

        return $action_no;
    }

    /**获取彩票封盘时间
     * @return array
     */
   public function GetActionTime() {
        //获得缓存中的开奖时间


        $actionlist = \think\facade\Cache::store('redis')->get('action_list_' . (string)$this->type);
        if (!$actionlist) {
            $map[] = ['type', '=', $this->type];
            //判断是否是香港六合彩
            if($this->type==70){
                $actionlist = (new \app\index\model\XglhcTimeModel())->where($map)->order('action_no asc')->select();
            }else{
                //其他彩票
                $actionlist = (new \app\index\model\LotteryTimeModel())->where($map)->order('action_no asc')->select();
            }
            \think\facade\Cache::store('redis')->set('action_list_' . (string)$this->type, $actionlist,'600');
        }
        foreach ($actionlist as $key => $value) {
            if($this->time  >= strtotime($value['action_time']) &&   $this->time <= strtotime($value['stop_time'])){
                $this->ActionNumber=(int)$value['action_no'];
                $this->ActionTime=$value['action_time'];
                $this->StopTime=$value['stop_time'];
                break;
            }
        }




    }

    /**获得赔率
     * @return array
     */

    public function GetOddsList():array {
        //赔率列表整理
        $oddslist = \think\facade\Cache::store('redis')->get('oddslist_' . $this->type);
        if (!$oddslist) {
            $oddslist = [];
            $odds = (new \app\index\model\OddsModel()) ->where(['type' => $this->type])->select();
            foreach ($odds as $key => $value) {
                $oddslist[$value['id']] = $value;
            }
            \think\facade\Cache::store('redis')->set('oddslist_' . $this->type, $oddslist,'600');
        }

        return $oddslist;
    }

}
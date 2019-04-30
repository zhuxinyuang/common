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
    public $time;
    /**彩票类型  1:重庆时时彩 50：北京赛车 55：幸运飞艇 99：极速赛车
     * @int
     */
    public $type;

    /**时间获取的期号
     * @int
     */
    private $actionNumber;


    /**彩票期号
     * @int
     */
    public $number;
    /**开始时间
     * @var
     */
    public $actionTime;
    /**结束时间
     * @var
     */
    public $stopTime;
    /**赔率
     * @array
     */
    public $oddsList = [];
    /**开奖model
     * @var \app\index\model\JsscAutoModel
     */
    private $autoModel;

    /**
     * 架构函数
     * @access public
     */
    public function __construct(int $type = 50)
    {

        $this->time = time();

        $this->type = $type;

        $this->number = $this->GetLotteryNumber();

        $this->oddsList = $this->GetOddsList();




    }


    /**计算彩票开奖期数
     * @param int $type 彩票类型
     * @param array $list 数据库获取时间
     * @return string 返回彩票处理的真实期号
     */
    public function GetLotteryNumber(): string
    {

        //其中里面一个没有赋值  就执行获取开盘封盘的时间和期号
        if (empty($this->actionNumber) === true || empty($this->actionTime) === true || empty($this->stopTime) === true) {

            $this->GetActionTime();
        }


        if ($this->type == 50) {
            //北京赛车PK拾
            $action_no = (string)(44 * ((strtotime(date('Y-m-d', $this->time)) - strtotime('2019-2-11')) / 3600 / 24) + $this->actionNumber + 729391);

        } elseif ($this->type == 55) {
            //幸运飞艇
            $number = (new Xyft())->BuLings((int)$this->actionNumber);
            //幸运飞艇大于132 算第二天的时间 但官方会算昨天的
            if ($number >= 132) {

                $action_no = (string)(date('Ymd', strtotime('-1 day', $this->time)) . (string)$this->actionNumber);

            } else {

                $action_no = (string)date('Ymd', $this->time) . $number;

            }
        } elseif ($this->type == 99) {
            //极速赛车
            $action_no = (string)(((strtotime(date('Y-m-d', $this->time)) - strtotime('2017-6-16')) / 3600 / 24 - 1) * 1152 + ($this->actionNumber + 30264272));

        } elseif ($this->type == 1) {
            //重庆时时彩
            $action_no = (string)(date('Ymd', $this->time) . (new Cqssc())->BuLings($this->actionNumber));

        } elseif ($this->type == 70) {
            //香港六合彩
            $action_no = (string)$this->actionNumber;

        } elseif ($this->type == 77) {
            //私人彩种
            $action_no = (string)(date('Ymd', $this->time) . (string)$this->actionNumber);

        } elseif ($this->type == 88) {
            //私人彩种
            $action_no = (string)(date('Ymd', $this->time) . (string)$this->actionNumber);

        }

        return $action_no;
    }

    /**获取彩票封盘时间
     * @return void
     */
    private function GetActionTime(): void
    {
        //获得缓存中的开奖时间
        $actionlist = \think\facade\Cache::store('redis')->get(config('code.actionlist') . (string)$this->type);

        if (!$actionlist) {

            $map[] = ['type', '=', $this->type];

            //判断是否是香港六合彩
            if ($this->type == 70) {

                $actionlist = (new \app\index\model\XglhcTimeModel())->where($map)->order('action_no asc')->select();

            } else {
                //其他彩票
                $actionlist = (new \app\index\model\LotteryTimeModel())->where($map)->order('action_no asc')->select();

            }

            \think\facade\Cache::store('redis')->set(config('code.actionlist') . (string)$this->type, $actionlist, '600');

        }


        foreach ($actionlist as $key => $value) {

            if ($this->time >= strtotime($value['action_time']) && $this->time <= strtotime($value['stop_time'])) {

                $this->actionNumber = (int)$value['action_no'];

                $this->actionTime = strtotime($actionlist[$key]['action_time']);

                $this->stopTime = strtotime($actionlist[$key]['stop_time']);

                break;

            }
        }

        //处理香港六合彩没开盘
        if ($this->actionNumber == null && $key == count($actionlist) - 1 && $this->type == 70) {

            $this->actionNumber = (int)$actionlist[$key]['action_no'];

            $this->actionTime = strtotime($actionlist[$key]['action_time']);

            $this->stopTime = strtotime($actionlist[$key]['stop_time']);
        }


        $this->actionTime = $this->actionTime - $this->time;

        $this->stopTime = $this->stopTime - $this->time;


    }

    /**获得赔率
     * @return array
     */

    private function GetOddsList(): array
    {
        //赔率列表整理
        $oddslist = \think\facade\Cache::store('redis')->get(config('code.oddslist'). $this->type);

        if (!$oddslist) {

            $oddslist = [];

            $odds = (new \app\index\model\OddsModel())->where(['type' => $this->type])->select();

            foreach ($odds as $key => $value) {

                $oddslist[$value['id']] = $value;
            }

            \think\facade\Cache::store('redis')->set(config('code.oddslist') . $this->type, $oddslist, '600');

        }

        return $oddslist;

    }


    /**
     * 获得当前开奖model
     */
    private  function GetAutoMode(){

        if ($this->type == 1) {
            //重庆时时彩
            $this->autoModel = new \app\index\model\CqsscAutoModel();

        } else if ($this->type == 50) {
            //北京PK拾
            $this->autoModel = new \app\index\model\BjscAutoModel();

        } else if ($this->type == 55) {
            //幸运飞艇
            $this->autoModel = new \app\index\model\XyftAutoModel();

        } else if ($this->type == 70) {
            //香港六合彩
            $this->autoModel = new \app\index\model\XglhcAutoModel();

        }else if ($this->type == 88) {
            //SG飞艇
            $this->autoModel = new \app\index\model\SgftAutoModel();

        }else if ($this->type == 99) {
            //极速赛车
            $this->autoModel = new \app\index\model\JsscAutoModel();
        }
    }

    /**获取单个最新开奖号码
     * @return object
     */
    public function GetAutoFind(): object
    {
        //模型没有就NEW 模型
        if(empty($this->autoModel) === true) $this->GetAutoMode();


        $list = \think\facade\Cache::store('redis')->get(config('code.autofind') . $this->type);

        if (!$list) {

            $list = $this->autoModel->order('number desc')->field('number,data')->find();

            \think\facade\Cache::store('redis')->set(config('code.autofind') . $this->type, $list,'600');
        }

        return $list;

    }

    /**获得最新开奖列表
     * @return object
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function GetAutolist(): object
    {
        //模型没有就NEW 模型
        if(empty($this->autoModel) === true)  $this->NewAutoMode();


        $list = \think\facade\Cache::store('redis')->get(config('code.autolist') . $this->type);

        if (!$list) {

            $list = $this->autoModel->order('number desc')->field('number,data')->select();

            \think\facade\Cache::store('redis')->set(config('code.autolist') . $this->type, $list,'600');
        }

        return $list;

    }

    /**生成唯一订单ID
     * @return string
     */
    public function SetOrderId(): string
    {
        return date('YmdHis') . str_pad((string)mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);;

    }

    /**获得彩票状态
     * @return object\
     */
    public function GetLotteryStatus():object{
        
        $list = \think\facade\Cache::store('redis')->get(config('code.lotteryinfo') . $this->type);

        if (!$list) {

            $list = (new \app\index\model\LotteryTypeModel())->select();

            \think\facade\Cache::store('redis')->set(config('code.lotteryinfo') . $this->type, $list,'600');
        }

        return $list;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Zhu
 * Date: 2018/3/16
 * Time: 13:36
 */
declare(strict_types=1);
namespace Zhuxinyuang\common;


/**会员帐变和缓存
 * Class Member
 * @package Zhuxinyuang\common
 */




class Member
{
    /**会员帐变
     * @param array $param
     * @return int
     */
   public function change(array $param):int{

       $moneymodel = new \app\index\model\MoneyLogModel();






       $moneymodel->uid           = $param['uid'];
       $moneymodel->username      = $param['username'];
       $moneymodel->type          = $param['type'];
       $moneymodel->money         = $param['money'];
       $moneymodel->member_money  = (new \app\index\model\MemberModel())->where(['id'=>$param['uid']])->value('money');
       $moneymodel->cause_type    = $param['cause_type'];
       $moneymodel->info          = $param['info'];
       $moneymodel->date          = isset($param['date'])? $param['date'] : date('Y-m-d');

       $this->DelteCahe($param['username']);

       return $moneymodel->save();


   }

    /**删除会员缓存
     * @param string $username
     * @return bool
     */
   public function DelteCahe(string $username):bool {

       return \think\facade\Cache::store('redis')->rm(config('code.member').$username);
   }
}
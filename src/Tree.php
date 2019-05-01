<?php
declare(strict_types=1);
namespace Zhuxinyuang\common;


class Tree{
    static public $treeList=[];//存放无限极分类结果
    static public $childNode=[];//存放父节点和父节点下面的子节点

    //无限级分类排序
    public function create(array $data,int $pid = 0,int $level = 1):array {

        foreach($data as $key => $value){
            if($value['parent_1']==$pid){
                $value['level'] = $level;
                self::$treeList[] = $value;
                unset($data[$key]);
                self::create($data,(int)$value['id'],$level+1);
            }
        }
        return self::$treeList;
    }

    /**
     *根据自身节点ID逆向父节点 盘
     * @param int $id   父节点ID
     * @param array $list   tree表所有的id,pid
     */
    public function reverseArrayNode($username,$data){
        foreach ($data as $key => $val){
            if ($username['parent_1']==$val['id']){
                self::$treeList[]['id']=$val['id'];
                self::reverseArrayNode($val, $data);     //递归，传入新节点ID
            }
        }

        return self::$treeList;
    }

}
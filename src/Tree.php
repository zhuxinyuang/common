<?php
declare(strict_types=1);
namespace zhuxinyuang;


class Tree{
    static public $treeList=[];//存放无限极分类结果
    static public $childNode=[];//存放父节点和父节点下面的子节点

    //无限级分类排序
    public function create(array $data,int $pid = 0,int $level = 1):array {

        foreach($data as $key => $value){
            if($value['agency_id']==$pid){
                $value['level'] = $level;
                self::$treeList[] = $value;
                unset($data[$key]);
                self::create($data,(int)$value['id'],$level+1);
            }
        }
        return self::$treeList;
    }

    //无限级分类name排序
    public function CreateName(array $data,string $pid,int $level = 1):array {

        foreach($data as $key => $value){
            if($value['agency_name']==$pid){
                $value['level'] = $level;
                self::$treeList[] = $value;
                unset($data[$key]);
                self::CreateName($data,(string)$value['username'],$level+1);
            }
        }
        return self::$treeList;
    }


}
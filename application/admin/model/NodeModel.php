<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;

class NodeModel extends Model
{

    protected $table = "snake_node";

    protected $autoWriteTimestamp = false;

    public static $isMenuText = [
        1 => '否',
        2 => '是',
    ];

    /**
     * 根据搜索条件获取节点列表信息
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getNodesByWhere($where, $offset, $limit)
    {
        return $this->field('snake_node.*')
            // ->join('snake_role', 'snake_user.typeid = snake_role.id')
            ->where($where)->limit($offset, $limit)->order('CONCAT(path,id) asc')->select();
    }

    /**
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNodesList($where = [])
    {
        if (empty($where)) {
            $where['level'] = ['in', [1, 2]];
        }
        return $this->field('snake_node.*')
            ->where($where)->order('CONCAT(path,id) asc')->select();
    }

    /**
     * 根据搜索条件获取所有的节点数量
     * @param $where
     * @return int|string
     */
    public function getAllNodes($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 插入节点信息
     * @param $param
     * @return array
     */
    public function insertNode($param)
    {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            } else {

                return ['code' => 1, 'data' => '', 'msg' => '添加节点成功'];
            }
        } catch (PDOException $e) {

            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 编辑节点信息
     * @param $param
     * @return array
     */
    public function editNode($param)
    {
        try{

            $result =  $this->save($param, ['id' => $param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '编辑节点成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 根据节点id获取节点
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getOneNode($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 获取节点数据
     */
    public function getNodeInfo($id)
    {
        $result = $this->field('id,node_name,typeid')->select();
        $str = "";

        $role = new UserType();
        $rule = $role->getRuleById($id);

        if (!empty($rule)) {
            $rule = explode(',', $rule);
        }
        foreach ($result as $key => $vo) {
            $str .= '{ "id": "' . $vo['id'] . '", "pId":"' . $vo['typeid'] . '", "name":"' . $vo['node_name'] . '"';

            if (!empty($rule) && in_array($vo['id'], $rule)) {
                $str .= ' ,"checked":1';
            }

            $str .= '},';

        }

        return "[" . substr($str, 0, -1) . "]";
    }

    /**
     * 根据节点数据获取对应的菜单
     * @param $nodeStr
     * @return array
     */
    public function getMenu($nodeStr = '')
    {
        //超级管理员没有节点数组
        $where = empty($nodeStr) ? 'is_menu = 2' : 'is_menu = 2 and id in(' . $nodeStr . ')';

        $result = db('snake_node')->field('id,node_name,typeid,control_name,action_name,style')
            ->where($where)->select();
        $menu = prepareMenu($result);

        return $menu;
    }
}
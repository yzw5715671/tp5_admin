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
namespace app\admin\controller;

use app\admin\model\NodeModel;

class Node extends Base
{
    //节点列表
    public function index()
    {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['node_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $node = new NodeModel();
            $selectResult = $node->getNodesByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $level = substr_count($vo['path'], ',');
                $selectResult[$key]['node_name'] = trim(str_repeat("&nbsp&nbsp&nbsp&nbsp", $level - 1) . '|——' . $vo['node_name'], '|——');

                $selectResult[$key]['is_menu'] = NodeModel::$isMenuText[$vo['is_menu']];

                $operate = [
                    '编辑' => url('node/nodeEdit', ['id' => $vo['id']]),
                ];

                $selectResult[$key]['operate'] = showOperate($operate);
            }

            $return['total'] = $node->getAllNodes($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    /**
     * 添加节点
     * @return mixed|\think\response\Json
     */
    public function nodeAdd()
    {
        $node = new NodeModel();

        if (request()->isPost()) {

            $param = input('param.');
            $param = parseParams($param['data']);

            if (empty($param['typeid'])) {
                $param['level'] = 1;
                $param['path'] = '0,';
            } else {
                $nodeInfo = $node->find($param['typeid']);

                $param['level'] = $nodeInfo['level'] + 1;
                $param['path'] = $nodeInfo['path'] . $param['typeid'] . ',';
            }

            $flag = $node->insertNode($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $nodesList = $node->getNodesList();
        $this->assign([
            'nodeList' => $nodesList,
        ]);

        return $this->fetch();
    }

    /**
     * 编辑节点
     * @return mixed|\think\response\Json
     */
    public function nodeEdit()
    {
        $node = new NodeModel();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);

            if (empty($param['typeid'])) {
                $param['level'] = 1;
                $param['path'] = '0,';
            } else {
                $nodeInfo = $node->find($param['typeid']);

                $param['level'] = $nodeInfo['level'] + 1;
                $param['path'] = $nodeInfo['path'] . $param['typeid'] . ',';
            }

            $flag = $node->editNode($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $nodesList = $node->getNodesList();
        $this->assign([
            'nodeInfo' => $node->getOneNode($id),
            'nodeList' => $nodesList,
        ]);

        return $this->fetch();
    }
}
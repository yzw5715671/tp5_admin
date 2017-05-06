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

use common\model\sell66\AdditionConfig as AdditionConfigModel;

class AdditionConfig extends Base
{
    //加成配置列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
//            if (isset($param['activity_id']) && !empty($param['activity_id'])) {
//                $where['activity_id'] = $param['activity_id'];
//            }
            $additionConfig = new AdditionConfigModel();
            $selectResult = $additionConfig->getAdditionConfigByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['surplus_number'] = $vo['number'] != -1 ? $vo['surplus_number'] : '无限';
                $selectResult[$key]['number'] = $vo['number'] != -1 ? $vo['number'] : '无限';
                $selectResult[$key]['scope'] = AdditionConfigModel::$scope_text[$vo['scope']];
                $selectResult[$key]['status'] = AdditionConfigModel::$is_effect[$vo['status']];
                $selectResult[$key]['start_time'] = date('Y-m-d H:i:s', $vo['start_time']);
                $selectResult[$key]['end_time'] = date('Y-m-d H:i:s', $vo['end_time']);

                $operate = [
                    '编辑' => url('additionConfig/additionConfigEdit', ['id' => $vo['id']]),
                ];

                 $selectResult[$key]['operate'] = showOperate($operate);
            }

            $return['total'] = $additionConfig->getAllAdditionConfig($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    /**
     * 添加加成配置
     * @return mixed|\think\response\Json
     */
    public function additionConfigAdd()
    {
        if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $param['surplus_number'] = $param['number'];
            $param['start_time'] = (int)strtotime($param['start_time']);
            $param['end_time'] = (int)strtotime($param['end_time']);

            $additionConfig = new AdditionConfigModel();
            $flag = $additionConfig->insertAdditionConfig($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $this->assign([
            'activity_id' => input('param.activity_id', ''),
            'title' => input('param.title', ''),
        ]);
        return $this->fetch();
    }

    /**
     * 编辑加成配置
     * @return mixed|\think\response\Json
     */
    public function additionConfigEdit()
    {
        $additionConfig = new AdditionConfigModel();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);
            $param['start_time'] = (int)strtotime($param['start_time']);
            $param['end_time'] = (int)strtotime($param['end_time']);


            $flag = $additionConfig->editAdditionConfig($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'additionConfigInfo' => $additionConfig->getOneAdditionConfig($id),
        ]);

        return $this->fetch();
    }
}
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

use common\model\sell66\Activity as ActivityModel;

class Activity extends Base
{
    //机器人列表列表
    public function index()
    {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $activity = new ActivityModel();
            $selectResult = $activity->getActivityByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {

                $selectResult[$key]['status'] = ActivityModel::$is_effect[$vo['status']];
                $selectResult[$key]['start_time'] = date('Y-m-d H:i:s', $vo['start_time']);
                $selectResult[$key]['end_time'] = date('Y-m-d H:i:s', $vo['end_time']);

                $operate = [
                    '活动配置' => url('activity_config/index', ['activity_id' => $vo['id']]),
                    '添加活动配置' => url('activity_config/activityConfigAdd', ['activity_id' => $vo['id']]),
                    // '删除' => "javascript:userDel('".$vo['id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);
            }

            $return['total'] = $activity->getAllActivity($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加活动
    public function activityAdd()
    {
        if (request()->isPost()) {

            $param = input('param.');
            $param = parseParams($param['data']);
            // dump($param);exit;

            $activity = new ActivityModel();
            $flag = $activity->insertActivity($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
    }

}
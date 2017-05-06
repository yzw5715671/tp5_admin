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

use common\model\sell66\ActivityConfig as ActivityConfigModel;
use common\model\sell66\Activity as ActivityModel;

class ActivityConfig extends Base
{
    //机器人列表列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['activity_id']) && !empty($param['activity_id'])) {
                $where['activity_id'] = $param['activity_id'];
            }
            $activityConfig = new ActivityConfigModel();
            $selectResult = $activityConfig->getActivityConfigByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['activity_title'] = isset($param['title']) ? $param['title'] : '';
                $selectResult[$key]['surplus_number'] = !empty($vo['number']) ? $vo['surplus_number'] : '无限';
                $selectResult[$key]['number'] = !empty($vo['number']) ? $vo['number'] : '无限';
                $selectResult[$key]['type'] = ActivityConfigModel::$type_text[$vo['type']];
                $selectResult[$key]['scope'] = ActivityConfigModel::$scope_text[$vo['scope']];
                $selectResult[$key]['status'] = ActivityConfigModel::$is_effect[$vo['status']];
                $selectResult[$key]['start_time'] = date('Y-m-d H:i:s', $vo['start_time']);
                $selectResult[$key]['end_time'] = date('Y-m-d H:i:s', $vo['end_time']);

                $operate = [
                    '编辑' => url('activityConfig/userEdit', ['id' => $vo['id']]),
                    '删除' => "javascript:userDel('".$vo['id']."')"
                ];

                // $selectResult[$key]['operate'] = showOperate($operate);
            }

            $return['total'] = $activityConfig->getAllActivityConfig($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        $this->assign([
            'activity_id' => input('param.activity_id', ''),
            'title' => input('param.title', ''),
        ]);

        return $this->fetch();
    }

    //添加活动配置
    public function activityConfigAdd()
    {

        if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $activityConfig = new ActivityConfigModel();
            $flag = $activityConfig->insertActivityConfig($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $activity_id = input('param.activity_id', '');
        $activity = new ActivityModel();
        $activityInfo = $activity->getOneActivity($activity_id);

        $this->assign([
            'activity_id' => $activity_id,
            'title' => $activityInfo['title'],
        ]);
        return $this->fetch();
    }
}
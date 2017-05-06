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

use common\model\sell66\UserFeedback;

class Feedback extends Base
{
    //节点列表
    public function index()
    {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
//            if (isset($param['searchText']) && !empty($param['searchText'])) {
//                $where['node_name'] = ['like', '%' . $param['searchText'] . '%'];
//            }
            $node = new UserFeedback();
            $selectResult = $node->getFeedbackByWhere($where, $offset, $limit);

//            foreach ($selectResult as $key => $vo) {
//
//            }

            $return['total'] = $node->getAllFeedback($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }
}
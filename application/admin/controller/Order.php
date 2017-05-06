<?php
namespace app\admin\controller;

use app\admin\model\OrderDetailModel;
use app\admin\model\OrderModel;

class Order extends Base
{
    //订单列表
    public function index()
    {
        if(request()->isAjax()){
            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['tradeoffer_id'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $order = new OrderModel();
            $selectResult = $order->getOrdersByWhere($where, $offset, $limit);

            $order_status = config('order_status');

            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['created_time'] = date('Y-m-d H:i:s', $vo['created_time']);
                $selectResult[$key]['order_status'] = $order_status[$vo['order_status']];

                $operate = [
                    '详情' => url('order/detailindex', ['orderid' => $vo['user_order_id']]),
//                    '编辑' => url('order/orderEdit', ['user_order_id' => $vo['user_order_id']]),
//                    '删除' => "javascript:userDel('".$vo['user_order_id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);
            }
            $return['total'] = $order->getAllOrders($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    //订单详情列表
    public function detailindex()
    {
        if(request()->isAjax()) {
            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where['user_order_id'] = $param['orderid'];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['market_hash_name'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $order = new OrderDetailModel();
            $selectResult = $order->getOrdersDetailByWhere($where, $offset, $limit);

            $order_type = config('order_type');

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['created_time'] = date('Y-m-d H:i:s', $vo['created_time']);
                $selectResult[$key]['type'] = $order_type[$vo['type']];
            }
            $return['total'] = $order->getAllOrderDetail($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        $this->assign([
            'orderid' => input('param.orderid', ''),
        ]);

        return $this->fetch();
    }
}

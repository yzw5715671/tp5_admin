<?php

namespace app\admin\controller;

use common\model\sell66\UserBalanceLog;
use common\model\sell66\UserWithdrawRecord;

class Capital extends Base
{
    /**
     * 提现列表列表
     * @return mixed|\think\response\Json
     */
    public function index()
    {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [
            ];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['user_balance_log.balance_no'] = $param['searchText'];
            }

            $capital = new UserWithdrawRecord();
            $selectResult = $capital->getWithdrawRecordsByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {

                if (!empty($vo['source_type'])){
                    $selectResult[$key]['source_type'] = UserBalanceLog::$sourceTypeText[$vo['source_type']];
                }

                if ($vo['status'] == 1) {
                    $operate = [
                        '更新打款成功' => url('Capital/playMoneyEdit', ['user_balance_log_id' => $vo['user_balance_log_id']]),
                        '更新打款失败' => "javascript:playMoneyFail('" . $vo['user_balance_log_id'] . "'')"
                    ];
                    $selectResult[$key]['operate'] = showOperate($operate);
                } else if ($vo['status'] == 2) {
                    $operate = [
                        '更新打款失败' => "javascript:playMoneyFail('" . $vo['user_balance_log_id'] . "'')"
                    ];
                    $selectResult[$key]['operate'] = showOperate($operate);
                }

                $selectResult[$key]['status'] = UserWithdrawRecord::$statusText[$vo['status']];
            }

            $return['total'] = $capital->getAllWithdrawRecords($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    /**
     * 更新打款成功
     * @return mixed|\think\response\Json
     */
    public function playMoneyEdit()
    {
        $capital = new UserWithdrawRecord();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $capital->editPlayMoney($param['user_balance_log_id'], $param['trans_no']);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $user_balance_log_id = input('param.user_balance_log_id');
        $capitalInfo = $capital->getOnePlayMoney($user_balance_log_id);
        $capitalInfo['source_type'] = UserBalanceLog::$sourceTypeText[$capitalInfo['source_type']];
        $capitalInfo['status'] = UserWithdrawRecord::$statusText[$capitalInfo['status']];
        $this->assign([
            'playMoney' => $capitalInfo,
        ]);
        return $this->fetch();
    }

    /**
     * 更新打款失败
     * @return \think\response\Json
     */
    public function playMoneyFail()
    {
        $id = input('param.user_balance_log_id');

        $capital = new UserBalanceLog();
        $flag = $capital->playMoney($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}
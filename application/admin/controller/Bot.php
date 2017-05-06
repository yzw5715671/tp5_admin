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

use common\model\sell66\Bot as BotModel;

class Bot extends Base
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
            $bot = new BotModel();
            $selectResult = $bot->getBotsByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {

                $selectResult[$key]['is_active'] = BotModel::$is_active[$vo['is_active']];
                $selectResult[$key]['login_status'] = BotModel::$is_active[$vo['login_status']];

                $operate = [
                    '编辑' => url('bot/botEdit', ['id' => $vo['id']]),
                ];

                $selectResult[$key]['operate'] = showOperate($operate);
            }

            $return['total'] = $bot->getAllBots($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    /**
     * 添加机器人
     * @return mixed|\think\response\Json
     */
    public function botAdd()
    {
        if (request()->isPost()) {

            $param = input('param.');
            $param = parseParams($param['data']);

            $bot = new BotModel();
            $flag = $bot->insertBot($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
    }

    /**
     * 编辑机器人
     * @return mixed|\think\response\Json
     */
    public function botEdit()
    {
        $bot = new BotModel();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);


            $flag = $bot->editBot($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'botInfo' => $bot->getOneBot($id),
        ]);

        return $this->fetch();
    }

}

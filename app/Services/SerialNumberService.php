<?php
/**
 * 序列号服务类
 * User: jason
 * Date: 2018/9/28
 * Time: 上午10:33
 */

namespace App\Services;

class SerialNumberService
{
    /**
     * 生成唯一序列号
     *
     * @return string
     */
    public static function generateNum()
    {
        //strtoupper转换成全大写的
        $charid = strtoupper(md5(uniqid(mt_rand())));
        $uuid = substr($charid, 0, 8).substr($charid, 8, 4).substr($charid, 12, 4).substr($charid, 16, 4);

        return $uuid;
    }

    /**
     * 批量生成唯一序列号
     *
     * @param     $sum
     * @param int $is_senior
     * @param int $admin_id
     * @param int $agent_id
     * @param int $vip_id
     * @param int $channel
     * @return array
     */
    public function getSerialnunmbers($sum, $is_senior = 0, $admin_id = 0, $agent_id = 0, $vip_id = 0, $channel = 0)
    {
        $serial_number_arr = [];
        for ($i = 1; $i <= $sum; $i++) {
            $serial_number_arr[$i]['admin_id'] = $admin_id;
            $serial_number_arr[$i]['agent_id'] = $agent_id;
            $serial_number_arr[$i]['vip_id'] = $vip_id;
            $serial_number_arr[$i]['number'] = $this->generateNum();
            $serial_number_arr[$i]['is_senior'] = $is_senior;
            $serial_number_arr[$i]['channel'] = $channel;
        }

        return $serial_number_arr;
    }

    /**
     * 批量生成唯一授权码
     *
     * @param     $sum
     * @param int $status
     * @return array
     */
    public function getVideoCOdes($sum, $status = 0)
    {
        $serial_number_arr = [];
        for ($i = 1; $i <= $sum; $i++) {
            $serial_number_arr[$i]['number'] = $this->generateNum();
            $serial_number_arr[$i]['user_id'] = 0;
            $serial_number_arr[$i]['status'] = $status;
            $serial_number_arr[$i]['created_at'] = date('Y-m-d H:i:s', time());
        }

        return $serial_number_arr;
    }
}
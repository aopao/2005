<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadServices
 *
 * @package App\Services
 */
class UploadServices
{
    /**
     * 上传组件
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $type
     * @param array                    $extensionArr
     * @return bool|string
     */
    public function updateStore(Request $request, $type = 'upload', $extensionArr = ['xlsx', 'xls'])
    {
        $file = $request->file('file');
        if ($file->isValid()) {

            //获取文件的扩展名
            $extension = $file->getClientOriginalExtension();
            if (! in_array($extension, $extensionArr)) {
                return 203;
            }
            //获取文件的绝对路径，但是获取到的在本地不能打开
            $path = $file->getRealPath();

            //要保存的文件名 时间+扩展名
            $filename = '/'.$type.'/'.date('YmdHis').uniqid().'.'.$extension;

            //保存文件  配置文件存放文件的名字  ，文件名，路径
            if (Storage::disk('public')->put($filename, file_get_contents($path))) {
                return $filename;
            } else {
                return false;
            }
        }
    }
}
<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Services\UploadServices;

/**
 * Class ProvincecontrolScoreController.
 *
 * @package namespace App\Http\Controllers;
 */
class UploadController extends BaseController
{
    public function UploadImg(Request $request, UploadServices $uploadServices)
    {
        $file = $uploadServices->updateStore($request, 'temp', '');
        if ($file == 203) {
            return $this->responseFormat->error('请上传Excel格式文件!', 203);
        }
        Excel::import(new ProvinceControlScoreImport(), $file, 'public');

        return $file;
    }
}

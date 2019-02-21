<?php

namespace App\Repositories;

use App\Services\TreeServices;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ArticleCategoryRepository;
use App\Entities\ArticleCategory;
use App\Validators\ArticleCategoryValidator;

/**
 * Class ArticleCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ArticleCategoryRepositoryEloquent extends BaseRepository implements ArticleCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ArticleCategory::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return ArticleCategoryValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Ant desing 所需的分页方法
     *
     * @param $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getAllByPage($request)
    {
        /*判断页数*/
        $pageSize = $request->get('pageSize', 10) != null ? $request->get('pageSize', 10) : 10;
        if (($pageSize % 10 != 0) || $pageSize > 50) {
            return response()->json(['status_code' => '404']);
        }
        /*获取查询参数*/
        $name = $request->get('name', null);

        /*组装查询参数*/
        $sql = $this->model;
        if ($name != null) {
            $sql = $sql->where('name', 'like', '%'.$name.'%');
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)->get();
        $service = new TreeServices();
        if (! empty($data)) {
            $data = $service->makeTreeForHtml($data);
        }

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }

    /**
     * 获取 OptionList  列表
     */
    public function getOptionList()
    {
        $service = new TreeServices();
        $data = $this->model->all()->toArray();
        if (empty($data)) {
            return [];
        } else {
            $data = $service->makeTreeForHtml($data);
        }

        return $data;
    }
}

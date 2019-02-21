<?php

namespace App\Repositories;

use Cache;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Major;
use App\Entities\MajorDetail;
use App\Validators\MajorValidator;

/**
 * Class MajorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MajorRepositoryEloquent extends BaseRepository implements MajorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Major::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return MajorValidator::class;
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
        $sql = $this->model->orderBy('code', 'asc');
        if ($name != null) {
            $sql = $sql->where('name', 'like', '%'.$name.'%');
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)->with('majorDetail')->get();

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }

    /**
     * 层级列表
     *
     * @return array
     */
    public function levelOptionList()
    {
        if (Cache::has('majorLevelOptionList')) {
            return Cache::get('majorLevelOptionList', null);
        } else {

            $item = [];
            $item[0]['value'] = '1';
            $item[0]['label'] = '本科';
            $tops = $this->model->where('parent_id', '0')->where('diplomas', 1)->get();
            $data = $tops->map(function ($top) {
                $item = [];
                $item['value'] = (string) $top['id'];
                $item['label'] = $top['name'];
                $childrens = $this->model->where('parent_id', $top['id'])->where('diplomas', 1)->get();
                $item['children'] = $childrens->map(function ($item) {
                    $node = [];
                    $node['value'] = (string) $item['id'];
                    $node['label'] = $item['name'];

                    return $node;
                });

                return $item;
            });
            $item[0]['children'] = $data;

            $item[1]['value'] = '0';
            $item[1]['label'] = '专科';
            $tops = $this->model->where('parent_id', '0')->where('diplomas', 0)->get();
            $data = $tops->map(function ($top) {
                $item = [];
                $item['value'] = $top['id'];
                $item['label'] = $top['name'];
                $childrens = $this->model->where('parent_id', $top['id'])->where('diplomas', 0)->get();
                $item['children'] = $childrens->map(function ($item) {
                    $node = [];
                    $node['value'] = $item['id'];
                    $node['label'] = $item['name'];

                    return $node;
                });

                return $item;
            });
            $item[1]['children'] = $data;
            Cache::put('majorLevelOptionList', $item, 43200);

            return $item;
        }
    }

    public function createMajor($data)
    {
        if (count($data['level']) == 3) {
            $major = [
                'name' => $data['name'],
                'code' => $data['code'],
                'parent_id' => $data['level'][2],
                'top_parent_id' => $data['level'][1],
                'diplomas' => $data['level'][0],
                'ranking' => $data['ranking'],
                'ranking_type' => $data['ranking_type'],
            ];
            $major_info = $this->model->create($major);
            $majro_detail = [
                'major_id' => $major_info['id'],
                'clicks' => $data['clicks'],
                'awarded_degree' => $data['awarded_degree'],
                'job_direction' => $data['job_direction'],
                'graduation_student_num' => $data['graduation_student_num'],
                'work_rate' => $data['work_rate'],
                'wen_ratio' => $data['wen_ratio'],
                'li_ratio' => $data['li_ratio'],
                'male_ratio' => $data['male_ratio'],
                'female_ratio' => $data['female_ratio'],
                'zh_ratio' => $data['zh_ratio'],
                'bxtj_ratio' => $data['bxtj_ratio'],
                'jxzl_ratio' => $data['jxzl_ratio'],
                'jy_ratio' => $data['jy_ratio'],
                'description' => $data['description'],
                'goal' => $data['goal'],
                'require' => $data['require'],
                'obtain' => $data['obtain'],
                'subject' => $data['subject'],
                'course' => $data['course'],
                'teach' => $data['teach'],
                'year' => $data['year'],
                'degree' => $data['degree'],
                'jobs' => $data['jobs'],
                'employment_type' => $data['employment_type'],
                'employment_city' => $data['employment_city'],
            ];
            $res = MajorDetail::create($majro_detail);
            if (isset($res['id'])) {
                return true;
            }
        } else {
            return false;
        }
    }
}

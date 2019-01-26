<?php

namespace App\Http\Controllers;

use App\Entities\Province;
use App\Entities\ProvinceControlScore;
use App\Services\JsonToArrayService;
use App\Imports\MajorImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MajorCreateRequest;
use App\Http\Requests\MajorUpdateRequest;
use App\Repositories\MajorRepository;
use App\Validators\MajorValidator;

/**
 * Class MajorsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MajorsController extends Controller
{
    /**
     * @var MajorRepository
     */
    protected $repository;

    /**
     * @var MajorValidator
     */
    protected $validator;

    /**
     * MajorsController constructor.
     *
     * @param MajorRepository $repository
     * @param MajorValidator  $validator
     */
    public function __construct(MajorRepository $repository, MajorValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Excel::import(new MajorImport(), '1.xlsx','public');
        //$major_detal = JsonToArrayService::getJson('province_control_scores.json');
        //foreach ($major_detal as $item) {
        //    if ($item['type'] == "不分科类") {
        //        $type = 2;
        //    } elseif ($item['type'] == "文科") {
        //        $type = 0;
        //    } elseif ($item['type'] == "理科") {
        //        $type = 1;
        //    }
        //    $province = Province::where('name', 'like', '%'.$item['name'].'%')->first();
        //    $data = [
        //        'province_id' => $province['id'],
        //        'year' => $item['year'],
        //        'subject' => $type,
        //        'batch' => $item['batch'],
        //        'score' => $item['score'],
        //    ];
        //    echo "<pre>";
        //    print_r($data);
        //    echo "</pre>";
        //    ProvinceControlScore::create($data);
        //}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MajorCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MajorCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $major = $this->repository->create($request->all());

            $response = [
                'message' => 'Major created.',
                'data' => $major->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $major = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $major,
            ]);
        }

        return view('majors.show', compact('major'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $major = $this->repository->find($id);

        return view('majors.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MajorUpdateRequest $request
     * @param  string             $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MajorUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $major = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Major updated.',
                'data' => $major->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Major deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Major deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProvinceControlScoreCreateRequest;
use App\Http\Requests\ProvinceControlScoreUpdateRequest;
use App\Repositories\ProvinceControlScoreRepository;
use App\Validators\ProvinceControlScoreValidator;

/**
 * Class ProvinceControlScoresController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProvinceControlScoresController extends Controller
{
    /**
     * @var ProvinceControlScoreRepository
     */
    protected $repository;

    /**
     * @var ProvinceControlScoreValidator
     */
    protected $validator;

    /**
     * ProvinceControlScoresController constructor.
     *
     * @param ProvinceControlScoreRepository $repository
     * @param ProvinceControlScoreValidator $validator
     */
    public function __construct(ProvinceControlScoreRepository $repository, ProvinceControlScoreValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $provinceControlScores = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $provinceControlScores,
            ]);
        }

        return view('provinceControlScores.index', compact('provinceControlScores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProvinceControlScoreCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProvinceControlScoreCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $provinceControlScore = $this->repository->create($request->all());

            $response = [
                'message' => 'ProvinceControlScore created.',
                'data'    => $provinceControlScore->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
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
        $provinceControlScore = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $provinceControlScore,
            ]);
        }

        return view('provinceControlScores.show', compact('provinceControlScore'));
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
        $provinceControlScore = $this->repository->find($id);

        return view('provinceControlScores.edit', compact('provinceControlScore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProvinceControlScoreUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProvinceControlScoreUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $provinceControlScore = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ProvinceControlScore updated.',
                'data'    => $provinceControlScore->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
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
                'message' => 'ProvinceControlScore deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ProvinceControlScore deleted.');
    }
}

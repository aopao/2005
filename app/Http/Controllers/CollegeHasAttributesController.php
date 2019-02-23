<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CollegeHasAttributeCreateRequest;
use App\Http\Requests\CollegeHasAttributeUpdateRequest;
use App\Repositories\CollegeHasAttributeRepository;
use App\Validators\CollegeHasAttributeValidator;

/**
 * Class CollegeHasAttributesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CollegeHasAttributesController extends Controller
{
    /**
     * @var CollegeHasAttributeRepository
     */
    protected $repository;

    /**
     * @var CollegeHasAttributeValidator
     */
    protected $validator;

    /**
     * CollegeHasAttributesController constructor.
     *
     * @param CollegeHasAttributeRepository $repository
     * @param CollegeHasAttributeValidator $validator
     */
    public function __construct(CollegeHasAttributeRepository $repository, CollegeHasAttributeValidator $validator)
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
        $collegeHasAttributes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collegeHasAttributes,
            ]);
        }

        return view('collegeHasAttributes.index', compact('collegeHasAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CollegeHasAttributeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CollegeHasAttributeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $collegeHasAttribute = $this->repository->create($request->all());

            $response = [
                'message' => 'CollegeHasAttribute created.',
                'data'    => $collegeHasAttribute->toArray(),
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
        $collegeHasAttribute = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collegeHasAttribute,
            ]);
        }

        return view('collegeHasAttributes.show', compact('collegeHasAttribute'));
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
        $collegeHasAttribute = $this->repository->find($id);

        return view('collegeHasAttributes.edit', compact('collegeHasAttribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CollegeHasAttributeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CollegeHasAttributeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $collegeHasAttribute = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CollegeHasAttribute updated.',
                'data'    => $collegeHasAttribute->toArray(),
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
                'message' => 'CollegeHasAttribute deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CollegeHasAttribute deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CollegeAttributeCreateRequest;
use App\Http\Requests\CollegeAttributeUpdateRequest;
use App\Repositories\CollegeAttributeRepository;
use App\Validators\CollegeAttributeValidator;

/**
 * Class CollegeAttributesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CollegeAttributesController extends Controller
{
    /**
     * @var CollegeAttributeRepository
     */
    protected $repository;

    /**
     * @var CollegeAttributeValidator
     */
    protected $validator;

    /**
     * CollegeAttributesController constructor.
     *
     * @param CollegeAttributeRepository $repository
     * @param CollegeAttributeValidator $validator
     */
    public function __construct(CollegeAttributeRepository $repository, CollegeAttributeValidator $validator)
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
        $collegeAttributes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collegeAttributes,
            ]);
        }

        return view('collegeAttributes.index', compact('collegeAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CollegeAttributeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CollegeAttributeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $collegeAttribute = $this->repository->create($request->all());

            $response = [
                'message' => 'CollegeAttribute created.',
                'data'    => $collegeAttribute->toArray(),
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
        $collegeAttribute = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collegeAttribute,
            ]);
        }

        return view('collegeAttributes.show', compact('collegeAttribute'));
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
        $collegeAttribute = $this->repository->find($id);

        return view('collegeAttributes.edit', compact('collegeAttribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CollegeAttributeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CollegeAttributeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $collegeAttribute = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CollegeAttribute updated.',
                'data'    => $collegeAttribute->toArray(),
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
                'message' => 'CollegeAttribute deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CollegeAttribute deleted.');
    }
}

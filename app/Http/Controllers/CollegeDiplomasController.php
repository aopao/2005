<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CollegeDiplomasCreateRequest;
use App\Http\Requests\CollegeDiplomasUpdateRequest;
use App\Repositories\CollegeDiplomasRepository;
use App\Validators\CollegeDiplomasValidator;

/**
 * Class CollegeDiplomasController.
 *
 * @package namespace App\Http\Controllers;
 */
class CollegeDiplomasController extends Controller
{
    /**
     * @var CollegeDiplomasRepository
     */
    protected $repository;

    /**
     * @var CollegeDiplomasValidator
     */
    protected $validator;

    /**
     * CollegeDiplomasController constructor.
     *
     * @param CollegeDiplomasRepository $repository
     * @param CollegeDiplomasValidator $validator
     */
    public function __construct(CollegeDiplomasRepository $repository, CollegeDiplomasValidator $validator)
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
        $collegeDiplomas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collegeDiplomas,
            ]);
        }

        return view('collegeDiplomas.index', compact('collegeDiplomas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CollegeDiplomasCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CollegeDiplomasCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $collegeDiploma = $this->repository->create($request->all());

            $response = [
                'message' => 'CollegeDiplomas created.',
                'data'    => $collegeDiploma->toArray(),
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
        $collegeDiploma = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collegeDiploma,
            ]);
        }

        return view('collegeDiplomas.show', compact('collegeDiploma'));
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
        $collegeDiploma = $this->repository->find($id);

        return view('collegeDiplomas.edit', compact('collegeDiploma'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CollegeDiplomasUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CollegeDiplomasUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $collegeDiploma = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CollegeDiplomas updated.',
                'data'    => $collegeDiploma->toArray(),
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
                'message' => 'CollegeDiplomas deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CollegeDiplomas deleted.');
    }
}

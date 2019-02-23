<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MajorChoiceSubjectCreateRequest;
use App\Http\Requests\MajorChoiceSubjectUpdateRequest;
use App\Repositories\MajorChoiceSubjectRepository;
use App\Validators\MajorChoiceSubjectValidator;

/**
 * Class MajorChoiceSubjectsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MajorChoiceSubjectsController extends Controller
{
    /**
     * @var MajorChoiceSubjectRepository
     */
    protected $repository;

    /**
     * @var MajorChoiceSubjectValidator
     */
    protected $validator;

    /**
     * MajorChoiceSubjectsController constructor.
     *
     * @param MajorChoiceSubjectRepository $repository
     * @param MajorChoiceSubjectValidator $validator
     */
    public function __construct(MajorChoiceSubjectRepository $repository, MajorChoiceSubjectValidator $validator)
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
        $majorChoiceSubjects = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $majorChoiceSubjects,
            ]);
        }

        return view('majorChoiceSubjects.index', compact('majorChoiceSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MajorChoiceSubjectCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MajorChoiceSubjectCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $majorChoiceSubject = $this->repository->create($request->all());

            $response = [
                'message' => 'MajorChoiceSubject created.',
                'data'    => $majorChoiceSubject->toArray(),
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
        $majorChoiceSubject = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $majorChoiceSubject,
            ]);
        }

        return view('majorChoiceSubjects.show', compact('majorChoiceSubject'));
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
        $majorChoiceSubject = $this->repository->find($id);

        return view('majorChoiceSubjects.edit', compact('majorChoiceSubject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MajorChoiceSubjectUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MajorChoiceSubjectUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $majorChoiceSubject = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MajorChoiceSubject updated.',
                'data'    => $majorChoiceSubject->toArray(),
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
                'message' => 'MajorChoiceSubject deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MajorChoiceSubject deleted.');
    }
}

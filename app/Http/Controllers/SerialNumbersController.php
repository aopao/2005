<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SerialNumberCreateRequest;
use App\Http\Requests\SerialNumberUpdateRequest;
use App\Repositories\SerialNumberRepository;
use App\Validators\SerialNumberValidator;

/**
 * Class SerialNumbersController.
 *
 * @package namespace App\Http\Controllers;
 */
class SerialNumbersController extends Controller
{
    /**
     * @var SerialNumberRepository
     */
    protected $repository;

    /**
     * @var SerialNumberValidator
     */
    protected $validator;

    /**
     * SerialNumbersController constructor.
     *
     * @param SerialNumberRepository $repository
     * @param SerialNumberValidator $validator
     */
    public function __construct(SerialNumberRepository $repository, SerialNumberValidator $validator)
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
        $serialNumbers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $serialNumbers,
            ]);
        }

        return view('serialNumbers.index', compact('serialNumbers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SerialNumberCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SerialNumberCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $serialNumber = $this->repository->create($request->all());

            $response = [
                'message' => 'SerialNumber created.',
                'data'    => $serialNumber->toArray(),
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
        $serialNumber = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $serialNumber,
            ]);
        }

        return view('serialNumbers.show', compact('serialNumber'));
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
        $serialNumber = $this->repository->find($id);

        return view('serialNumbers.edit', compact('serialNumber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SerialNumberUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SerialNumberUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $serialNumber = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'SerialNumber updated.',
                'data'    => $serialNumber->toArray(),
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
                'message' => 'SerialNumber deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'SerialNumber deleted.');
    }
}

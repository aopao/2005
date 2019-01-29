<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\VipCardCreateRequest;
use App\Http\Requests\VipCardUpdateRequest;
use App\Repositories\VipCardRepository;
use App\Validators\VipCardValidator;

/**
 * Class VipCardsController.
 *
 * @package namespace App\Http\Controllers;
 */
class VipCardsController extends Controller
{
    /**
     * @var VipCardRepository
     */
    protected $repository;

    /**
     * @var VipCardValidator
     */
    protected $validator;

    /**
     * VipCardsController constructor.
     *
     * @param VipCardRepository $repository
     * @param VipCardValidator $validator
     */
    public function __construct(VipCardRepository $repository, VipCardValidator $validator)
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
        $vipCards = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $vipCards,
            ]);
        }

        return view('vipCards.index', compact('vipCards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VipCardCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(VipCardCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $vipCard = $this->repository->create($request->all());

            $response = [
                'message' => 'VipCard created.',
                'data'    => $vipCard->toArray(),
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
        $vipCard = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $vipCard,
            ]);
        }

        return view('vipCards.show', compact('vipCard'));
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
        $vipCard = $this->repository->find($id);

        return view('vipCards.edit', compact('vipCard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VipCardUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(VipCardUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $vipCard = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'VipCard updated.',
                'data'    => $vipCard->toArray(),
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
                'message' => 'VipCard deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'VipCard deleted.');
    }
}

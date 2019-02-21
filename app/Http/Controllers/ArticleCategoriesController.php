<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ArticleCategoryCreateRequest;
use App\Http\Requests\ArticleCategoryUpdateRequest;
use App\Repositories\ArticleCategoryRepository;
use App\Validators\ArticleCategoryValidator;

/**
 * Class ArticleCategoriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ArticleCategoriesController extends Controller
{
    /**
     * @var ArticleCategoryRepository
     */
    protected $repository;

    /**
     * @var ArticleCategoryValidator
     */
    protected $validator;

    /**
     * ArticleCategoriesController constructor.
     *
     * @param ArticleCategoryRepository $repository
     * @param ArticleCategoryValidator $validator
     */
    public function __construct(ArticleCategoryRepository $repository, ArticleCategoryValidator $validator)
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
        $articleCategories = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $articleCategories,
            ]);
        }

        return view('articleCategories.index', compact('articleCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleCategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ArticleCategoryCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $articleCategory = $this->repository->create($request->all());

            $response = [
                'message' => 'ArticleCategory created.',
                'data'    => $articleCategory->toArray(),
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
        $articleCategory = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $articleCategory,
            ]);
        }

        return view('articleCategories.show', compact('articleCategory'));
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
        $articleCategory = $this->repository->find($id);

        return view('articleCategories.edit', compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleCategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ArticleCategoryUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $articleCategory = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ArticleCategory updated.',
                'data'    => $articleCategory->toArray(),
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
                'message' => 'ArticleCategory deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ArticleCategory deleted.');
    }
}

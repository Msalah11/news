<?php

namespace App\Http\Controllers;

use App\Actions\NewsAction;
use App\Http\Requests\IndexNews;
use App\Http\Requests\StoreNews;
use App\Http\Requests\UpdateNews;
use App\Http\Resources\NewsResource;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    use HttpResponse;

    /**
     * Controller Action
     * @var NewsAction
     */
    protected $newsAction;

    /**
     * @param NewsAction $newsAction
     */
    public function __construct(NewsAction $newsAction)
    {
        $this->newsAction = $newsAction;
    }

    /**
     * Display a listing of the news posts.
     *
     * @param IndexNews $request
     * @return JsonResponse
     */
    public function index(IndexNews $request): JsonResponse
    {
        return $this->sendSuccess(
            NewsResource::collection(
                $this->newsAction->search( $request->getSanitizedData() )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNews $request
     * @return JsonResponse
     */
    public function store(StoreNews $request): JsonResponse
    {
        // Sanitize input
        $sanitized = $request->getSanitizedData();

        // Store the News Item
        $item = $this->newsAction->create($sanitized);

        if(empty($item)) {
            return $this->sendError(__('Item Store Failed'));
        }

        return $this->sendSuccess(
            new NewsResource($item),
            __('Item Stored Successfully')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param UpdateNews $request
     * @return JsonResponse|void
     */
    public function update($id, UpdateNews $request)
    {
        $sanitized = $request->validated();
        $item = $this->newsAction->findNews($id);

        if(empty($item)) {
            return $this->sendError(
                __('The item you are looking for does not exist'),
                404
            );
        }

        if($item->user_id != $request->user()->id) {
            return $this->sendError(
                __("You don't have permission to perform this action"),
                401
            );
        }

        return $this->sendSuccess(
            $this->newsAction->edit($sanitized, $id),
            __('News item updated successfully')
        );
    }

    public function destroy($id)
    {
        $item = $this->newsAction->findNews($id);

        if(empty($item)) {
            return $this->sendError(
                __('The item you are looking for does not exist'),
                404
            );
        }

        if($item->user_id != request()->user()->id) {
            return $this->sendError(
                __("You don't have permission to perform this action"),
                401
            );
        }

        return $this->sendSuccess(
            $this->newsAction->delete($id),
            __('News item Deleted successfully')
        );
    }
}

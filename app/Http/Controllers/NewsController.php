<?php

namespace App\Http\Controllers;

use App\Actions\NewsAction;
use App\Http\Requests\IndexNews;
use App\Http\Requests\StoreNews;
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
}

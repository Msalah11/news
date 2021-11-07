<?php

namespace App\Http\Controllers;

use App\Actions\NewsAction;
use App\Http\Requests\IndexNews;
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
}

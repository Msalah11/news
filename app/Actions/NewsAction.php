<?php

namespace App\Actions;

use App\Repositories\Interfaces\NewsRepository;

class NewsAction
{

    /**
     * Action Repository
     *
     * @var NewsRepository
     */
    protected $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function search($conditions)
    {
        $withRelation = ['user'];
        $orderBy = ['id' => 'DESC'];

        return $this->newsRepository->paginate(30, ['*'], $withRelation, $conditions, $orderBy);
    }
}

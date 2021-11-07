<?php

namespace App\Actions;

use App\Repositories\Interfaces\NewsRepository;
use Carbon\Carbon;

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

    public function create($data)
    {
        return $this->newsRepository->create($data);
    }

    public function edit($data, $id)
    {
        return $this->newsRepository->update($data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->newsRepository->delete(['id' => $id]);
    }

    public function deleteByDate($period): ?bool
    {
       $items = $this->newsRepository->all(['id'], [], function($q) use ($period) {
           return $q->where('created_at', '<=', Carbon::now()->subDays($period)->toDateTimeString());
       })->pluck('id')->toArray();

       if(!empty($items)) {
           return $this->newsRepository->bulkDelete($items);
       }

       return false;
    }

    public function findNews($id)
    {
        return $this->newsRepository->find($id, ['user']);
    }
}

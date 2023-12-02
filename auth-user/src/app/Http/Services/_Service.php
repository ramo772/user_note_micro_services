<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class _Service
{


     protected function create( $data)
     {

          return $this->model::create($data->toArray());
     }

     protected function update(Model $model, Collection $data)
     {

          $model->update($data->toArray());

          return $model;
     }


     protected function updateAll(array $ids, Collection $data)
     {

          $this->model::whereIn('id', $ids)->update($data->toArray());
     }

     protected function delete($id)
     {
          if ($id == 'all') return $this->deleteAll(request('ids', []));

          $this->model::destroy($id);
     }

     protected function deleteAll($ids)
     {

          $this->model::destroy($ids);
     }

     public function __call($method, $args)
     {
          return DB::transaction(function () use ($method, $args) {
               return call_user_func_array(
                    [$this, $method],
                    array_map(function ($arg) {
                         return is_array($arg) ? collect($arg) : $arg;
                    }, $args)
               );
          });
     }
}

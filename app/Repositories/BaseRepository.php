<?php

namespace App\Repositories;

use App\Enums\CommonEntries;
use App\Enums\Fields;
use App\Models\User;
use App\Repository\Currency\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $object = $this->model::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->jsonErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $object;
    }

    public function delete($id)
    {
        $object = $this->model::find($id);
        $object->delete();

        return $object;
    }

    public function update(array $data, $id = null, $object = null)
    {
        if ($object == null) {
            $object = $this->model::find($id);
            $object->update($data);
        } else {
            $object->update($data);
        }

        return $object;
    }

    public function getAllRecords()
    {
        return $this->model::all();
    }

    public function getRecordById($id, $select = [])
    {
        if (!empty($select)) {
            return $this->model->select($select)->find($id);
        }

        return $this->model->find($id);
    }

    public function jsonErrorResponse($message, int $status = Response::HTTP_NOT_FOUND): HttpResponseException
    {
        throw new HttpResponseException(
            $this->jsonResponse([
                'error' => $message,
            ], $status)
        );
    }

    public function jsonResponse($data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }

    public function select($selectFields = [], $orderBy, $perPage = CommonEntries::PER_PAGE, $searchFields = [], $search = null, $where = [], $count = [], $viewPath)
    {
        $query = $this->model::select($selectFields)->orderBy($orderBy[0], $orderBy[1]);
        $countResult = [];

        foreach ($where as $key => $value) {
            $query = $query->where($key, $value);
        }

        if ($search) {
            $query = $query->where(function ($query) use ($searchFields, $search) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        if(!empty($count)) {
            foreach ($count as $key => $values) {
                foreach($values as $value) {
                    $countResult[$key][$value] = $this->model::where($key, $value)->count();
                }
            }
        }

        $query = $query->paginate($perPage);

        return view($viewPath, compact('perPage', 'countResult'))->with($this->modifyString(class_basename($this->model)), $query);
    }

    private function modifyString($string)
    {
        $modifiedString = strtolower(substr($string, 0, 1)) . substr($string, 1);

        return $modifiedString . 's';
    }

    public function newQuery(): Builder
    {
        return $this->model::query();
    }
}

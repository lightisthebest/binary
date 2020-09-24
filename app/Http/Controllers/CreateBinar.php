<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Requests\BinarRequest;
use App\Models\Binar;
use Illuminate\Http\JsonResponse;
use Throwable;

class CreateBinar extends Controller
{
    use ResponseTrait;

    /**
     * @param BinarRequest $request
     * @return JsonResponse
     */
    public function store(BinarRequest $request)
    {
        try {
            $p_id = $request->post('parent_id');
            $pos = $request->post('position');
            if (Binar::where('parent_id', $p_id)->where('position', $pos)->exists()) {
                throw new ValidationException([], "Binar already exists");
            }
            /** @var Binar $parent */
            $parent = Binar::select(['path', 'level'])->where('id', $p_id)->first();
            $id = Binar::max('id') + 1;
            $binar = Binar::create([
                'id' => $id,
                'parent_id' => $p_id,
                'position' => $pos,
                'path' => $parent->path.'.'.$id,
                'level' => $parent->level + 1,
            ]);

            return response()->json(array_merge(SUCCESS_ARRAY, [
                "item" => $binar->toArray()
            ]));
        } catch (Throwable $e) {
            return self::handleException($e);
        }
    }
}

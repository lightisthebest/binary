<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Models\Binar;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class ManageBinar extends Controller
{
    use ResponseTrait;
    public $depth = 5;

    /**
     * @return JsonResponse
     */
    public function fillTable()
    {
        try {
            $new = [];
            DB::beginTransaction();
            $new_id = Binar::max('id') + 1;
            $collection = Binar::where('level', '<=', 5)->get();
            for ($i = 2; $i <= $this->depth; $i++) {
                $parents = $collection->where('level', $i - 1);
                foreach ($parents as $parent) {
                    foreach ([1, 2] as $pos) {
                        if (!$collection->where('parent_id', $parent->id)->where('position', $pos)->first()) {
                            $new[] = $binar = [
                                'id' => $new_id,
                                'parent_id' => $parent->id,
                                'position' => $pos,
                                'path' => $parent->path.'.'.$new_id,
                                'level' => $i
                            ];
                            $collection->add((object)$binar);
                            $new_id++;
                        }
                    }
                }
            }
            Binar::insert($new);
            DB::commit();
            return response()->json(SUCCESS_ARRAY);
        } catch (Throwable $e) {
            DB::rollBack();
            return self::handleException($e);
        }
    }

    /**
     * @param Binar $binar
     * @return JsonResponse
     */
    public function getRelated(Binar $binar)
    {
        try {
            if ($binar->id === 1) {
                $data = Binar::all();
            } else {
                $ids = explode('.', $binar->path);
                $data = Binar::whereIn('id', $ids)
                    ->orWhere('path', 'LIKE', "%.{$binar->id}.%")
                    ->get();
            }
            //todo continue here

        } catch (Throwable $e) {
            return self::handleException($e);
        }
    }
}

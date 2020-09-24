<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * Class Binar
 * @package App\Models
 * @method static self create(array $attributes)
 * @method static self find($id)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder select($columns = ['*'])
 * @method static bool insert(array $values)
 * @method static mixed max($column)
 *
 * @property int $id
 * @property int $parent_id
 * @property int $position
 * @property string $path
 * @property string $pos_path
 * @property int $level
 */
class Binar extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'parent_id',
        'position',
        'path',
        'pos_path',
        'level',
    ];

    protected $hidden = ['pos_path'];

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }
}

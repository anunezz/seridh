<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Cats\CatPopulation
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatPopulation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatPopulation extends Model
{
    protected $table = 'cat_populations';

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function getIsCreatorAttribute(): bool
    {
        return true;
        //return $this->user_id === auth()->user()->id;
    }
}

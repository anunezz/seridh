<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Cats\CatGobOrder
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatGobOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatGobOrder extends Model
{

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

<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Cats\CatSolidarityAction
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSolidarityAction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatSolidarityAction extends Model
{
    protected $fillable = ['name', 'cat', 'acronym'];

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

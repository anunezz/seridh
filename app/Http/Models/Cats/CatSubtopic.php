<?php namespace App\Http\Models\Cats;

use App\Http\Models\Recommendation;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Cats\CatSubtopic
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatSubtopic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatSubtopic extends Model
{
    protected $fillable = ['cat_subtopic_id', 'name','isActive'];

    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class);
    }

    public function topic()
    {
        return $this->belongsTo(CatSubtopic::class);

    }
}

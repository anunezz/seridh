<?php namespace App\Http\Models\Cats;

use App\Http\Models\Recommendation;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Cats\CatSubtopic
 *
 * @property int $id
 * @property string $name
 * @property string $cat_topic_id
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

    protected $fillable = ['name', 'cat', 'cat_topic_id'];

    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class);
    }

    public function topic()
    {
        return $this->belongsTo(CatSubtopic::class);

    }
    public function topics()
    {
        return $this->belongsTo(CatTopic::class, 'cat_topic_id', 'id');

    }

    protected $appends = ['is_used', 'hash'];

    public function scopeSearch($query, $search)
    {
            return $query->when(!empty($search), function ($query) use ($search){
                return $query->where('name', 'like', '%' .$search . '%')
                    ->orWhereHas('topics', function ($q) use ($search) {
                        $q->where('name', 'like', '%' .$search . '%');

            });

        });
    }

    public function getIsUsedAttribute()
    {
        $isUsed = \DB::table('themes_recommendation')->where('cat_subtopic_id', $this->id)->first();

        return $isUsed ? true : false;
    }

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

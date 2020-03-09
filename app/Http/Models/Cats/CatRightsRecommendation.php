<?php namespace App\Http\Models\Cats;

use App\Http\Models\Recommendation;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Cats\CatRightsRecommendation
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatRightsRecommendation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatRightsRecommendation extends Model
{
    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class);

    }
    public function subrights()
    {
        return $this->hasMany(CatSubRights::class, 'rights_recommendations_id')
            ->whereIsactive(true);
    }

    protected $appends = ['is_used', 'hash'];

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('name', 'like', '%' .$search . '%');
            });
        });
    }

    public function getIsUsedAttribute()
    {
        $isUsed = \DB::table('recommendation_right_subright')->where('right_id', $this->id)->first();

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

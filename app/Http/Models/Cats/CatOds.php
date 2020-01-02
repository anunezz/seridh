<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Recommendation;
/**
 * App\Http\Models\Cats\CatOds
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatOds whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatOds extends Model
{
    protected $table = 'cat_ods';



    public function goalsOds()
    {
        return $this->hasMany(CatGoalsOds::class, 'ods_id');
    }

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

    //Create by Adrian Núñez Alanis ------------------------------>
    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class);
    }

    public function subOds()
    {
        return $this->belongsToMany(
            CatSubtopic::class,
            'ods_recommendation',
            'ods_id',
            'goals_ods_id'
        )->distinct('goals_ods_id');
    }


}

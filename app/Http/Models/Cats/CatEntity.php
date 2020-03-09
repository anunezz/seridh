<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Recommendation;

/**
 * App\Http\Models\Cats\CatEntity
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Cats\CatEntity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatEntity extends Model
{
    protected $fillable = ['name', 'cat', 'acronym'];

    protected $appends = ['is_used', 'hash'];

    public function recommendation()
    {
        return $this->hasOne(Recommendation::class, 'cat_entity_id')->select('id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('name', 'like', '%' .$search . '%') ->orWhere ('acronym', 'like', '%' .$search . '%');
            });
        });
    }

    public function getIsUsedAttribute()
    {
        return isset($this->recommendation) ? true : false;
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

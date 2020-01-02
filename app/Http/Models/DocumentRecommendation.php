<?php namespace App\Http\Models;

use App\Http\Models\Cats\CatEntity;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\DocumentRecommendation
 *
 * @property int $id
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class DocumentRecommendation extends Model
{
    protected $appends = ['hash'];

    protected $fillable = ['title', 'folio', 'cat_entity_id', 'date', 'document_id'];


    function documents(){
        return $this->belongsTo(Document::class,'document_id','id', 'isType');
    }


    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function getIsCreatorAttribute(): bool
    {
        return true;
        //return $this->user_id === auth()->user()->id;
    }
}

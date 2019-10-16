<?php namespace App\Http\Models;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatReviewRight;
use App\Http\Models\Cats\CatReviewTopic;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubtopic;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Recommendation
 *
 * @property int $id
 * @property string $name
 * @property int|null $cat_entitie_id
 * @property int|null $cat_gob_order_id
 * @property int|null $cat_rights_recommendation_id
 * @property int|null $cat_population_id
 * @property int|null $cat_solidarity_action_id
 * @property int|null $cat_review_right_id
 * @property int|null $cat_review_topic_id
 * @property int|null $user_id
 * @property int|null $cat_od_id
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatEntitieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatGobOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatOdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatPopulationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatReviewRightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatReviewTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatRightsRecommendationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatSolidarityActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $cat_entity_id
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatEntityId($value)
 * @property string $recommendation
 * @property int|null $cat_gob_power_id
 * @property int|null $cat_attendig_id
 * @property int|null $cat_subtopic_id
 * @property int|null $cat_ods_id
 * @property string $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatAttendigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatGobPowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatOdsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatSubtopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereRecommendation($value)
 */
class Recommendation extends Model
{
    protected $fillable = ['recommendation', 'cat_entity_id', 'cat_gob_order_id', 'cat_gob_power_id', 'cat_attendig_id',
        'cat_rights_recommendation_id', 'cat_population_id', 'cat_solidarity_action_id', 'cat_review_right_id',
        'cat_review_topic_id', 'cat_subtopic_id', 'comments', 'isPublished'];

    protected $appends = ['hash', 'is_creator', 'implode_ods'];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function entity()
    {
        return $this->belongsTo(
            CatEntity::class,
            'cat_entity_id'
        );
    }

    public function order()
    {
        return $this->belongsTo(
            CatGobOrder::class,
            'cat_gob_order_id'
        );
    }

    public function power()
    {
        return $this->belongsTo(
            CatGobPower::class,
            'cat_gob_power_id'
        );
    }

    public function attending()
    {
        return $this->belongsTo(
            CatAttending::class,
            'cat_attendig_id'
        );
    }

    public function right()
    {
        return $this->belongsTo(
            CatRightsRecommendation::class,
            'cat_rights_recommendation_id'
        );
    }

    public function population()
    {
        return $this->belongsTo(
            CatPopulation::class,
            'cat_population_id'
        );
    }

    public function action()
    {
        return $this->belongsTo(
            CatSolidarityAction::class,
            'cat_solidarity_action_id'
        );
    }

    public function reviewRight()
    {
        return $this->belongsTo(
            CatReviewRight::class,
            'cat_review_right_id'
        );
    }

    public function reviewTopic()
    {
        return $this->belongsTo(
            CatReviewTopic::class,
            'cat_review_topic_id'
        );
    }

    public function subtopic()
    {
        return $this->belongsTo(
            CatSubtopic::class,
            'cat_subtopic_id'
        );
    }

    public function ods()
    {
        return $this->belongsToMany(
            CatOds::class,
            'ods_recommendation'
        );
    }

    public function documents()
    {
        return $this->hasMany(
            Document::class,
            'recommendation_id'
        )->where('isActive', true);
    }

    public function scopeSearch($query, $filters)
    {
        return $query->when(! empty ($filters), function ($query) use ($filters) {

            return $query->where(function($q) use ($filters)
            {
                $filters = json_decode($filters, false);

                if ($filters->recommendation) {
                    $q->where('recommendation', 'like', '%' . $filters->recommendation . '%');
                }

//                $q->whereHas('topics', function($q) use ($filters) {
//                    if ($filters->cat_topic_id) {
//                        $q->where('cat_topic_id', $filters->cat_topic_id);
//                    }
//                });
            });
        });
    }

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function getIsCreatorAttribute(): bool
    {
        return $this->user_id === auth()->user()->id;
    }

    public function getImplodeOdsAttribute()
    {
        return implode(', ', $this->ods->pluck('name')->toArray());
    }
}

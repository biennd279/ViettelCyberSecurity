<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Challenge
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $file_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge query()
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereUserId($value)
 * @mixin \Eloquent
 * @property string $suggestion
 * @property-read \App\Models\File $file
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Challenge whereSuggestion($value)
 */
class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'file_id',
        'suggestion'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    public function delete()
    {
        $this->file()->delete();
        return parent::delete();
    }
}

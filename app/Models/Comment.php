<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \App\Models\Task $task
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $fillable = [
        'description',
        'task_id',
        'user_id'
    ];
    protected $hidden = ['remember_token'];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
    
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mentionedUsers()
    {
         preg_match_all('/\@([^\s\.])/', $this->body, $matches);
 
         return $matches[1];
    }
}

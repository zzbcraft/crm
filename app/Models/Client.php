<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Client
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read mixed $assigned_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lead[] $leads
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Client extends Model
{

    protected $fillable = [
        'name',
        'company_name',
        'vat',
        'email',
        'address',
        'zipcode',
        'city',
        'primary_number',
        'secondary_number',
        'industry_id',
        'company_type',
        'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

   public function tasks()
    {
        return $this->hasMany(Task::class, 'client_id', 'id')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'client_id', 'id')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'client_id', 'id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->user_id);
    }
}

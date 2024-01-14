<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;

    protected $date = ['deleted_at'];


    protected $fillable = ['title', 'price', 'inventory', 'description', 'user_id'];

    public function Orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('count');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

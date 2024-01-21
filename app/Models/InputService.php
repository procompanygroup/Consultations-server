<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class InputService extends Model
{
    use HasFactory;
    protected $table = 'inputs_services';
    protected $fillable = [
        'service_id',
        'input_id',
        
             
    ];
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault();
    }
    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class)->withDefault();
    }
    public function valueService(): HasMany
    {
        return $this->hasMany(ValueService::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ExpertService extends Model
{
    use HasFactory;
    protected $table = 'experts_services';
    protected $fillable = [       
        'service_id',
        'expert_id',
        'points',
        'expert_cost',
        'cost_type',
        'expert_cost_value',
       ];
    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class)->withDefault();
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault();
    }

}

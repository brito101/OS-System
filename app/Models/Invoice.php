<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'subsidiary_id', 'description', 'category', 'invoice_id', 'type', 'value', 'due_date', 'repetition', 'quota', 'status', 'purchase_mode', 'annotation', 'file', 'provider_id'];

    /** Accessors */
    public function getDueDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
    }

    public function getValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    /** Relationships */
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class)->withDefault([
            'alias_name' => 'Todas',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }
}

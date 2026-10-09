<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recu extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'recus';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id_recu';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'numero_recu',
        'chemin_fichier',
        'date_generation',
        'paiement_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'date_generation' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Générer automatiquement un numéro de reçu
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($recu) {
            if (empty($recu->numero_recu)) {
                $recu->numero_recu = 'RECU-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relation avec le paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'paiement_id', 'id_paiement');
    }
}
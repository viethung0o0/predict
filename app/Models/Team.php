<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'description',
        'admin_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|unique:teams,name|max:255',
        'description' => 'min:10',
        'admin_id' => 'required|integer|min:0',
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $updateRules = [
        'name' => 'required|unique:teams,name|max:255',
        'description' => 'min:10',
        'admin_id' => 'required|integer|min:0',
    ];

    /**
     * Team belongsTo Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}

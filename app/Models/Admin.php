<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Admin
 *
 * @package App\Models
 * @version August 13, 2017, 9:05 am UTC
 *
 * @method static Admin find($id = null, $columns = array())
 * @method static Admin|\Illuminate\Database\Eloquent\Collection findOrFail($id, $columns = ['*'])
 * @property string name
 * @property string username
 * @property string email
 * @property password password
 * @property string birthday
 * @property string gender
 * @property string phone
 * @property integer role
 */
class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * Admin role
     */
    const ADMIN_ROLE = 1;

    /**
     * Viewer role
     */
    const VIEWER_ROLE = 2;

    /**
     * Gender is male
     */
    const MALE = 1;

    /**
     * Gender is female
     */
    const FEMALE = 2;

    /**
     * Gender is other
     */
    const OTHER_GENDER = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'admins';

    public static $roles = [
        self::ADMIN_ROLE => 'Admin',
        self::VIEWER_ROLE => 'Viewer',
    ];

    public static $genders = [
        self::MALE => 'Male',
        self::FEMALE => 'Female',
        self::OTHER_GENDER => 'Other',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'username',
        'email',
        'password',
        'birthday',
        'gender',
        'phone',
        'role'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'username' => 'string',
        'email' => 'string',
        //'birthday' => 'date',
        'gender' => 'string',
        'phone' => 'string',
        'role' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|max:255',
        'username' => 'required|unique:admins,username|max:255',
        'email' => 'required|email|unique:admins,email|max:255',
        'password' => 'required|confirmed|max:20',
        'birthday' => 'date_format:Y-m-d',
        'gender' => 'max:255',
        'phone' => 'max:255',
        'role' => 'required'
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $updateRules = [
        'name' => 'required|max:255',
        'username' => 'required|unique:admins,username|max:255',
        'email' => 'required|email|unique:admins,email|max:255',
        'password' => 'required|confirmed|max:20',
        'birthday' => 'date_format:Y-m-d',
        'gender' => 'max:255',
        'phone' => 'max:255',
        'role' => 'required'
    ];

    /**
     * Set password attribute.
     *
     * @param str $password Password
     *
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        if (empty($password)) {
            return;
        }
        if (app('hash')->needsRehash($password)) {
            $password = app('hash')->make($password);
        }
        $this->attributes['password'] = $password;
    }

    /**
     * Admin belongsTo Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teams()
    {
        return $this->hasMany(Team::class, 'admin_id', 'id');
    }
}

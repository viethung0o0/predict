<?php

namespace App\Repositories;

use App\Models\Admin;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AdminRepository
 * @package App\Repositories
 * @version August 13, 2017, 9:05 am UTC
 *
 * @method Admin findWithoutFail($id, $columns = ['*'])
 * @method Admin find($id, $columns = ['*'])
 * @method Admin first($columns = ['*'])
*/
class AdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return Admin::class;
    }
}

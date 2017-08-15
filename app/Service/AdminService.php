<?php

namespace App\Service;

use App\Models\Admin;
use App\Repositories\AdminRepository;

class AdminService
{
    /** @var  AdminRepository */
    private $adminRepo;

    /**
     * AdminService constructor.
     *
     * @param AdminRepository $adminRepo AdminRepository
     *
     * @return void
     */
    public function __construct(AdminRepository $adminRepo)
    {
        $this->adminRepo = $adminRepo;
    }

    /**
     * Create admin account
     *
     * @param array $input Input
     *
     * @return Admin
     */
    public function create(array $input)
    {
        $admin = $this->adminRepo->create($input);

        return $admin;
    }

    /**
     * Update admin account
     *
     * @param array $input Input data
     * @param int   $id    Id of admin
     *
     * @return Admin
     */
    public function update(array $input, int $id)
    {
        $this->adminRepo->find($id, ['id']);

        if (is_null($input['password'])) {
            unset($input['password']);
        }

        $admin = $this->adminRepo->update($input, $id);

        return $admin;
    }

    /**
     * Get admin info when edit
     *
     * @param int $id Id of admin
     *
     * @return Admin
     */
    public function getAdminDataWhenEdit(int $id)
    {
        $admin = $this->adminRepo->find($id, [
            'id',
            'name',
            'username',
            'email',
            'password',
            'birthday',
            'gender',
            'phone',
            'role'
        ]);

        return $admin;
    }

    /**
     * Get admin info when show
     *
     * @param int $id Id of admin
     *
     * @return Admin
     */
    public function getAdminDataWhenShow(int $id)
    {
        $admin = $this->adminRepo->find($id, [
            'id',
            'name',
            'username',
            'email',
            'birthday',
            'gender',
            'phone',
            'role'
        ]);

        return $admin;
    }

    /**
     * Delete admin account
     *
     * @param int $id Id of admin
     *
     * @return Admin
     */
    public function delete(int $id)
    {
        $this->adminRepo->find($id, ['id']);

        return $this->adminRepo->delete($id);
    }
}
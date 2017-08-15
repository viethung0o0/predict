<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Flash;
use Response;
use App\Service\AdminService;
use Exception;

class AdminController extends AppBaseController
{
    /** @var  AdminService */
    private $adminService;

    /**
     * AdminController constructor.
     *
     * @param AdminService $adminService AdminService
     *
     * @return void
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the Admin.
     *
     * @param AdminDataTable $adminDataTable
     *
     * @return Response
     */
    public function index(AdminDataTable $adminDataTable)
    {
        try {
            return $adminDataTable->render('backend.admins.index');
        } catch (Exception $ex) {
            return redirect(route('admin.'));
        }
    }

    /**
     * Show the form for creating a new Admin.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.admins.create');
    }

    /**
     * Store a newly created Admin in storage.
     *
     * @param CreateAdminRequest $request
     *
     * @return Response
     */
    public function store(CreateAdminRequest $request)
    {
        $input = $request->only([
            'name',
            'username',
            'email',
            'password',
            'birthday',
            'gender',
            'phone',
            'role'
        ]);

        try {
            $admin = $this->adminService->create($input);
            Flash::success('Admin saved successfully.');
        } catch (Exception $ex) {
            Flash::error('Create admin account failed.');
        }

        return redirect(route('admin.admin-managements.index'));
    }

    /**
     * Display the specified Admin.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        try {
            $admin = $this->adminService->getAdminDataWhenShow($id);
        } catch (ModelNotFoundException $ex) {
            Flash::error('Admin not found.');
            return redirect(route('admin.admin-managements.index'));
        } catch (Exception $ex) {
            Flash::error('Server error.');
            return redirect(route('admin.admin-managements.index'));
        }

        return view('backend.admins.show')->with('admin', $admin);
    }

    /**
     * Show the form for editing the specified Admin.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        try {
            $admin = $this->adminService->getAdminDataWhenEdit($id);
        } catch (ModelNotFoundException $ex) {
            Flash::error('Admin not found.');
            return redirect(route('admin.admin-managements.index'));
        } catch (Exception $ex) {
            Flash::error('Server error.');
            return redirect(route('admin.admin-managements.index'));
        }

        return view('backend.admins.edit')->with('admin', $admin);
    }

    /**
     * Update the specified Admin in storage.
     *
     * @param  int               $id
     * @param UpdateAdminRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdminRequest $request)
    {
        $input = $request->only([
            'name',
            'username',
            'email',
            'password',
            'birthday',
            'gender',
            'phone',
            'role'
        ]);

        try {
            $admin = $this->adminService->update($input, $id);
            Flash::success('Admin updated successfully.');
        } catch (ModelNotFoundException $ex) {
            Flash::error('Admin not found.');
        } catch (Exception $ex) {
            Flash::error('Update admin account failed.');
        }

        return redirect(route('admin.admin-managements.index'));
    }

    /**
     * Remove the specified Admin from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->adminService->delete($id);
            Flash::success('Admin deleted successfully.');
        } catch (ModelNotFoundException $ex) {
            Flash::error('Admin not found.');
        } catch (Exception $ex) {
            Flash::error('Delete admin account failed.');
        }

        return redirect(route('admin.admin-managements.index'));
    }
}

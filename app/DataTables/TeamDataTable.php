<?php

namespace App\DataTables;

use App\Models\Admin;
use Form;
use Yajra\Datatables\Services\DataTable;

class AdminDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->orderColumn('admins.id', '-admins.id $1')
            ->escapeColumns([
                'name',
                'username',
                'email',
                'birthday',
                'gender',
                'phone',
            ])
            ->editColumn('role', function ($admin) {
                return Admin::$roles[$admin->role] ?? null;
            })
            ->editColumn('gender', function ($admin) {
                return Admin::$genders[$admin->gender] ?? null;
            })
            ->addColumn('action', 'backend.admins.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $admins = Admin::query();
        $admins->select([
            'admins.id',
            'admins.name',
            'admins.username',
            'admins.email',
            'admins.birthday',
            'admins.gender',
            'admins.phone',
            'admins.role',
            'admins.created_at',
        ]);

        return $this->applyScopes($admins);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                        'extend' => 'collection',
                        'text' => '<i class="fa fa-download"></i> Export',
                        'buttons' => [
                            'csv',
                            'excel',
                            'pdf',
                        ],
                    ],
                    'colvis'
                ],
                'language' => ['url' => asset('vendor/datatables/Vietnamese.json')]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'id' => ['name' => 'admins.id', 'data' => 'id'],
            'name' => ['name' => 'admins.name', 'data' => 'name'],
            'username' => ['name' => 'admins.username', 'data' => 'username'],
            'email' => ['name' => 'admins.email', 'data' => 'email'],
            'birthday' => ['name' => 'admins.birthday', 'data' => 'birthday'],
            'gender' => ['name' => 'admins.gender', 'data' => 'gender'],
            'phone' => ['name' => 'admins.phone', 'data' => 'phone'],
            'role' => ['name' => 'admins.role', 'data' => 'role']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'admins';
    }
}

<?php

namespace App\DataTables;

use App\Models\Team;
use Form;
use Yajra\Datatables\Services\DataTable;

class TeamDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->orderColumn('teams.id', '-teams.id $1')
            ->escapeColumns([
                'name',
            ])
            ->addColumn('action', 'backend.teams.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $teams = Team::query();
        $teams->with([
            'admin' => function ($q) {
                $q->select(['id', 'name']);
            }
        ])->select([
            'teams.id',
            'teams.name',
            'teams.created_at',
            'teams.admin_id'
        ]);

        return $this->applyScopes($teams);
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
            'id' => ['name' => 'teams.id', 'data' => 'id'],
            'name' => ['name' => 'teams.name', 'data' => 'name'],
            'creator' => ['name' => 'admin.name', 'data' => 'admin.name'],
            'created_at' => ['name' => 'teams.created_at', 'data' => 'created_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'teams';
    }
}


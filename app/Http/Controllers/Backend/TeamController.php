<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\TeamDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Flash;
use Response;
use App\Service\TeamService;
use Exception;

class TeamController extends AppBaseController
{
    /** @var  TeamService */
    private $teamService;

    /**
     * TeamController constructor.
     *
     * @param TeamService $teamService TeamService
     *
     * @return void
     */
    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the Team.
     *
     * @param TeamDataTable $teamDataTable
     *
     * @return Response
     */
    public function index(TeamDataTable $teamDataTable)
    {
        try {
            return $teamDataTable->render('backend.teams.index');
        } catch (Exception $ex) {
            return redirect(route('admin.'));
        }
    }

    /**
     * Show the form for creating a new Team.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.teams.create');
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param CreateTeamRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamRequest $request)
    {
        $input = $request->only([
            'name',
            'description',
        ]);

        try {
            $team = $this->teamService->create($input);
            Flash::success('Team saved successfully.');
        } catch (Exception $ex) {
            Flash::error('Create team account failed.');
        }

        return redirect(route('admin.team-managements.index'));
    }

    /**
     * Display the specified Team.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        try {
            $team = $this->teamService->getTeamDataWhenShow($id);
        } catch (ModelNotFoundException $ex) {
            Flash::error('Team not found.');
            return redirect(route('admin.team-managements.index'));
        } catch (Exception $ex) {
            Flash::error('Server error.');
            return redirect(route('admin.team-managements.index'));
        }

        return view('backend.teams.show')->with('team', $team);
    }

    /**
     * Show the form for editing the specified Team.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        try {
            $team = $this->teamService->getTeamDataWhenEdit($id);
        } catch (ModelNotFoundException $ex) {
            Flash::error('Team not found.');
            return redirect(route('admin.team-managements.index'));
        } catch (Exception $ex) {
            Flash::error('Server error.');
            return redirect(route('admin.team-managements.index'));
        }

        return view('backend.teams.edit')->with('team', $team);
    }

    /**
     * Update the specified Team in storage.
     *
     * @param int               $id
     * @param UpdateTeamRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamRequest $request)
    {
        $input = $request->only([
            'name',
            'description',
        ]);

        try {
            $team = $this->teamService->update($input, $id);
            Flash::success('Team updated successfully.');
        } catch (ModelNotFoundException $ex) {
            Flash::error('Team not found.');
        } catch (Exception $ex) {
            Flash::error('Update team account failed.');
        }

        return redirect(route('admin.team-managements.index'));
    }

    /**
     * Remove the specified Team from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->teamService->delete($id);
            Flash::success('Team deleted successfully.');
        } catch (ModelNotFoundException $ex) {
            Flash::error('Team not found.');
        } catch (Exception $ex) {
            Flash::error('Delete team account failed.');
        }

        return redirect(route('admin.team-managements.index'));
    }
}

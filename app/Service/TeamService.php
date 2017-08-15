<?php

namespace App\Service;

use App\Repositories\TeamRepository;

class TeamService
{
    /** @var  TeamRepository */
    private $teamRepo;

    /**
     * TeamService constructor.
     *
     * @param TeamRepository $teamRepo TeamRepository
     *
     * @return void
     */
    public function __construct(TeamRepository $teamRepo)
    {
        $this->teamRepo = $teamRepo;
    }

    /**
     * Create a team
     *
     * @param array $input Input
     *
     * @return Team
     */
    public function create(array $input)
    {
        $team = $this->teamRepo->create($input);

        return $team;
    }

    /**
     * Update a team
     *
     * @param array $input Input data
     * @param int   $id    Id of admin
     *
     * @return Team
     */
    public function update(array $input, int $id)
    {
        $this->teamRepo->find($id, ['id']);

        $team = $this->teamRepo->update($input, $id);

        return $team;
    }

    /**
     * Get team info when edit
     *
     * @param int $id Id of admin
     *
     * @return Team
     */
    public function getTeamDataWhenEdit($id)
    {
        $team = $this->teamRepo->find($id, [
            'id',
            'name',
            'description',
            'admin_id',
        ]);

        return $team;
    }

    /**
     * Get team info when show
     *
     * @param int $id Id of admin
     *
     * @return Team
     */
    public function getTeamDataWhenShow($id)
    {
        $team = $this->teamRepo->find($id, [
            'id',
            'name',
            'description',
            'admin_id',
        ]);

        return $team;
    }

    /**
     * Delete a team
     *
     * @param int $id Id of admin
     *
     * @return Team
     */
    public function delete($id)
    {
        $this->teamRepo->find($id, ['id']);

        return $this->teamRepo->delete($id);
    }
}
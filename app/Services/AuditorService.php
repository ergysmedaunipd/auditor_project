<?php

namespace App\Services;

use App\Models\Auditor;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\Auditors\Location;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuditorService
{
    /**
     * Retrieve all auditors from the database.
     *
     * @return Collection Returns a collection of all Auditor models.
     */
    public function getAllAuditors(): Collection
    {
        return Auditor::all();
    }

    /**
     * Retrieve a specific auditor by their ID.
     *
     * @param mixed $auditorId The ID of the auditor to retrieve.
     * @return Auditor Returns the Auditor model that matches the provided ID.
     * @throws ModelNotFoundException if no Auditor with the given ID exists.
     */
    public function getAuditorById(mixed $auditorId): Auditor
    {
        return Auditor::findOrFail($auditorId);
    }

    /**
     * Retrieve the timezone shift for a specific auditor.
     *
     * @param mixed $auditorId The ID of the auditor to retrieve the timezone shift for.
     * @return string Returns the timezone shift for the auditor's location.
     */
    public function getTimezoneShift(mixed $auditorId): string
    {
        $auditor = $this->getAuditorById($auditorId);
        return Location::locationTimezone($auditor->location);

    }

}

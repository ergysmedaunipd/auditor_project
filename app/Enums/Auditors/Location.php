<?php
namespace App\Enums\Auditors;

/**
 * Class Location
 *
 * This class defines constants for different locations.
 * It also provides methods to get all the locations and the timezone for a given location.
 */
class Location
{
    // three possible locations: Spain, Mexico and India.
    const SPAIN = 'spain';
    const MEXICO = 'mexico';
    const INDIA = 'india';

    /**
     * Get all locations
     *
     * This method returns an array of all the locations defined in this class.
     *
     * @return array An array of all locations
     */
    public static function getLocations(): array
    {
        return [
            self::SPAIN,
            self::MEXICO,
            self::INDIA,
        ];
    }

    /**
     * Get timezone for a given location
     *
     * This method returns the timezone string for a given location.
     * If the location is not recognized, it defaults to 'UTC'.
     *
     * @param self::SPAIN|self::MEXICO|self::INDIA $location The location for which to get the timezone
     * @return string The timezone string for the given location
     */
    public static function locationTimezone(string $location): string
    {
        return match ($location) {
            self::SPAIN => 'Europe/Madrid',
            self::MEXICO => 'America/Mexico_City',
            self::INDIA => 'Asia/Kolkata',
            default => 'UTC',
        };
    }
}

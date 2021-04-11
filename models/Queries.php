<?php 
require_once __DIR__."/../handlers/ResponseHandler.php";

function GetQuery($queryName) {
    switch($queryName) {

        case "TotalShowType":
            return QueryResponse(
            "SELECT 
                `tblShowTypes`.`description` AS 'descriptor', 
                COUNT(`show_id`) AS 'value' 
            FROM `tblShows` 
            INNER JOIN tblShowTypes 
                ON `tblShowTypes`.`type_id` = `tblShows`.`type_id` 
            GROUP BY `tblShows`.`type_id`"
            );

        case "TotalRatings":
            return QueryResponse(
            "SELECT 
                description as 'Rating', 
                COUNT(`show_id`) as 'Total' 
            from `tblShowRatings`
            inner join `tblRatings`
                on `tblShowRatings`.`rating_id` = tblRatings.rating_id
            group by tblShowRatings.rating_id"
            );

        case "TotalTvShowsForReleaseYears":
            return QueryResponse(
            "SELECT 
				tblShows.year_of_release as 'Year', 
				COUNT(tblShows.show_id) as 'Total' 
			FROM tblShows 
			INNER JOIN tblShowTypes
				ON tblShows.type_id = tblShowTypes.type_id
			WHERE tblShowTypes.description = 'TV Show' 
			GROUP BY tblShows.year_of_release"
            );

        case "TotalMoviesForReleaseYears":
            return QueryResponse(
            "SELECT 
				tblShows.year_of_release as 'Year', 
				COUNT(tblShows.show_id) as 'Total' 
			FROM tblShows 
			INNER JOIN tblShowTypes
				ON tblShows.type_id = tblShowTypes.type_id
			WHERE tblShowTypes.description = 'Movie' 
			GROUP BY tblShows.year_of_release"
            );

        case "TotalNumberOfSeasons":
            return QueryResponse(
                "SELECT
                    SUM(tblShows.duration) as 'Total'
                FROM tblShows
                INNER JOIN tblShowTypes
                    ON tblShows.type_id = tblShowTypes.type_id
                WHERE tblShowTypes.description = 'TV Show'"
            );

        case "AvailableSeasons":
            return QueryResponse(
                "SELECT 
                    tblShows.duration as 'Seasons', 
                    count(tblShows.show_id) as 'Total'
                FROM tblShows 
                INNER JOIN tblShowTypes 
                    on tblShows.type_id = tblShowTypes.type_id 
                WHERE tblShowTypes.description = 'TV Show' 
                GROUP BY tblShows.duration
                ORDER BY Total desc"
            );

        case "TopActors":
            return QueryResponse(
                "SELECT 
                    tblCast.name as 'Name',
                COUNT(tblShowCast.show_id) as 'Total'
                FROM tblCast
                INNER JOIN tblShowCast
                    ON tblShowCast.cast_id = tblCast.cast_id
                GROUP BY tblShowCast.cast_id
                ORDER BY Total DESC
                LIMIT :limit"
            );

        case "TopCountries":
            return QueryResponse(
                "SELECT 
                    tblCountries.name as 'Name',
                COUNT(tblShowCountries.show_id) as 'Total'
                FROM tblCountries
                INNER JOIN tblShowCountries
                    ON tblShowCountries.country_id = tblCountries.country_id
                GROUP BY tblCountries.country_id
                ORDER BY Total DESC
                LIMIT :limit"
            );

        case "AllCountries":
            return QueryResponse(
                "SELECT 
                    tblCountries.name as 'Name'
                FROM tblCountries"
            );

        case "AllCountryMovies":
            return QueryResponse(
                "SELECT 
                    tblShows.title as 'Title'
                FROM tblShows
                INNER JOIN tblShowCountries
                    ON tblShows.show_id = tblShowCountries.show_id
                INNER JOIN tblCountries
                    ON tblShowCountries.country_id = tblCountries.country_id
                WHERE tblCountries.name = :constraint"
            );

        case "TopFilmsForRating":
            return QueryResponse(
                "SELECT 
                    tblShows.title, tblRatings.description 
                FROM tblShows
                INNER JOIN tblShowRatings
                    ON tblShows.show_id = tblShowRatings.show_id
                INNER JOIN tblRatings
                    ON tblShowRatings.rating_id = tblRatings.rating_id
                WHERE tblRatings.description = :constraint
                LIMIT :limit"
            );

        case "DurationFrequency":
            return QueryResponse(
                "SELECT tblShows.duration, COUNT(tblShows.show_id) 
                FROM tblShows 
                INNER JOIN tblShowTypes
                    ON tblShows.type_id = tblShowTypes.type_id
                WHERE tblShowTypes.description = :constraint
                GROUP BY tblShows.duration
                ORDER BY LENGTH(tblShows.duration), tblShows.duration ASC"
            );

        default:
            return NewResponse(400, "Invalid param name");
    }
}

function QueryResponse($query) {
    return NewResponseWithPayload(200, "Query", $query);
}
?>
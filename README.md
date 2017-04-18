# README #

## HTACCESS ##

The htaccess removes the .php extension from the url's.
This also rewrites urls to hide variable names.

## DATABASE, INCLUDES AND OTHER CONFIGURATION ##

All configuration and included files are declared in config.php
Database functions that are used in multiple pages are declared in db.php, inside the class.

## API DOCUMENTATION ##

### getInitCheck ###
/getInitCheck

#### params ####
none

### getRoutes ###
/getRoutes/{id}

#### params ####
__(Optional) id__

Returns a single route
If not filled in, returns all routes

### getPOIs ###
/getPOIs/{routeId}

#### params ####
__(Optional) routeId__

Returns POIs for a single route
If not filled in, returns all POIs

### getPOITypes ###
/getPOITypes/{id}

#### params ####
__(Optional) id__

Returns a single POIType
If not filled in, returns all POITypes

### getExercises ###
/getExercises/{poiTypeId}/{difficultyId}

#### params ####
__(Optional, but Always used with difficultyId) poiTypeId__

Returns exercises with are equal to the filter



__(Optional, but Always used with poiTypeId) difficultyId__

Returns exercises with are equal to the filter

### getDifficulties ###
/getDifficulties/{id}

#### params ####
__(Optional) id__

Returns a single difficulty
If not filled in, returns all difficulties
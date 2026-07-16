# Domain

## Core models
- `User` — has_many Trip; auth via password, google OAuth, or OTP
- `Trip` — belongs_to User; has_many RouteStop, Expense, Photo, Note, Like, Comment; has `is_public` style visibility (see `PublicTripsSeeder`)
- `RouteStop` — ordered stop on a trip's route
- `Expense` — cost entry attached to a trip
- `Photo` — image attached to a trip
- `Note` — freeform note attached to a trip
- `Like`, `Comment` — social interactions on public trips

## API surface
- Defined in `routes/api.php`, Sanctum-protected where applicable
- Self-documenting via Scramble — check the generated docs endpoint rather than hand-maintained specs

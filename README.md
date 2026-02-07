# Order Service 


### Table of contents

1. [Project overview](#project-overview)
2. [Architecture](#architecture)
    - [Layers](#layers)
    - [Event sourcing and CQRS](#event-sourcing--cqrs)
    - [Command/Query bus & middleware](#commandquery-bus--middleware)
3. [Error handling & messaging](#error-handling--messaging)
4. [Events (examples)](#events-examples)
5. [Tests & CI](#tests--ci)
6. [Local setup (developer)](#local-setup-developer)
7. [Conventions & best practices used](#conventions--best-practices-used)
8. [Contributing](#contributing)
9. [Contact / Notes](#contact--notes)
#
## Project overview
Order Service implements order lifecycle management: create orders (with or without orderlines), add orderlines, remove orderlines. It is designed as a single bounded context using Event Sourcing with CQRS and a clean layered architecture.

### Key features
 * Create order (guest / registered)
 * Add orderline(s) to order
 * Remove orderline(s) from order (with quantity semantics and safety guards)
 * Command / Query bus with middleware pipeline
 * Deterministic domain events for all state changes (replayable)
 * Domain-level invariants enforced via domain exceptions
 * Unit tests for success and failure scenarios; tests run in CI

 #

## Architecture

### Layers
 * **Domain** — pure domain: aggregates, value objects, domain events, domain exceptions. No dependencies on other layers.
 * **Application** — command and query handlers, DTOs, application exceptions, policies. Depends on Domain.
 * **Infrastructure** — repositories, event store wiring, HTTP clients (e.g. ProductHttpClient), persistence adapters. Depends on Domain + Application.
 * **API** — HTTP controllers / routes; maps requests to commands/queries and returns translated results. Depends on Application.

### Event sourcing & CQRS
 * Aggregates emit domain events via Spatie Event Sourcing. Events are the source of truth; read models (projections) are built from events.
 * Commands mutate state via command handlers; queries fetch read-model data.
 * Aggregates are not constructed via `new` — they are retrieved/rebuilt from event store.

### Command/Query bus & middleware
A dispatched command/query flows through middleware in this order:

**Comands**

`ResultDataTranslatorMiddleware <=> LoggingMiddleware <=> TransactionMiddleware <=> CommandHandler`

**Queries**

`ResultDataTranslatorMiddleware <=> LoggingMiddleware <=> QueryHandler`

Middleware responsibilities:
 * `ResultDataTranslatorMiddleware` — convert domain result to application DTO / API shape
 * `LoggingMiddleware` — contextual logging for observability
 * `TransactionMiddleware` — start/commit/rollback DB transactions for commands

## Error handling & messaging
 * Domain exceptions: one exception class per domain invariant; message crafted for logging and for internal diagnostics.
 * Application exceptions: domain-aware business errors (e.g. ProductServiceNotReachedException, ProductNotFoundException, DuplicateDraftOrderException). Each includes:
    * userMessage — safe, non-technical string for API consumers
    * logContext — detailed information for engineers and logs
* API responses map application exceptions to proper HTTP status codes (e.g., 400, 404, 409, 503) and return the userMessage in the response body.

## Events (examples)

* `OrderCreated`
* `OrderlineAdded`
* `OrderlineRemoved`

Events are deterministic. All time values are passed explicitly (no implicit `new DateTimeImmutable()` in event constructors).

## Tests & CI

 * Unit tests cover success and failure cases for:
    * Create order (with/without orderlines)
    * Add orderline(s)
    * Remove orderline(s)
    * External failures (product service unreachable)
    * Domain validation (customer not found, duplicate draft, quantity too low)
* Aggregate tests validate emitted events (use Spatie aggregate testing helpers, e.g. OrderAggregateRoot::fake() → when() → assertRecorded() / assertNothingRecorded()).
* Tests execute in CI and are required to pass for merges.

## Local setup (developer)

 * PHP 8.6.4 (as used in this project)
 * Composer
 * PostgreSQL (or configured DB for event store and read models)
 * Kafka (if used for share event and messages)
 * Optional: Docker for reproducible dev environment

### Install and prepare
```bash
composer install
cp .env.example .env
php artisan key:generate
# run migrations / event-store setup
php artisan migrate
# if you use projections/mappers:
php artisan event-sourcing:replay
```
### Run tests
 * Domain tests (only domain/aggregate):
```bash
# Run domain tests in tests/Domain (aggregate tests)
php artisan test tests/Domain
```
 * Full test suite (all tests):
```bash
php artisan test
```

## Conventions & best practices used
 * Events must be deterministic; pass timestamps explicitly from application/handler level or via a Clock abstraction.
 * No side effects in event constructors.
 * Domain validation throws domain-specific exceptions; command handlers translate them into application exceptions as needed.
 * Repositories / event-store access can be abstracted behind interfaces to facilitate unit testing without touching the database.

## Contributing
 * Write tests for every change: domain rules → unit tests asserting events; projections/SQL → integration tests.
 * Follow existing exception and event naming conventions.
 * Document new public commands/queries in this README and update API route documentation.

## Contact / Notes
 * This service implements Order lifecycle only. Other bounded contexts (Product, Customer) are external and accessed via HTTP clients; their failures are modeled explicitly in application exceptions and returned as user-friendly messages.


## Development


### Install
Requires git and Composer

* `git clone git@github.com:calderawp/caldera-forms-admin.git`
* `cd caldera-forms-admin`
* `composer install`
* `yarn`

### Local Development Environment
A  local development environment is included, and provided. It is used for integration tests. Requires Composer, Docker and Docker Compose.

* Install Local Environment And WordPress "Unit" Test Suite
- `composer wp-install`

You should know have WordPress at http://localhost:8888/

* (re)Start Server: Once server is installed, you can start it again
- `composer wp-start`

* Activate the plugin inside of container
- `composer wp-activate`

### Testing

#### Install
Follow the steps above to create local development environment, then you can use the commands listed in the next section.

#### Use
Run these commands from the plugin's root directory.

* Run All php Test, Sniffs and Lints
    - `composer tests`
* Run php Unit Tests
    - `composer unit-tests`
* Run WordPress Integration Tests
    - `composer wp-tests`
* Fix All Code Formatting
    - `composer formatting`
* Run JavaScript Unit Test Watcher
    - `yarn test`
* Run JavaScript Unit Tests Once
    - `yarn test:once`
* Test JavaScript Unit Test Coverage
    - `yarn test:coverage`


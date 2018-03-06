Example code for an upcoming Torque article showing how to modify REST API requests to content routes to improve search, using an object-oriented approach.

**This Plugin Is For Educational Purposes _This Plugin Does Not Work_** See the "Recommend Next Steps" section below for recommendations on what to do to finish this plugin.

This plugin demonstrates the beginning of the process of using PHPUnit for isolated unit testing of PHP code for WordPress. It will also illustrates -- in a future revision -- how to use PHPUnit and the WordPress test suite to create integration tests.

This plugin also demonstrates using Composer for dependency management, as well as using Composer as a task runner. The tasks run by composer will include code sniffing with PHPCS and automatic conforming to PSR-1 and PSR-2 for PHP code formatting, but with tabs instead of spaces. Always tabs.

This plugin is not done. You should finish it to learn these concepts.
## Development

### Install
Requires git and Composer

* `git clone git@github.com:caldera-learn/rest-api-search.git`
* `cd rest-api-search`
* `composer install`

### Tests

#### Install
* Install all tests besides integration tests
   - They were installed automatically by Composer
* Install Integration Tests
    - Switch to bin
    - `cd bin`
    - Install tests (this SHOULD erase your database)
    - `bash ./install-wp-tests local root root`
    - This command assumes your database is called "local", and has a user "root" with this password of "root"

#### Use
Run these tests from the plugin's root directory, unless directed otherwise.
* Run Tests and Code Sniffs
    - `composer test`
* Run Unit Tests and Integration Tests
    - `composer tests`
* Run Unit Tests
    - `composer unit-tests`
* Fix all code formatting
    - `composer formatting`
* Integration tests (also runs unit tests)
    * Run these tests from the `bin` directory
    * `bash run-tests.sh`

## Recommend Next Steps
* Abstract out all WordPress specific logic to methods that are required by an interface
* Mock all classes that required creation of an interface in previous step
* Write a unit test for each method of each class that isn't mocked.
* Complete integration tests for WordPress interactions.
* Finish the `Hooks` class so all of this works.
* Add coverage reports and achieve full test coverage.
* Integration tests (next revision and planned Torque post)
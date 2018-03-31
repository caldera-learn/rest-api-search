[![Build Status](https://travis-ci.org/caldera-learn/rest-api-search.svg?branch=master)](https://travis-ci.org/caldera-learn/rest-api-search)

Example code for a series of Torque article showing how to modify REST API requests to content routes to improve search, using an object-oriented approach.

**This Plugin Is For Educational Purposes _This Plugin Does Not Work_** See the "Recommend Next Steps" section below for recommendations on what to do to finish this plugin.

This plugin demonstrates the beginning of the process of using PHPUnit for isolated unit testing of PHP code for WordPress. It will also illustrates -- in a future revision -- how to use PHPUnit and the WordPress test suite to create integration tests.

This plugin also demonstrates using Composer for dependency management, as well as using Composer as a task runner. The tasks run by composer will include code sniffing with PHPCS and automatic conforming to PSR-1 and PSR-2 for PHP code formatting, but with tabs instead of spaces. Always tabs.

This plugin is not done. You should finish it to learn these concepts.

## Articles
This code is for a series of articles on [Torque Magazine](https://torquemag.io/author/joshp/) by [Josh Pollock](https://JoshPress.net) on advanced object-oriented PHP for WordPres developers.

* [Part One: Customizing The WordPress REST API To Improve Search](https://torquemag.io/2018/03/advanced-oop-wordpress-customizing-rest-api-endpoints-improve-wordpress-search/)
    - The example code for part one is in [this gist](https://gist.github.com/Shelob9/ec02944421cbc57dbff3dbdfbdc3bf0d) and [this gist](https://gist.github.com/Shelob9/8f59a1ece87337a03f2ebffbc235e45e)
* [Part Two: __Future Post__ Writing Testable Code That Interacts With The WordPress Plugins API and REST API]()
    - [This Commit](https://github.com/caldera-learn/rest-api-search/commit/c8e0a27f281b63b3c7e64c9ca598b06aa7a2c875) is the plugin as of part two.
    - The code in this commit basically works to modify the REST API results, but we don't have tests to prove it.
* [Part Three: __Future Post__ Writing Unit Tests ]()
    - [This Commit](https://github.com/caldera-learn/rest-api-search/tree/ecdce18d737f258b4cf9ab35f2cfd473fd57bbb1) is the plugin as of part three.
    - The code in this commit works to modify the REST API results, and creates as much test coverage we can get with isolated unit tests.
* [Part Four: __Future Post__ Setting Up Integration Tests In Docker)]() 
    - [This Commit](https://github.com/caldera-learn/rest-api-search/commit/0ce0ae8869779a580f738553123a10d5cd0b28ac) is the plugin as of part four.
    - In this commit the Docker-based integration testing environment is added. The integration tests, which will be explained in part five are almost complete in this commit, but do not pass.
* [Part Five: __Future Post__ Writing Integration Tests ]()
    - [This Commit](https://github.com/caldera-learn/rest-api-search/commit/0ce0ae8869779a580f738553123a10d5cd0b28ac) is the plugin as of part five.
    - The tests, that are explained in part five are complete in this commit, and do pass.
* [Part Six: __Future Post__ Test Automation  With Travis  ]()
    - [This Commit](https://github.com/caldera-learn/rest-api-search/commit/e2017afca02d7406eb93b5bb3d5bcf49a353b8c8) is the plugin as of part six.
    - The tests, that are explained in parts three and five are now run using the environment created in part 5 for local testing and development automatically using Travis CI.
    
## Development


### Install
Requires git and Composer

* `git clone git@github.com:caldera-learn/rest-api-search.git`
* `cd rest-api-search`
* `composer install`

### Local Development Environment
A  local development environment is included, and provided. It is used for integration tests. Requires Composer, Docker and Docker Compose.

* Install Local Environment And WordPress "Unit" Test Suite
- `composer wp-install`

You should know have WordPress at http://localhost:8888/

* (re)Start Server: Once server is installed, you can start it again
- `composer wp-start`

### Testing

#### Install
Follow the steps above to create local development environment, then you can use the commands listed in the next section.

#### Use
Run these commands from the plugin's root directory.

* Run All Tests and Code Sniffs and Fixes
    - `composer tests`
* Run Unit Tests
    - `composer unit-tests`
* Run WordPress Integration Tests
    - `composer wp-tests`
* Fix All Code Formatting
    - `composer formatting`

## Recommend Next Steps
* Abstract out all WordPress specific logic to methods that are required by an interface
* Mock all classes that required creation of an interface in previous step
* Write a unit test for each method of each class that isn't mocked.
* Complete integration tests for WordPress interactions.
* Finish the `Hooks` class so all of this works.
* Add coverage reports and achieve full test coverage.
* Integration tests (next revision and planned Torque post)
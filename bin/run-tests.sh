#!/usr/bin/env bash
#Report PHPUnit version to remind ourselves this likely NOT the same version as composer is using
phpunit --version
# Run tests
phpunit --configuration='../phpunit.xml.dist'  --bootstrap=../Tests/bootstrap-integration.php
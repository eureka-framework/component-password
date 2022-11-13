# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

```
## [tag] - YYYY-MM-DD
[tag]: https://github.com/eureka-framework/component-deployer/compare/1.3.0...master
### Changed
 - Change 1
### Added
 - Added 1
### Removed
 - Remove 1
```
----


## [4.1.0] - 2022-11-13
### Added
 - PHPStan + config
### Removed
 - PHP Compatibility
### Changed
 - Update CI GitHub actions
 - Update makefile
 - Update Readme
 - Fix code style & warnings from PHPStan

## [4.0.0] - 2020-10-29
### Changed
 - New require PHP 7.4+
 - Move some code outside Password class
 - Generator parameters are now on generate method
 - Upgrade phpcodesniffer to v0.7 for composer 2.0
### Added
 - Added tests
 - Set up CI
 - Suggest eureka/component-console as complementary package for password script helper


## [3.x.y] Release v3.x.y
### Changed
 - Require PHP 7.2 min
 - Replace ircmaxell/randomLib generator by internal generator
 - Use php 7 random_int() method for randomization
 - Some clean

## [2.x.y] Release v2.x.y
### Added
 - Add Generator class
 - Add Script generator
### Changed
 - Password as service
 - Move code
 


## [1.0.0] - 2019-04-03
### Added
  - Add Breadcrumb item & controller aware trait
  - Add Flash notification service & controller aware trait
  - Add Menu item & controller aware trait
  - Add meta controller aware trait
  - Add Notification item

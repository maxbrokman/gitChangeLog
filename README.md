[![Build Status](https://travis-ci.org/maxbrokman/gitChangeLog.svg?branch=master)](https://travis-ci.org/maxbrokman/gitChangeLog)
[![Coverage Status](https://img.shields.io/coveralls/maxbrokman/gitChangeLog.svg)](https://coveralls.io/r/maxbrokman/gitChangeLog)

## Git Based Change Log

This package generates a change log style report from git commits. Each tag is listed with its date and any commits included in it tagged with a certain string (@public by default)

## Requirements

- PHP must be able to run exec().
- Git must be installed! You should probably have some tags as well...

## Code Example

    $changeLog = new MaxBrokman\GitChangeLog\ChangeLog( new MaxBrokman\GitChangeLog\Git );
    $log = $changeLog->getChangeLog( $page = 1 );


Will return something like

    [
        {
            "tag": "v1",
            "date": 1409965746, // utc time
            "changesSinceLastTag":
                [
                    {
                        "commit": "9e9125b", // Short commit hash
                        "author": "Max Brokman <max.brokman@gmail.com>",
                        "message": "Commit Message @public"
                    },
                ...
                ]
        },
        ...
    ]

## Use Case

I work on an internal project for a large company. Some of our stakeholders want to be kept informed about what is happening with the application.
We release several times a day, and this package allows us to provide a list within the application of what has been updated, without having to manually maintain a changelog.
We use **@public** in commit messages to mark them as safe for public (well in our case internal) consumption.

## API Reference

To change the pattern used to find public commit messages you may call `setPublicMarker( "grep pattern" )` on the instance of MaxBrokman\GitChangeLog\Git you pass to to ChangeLog


To change the number of results per page you may call `setPerPage( 100 )` on MaxBrokman\GitChangeLog\ChangeLog

## Tests

Tests are run using [PHPUnit](https://phpunit.de/ "PHPUnit"). Run `phpunit` from the root directory.

GitTest.php requires a git repo with a tag v0.0.1

## License

The MIT License (MIT)

Copyright (c) 2014 Max Brokman

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
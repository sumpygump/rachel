# Rachel

```
 ▄▄▄            ▄         ▄
 █  █ ▄▄▄   ▄▄▄ █▄▄   ▄▄  █
 ██▀   ▄▄█ █    █  █ █▄▄█ █
 █ ▀▄ ▀▄▄█ ▀▄▄▄ █  █ ▀▄▄▄ ▀▄▄

Refactoring assimilation can help everyone learn
```

Improve your software development skills by learning about different refactoring techniques and keep them in your head. Challenge yourself to refactoring something everyday.

This is a simple program that provides a "refactoring-of-the-day" from [Martin Fowler's refactoring catalog](https://refactoring.com/catalog/) and from [Refactoring.guru](https://refactoring.guru/refactoring/techniques).

## Installation

Installing globally via [composer](https://getcomposer.org):

```
composer global require sumpygump/rachel
```

Ensure `~/.composer/vendor/bin` is on your `$PATH` to be able to invoke rachel from any directory on your CLI.

Alternatively, you can clone this repository, and then run `composer install` from the path that was cloned.

## Usage

From the command line, run `bin/rachel` to invoke.

- `bin/rachel` will print the current refactoring of the day. (Alias of `bin/rachel today`)
- `bin/rachel date 2019-02-28` will print the refactoring for a specific date.

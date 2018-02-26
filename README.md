# Yarn plugin for [PHPCI](https://www.phptesting.org)

A plugin for PHPCI to download and install npm packages required by your application.

### Install the Plugin

1. Navigate to your PHPCI root directory and run `composer require hammock/yarn-phpci-plugin`
2. If you are using the PHPCI daemon, restart it
3. Update your `phpci.yml` in the project you want to deploy with

### Prerequisites

1. [yarn](https://yarnpkg.com/en/) needs to be installed.

### Plugin Options
- **command** _[string, require]_ - Command name. See [docs](https://docs.npmjs.com/)
- **directory** _[string, optional]_ - Relative path to run yarn command in.
- **flags** _[list, optional]_ - Command flags

### PHPCI Config

```yml
    Hammock\PHPCI\Yarn:
        command: install
```
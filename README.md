![GitHub Workflow Status](https://img.shields.io/github/workflow/status/sebot/mist/PHP%20Composer?style=for-the-badge) ![GitHub repo size](https://img.shields.io/github/repo-size/sebot/mist?style=for-the-badge) ![GitHub License](https://img.shields.io/github/license/sebot/mist?style=for-the-badge) ![Languages](https://img.shields.io/github/languages/count/sebot/mist?style=for-the-badge) ![Last Commit](https://img.shields.io/github/last-commit/sebot/mist?style=for-the-badge) ![Releases](https://img.shields.io/github/v/release/sebot/mist?include_prereleases&style=for-the-badge) ![Downloads](https://img.shields.io/github/downloads/sebot/mist/total?style=for-the-badge) ![Discord](https://img.shields.io/discord/517358401529839626?style=for-the-badge)

# Mist

Mist is a Framework for building WordPress Themes - it's to be used by developers
who want to built custom Themes for WordPress with ease using an OOP API in both
frontend and backend.

The Framework can be used in any WordPress Theme including child themes, simply install it using composer as per installation notes below and start using the classes in your Theme to customize it with ease!

## Installation

The framework source is not available as composer package right now (sooooonish) - however you're more than safe to use everything inside /src to take a look. For production use make sure you have a good understanding of php and WordPress.

## Why a Framework on top of a Framework (WordPress)?

Because WordPress is only the foundation layer. See Mist as a Wrapper, a Toolkit-Set of classes to get repetetive tasks like post type creation or customizer settings done. It also provides a way to securely generate forms or post meta fields from code without much hassle. 

Mist also brings you more object oriented approaches to work with Post objects, Images and schema.org

## Configuration over Convention

The framework leaves choices to you everywhere not getting in your way with some nasty css, js or hooks you can't get rid of. You can use a configuration file mist.config.json which you can simply create in your theme root to get basic stuff like post types, theme support, navigation and alike set and usable.

## WIP

- [x] implement config loading
- [x] load post types (multiple) with their respective args handed over to johnbillion/extended-cpts
- [x] load theme support
- [x] load nav menus
- [x] allow all configuration items to be created via code (sometimes config just does not fit)
- [x] move "theme" assets/enqueuing to theme (atm in framework)
- [x] add Mist css and js
- [x] test theme in live env
- [ ] add theme colors and expose them to plugins (and blocks)
- [ ] add support for meta fields (acf replacement)
- [ ] eject Mist from theme as composer package to be used as framework hence anything inside ./src has to stay dependency-free at all times (except require-dev ofc) -> a few dependencies are always necessary (!)
- [ ] add schema.org (all of them) ~~check this plugin to safe time https://de.wordpress.org/plugins/seo-by-rank-math/ _~~ (plugin code is crap)
- [ ] add svg sizes and default colors to mist config
- [ ] add customizer settings via config
- [ ] add form creator (TBD)
- [ ] extended-cpts should be optional (this is sort of working already by using filter over config)
- [ ] top level theme wide configuration (colors etc.)
- [ ] default theme wide widget title tag
- [ ] documentation
- [ ] add sticky header option

# Changelog

## v0.3.1(9) - 29.06.2024
- Fixed errors caused by missing json/graph.data.json (json/ directory still required)

## v0.3.0(8) - 16.06.2024
- Fixed graph generation for multiple values instead of one
- Graph generation as class with methods for different graph types
- Stylistic and output buffering modifications across entire root
- Added display of phpversion() to footer.php

## v0.2.2(7) - 15.06.2024
### DP (thesis) release:
- Added type info form database columns
- Removed unnecessary files (`profile/*.png`; `json/*.json`)

## v0.2.1(6) - 06.04.2024
### Security update:
- Added automatic log out after 20 minutes (session timeout in `localhost/templates/header.php`)
- `*.*.php` pages are protected from access by not logged-in users

## v0.2.0(5) - 05.04.2024
- Added functionality for receiving data from ESP32 via `localhost/dataHandler.php`

## v0.1.0(4) - 04.04.2024
### Major update:
- Added **View** button with _view graph with selected data from database_ functionality

## v0.0.3(3) - 04.04.2024
- Major code fix and cleanup in **Sign in** and **Register** functionalities

## v0.0.2(2) - 24.02.2024
- Added changelog.md
- Updated file references to root folder for:
  - include/require
  - header()
- Updated PHPMailer from 6.8.0 to 6.9.1
- Updated README.md

## v0.0.1(1) - 24.02.2024
### Initial commit
- Developed during 2023

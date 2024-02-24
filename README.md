# Aquarius project

Aquarius project is designed to regulate water temperature of aquarium based on peltier module. Devices regulating temperature are controlled by microcontroller - ESP32 module, which uploades measured temperature values to database. Database along with Web UI is running on Raspberry Pi. Web UI consists of login/registration system and simple function, which uploads data to database using GET method.

This is the **_initial commit_** of this project, which comes with these functions:

## **Functions:**

This section lists currently implemented functions of Aquarius.

### **Web UI - v0.0.1**

- Sign in system
- Registration system
- Simple data upload via `localhost/dataHandler.php` using parameters: projectID; value1; value2
- PHP 8.2.4

#### Database structure:

| DATABASE    | TABLE   | COLUMN   |
| ----------- | ------- | -------- |
| diplomka_ud |         |          |
|             | users   |          |
|             |         | uid      |
|             |         | username |
|             |         | email    |
|             |         | password |
| diplomka_pd |         |          |
|             | proj123 |          |
|             |         | id       |
|             |         | temp     |
|             |         | time     |

## **Added folders/files:**

This section lists current project folder structure.

- web/
- .gitignore
- README.md

## **Release notes:**

- **_initial commit_**

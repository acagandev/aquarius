# Aquarius project

Aquarius project is designed to regulate water temperature of aquarium based on peltier module. Devices regulating temperature are controlled by microcontroller - ESP32 module, which uploades measured temperature values to database. Database along with Web UI is running on Raspberry Pi. Web UI consists of login/registration system and simple function, which uploads data to database using GET method. Data in database can be viewed after filling form in graph via Profile > View button.

## **Functions:**

This section describes functionalities in current release of Aquarius Web.

### **Web UI 0.1.0**

- Sign in system
- Registration system
- Viewing graph of values in database selected via on Profile > View tab
- Simple data upload via `localhost/dataHandler.php` using parameters: projectID; value1; value2
- PHP 8.3.4

#### Database structure:

| DATABASE    | TABLE       | COLUMN      |
| ------------| ------------| ------------|
| diplomka_ud |             |             |
|             | users       |             |
|             |             | uid         |
|             |             | username    |
|             |             | email       |
|             |             | password    |
| diplomka_pd |             |             |
|             | temperature |             |
|             |             | id          |
|             |             | tempWater   |
|             |             | tempAmbient |
|             |             | measured    |
|             | tds         |             |
|             |             | id          |
|             |             | tds         |
|             |             | measured    |

## **Release notes:**

[see changelog](/changelog.md)

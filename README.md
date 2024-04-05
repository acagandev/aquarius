# Aquarius project

Aquarius project is designed to regulate water temperature of aquarium based on peltier module. Devices regulating temperature are controlled by microcontroller - ESP32 module, which uploades measured temperature values to database. Database along with Web UI is running on Raspberry Pi. Web UI consists of login/registration system. It is also possible to receive and upload data into database. Data in database can be viewed after filling form in graph via Profile > View button.

## **Functions:**

This section describes functionalities in current release of Aquarius Web.

### **Web UI 0.2.0**

- Sign in system
- Registration system
- Viewing graph of selected data in database via on Profile > View tab
- Receive and upload data into database via `localhost/dataHandler.php`
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

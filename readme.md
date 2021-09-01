## Introduction
BBN SMS API Client is a simple library that powers your sms to send sms notifications and transactional alerts in a fly. The setup is so simple it shouldn't take more than two minutes to get up and running.
## Pre-requisites
1. Create a BBN SMS Account at https://bbnsms.com (Note: this will redirect to https://sms.bbnplace.com)
2. Register your Sender Names for Approval. (This is a regulatory step. Sender name approval may take 24 - 48 hours. While you await the approval, let's proceed with the setup.
3. Make sure you have downloaded and installed composer for your project. [See guide on how to install composer](https://https://getcomposer.org/doc/00-intro.md).


## Setup
### 1. Install Package
 You can add the bbnsms api client into your project by adding
```
"bbnsms/sms-api-client": "dev-master"
```
to your dependencies (the require attribute) of your composer.json file followed by  running
```
composer install
```
on your terminal. Or you could simply run
```
composer require bbnsms/sms-api-client
```
on your terminal. This will install bbnsms-api-client and all it's dependencies into your vendor directory.


### 2. Setup Package
Create a .bbnsms.json file in your app root directory. Add your BBN SMS login credentials to the file as follows

```
{
    "access": {
        "credentials": {
            "username": "me@company.com",
            "password": "aWe$0mePas5word"
        }
    }
}
```

And that's it! You are all setup!


## Test the Library

At the top of your script or class file import SMSClient and create an instance of the SMSClient as follows:
```
use Bbnsms\SMSClient;

$smsclient = new SMSClient();
```

### Test your login credentials
```
printf("Valid Credentials: %s", $smsclient->testCredentials());
```
### Check your Balance
```
printf("Balance: %.2f", $smsclient->getBalance());
```
### Send SMS to a Single Contact
```
printf("Send Response: %s", $smsclient->send("Hello", "BBN LAB", ["2348183172770"], 0));
```
### Send SMS to a Multiple Contacts
```
printf("Send Response: %s", $smsclient->send("Hello", "BBN LAB", ["2348183172770","2349090000246"], 0));
```
### Scheduling Message
```
// printf("Scheduler Response: %s", $smsclient->schedule(time() + 60, "SchedTstr", "Hello", "BBN LAB", ["2348183172770"], 0));
```
A successfully sent message will return 1801 as response. See full list of response codes and their meanings in the **API Response** section below.


## API Responses
| Response Code | Definition 
|---------------|--------------
|1800           | Request timeout
|1801           |Message successfully sent
|1802           |Invalid username
|1803           |Incorrect password
|1804           |Insufficient credit
|1805           |Invalid url submission
|1806           |Invalid mobile
|1807           |Invalid sender id
|1808           |Message too long
|1809           |Empty Message
|1901           |Schedule was successfully saved
|1902           |Scheduled broadcast time cannot be earlier than current time
|1903           |Invalid broadcast time
|1904           |Schedule name is too long. Maximum of 16 alphanumeric characters allowed
|1905           |Invalid value for notify me. 0 or 1 expected
|1906           |Incorrect Schedule Name. Schedule name may contain special character
|2001           |App ID does not exist
|2002           |Invalid App ID
|2003           |IP Lock Violation
|3001           |Recipient - Message ID mismatch. Number of recipients does not correlate with provided message ids


If you would like to customize your integration, kindly refer to our[Integration Guide](https://dev.bbnplace.com/docs/).
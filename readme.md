## Introduction
BBN SMS API Client is a simple library that powers your app to send sms notifications at transaction time. The setup is so simple it shouldn't take more than two(2) minutes to get up and running.
## Pre-requisites
1. Create a BBN SMS Account at https://bbnsms.com (Note: this will redirect to https://sms.bbnplace.com)
2. Login to bbnsms.com and register your Sender Names for Approval. (This is a regulatory step. Sender name approval may take 24 - 48 hours.) While you await the approval, let's proceed with the setup.


## Setup
Before we begin, make sure you have downloaded and installed composer for your project. [See guide on how to install composer](https://https://getcomposer.org/doc/00-intro.md).
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
Create a .bbnsms.json file in your app root directory. Add your BBN SMS login credentials (generated during pre-requisite step one) to the file as follows

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

And that's all the setup! Surprised? Let's test the package.


## Test the Library

Since we are working with composer, I am trusting somewhere in your project you have already autoloaded classes. BBN SMS API Client will autoload if you have done something like this at least in your entry script. 

```
require_once __DIR__."/vendor/autoload.php";
```
*** If you are using a framework, that would have already been done for you.

At the top of your script or class file import **Bbnsms\SMSClient** and create an instance of the SMSClient as as appropriate
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
To send message call the **send** method of the sms client as follows:

SMSClient->send(string message, string senderName, array recipients, bool flash=false): string

Example:
#### Send Inbox SMS
~~~~
printf("Send Response: %s", $smsclient->send("Sample Message", "APPROVED_SENDER_NAME", ["234818xxxxxxx"]));
~~~~

#### Send Flash SMS
~~~~
printf("Send Response: %s", $smsclient->send("Sample Message", "APPROVED_SENDER_NAME", ["234818xxxxxxx"], true));
~~~~
### Send SMS to a Multiple Contacts
~~~~
printf("Send Response: %s", $smsclient->send("Hello", "APPROVED_SENDER_NAME", ["234818xxxxxxx","234909xxxxxxx"]));
~~~~
### Scheduling Message

Scheduled message will require two additional parameters: broadcastTime and scheduleName

    SMSClient->schedule(int broadcastTime, string scheduleName, string message, string senderName, array recipients, bool flash=false): string

broadcastTime will be a UNIX_TIMESTAMP value. Kind of timestamp you generate by simply calling php time().

Example:
#### Schedule Inbox SMS
~~~~
// printf("Scheduler Response: %s", $smsclient->schedule(time() + 60, "SchedTstr", "Hello", "APPROVED_SENDER_NAME", ["234818xxxxxxx"]));
~~~~
#### Schedule Flash SMS
~~~~
// printf("Scheduler Response: %s", $smsclient->schedule(time() + 60, "SchedTstr", "Hello", "APPROVED_SENDER_NAME", ["234818xxxxxxx"], true));
~~~~

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

## Important Note:
### Sender Names
1. APPROVED_SENDER_NAME are sender names you have registered on bbnsms.com which has been confirmed approved
2. Sender names are eleven (11) alphanumeric character string.
3. Sender names must be the name, shortened name or acronymns of your business.

### Message
1. Messages cannot be longer than 765 characters (5 pages)
2. Pages are counted according to sms messaging standards as follows:
   1. A single page SMS will accept 160 characters
   2. The second page of sms only accomodates 146 characters
   3. Every other sms page accomodates 153 characters
3. A flash message is a message that pops-up on the receiving device to be read instantly and may not save to the receiving mobile phone Inbox.


If you would like to customize your integration, kindly refer to our [Integration Guide](https://dev.bbnplace.com/docs/).


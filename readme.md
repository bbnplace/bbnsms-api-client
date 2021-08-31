**Pre-requisites**
1. Create a BBN SMS Account at https://bbnsms.com (Note: this will redirect to https://sms.bbnplace.com)
2. Register your Sender Names for Approval. (This is a regulatory step. Sender name approval may take 24 - 48 hours. While you await the approval, let's proceed with the setup.


**Setup**
1. Using Composer
Make sure you have downloaded and installed composer for your project. You can either require the bbnsms api client into your project by typing
```
"bbnsms/sms-api-client": "dev-master"
```
in the require attribute of your composer.json file followed by  running
```
composer install
```
on your terminal. Or you could simply run
```
composer require bbnsms/sms-api-client
```
on your terminal. This will install bbnsms and all it's dependencies into our vendor directory.


1. Install the library by typing composer install
2. Create a .bbnsms.json file in your app root directory. Paste your login credentials as follows

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

**Login Types**
There are two supported values for login types: **credentials** and **apiKey** The credential login type will requires you to specify your username and password while the API Key method requires that you generate an API key on BBN SMS Developer Platform. If API Key based account, you are required to input the generated key into the **config.json** file.

**API Parameters**
| Parameter | Relevance | Definition
|--------------|-------------|------------------------------------
| username | Required | Your BBN username (usually an email)
| password | Required | Your BBN alphanumeric password
| apiKey   | Optional | An alternative method of authenticatin g your access to the API
| appId    | Optional | System generated Identification for the app
| sender    | Required | An up-to-eleven character alphanumeric name that appears as the originator of your message. Kindly note that since June 2021, it is a requirement that all sender names be pre-approved before use. Use the link below to submit your sender names for approval.
| message  | Required | The body of the message to be sent. A single page message would contain max 160 characters. Second page will accommodate additional 146 characters. Every other page takes 153 characters. SMS message cannot be longer than five (5) pages.
|mobile    | Required | The mobile number of the recipient preceeded with country code. Eg. 2348050209037. When sending sms to multiple numbers, the numbers should be seperated with a comma(,) eg. 2348050209037,2349090000246,23480xxxxxxx,...
| flash | Optional | When this option is set to 1, the message instantly appears on the recipient's phone without saving to their Inbox. Default value is 0.
| schedule | Optional | When this option is set to 1, message will deliver at the date and time defined in **broadcast_time**. The default value is 0.
| broadcast_time | Optional  | Required only when **schedule** is set to 1. This should be set to the UNIX timestamp value of the date-time when message should broadcast. The default timezone is WAT(GMT+1).
| schedule_name | Optional | An optional 16 character alphanumeric name that will be used to uniquely identify the schedule.
| schedule_notification | Optional | Set to 1 if you want to receive sms notification on your verified number when scheduled a message has been sent. Default value is 0.


**API Responses**
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


**Delivery Statuses**
|Status    |Interpretation
|----------|--------------------
|DELIVERED |Recipient has received the message
|NOT_DELIVERED |Message could not be terminated to the destination mobile
|EXPIRED |Message could not be sent
|REJECTED |SMSC refused to teminate the message
|ACCEPTED |SMSC has received the message
|DELETED |Message has been purged from gateway
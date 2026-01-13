
🟦 Google Wallet Documentation (PHP)

This repository also includes a Google Wallet example demonstrating how to create and issue Google Wallet passes using the Google Wallet REST API.

📦 Composer Dependencies (Google Wallet)

The Google Wallet PHP example uses the following Composer packages:
~~~
{
  "require": {
    "guzzlehttp/guzzle": "^7.8",
    "firebase/php-jwt": "^6.10",
    "google/apiclient": "^2.16",
    "google/auth": "^1.40"
  }
}
~~~

☁️ Google Cloud Console Setup
1️⃣ Google Account & Business Profile

-Use a Google Account
-Set up your Business Profile under the same account (e.g Business name, Business location, Public business identity)



2️⃣ Create a Google Cloud Project

- Go to Google Cloud Platform
- Create a new project
- Name it something like: project_nameGoogleWallet


3️⃣ Enable Google Wallet API

- Go to Enabled APIs & Services
- Click + Enable APIs & Services
- Search for Google Wallet API
- Click Enable

5️⃣ Generate JSON Key
- Under the Service Account, go to the Keys tab
- Click Add Key → Create New Key
- Select JSON then a .json file will automatically download ➡️ This file is used as your authentication credentials

📄 config.json (Service Account Credentials)

Open the downloaded JSON file and copy its contents into a file named: config.json

~~~

{
  "type": "",
  "project_id": "",
  "private_key_id": "",
  "private_key": "",
  "client_email": "",
  "client_id": "",
  "auth_uri": "",
  "token_uri": "",
  "auth_provider_x509_cert_url": "",
  "client_x509_cert_url": "",
  "universe_domain": "googleapis.com"
}

~~~

⚠️ Important

- Do NOT commit this file to GitHub
- Keep it secure
- You will reference this file path in wallet.php



🧾 Google Pay & Wallet Console Setup

6️⃣ Access Google Pay & Wallet Console
- Go to Google Pay & Wallet Console
- Create or select your Business
- You will be assigned a Merchant ID and Issuer ID (shown beside your business name) ➡️ These IDs are required when creating passes.

7️⃣ Create a Generic Pass Class

- In Google Wallet Console, Create a Generic Class
- This class defines: Layout, Fields, Branding
- Classes can also be created programmatically via the API

8️⃣ Request Publishing Access

- Request Publishing Access
- This is required for production usage
- Until approved, passes work in test mode only


######Google Wallet Documentation######

#Google Cloud Console
1) Set up your google account
2) Set up your business profile in the same google account
3) Go to Google Cloud Platform for the same email and create a new p[roject named "project_nameGoogleWallet"
 
  a)Go to Enabled APIs & Services
 
  b)Go to Google Wallet API
 
  c)Activate API
 
  d)Under IAM & Admin, go to Service Accounts and Add a Service Account
 
  e)Under the Service Accounts, add the account and then go to Keys Tab
 
  f)Click Add Key -> Create New Key: This should prompt you to download a json.file (You will use this later on as config.json in the code)


#Google Play & Wallet Console

5) Once you created a business in Google Pay & Wallet Console, you will have a unique a merchant ID and Issuer ID (this is beside your business name) 

6) Create a class for the pass. (This is done by triggering the code o connect to the API) 

7) Request Publishing Access to Google for production usage


📁 Example Files Included

🟦 wallet.php
- PHP backend
- Authenticates using config.json
- Creates or references:
- Generic Class
- Generic Object
- Generates a Google Wallet Save URL

🌐 index.html

Simple frontend example
- Collecting user input
- Triggering pass creation
- Redirects user to Google Wallet “Save to Wallet” flow



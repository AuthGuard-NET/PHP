# AuthGuard.NET's PHP Implementation
> Template by colorlib.com under the CC BY 3.0 license

# Getting started

## Setup
First you'll need to get your **Secret Key** and your **API Key**:
- Secret Key is located at https://authguard.net/dashboard on your application's row
- API Key is located at https://authguard.net/dashboard/account.php on the right

### Connecting panel to your website
After you got the your **Secret Key** and your **API Key**, you can now Initialize and connect your application to our servers
```
include ("api/authguard.php");
Guard::Initialize("API KEY", "SECRET KEY");
```
## Example
```
Guard::Initialize("a4xefa5b126aa5e4be470140a522c10aa07a6d60", "35Yd6RgEM23XUmtpYTqFvW5IZ7xSX6hAcgdi7tXTC1Qwv");
```
## Login

```
if (Guard::Login($username, $password))
{
    //Code you want to do here on successful login
}
```
> After a successful login, the server will send back the following information on your user encoded in json
* ``username`` : Users username 
* ``email`` : Users email
* ``hwid`` : Users hwid
* ``level`` : Users level
* ``expiry`` : Users expiry
* ``lastlogin`` : Users last login
## Register

```
if (Guard::Register($username, $password, $email, $license))
{
    //Code you want to do here on successful register
}
```
## Extend Subscription
```
if (Guard::UseToken($username, $password, $license))
{
    // Do code of what you want after successful extend here!
}
```

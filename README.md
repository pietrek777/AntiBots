

----------

# AntiDDoS
#### AntiDDoS plugin for Spigot

----------

## Features
* Switchable AntiDDoS protection
* Commands for enabling and disabling protection and for changing default settings
* Verified users database can be easily truncated from game using command
* Permission for every command
* Not verified players have to visit your page, and fill the [reCAPTCHA](https://www.google.com/recaptcha/intro/)


## Requirements
* Spigot/Bukkit server for Minecraft 1.8/1.12
* Hosting, that supports PHP >=5.3 (there are a lot of free hostings, and almost all of it supports PHP)
* MySQL database (also available on almost all hostings)

## Building
If you want to build this app from sourcecode, go to __java__ folder, open your console and execute this command:

```sh
mvn clean package
```

After that go to target folder. File __antiddos-x.x-jar-with-dependencies.jar__ 
You can also download builded packages, ready to go from [here](https://github.com/pietrek777/AntiDDoS/releases)

## Video tutorials
(Coming soon)
## Instalation
### PHP side configuration
 * Download AntiDDoS package (or build it from sourcecode if you really want)
 * Go to [Google reCAPTCHA site](https://www.google.com/recaptcha/intro/), click *Get reCAPTCHA* button, and register your domain (any subdomains can be registered as well). Now you have your *Site key* and *Secret key* (save them somewhere, it will be required for futher configuration)
 * Open your FTP client (for example [FileZilla](https://filezilla-project.org/), it's free), log into your server and upload **content** of **php** folder to your domain root (or to other subfolder)
 *  Go to **./resources** and open **verification.ini**. Here you have to set some some settings:
  - **host** – your database host (e.g. http://mysql.example.com)
  -  **username** – your database username
  -  **password** – your database account password
  -  **database** – database name
  -  **site-key** – your *reCAPTCHA* site key
  -  **secret-key** – your *reCAPTCHA* secret key
  - **allowed_api_ips** (optional) – Ip's allowed to use the verified-users API, separated by space (e.g. if your Spigot server will be requesting to API from IP 1.2.3.4, add this IP to this setting, then API will be accessed only from 1.2.3.4 IP. Clients with every other IP will receive [403 Response Code](https://en.wikipedia.org/wiki/HTTP_403). If your server IP for outer connections is not persistent, or you don't know this IP, leave this setting empty)
 * Now open your domain (or where you placed the files). If you see reCAPTCHA with checkbox and "I'm not a robot" label, you configured reCAPTCHA well ([image with verification configured properly](http://i.imgur.com/24xFf1Q))
   > **verification.ini**  template is also available [here](https://pastebin.com/4rudZNiA)


### Bukkit/Spigot side configuration
 * Place plugin JAR in your server **./plugins** folder, and run your server (or type */reload* command)
 * Go to **./plugins/AntiDDoS/** and open **config.yml**. There are also some things to configurate here
  - **protection ➔ enabled-default** – is AntiDDoS protection will be launched on start
  - **protection ➔ kick-message** – message, that will be displayed to not-verified players on kick
  - **protection ➔ verification-url** – URL, where players can verify their accounts (so if your domain is example.com and you placed files into domain root, the URL will be *http://example.com/*)
  - **connection ➔ host** – your domain name (e.g. http://example.com)
  - **connection ➔ port** – propably you don't have to change it, port 80 is default HTTP port (see [HTTP session](https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#HTTP_session))
  - **connection ➔ path** – if you placed files in your domain root, just leave *api.php* value (however if you placed files in e.g. /verification change it to "/verification/api.php")
  -  **~~connection ➔ path~~** (deprecated) – just leave it as it is
  -  **wipe ➔ url** – URL for your **wipe.php** file
  - **wipe ➔ secret-key** (not to be mistaken with reCAPTCHA secret key) – paste here **wipe-password** from verification.ini (this password is generated on first visit to verification site, if you don't have the password, enter the verification site)
  -  **~~response ➔ outcome~~** (deprecated) – just leave it as it is
  -  **~~response ➔ result~~** (deprecated) – just leave it as it is
 * Restart your server (or type */reload* command)

And finally plugin is ready. Now you can set up [permissions](#permissions). I know, that verification may be hard, so if something is not working, see [FAQ](#FAQ) section. If there's no answer to your problem there, [contact me](#contact), or [start a new issue](https://github.com/pietrek777/AntiDDoS/issues).

## Commands
> Note
> Params in **[angle braces]** are required, those in **&lt;square braces&gt;** are optional

 * **/antiddos protect** (alias: **/antiddos enable**) – enables AntiDDoS protection
    - Params
      -  [no-kick/kick-all/force-kick-all] – kicking mode
         - no-kick – without kicking any players
          - kick-all – kick all players without *antiddos.nokick* permission (see [permissions](#permissions))
          - force-kick-all – kick all players, without any exceptions
      - [wipe] – enables database wiping
  - Examples
     - **/antiddos protect no-kick** – enable protection, kick nobody, don't truncate verified users database
     - **/antiddos enable kick-all wipe** – enable protection, kick all players without *antiddos.nokick* permission, truncate verified users database
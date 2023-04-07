# TacacsGUI
Free Authentication, Authorization, & Accounting Server for your Network Devices.
GUI for the powerful [tacacs daemon by Marc Huber](http://www.pro-bono-publico.de/projects/)

# Installing
Please use [Installation Script](https://github.com/tacacsgui/tgui_install). Only **Ubuntu 18.04.x** supported.

# What It Does
> AAA - Authentication Authorization Accounting

## Authentication

<p align="center">AAA User by <b>Local Database</b>, <b>LDAP Server</b> or <b>One-Time Password</b><p>
<p align="center">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern.gif" width="30%">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern_ldap.gif" width="30%">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern-1.gif" width="30%">
</p>

1. **Local Database**. All password are stored as hashes. A user can change their password via the GUI or a device cli (not all devices supported).
2. **LDAP Server**. Based on [Adldap2](https://github.com/Adldap2/Adldap2). Work with Windows AD and OpenLDAP.
3. **One-Time Password** (OTP). Based on [Spomky-Labs/otphp](https://github.com/Spomky-Labs/otphp). Authentication with OTP by using Google Authenticator, for example.

## Authorization

Each command the user executes on a device can be sent to the TACACS server for authorization. Meaning user actions can be locked down to only certain commands, regardless of userlevel.

## Accounting

All login events and commands are logged. The logs are displayed in the GUI and are searchable.

# Other Features

<p align="center"><b>High Availability</b> and <b>Configuration Manager</b>(alpha version)<p>
<p align="center">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern_ha.gif" width="35%">
  <img src="https://tacacsgui.com/wp-content/uploads/2019/03/diff_2.png" width="35%">
</p>

- **High Availability** based on MySQL Replication. All changes on the Primary will be available on the Secondary. In that case the Secondary is also a working TACACS server, with the AAA logs being stored on the Primary.
- **Configuration Manager** alpha version, but it is already has many advantages. It is written in Python and the main library is pexpect. All configuration files are stored in a git repository on the server; meaing you won't have many sets of configuration files with different versions, instead you will have only one set of files with story of changes.

Hope you will enjoy it!

# Support

If you want to help, you are welcome! Also you can be my Patron [on Patreon](https://www.patreon.com/tacacsgui), you can stimulate me to do updates more often.
# [<img src="https://tacacsgui.com/wp-content/uploads/2018/11/1000px-Patreon_logo_with_wordmark.png" width="40%">](https://www.patreon.com/tacacsgui)

~~Main site is https://tacacsgui.com/. There you can find more info about that project.~~

See you and have a nice day!

Best Regards, Aleksey

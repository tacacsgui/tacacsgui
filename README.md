# TacacsGUI
Free Access Control Server for Your Network Devices.
GUI for powerful [tacacs daemon by Marc Huber](http://www.pro-bono-publico.de/projects/)

## How to install
Please use [Installation Script](https://github.com/tacacsgui/tgui_install). Only **Ubuntu 16.04.x** supported.

## What it can
> AAA - Authentication Authorization Accounting
<p align="center">AAA User by <b>Local Database</b>, <b>LDAP Server</b> or <b>One-Time Password</b><p>
<p align="center">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern.gif" width="30%">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern_ldap.gif" width="30%">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern-1.gif" width="30%">
</p>

1. **Local Database**. All password stored as a hash, the main advantage of this type is a user can change his/her password via gui or via device cli (not all devices supported).
2. **LDAP Server**. Based on [Adldap2](https://github.com/Adldap2/Adldap2). Work with Windows AD and OpenLDAP.
3. **One-Time Password** (OTP). Based on [Spomky-Labs/otphp](https://github.com/Spomky-Labs/otphp). Authentication with OTP by using Google Authenticator, for example.

<p align="center"><b>High Availability</b> and <b>Configuration Manager</b>(alpha version)<p>
<p align="center">
  <img src="https://tacacsgui.com/wp-content/uploads/2018/12/main_pattern_ha.gif" width="35%">
  <img src="https://tacacsgui.com/wp-content/uploads/2019/03/diff_2.png" width="35%">
</p>

- **High Availability** based on MySQL Replication. All changes on Master will be available on Slave. In that case Slave also can be as a working auth-server, all full log will be stored on Master.
- **Configuration Manager** alpha version, but it is already have many advantages. It is works under Python and main library here's pexpect. All configuration files stored in git repository on server, it means that you won't have many files with different version you will have only one file with story of changes.

Hope you will enjoy it!

If you want to help, you are welcome! Also you can be my Patron [on Patreon](https://www.patreon.com/tacacsgui), you can stimulate me to do updates more often.
# [<img src="https://tacacsgui.com/wp-content/uploads/2018/11/1000px-Patreon_logo_with_wordmark.png" width="40%">](https://www.patreon.com/tacacsgui)

Main site is https://tacacsgui.com/. There you can find more info about that project.

See you and have a nice day!

Best Regards, Aleksey

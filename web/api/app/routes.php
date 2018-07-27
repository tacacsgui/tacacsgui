<?php

$app->get('/', 'HomeController:getHome'); //->add($container->get('csrf'));// We will return to that guard.
$app->post('/', 'HomeController:postHome'); //->add($container->get('csrf'));

###Authentication Routes#############################
$app->get('/auth/singin/', 'AuthController:getSingIn');
$app->post('/auth/singin/', 'AuthController:postSingIn');
$app->post('/auth/singin/changePassword/', 'AuthController:postChangePassword');
$app->get('/auth/singout/', 'AuthController:getSingOut');
#####################################################
###User Routes#######################################
$app->post('/user/datatables/', 'APIUsersCtrl:postUserDatatables');
$app->get('/user/add/', 'APIUsersCtrl:getUserAdd');
$app->post('/user/add/', 'APIUsersCtrl:postUserAdd');
$app->get('/user/edit/', 'APIUsersCtrl:getUserEdit');
$app->post('/user/edit/', 'APIUsersCtrl:postUserEdit');
$app->get('/user/delete/', 'APIUsersCtrl:getUserDelete');
$app->post('/user/delete/', 'APIUsersCtrl:postUserDelete');
$app->get('/user/info/', 'APIUsersCtrl:getUserInfo');
#####################################################
###User Routes#######################################
$app->post('/user/group/datatables/', 'APIUserGrpsCtrl:postUserGroupDatatables');
$app->get('/user/group/add/', 'APIUserGrpsCtrl:getUserGroupAdd');
$app->post('/user/group/add/', 'APIUserGrpsCtrl:postUserGroupAdd');
$app->get('/user/group/edit/', 'APIUserGrpsCtrl:getUserGroupEdit');
$app->post('/user/group/edit/', 'APIUserGrpsCtrl:postUserGroupEdit');
$app->get('/user/group/delete/', 'APIUserGrpsCtrl:getUserGroupDelete');
$app->post('/user/group/delete/', 'APIUserGrpsCtrl:postUserGroupDelete');
$app->post('/user/group/rights/', 'APIUserGrpsCtrl:postUserGroupRightsList');
$app->get('/user/group/list/', 'APIUserGrpsCtrl:getUserGroupList');
#####################################################
###API Settings Routes#############################
$app->get('/settings/pwpolicy/', 'APISettingsCtrl:getPasswdPolicy');
$app->post('/settings/pwpolicy/', 'APISettingsCtrl:postPasswdPolicy');
$app->get('/settings/smtp/', 'APISettingsCtrl:getSmtp');
$app->post('/settings/smtp/', 'APISettingsCtrl:postSmtp');
$app->post('/settings/smtp/test/', 'APISettingsCtrl:postSmtpTest');
$app->get('/settings/time/timezones/', 'APISettingsCtrl:getTimeTimezones');
$app->post('/settings/time/', 'APISettingsCtrl:postTimeSettings');
$app->get('/settings/time/', 'APISettingsCtrl:getTimeSettings');
$app->get('/settings/time/status/', 'APISettingsCtrl:getTimeStatus');
$app->get('/settings/network/interface/list/', 'APISettingsCtrl:getInterfaceList');
$app->get('/settings/network/interface/', 'APISettingsCtrl:getInterfaceSettings');
$app->post('/settings/network/interface/', 'APISettingsCtrl:postInterfaceSettings');
#####################################################
###Tacacs Devices Routes#######################################
$app->post('/tacacs/device/datatables/', 'TACDevicesCtrl:postDeviceDatatables');
$app->get('/tacacs/device/ping/', 'TACDevicesCtrl:getDevicePing');
$app->get('/tacacs/device/add/', 'TACDevicesCtrl:getDeviceAdd');
$app->post('/tacacs/device/add/', 'TACDevicesCtrl:postDeviceAdd');
$app->get('/tacacs/device/edit/', 'TACDevicesCtrl:getDeviceEdit');
$app->post('/tacacs/device/edit/', 'TACDevicesCtrl:postDeviceEdit');
$app->get('/tacacs/device/delete/', 'TACDevicesCtrl:getDeviceDelete');
$app->post('/tacacs/device/delete/', 'TACDevicesCtrl:postDeviceDelete');
$app->post('/tacacs/device/csv/', 'TACDevicesCtrl:postDeviceCsv');
#####################################################
###Tacacs Device Groups Routes#######################################
$app->post('/tacacs/device/group/datatables/', 'TACDeviceGrpsCtrl:postDeviceGroupsDatatables');
$app->get('/tacacs/device/group/add/', 'TACDeviceGrpsCtrl:getDeviceGroupAdd');
$app->post('/tacacs/device/group/add/', 'TACDeviceGrpsCtrl:postDeviceGroupAdd');
$app->get('/tacacs/device/group/edit/', 'TACDeviceGrpsCtrl:getDeviceGroupEdit');
$app->post('/tacacs/device/group/edit/', 'TACDeviceGrpsCtrl:postDeviceGroupEdit');
$app->get('/tacacs/device/group/delete/', 'TACDeviceGrpsCtrl:getDeviceGroupDelete');
$app->post('/tacacs/device/group/delete/', 'TACDeviceGrpsCtrl:postDeviceGroupDelete');
$app->get('/tacacs/device/group/list/', 'TACDeviceGrpsCtrl:getDeviceGroupList');
$app->post('/tacacs/device/group/csv/', 'TACDeviceGrpsCtrl:postDeviceGroupCsv');
#####################################################
###Tacacs Users Routes#######################################
$app->post('/tacacs/user/datatables/', 'TACUsersCtrl:postUserDatatables');
$app->get('/tacacs/user/add/', 'TACUsersCtrl:getUserAdd');
$app->post('/tacacs/user/add/', 'TACUsersCtrl:postUserAdd');
$app->get('/tacacs/user/edit/', 'TACUsersCtrl:getUserEdit');
$app->post('/tacacs/user/edit/', 'TACUsersCtrl:postUserEdit');
$app->get('/tacacs/user/delete/', 'TACUsersCtrl:getUserDelete');
$app->post('/tacacs/user/delete/', 'TACUsersCtrl:postUserDelete');
$app->post('/tacacs/user/csv/', 'TACUsersCtrl:postUserCsv');
#####################################################
###Tacacs User Groups Routes#######################################
$app->post('/tacacs/user/group/datatables/', 'TACUserGrpsCtrl:postUserGroupDatatables');
$app->get('/tacacs/user/group/add/', 'TACUserGrpsCtrl:getUserGroupAdd');
$app->post('/tacacs/user/group/add/', 'TACUserGrpsCtrl:postUserGroupAdd');
$app->get('/tacacs/user/group/edit/', 'TACUserGrpsCtrl:getUserGroupEdit');
$app->post('/tacacs/user/group/edit/', 'TACUserGrpsCtrl:postUserGroupEdit');
$app->get('/tacacs/user/group/delete/', 'TACUserGrpsCtrl:getUserGroupDelete');
$app->post('/tacacs/user/group/delete/', 'TACUserGrpsCtrl:postUserGroupDelete');
$app->get('/tacacs/user/group/list/', 'TACUserGrpsCtrl:getUserGroupList');
$app->post('/tacacs/user/group/csv/', 'TACUserGrpsCtrl:postUserGroupCsv');
#####################################################
#####################################################
###Tacacs ACL Routes#######################################
$app->post('/tacacs/acl/datatables/', 'TACACLCtrl:postACLDatatables');
$app->get('/tacacs/acl/add/', 'TACACLCtrl:getACLAdd');
$app->post('/tacacs/acl/add/', 'TACACLCtrl:postACLAdd');
$app->get('/tacacs/acl/edit/', 'TACACLCtrl:getACLEdit');
$app->post('/tacacs/acl/edit/', 'TACACLCtrl:postACLEdit');
$app->get('/tacacs/acl/delete/', 'TACACLCtrl:getACLDelete');
$app->post('/tacacs/acl/delete/', 'TACACLCtrl:postACLDelete');
$app->get('/tacacs/acl/list/', 'TACACLCtrl:getAclList');
$app->post('/tacacs/acl/csv/', 'TACACLCtrl:postACLCsv');
#####################################################
###Tacacs ACL Routes#######################################
$app->post('/tacacs/services/datatables/', 'TACServicesCtrl:postServiceDatatables');
$app->get('/tacacs/services/add/', 'TACServicesCtrl:getServiceAdd');
$app->post('/tacacs/services/add/', 'TACServicesCtrl:postServiceAdd');
$app->get('/tacacs/services/edit/', 'TACServicesCtrl:getServiceEdit');
$app->post('/tacacs/services/edit/', 'TACServicesCtrl:postServiceEdit');
$app->get('/tacacs/services/delete/', 'TACServicesCtrl:getServiceDelete');
$app->post('/tacacs/services/delete/', 'TACServicesCtrl:postServiceDelete');
$app->get('/tacacs/services/list/', 'TACServicesCtrl:getServiceList');
$app->post('/tacacs/services/csv/', 'TACServicesCtrl:postServiceCsv');
#####################################################
###Tacacs Configuration Generator Routes#######################################
$app->get('/tacacs/config/generate/file/', 'TACConfigCtrl:getConfigGenFile');
$app->get('/tacacs/config/generate/', 'TACConfigCtrl:getConfigGen');
$app->post('/tacacs/config/generate/', 'TACConfigCtrl:postConfigGen');
$app->post('/tacacs/config/deamon/', 'TACConfigCtrl:postDeamonConfig');
$app->get('/tacacs/config/global/edit/', 'TACConfigCtrl:getEditConfigGlobal');
$app->post('/tacacs/config/global/edit/', 'TACConfigCtrl:postEditConfigGlobal');
$app->post('/tacacs/config/part/', 'TACConfigCtrl:postConfPart');
#####################################################

###Tacacs Reports Routes#######################################
$app->post('/tacacs/reports/accounting/datatables/', 'TACReportsCtrl:postAccountingDatatables');
$app->post('/tacacs/reports/authentication/datatables/', 'TACReportsCtrl:postAuthenticationDatatables');
$app->post('/tacacs/reports/authorization/datatables/', 'TACReportsCtrl:postAuthorizationDatatables');
$app->get('/tacacs/reports/general/', 'TACReportsCtrl:getGeneralReport');
$app->get('/tacacs/reports/daemon/status/', 'TACReportsCtrl:getDaemonStatus');
$app->get('/tacacs/reports/top/access/', 'TACReportsCtrl:getTopAccess');
$app->post('/tacacs/reports/tree/', 'TACReportsCtrl:postFileTree');
$app->post('/tacacs/reports/delete/', 'TACReportsCtrl:postLogDelete');
#####################################################

###APIChecker Routes#######################################
$app->get('/apicheck/database/', 'APICheckerCtrl:getCheckDatabase');
$app->get('/apicheck/status/', 'APICheckerCtrl:getApiStatus');
$app->get('/apicheck/time/', 'APICheckerCtrl:getApiTime');
#####################################################

###Backup Routes#######################################
$app->post('/backup/datatables/', 'APIBackupCtrl:postBackupDatatables');
$app->post('/backup/delete/', 'APIBackupCtrl:postBackupDelete');
$app->post('/backup/restore/', 'APIBackupCtrl:postBackupRestore');
$app->get('/backup/download/', 'APIBackupCtrl:getBackupDownload');
$app->post('/backup/upload/', 'APIBackupCtrl:postBackupUpload');
$app->post('/backup/make/', 'APIBackupCtrl:postBackupMake');
$app->get('/backup/settings/', 'APIBackupCtrl:getBackupSettings');
$app->post('/backup/settings/', 'APIBackupCtrl:postBackupSettings');
#####################################################

###Update Routes#######################################
$app->get('/update/info/', 'APIUpdateCtrl:getInfo');
$app->post('/update/info/', 'APIUpdateCtrl:postInfo');
$app->post('/update/change/', 'APIUpdateCtrl:postChange');
$app->post('/update/', 'APIUpdateCtrl:postCheck');
$app->post('/update/upgrade/', 'APIUpdateCtrl:postUpgrade');
#####################################################

###MAVIS Routes#######################################
$app->get('/mavis/ldap/', 'MAVISLDAP:getLDAPParams');
$app->post('/mavis/ldap/', 'MAVISLDAP:postLDAPParams');
$app->post('/mavis/ldap/check/', 'MAVISLDAP:postLDAPCheck');
$app->post('/mavis/otp/generate/secret/', 'MAVISOTP:postOTPSecret');
$app->post('/mavis/otp/generate/url', 'MAVISOTP:postOTPurl');
$app->get('/mavis/otp/', 'MAVISOTP:getOTPParams');
$app->post('/mavis/otp/', 'MAVISOTP:postOTPParams');
$app->post('/mavis/otp/check/', 'MAVISOTP:postOTPCheck');
$app->get('/mavis/sms/', 'MAVISSMS:getSMSParams');
$app->post('/mavis/sms/', 'MAVISSMS:postSMSParams');
$app->post('/mavis/sms/send/', 'MAVISSMS:postSMSSend');
$app->post('/mavis/sms/check/', 'MAVISSMS:postSMSCheck');
#####################################################

###APIChecker Routes#######################################
$app->post('/logging/datatables/', 'APILoggingCtrl:postLoggingDatatables');
$app->post('/logging/delete/', 'APILoggingCtrl:postLoggingDelete');
#####################################################

###API Dounload Manager Routes#######################################
$app->get('/download/csv/', 'APIDownloadCtrl:getDownloadCsv');
$app->get('/download/log/', 'APIDownloadCtrl:getDownloadLog');
#####################################################

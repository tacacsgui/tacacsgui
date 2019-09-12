<?php

$app->get('/', 'HomeController:getHome'); //->add($container->get('csrf'));// We will return to that guard.
$app->post('/', 'HomeController:postHome'); //->add($container->get('csrf'));

###Authentication Routes#############################
$app->get('/auth/singin/', 'AuthController:getSignIn'); //please delete me
$app->get('/auth/signin/', 'AuthController:getSignIn');
$app->post('/auth/singin/', 'AuthController:postSignIn'); //please delete me
$app->post('/auth/signin/', 'AuthController:postSignIn');
$app->post('/auth/singin/changePassword/', 'AuthController:postChangePassword'); //please delete me
$app->post('/auth/signin/changePassword/', 'AuthController:postChangePassword');
$app->get('/auth/singout/', 'AuthController:getSignOut'); //please delete me
$app->get('/auth/signout/', 'AuthController:getSignOut');
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
$app->get('/user/status/', 'APIUsersCtrl:getUserStatus');
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
$app->get('/settings/ha/', 'APIHACtrl:getSettings');
$app->post('/settings/ha/', 'APIHACtrl:postSettings');
$app->post('/settings/ha/status/', 'APIHACtrl:getStatus');
$app->post('/settings/ha/slave/del/', 'APIHACtrl:postSlaveDel');
$app->post('/settings/ha/slave/list/', 'APISettingsCtrl:postHASlaveList');
#####################################################
###Tacacs Devices Routes#######################################
$app->post('/obj/address/datatables/', 'ObjAddress:postDatatables');
$app->post('/obj/address/add/', 'ObjAddress:postAdd');
$app->get('/obj/address/edit/', 'ObjAddress:getEdit');
$app->post('/obj/address/edit/', 'ObjAddress:postEdit');
$app->post('/obj/address/delete/', 'ObjAddress:postDel');
$app->post('/obj/address/csv/', 'ObjAddress:postCsv');
$app->get('/obj/address/list/', 'ObjAddress:getList');
$app->get('/obj/address/ref/', 'ObjAddress:getRef');
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
$app->get('/tacacs/device/list/', 'TACDevicesCtrl:getList');
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
$app->post('/tacacs/user/change_passwd/change/', 'TACUsersCtrl:postUserPWChange');
$app->post('/tacacs/user/change_passwd/send/', 'TACUsersCtrl:postSendPasswd');
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
$app->get('/tacacs/user/group/ldap/list/', 'TACUserGrpsCtrl:getLDAPGroupList');
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
$app->get('/tacacs/acl/ref/', 'TACACLCtrl:getAclRef');
$app->post('/tacacs/acl/csv/', 'TACACLCtrl:postACLCsv');
#####################################################
###Tacacs ACL Routes#######################################
$app->post('/tacacs/service/datatables/', 'TACServicesCtrl:postServiceDatatables');
$app->get('/tacacs/service/add/', 'TACServicesCtrl:getServiceAdd');
$app->post('/tacacs/service/add/', 'TACServicesCtrl:postServiceAdd');
$app->get('/tacacs/service/edit/', 'TACServicesCtrl:getServiceEdit');
$app->post('/tacacs/service/edit/', 'TACServicesCtrl:postServiceEdit');
$app->get('/tacacs/service/delete/', 'TACServicesCtrl:getServiceDelete');
$app->post('/tacacs/service/delete/', 'TACServicesCtrl:postServiceDelete');
$app->get('/tacacs/service/list/', 'TACServicesCtrl:getServiceList');
$app->get('/tacacs/service/ref/', 'TACServicesCtrl:getServiceRef');
$app->post('/tacacs/service/csv/', 'TACServicesCtrl:postServiceCsv');
#####################################################
###Tacacs CMD Routes#######################################
$app->post('/obj/cmd/datatables/', 'TACCMDCtrl:postDatatables');
$app->get('/obj/cmd/add/', 'TACCMDCtrl:getAdd');
$app->post('/obj/cmd/add/', 'TACCMDCtrl:postAdd');
$app->get('/obj/cmd/edit/', 'TACCMDCtrl:getEdit');
$app->post('/obj/cmd/edit/', 'TACCMDCtrl:postEdit');
$app->post('/obj/cmd/edit/type/', 'TACCMDCtrl:postEditType');
$app->get('/obj/cmd/delete/', 'TACCMDCtrl:getDelete');
$app->post('/obj/cmd/delete/', 'TACCMDCtrl:postDelete');
$app->get('/obj/cmd/list/', 'TACCMDCtrl:getList');
$app->get('/obj/cmd/list/junos/', 'TACCMDCtrl:getListJunos');
$app->post('/obj/cmd/csv/', 'TACCMDCtrl:postCsv');
#####################################################
###Tacacs Configuration Generator Routes#######################################
$app->get('/tacacs/config/apply/', 'TACConfigCtrl:getConfigGenFile');
$app->post('/tacacs/config/apply/slave/', 'TACConfigCtrl:postApplySlaveCfg');
$app->get('/tacacs/config/generate/', 'TACConfigCtrl:getConfigGen');
$app->post('/tacacs/config/generate/', 'TACConfigCtrl:postConfigGen');
$app->post('/tacacs/config/daemon/', 'TACConfigCtrl:postDaemonConfig');
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
$app->get('/tacacs/widget/chart/auth/', 'TACReportsCtrl:getAuthChartData');
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
$app->post('/update/info/slave/', 'APIUpdateCtrl:postInfoSlave');
$app->post('/update/upgrade/slave/', 'APIUpdateCtrl:postUpgradeSlave');
$app->post('/update/change/', 'APIUpdateCtrl:postChange');
$app->post('/update/', 'APIUpdateCtrl:postCheck');
$app->post('/update/upgrade/', 'APIUpdateCtrl:postUpgrade');
#####################################################

###MAVIS Routes#######################################
$app->get('/mavis/ldap/', 'MAVISLDAP:getLDAPParams');
$app->post('/mavis/ldap/', 'MAVISLDAP:postLDAPParams');
$app->post('/mavis/ldap/group/search/', 'MAVISLDAP:postLdapSearch');
$app->get('/mavis/ldap/group/list/', 'MAVISLDAP:getLdapList');
$app->post('/mavis/ldap/group/bind/', 'MAVISLDAP:postLdapBind');
$app->post('/mavis/ldap/group/bind/table/', 'MAVISLDAP:postBindTable');
$app->post('/mavis/ldap/check/', 'MAVISLDAP:postLDAPCheck');
$app->post('/mavis/ldap/test/', 'MAVISLDAP:postTest');
$app->post('/mavis/otp/generate/secret/', 'MAVISOTP:postOTPSecret');
$app->post('/mavis/otp/generate/url', 'MAVISOTP:postOTPurl');
$app->get('/mavis/otp/', 'MAVISOTP:getOTPParams');
$app->post('/mavis/otp/', 'MAVISOTP:postOTPParams');
$app->post('/mavis/otp/check/', 'MAVISOTP:postOTPCheck');
$app->get('/mavis/sms/', 'MAVISSMS:getSMSParams');
$app->post('/mavis/sms/', 'MAVISSMS:postSMSParams');
$app->post('/mavis/sms/send/', 'MAVISSMS:postSMSSend');
$app->post('/mavis/sms/check/', 'MAVISSMS:postSMSCheck');
$app->get('/mavis/local/', 'MAVISLocal:getParams');
$app->post('/mavis/local/', 'MAVISLocal:postParams');
$app->post('/mavis/local/check/', 'MAVISLocal:postCheck');
#####################################################

###APIChecker Routes#######################################
$app->post('/logging/datatables/', 'APILoggingCtrl:postLoggingDatatables');
$app->post('/logging/delete/', 'APILoggingCtrl:postLoggingDelete');
$app->post('/logging/delete/special/', 'APILoggingCtrl:postDelSpecial');
$app->post('/logging/miss/add/', 'APILoggingCtrl:postMissAdd');
// $app->get('/logging/miss/edit/', 'APILoggingCtrl:getMiss');
// $app->post('/logging/miss/edit/', 'APILoggingCtrl:postMissEdit');
$app->post('/logging/miss/delete/', 'APILoggingCtrl:postMissDel');
$app->post('/logging/miss/datatables/', 'APILoggingCtrl:postMissTable');
#####################################################

###APIChecker Routes#######################################
$app->get('/notification/settings/', 'APINotificationCtrl:getSettings');
$app->post('/notification/settings/', 'APINotificationCtrl:postSettings');
$app->post('/notification/post/logging/', 'APINotificationCtrl:postDatatables');
$app->post('/notification/post/buffer/', 'APINotificationCtrl:postBufferDatatables');
#####################################################

###API Dounload Manager Routes#######################################
$app->get('/download/csv/', 'APIDownloadCtrl:getDownloadCsv');
$app->get('/download/log/', 'APIDownloadCtrl:getDownloadLog');
#####################################################

###API HA##################################################
$app->post('/ha/init/', 'APIHACtrl:postInitFromSlave');
$app->post('/ha/check/', 'APIHACtrl:postCheck');
$app->post('/ha/cfg/apply/', 'APIHACtrl:postApply');
$app->post('/ha/log/add/', 'APIHACtrl:postLoggingEvent');
// $app->post('/ha/salave/update/check/', 'APIHACtrl:postCheckUpdate');
$app->post('/ha/slave/update/', 'APIHACtrl:postSlaveUpdate');
$app->post('/ha/slave/update/do/', 'APIHACtrl:postSlaveUpdateDo');
#####################################################

###API HA##################################################
$app->post('/confmanager/toggle/', 'ConfManager:postToggle');
$app->get('/confmanager/info/', 'ConfManager:getInfo');
$app->get('/confmanager/settings/preview/', 'ConfManager:getPreview');
$app->get('/confmanager/settings/cron/', 'ConfManager:getCron');
$app->post('/confmanager/settings/cron/', 'ConfManager:postCron');
$app->post('/confmanager/datatables/', 'ConfManager:postDatatables');
$app->post('/confmanager/log/datatables/', 'ConfManager:postLogDatatables');
$app->get('/confmanager/dir/', 'ConfManager:getDir');
$app->get('/confmanager/dir/exploer/', 'ConfManager:getDirExploer');
$app->post('/confmanager/dir/add/', 'ConfManager:postDirAdd');
$app->post('/confmanager/dir/delete/', 'ConfManager:postDirDel');
$app->post('/confmanager/dir/mv/', 'ConfManager:postDirMove');
$app->post('/confmanager/get/more/', 'ConfManager:postMore');
$app->post('/confmanager/file/delete/', 'ConfManager:postDel');
$app->get('/confmanager/file/download/', 'APIDownloadCtrl:getDlCm');
$app->get('/confmanager/file/download/hash/', 'APIDownloadCtrl:getCmHash');
$app->post('/confmanager/tacacs/', 'ConfManager:postTacacs');
$app->get('/confmanager/diff/list/', 'ConfManager:getDiffList');
$app->post('/confmanager/diff/brief/', 'ConfManager:postDiffBrief');
$app->post('/confmanager/diff/', 'ConfManager:postDiff');
// $app->post('/confmanager/diff/tacgui/users/', 'ConfManager:postTacgui');
$app->post('/confmanager/tacacs/aaa/', 'ConfManager:postTacguiAAA');
//Models
$app->post('/confmanager/models/datatables/', 'ConfModels:postDatatables');
$app->post('/confmanager/models/add/', 'ConfModels:postAdd');
$app->get('/confmanager/models/edit/', 'ConfModels:getEdit');
$app->post('/confmanager/models/edit/', 'ConfModels:postEdit');
$app->post('/confmanager/models/delete/', 'ConfModels:postDel');
$app->get('/confmanager/models/list/', 'ConfModels:getList');
//Devices
$app->post('/confmanager/devices/datatables/', 'ConfDevices:postDatatables');
$app->post('/confmanager/devices/add/', 'ConfDevices:postAdd');
$app->get('/confmanager/devices/edit/', 'ConfDevices:getEdit');
$app->post('/confmanager/devices/edit/', 'ConfDevices:postEdit');
$app->post('/confmanager/devices/delete/', 'ConfDevices:postDel');
$app->get('/confmanager/devices/list/', 'ConfDevices:getList');
//Groups
$app->post('/confmanager/groups/datatables/', 'ConfGroups:postDatatables');
$app->post('/confmanager/groups/add/', 'ConfGroups:postAdd');
$app->get('/confmanager/groups/edit/', 'ConfGroups:getEdit');
$app->post('/confmanager/groups/edit/', 'ConfGroups:postEdit');
$app->post('/confmanager/groups/delete/', 'ConfGroups:postDel');
$app->get('/confmanager/groups/list/', 'ConfGroups:getList');
//Credentials
$app->post('/confmanager/credentials/datatables/', 'ConfigCredentials:postDatatables');
$app->post('/confmanager/credentials/add/', 'ConfigCredentials:postAdd');
$app->get('/confmanager/credentials/edit/', 'ConfigCredentials:getEdit');
$app->post('/confmanager/credentials/edit/', 'ConfigCredentials:postEdit');
$app->post('/confmanager/credentials/delete/', 'ConfigCredentials:postDel');
$app->get('/confmanager/credentials/list/', 'ConfigCredentials:getList');
//Queries
$app->post('/confmanager/queries/datatables/', 'ConfQueries:postDatatables');
$app->post('/confmanager/queries/add/', 'ConfQueries:postAdd');
$app->get('/confmanager/queries/edit/', 'ConfQueries:getEdit');
$app->post('/confmanager/queries/edit/', 'ConfQueries:postEdit');
$app->post('/confmanager/queries/delete/', 'ConfQueries:postDel');
$app->post('/confmanager/queries/preview/', 'ConfQueries:postPreview');
#####################################################

###API Developer##################################################
$app->get('/dev/inc/js/dev.js', 'APIDevCtrl:getDevJS');
#####################################################

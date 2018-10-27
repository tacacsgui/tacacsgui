<?php

/**
* tacacsgui alert template
*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $title ?></title>

<?php require __DIR__  . '/style.php'; ?>

  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader"><?php echo $title ?></span>
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="100%" style="margin:0 auto;">
                          <tr>
                            <td style="font-size: 30px; text-align:center; color: #444;">

                              <br>

                                <b>Tacacs</b> <image class="logo-img" src="https://tacacsgui.com/wp-content/uploads/2018/04/graphicsrounded-152-22671.png" alt="logo"> <b>GUI</b>

                              <br>
                              <br>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <h2 class="title-info alert-title">Alert!</h2>
                        <table class="border-bottom">
                          <tr>
                            <td class="title-info border-bottom" colspan="2">Main Info</br></td>
                          </tr>
                          <tr>
                            <td class="title-info">Reason:</td>
                            <td class="alert-title" style="vertical-align: middle;"><?php echo $title ?></td>
                          </tr>
                          <tr>
                            <td class="title-info">Server Name:</td>
                            <td style="vertical-align: middle;"><?php echo trim(shell_exec('hostname')); ?></td>
                          </tr>
                          <tr>
                            <td class="title-info">Server IP:</td>
                            <td><?php echo trim(shell_exec('hostname -i')); ?></td>
                          </tr>
                          <tr>
                            <td class="title-info">Server Date:</td>
                            <td><?php echo trim(shell_exec('date "+%F %T"')); ?></td>
                          </tr>
                          <tr>
                            <td class="title-info">More info:</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td colspan="2" >
                              <table>
                              <?php if(@$NAS): ?>
                                <tr>
                                  <td>NAS (device ip address):</td>
                                  <td><?php echo $NAS;?></td>
                                </tr>
                              <?php endif; ?>
                              <?php if(@$username): ?>
                                <tr>
                                  <td>Username:</td>
                                  <td><?php echo $username;?></td>
                                </tr>
                              <?php endif; ?>
                              <?php if(@$NAC): ?>
                                <tr>
                                  <td>NAC (user ip address):</td>
                                  <td><?php echo $NAC;?></td>
                                </tr>
                              <?php endif; ?>
                              <?php if(@$line): ?>
                                <tr>
                                  <td>Line:</td>
                                  <td><?php echo $line;?></td>
                                </tr>
                              <?php endif; ?>
                              <?php if(@$date): ?>
                                <tr>
                                  <td>Date:</td>
                                  <td><?php echo $date;?></td>
                                </tr>
                              <?php endif; ?>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>

                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    the email was self generated based on configured policy
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>

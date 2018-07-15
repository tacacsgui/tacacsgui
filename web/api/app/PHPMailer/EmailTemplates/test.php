<?php

/**
*	@package tacacsgui-theme
*/

$url = 'http://tacacsgui.com/wp-content/themes/tacacsgui-theme';

$title = "Test Message";
$hello_words = "Hello there,";
$first_message = 'This is the test message form your TacacsGUI server.<p>Server address: '.$_SERVER['SERVER_ADDR'].'</p>';

$btn_show = false;
$btn_title = 'SomeText';
$btn_link = '';

$second_message = '';

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
                        <p><?php echo $hello_words; ?></p>
                        <p><?php echo $first_message; ?></p>
                        <?php if ( $btn_show ):  ?>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td> <a href="<?php echo $btn_link; ?>" target="_blank"><?php echo $btn_title; ?></a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <?php endif; ?>
                        <p><?php echo $second_message; ?></p>
                        <p>Have a nice day!</p>
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
                <!-- <tr>
                  <td class="content-block">
                    <span class="apple-link">Company Inc, 3 Abbey Road, San Francisco CA 94102</span>
                    <br> Don't like these emails? <a href="http://i.imgur.com/CScmqnj.gif">Unsubscribe</a>.
                  </td>
                </tr> -->
                <tr>
                  <td class="content-block">
                    Main Site - <a href="https://tacacsgui.com/">Tacacs GUI</a>
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                    Main Contact - <a href="mailto:developer@tacacsgui.com">Developer</a>
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

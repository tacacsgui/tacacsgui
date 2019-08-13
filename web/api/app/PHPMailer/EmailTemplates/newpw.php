<?php
$subject = (empty($subject)) ? 'TACACSGUI' : $subject;
 ?>


<?php require __DIR__  . '/parts/header.php'; ?>

<!-- =============== START BODY =============== -->


<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td height="40"></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td class="specbundle"><div class="contentEditableContainer contentTextEditable">
                            <div class="contentEditable" style="text-align: left;">
                              <h2 style="font-size: 20px;">Hello, here is your new credential:</h2>
                              <br>
                              <p style="color:#444;">Username: <?php echo $username; ?></p>
                              <p style="color:#444;">Password: <?php echo $password; ?></p>
                              <br>
                            </div>
                          </div></td>
      <td valign="top" width="75" class="specbundle">&nbsp;</td>

    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>



      </div>


<!-- =============== END BODY =============== -->

<?php require __DIR__  . '/parts/footer.php'; ?>

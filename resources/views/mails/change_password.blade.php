<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Democracias Cotidianas - Reestablecer contraseña</title>
</head>

<body style="margin:0; padding:0; background-color:#ECF2FF;">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td style="background-color:#FFFFFF;"><table width="600px" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" style="background:#ECF2FF;"></td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80"></td>
            <td width="440"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="50"></td>
                </tr>
              <tr>
                <td><font style=" font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:16px; line-height:20px; color:#000000; text-align:left;">Hola <strong style="font-weight:bold;">{{ $user->name }} {{ $user->last_name }}</strong>,</font></td>
                </tr>
              <tr>
                <td height="30"></td>
                </tr>
              <tr>
                <td><font style=" font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:14px; line-height:20px; color:#000000; text-align:left;">Hemos recibido tu solicitud de modificación de contraseña en la plataforma de <strong style="font-weight:bold;">Democracias Cotidianas</strong>.</font></td>
                </tr>
              <tr>
                <td height="15"></td>
                </tr>
              <tr>
                <td><font style=" font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:14px; line-height:20px; color:#000000; text-align:left;">Haz click para reestablecer tu contraseña:</font></td>
                </tr>
              <tr>
                <td height="30"></td>
                </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="241"><a href="{{ $url }}" target="_blank" style="border:none;"><img src="{{ asset('img/mails/btn-reestablecer-contrasena.png') }}" width="241" height="49" style="display:block; border:none;"></a></td>
                    <td width="199"></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td height="40"></td>
                </tr>
              <tr>
                <td><font style=" font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-style:italic; font-size:12px; line-height:20px; color:#000000; text-align:left;">Si el botón de “Reestablecer contraseña” no funciona, copia y pega el siguiente link en tu navegador: <br>
                  <strong style="font-weight:bold;">{{ $url }}</strong></font></td>
              </tr>
              <tr>
                <td height="20"></td>
              </tr>
              <tr>
                <td><font style=" font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-style:italic; font-size:12px; line-height:20px; color:#000000; text-align:left;">PD: Si no has solicitado el cambio de contraseña en
                  {{ config('app.url') }} puedes ignorar este correo.</font></td>
              </tr>
              <tr>
                <td height="50"></td>
                </tr>
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="160"></td>
                    <td width="120" align="center"><img src="images/logo-democracias-cotidianas.png" width="120" height="56" style="display:block; border:none;"></td>
                    <td width="160"></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td height="25"></td>
                </tr>
              <tr>
                <td height="25"></td>
                </tr>
              </table></td>
            <td width="80"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="30" style="background:#0A0B38;"></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
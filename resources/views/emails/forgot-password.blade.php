<html>
<body>
    <table style="max-width: 500px; width:500px; overflow: hidden;" align="center" width="500" cellpadding="0" cellspacing="0">
        <tr>
            <td style="border-bottom: 4px solid #26bcf1; height: auto;"></td>
        </tr>
        <tr>
            <td style="padding: 13px 13px 20px 13px; max-width: 500px; overflow: hidden;">
                <div class="container" style="padding: 2px;">
                    <h1>Здравствуйте!</h1>

                    Мы получили запрос на сброс вашего пароля. Перейдите по ссылке, чтобы сбросить пароль:<br>

                    <a href="{{ $url . '/reset?jwt=' . $jwt }}" target="_blank">»»» Сбросить пароль</a><br>

                </div>
            </td>
        </tr>
    </table>
</body>
</html>

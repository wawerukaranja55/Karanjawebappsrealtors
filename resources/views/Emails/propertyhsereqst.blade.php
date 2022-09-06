
<body>
  <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tbody>
        <tr>
            <td width="100%" align="center">
                <p style="font-family:'Ubuntu', sans-serif; font-size:14px; color:#202020; padding-left:20px; padding-right:20px; text-align:justify;">
                    Hello You have a new message from {{ $contactname }}.They are requesting about {{ $propertytitle }}.
                    Their email and phone number is:<br>
                    <ul>
                        <li>Phone Number:{{ $contactphone }}</li>
                        <li>Email:{{ $contactemail }}</li>
                    </ul>here is the message:<hr>
                    <span>{{ $contactmsg }}</span>
                </p>
            </td>
        </tr>
    </tbody>
</table>
</body>
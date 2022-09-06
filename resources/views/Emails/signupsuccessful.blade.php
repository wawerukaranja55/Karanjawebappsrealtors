<!-- START HEAD -->
<head>
    
    <!-- CHARSET -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <!-- MOBILE FIRST -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    {{-- icon for our website --}}
    <link rel="icon" type="image/png" href="{{ asset('imagesforthewebsite/webicon.jpg') }}">
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    
    <!-- RESPONSIVE CSS -->
    <style type="text/css">
        @media only screen and (max-width: 550px){
            .responsive_at_550{
                width: 90% !important;
                max-width: 90% !important;
            }
        }
    </style>

</head>
<!-- END HEAD -->

<!-- START BODY -->
<body>
    
    <!-- START EMAIL CONTENT -->
    <table style="width:100%; align:center;">        
        <tbody>
            <tr>
                <td style="align:center; backgroundcolor:#1976D2;">
                    <table style="align:center; width:100%;">
                        <tbody>
                            <tr>
                                <td width="100%" align="center">
                                    
                                    <!-- START SPACING -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END SPACING -->
                                    
                                    <!-- START LOGO -->
                                    <table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td width="100%" align="center">
                                                    <img width="200" src="{{ asset('imagesforthewebsite/webicon.jpg') }}" style="text-align: center;"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END LOGO -->
                                    
                                    <!-- START SPACING -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END SPACING -->
                                    
                                    <!-- START CONTENT -->
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-left:20px; padding-right:20px;" class="responsive_at_550">
                                        <tbody>
                                            <tr>
                                                <td align="center" bgcolor="#ffffff">
                                                    
                                                    <!-- START HEADING -->
                                                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" align="center">
                                                                    <h1 style="font-family:'Ubuntu Mono', monospace; font-size:20px; color:#202020; font-weight:bold; padding-left:20px; padding-right:20px;">Hello {{ $name }} Welcome to Jamar Real estate Agencies.</h1>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- END HEADING -->
                                                    
                                                    <!-- START PARAGRAPH -->
                                                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" align="center">
                                                                    <p style="font-family:'Ubuntu', sans-serif; font-size:14px; color:#202020; padding-left:20px; padding-right:20px; text-align:justify;">
                                                                        You can Now be Able to do the following tasks in your Portal.
                                                                        <ul>
                                                                            <li>1.Pay Your Rent in The Website Using Mpesa</li>
                                                                            <li>2.Download all Your Mpesa Statements which you have paid your rent in the website.</li>
                                                                            <li>3.Review and rate your house to improve and acknowledge the perfomance of the Company</li>
                                                                            <li>4.Easily and fast access the company administration.</li>
                                                                            <li>5.Share a house details to a friend who is house hunting in a particular location.</li>
                                                                        </ul>
                                                                        Click <a href="{{ url('login_register/') }}">here</a> To Login to your Account </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- END PARAGRAPH -->
                                                    
                                                    <!-- START SPACING -->
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- END SPACING -->
                                                    
                                                    <!-- START BUTTON -->
                                                    <table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" bgcolor="#1976D2">
                                                                    {{-- <a style="font-family:'Ubuntu Mono', monospace; display:block; color:#ffffff; font-size:14px; font-weight:bold; text-decoration:none; padding-left:20px; padding-right:20px; padding-top:20px; padding-bottom:20px;" href="{{ url('confirmaccount/'.) }}">Verify E-mail Address</a> --}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- END BUTTON -->
                                                    
                                                    <!-- START SPACING -->
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- END SPACING -->
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END CONTENT -->
                                    
                                    <!-- START SPACING -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END SPACING -->
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </td>
                
            </tr>
            
        </tbody>        
    </table>
    <!-- END EMAIL CONTENT -->
    
</body>
<!-- END BODY -->
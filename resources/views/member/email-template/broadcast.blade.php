<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        @if (isset($subject) && $subject != '')
        <title>{{ $subject }}</title>
        @endif
    </head>
    <body style="margin:0px; background: #f8f8f8; ">
        <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
            <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                    <tbody>
                        <tr>
                            <td style="vertical-align: top; padding-bottom:30px;" align="center">
                                <a href="{{ asset('/') }}" target="_blank">
                                    <img src="{{ asset('/') }}images/logo.png" alt="Helpgivers" style="border:none; max-width: 150px;" />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr style="border:0 0 1px 0; border-color: #cecece"/>
                <div style="padding: 40px; background: #fff;">
                    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td>
                                    <b>Dear Sir/Madam,</b>
                                    @if (isset($message) && $message != '')
                                    {!! $message !!}
                                    @endif
                                    <br/>
                                    <b>- Thanks <br/>(HelpGivers team)</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
                    <p> 
                        &copy; Copy Rights by Helpgivers <br />
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>

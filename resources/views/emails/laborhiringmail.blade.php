<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Labor Hiring Email</title>

    <style>
        p {
            text-align: left;
        }

        h1 {
            text-align: left;
            color: black;
        }

        #logo {
            /* display: block; */
            /* float: left; */
            margin-left: auto; 
            margin-right: auto; 
        }

        #description{
            width: 80%; 
            /* margin-top: 100px; */
            background-color: #FFAC4C;
            box-sizing: border-box;
            padding: 20px 20px;
        }


        @media only screen and (max-width: 600px) {
            #logo {
            display: block;
            margin-right: auto;
            width: 250px;
            height: 100px;
            margin-left: auto; 

        }
        h1 {
            text-align: left;
            font-size: 20px;
            color: black;
        }
        #description{
            width: 80%; 
            /* margin-top: 100px; */
            background-color: #FFAC4C;
            box-sizing: border-box;
            padding: 10px 10px;
        }
        }
    </style>

</head>

<body>
<div style="width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">

    <div style="width: 80%">
        <img src="{{ url('/images/taqat_logo.png') }}" alt="" id="logo">
    </div>

    <div id="description">
        <h1>Labor Hiring Request</h1>
        <p>Dear <b>{{ $mailData['oldsponsor'] }},</b>

            I hope this email finds you well. <b>{{ $mailData['sender_name'] }}</b> is interested in hiring your labor
            <b>{{ $mailData['labor_name'] }}</b> for an upcoming project. To proceed, kindly log in to your account to
            view further details and initiate the hiring process. Your prompt attention to this matter is
            appreciated.<br><br>

            Please note that once you review the details and agree to the terms, you will be required to release the
            labor accordingly.<br><br>

            Thank you for your cooperation.<br>
            Best regards,<br>
            Taqat
        </p>

    </div>

</div>
    


</body>

</html>

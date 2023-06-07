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

            {{-- <p>Dear {{ $mailData['hiring_sponsor'] }}, your request for {{ $mailData['labor_name'] }} of {{ $mailData['oldsponsor'] }} is acepted; --}}
                <p>
                Thank you for expressing interest in hiring <b>{{ $mailData['labor_name'] }}</b> for the upcoming project. We are pleased to inform you that your request has been accepted by <b>{{ $mailData['oldsponsor'] }}</b>.<br><br>
    
                To proceed with the hiring process, please log in to your account to review the project details and finalize the terms of the agreement. Once you have reviewed and agreed to the terms, kindly release the labor accordingly.<br><br>
                
                We appreciate your prompt attention to this matter and look forward to a successful collaboration.<br>
                
                Best regards,<br>
                Taqat
            </p>
    </div>

</div>
    


</body>

</html>

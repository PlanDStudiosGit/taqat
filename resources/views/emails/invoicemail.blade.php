<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taqat</title>
</head>

<style>
    * {
        padding: 0;
        margin: 0;
    }

    body {
        /* background-color: grey; */
        /* font-family: 'Courier New', Courier, monospace; */
        font-family: 'Times New Roman', Times, serif;
        /* font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; */
        /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
        /* font-family:Verdana, Geneva, Tahoma, sans-serif; */
        /* background-image: url('taqat_background.png'); */
        background-repeat: no-repeat;
        background-position: bottom;
        background-size: contain;

    }

    .wrapper {
        /* width: 100%; */
        /* background-color: red; */
        /* table-layout: fixed; */
    }


    /* .main { */
        /* width: 80%;
        max-width: 600px;
        height: 100%; */
        /* box-shadow: 0px 0px 8px #888888; */
        /* background-color: lightcoral; */
        /* padding: 100px; */

    /* } */

    /* .column_one {
        margin-top: 20px !important;
        padding: 0px 15px 0px 15px;
    } */

    /* .billed_to td p {
        font-size: 15px;
    } */

    /* .padding {
        margin-top: 20px;
    } */

    /* .column {
        background-color: aquamarine;
        padding: 0px 15px 0px 15px;
    } */

    /* .content-table {
        border-collapse: collapse;
    } */

    /* .content-table thead tr {
        background-color: #37B8E8;
        text-align: left;
        padding: 10px;
    } */

    /* .content-table thead th,
    .content-table tbody td {
        padding: 10px 15px !important;
    }

    .content-table tbody tr td {
        background-color: lightgray;
        border-bottom: 1px solid rgb(255, 255, 255);
        margin-bottom: 3px;
    } */
</style>

<body>

    <center class="wrapper" style=" width: 100%;">
        <table class="main" style=" width: 80%;
        max-width: 600px;
        height: 100%;">
            <tr style="text-align: center;">
                <!-- <td style="padding:5px; background-color: #37B8E8;">

                </td> -->
            </tr>
            <!-- LOGO -->
            <tr style="text-align: left;">
                <td>
                    <a href="#"><img src="taqat_logo.png" alt="" width="200px"></a>
                </td>
            </tr>

            <!-- BILLED TO  -->
            <tr class="billed_to">
                <td>
                    <table class="column_one" style="margin-top: 20px;
                    padding: 0px 15px 0px 15px;">
                        <tr>

                            <td style="padding-right: 30px;">
                                <p style="margin-bottom: 5px;  font-size: 15px;"><span style="font-weight: bold; font-size: 17px; ">BILLED TO</span> </p>
                                <p style="margin-bottom: 5px;  font-size: 15px;"><span
                                        style="font-weight: bold; font-size: 17px; ">GSM</span> </p>
                                <p style="margin-bottom: 5px;  font-size: 15px;"><span
                                        style="font-weight: bold; font-size: 17px; ">EMAIL</span> </p>
                            </td>
                            <td border-spacing="10" style="line-height: 1.4;">
                                <p style="margin-bottom: 5px;"> {{ $invoiceData['hiring_sponsor'] }} </p>
                                <p style="margin-bottom: 5px;"> {{ $invoiceData['hiring_sponsor_phone'] }} </p>
                                <p style="margin-bottom: 5px;"> {{ $invoiceData['hiring_sponsor_email'] }} </p>

                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <!-- INVOICE  -->
            <tr>
                <td class="invoice">
                    <table class="padding" width="100%" style="margin-top: 20px;">
                        <tr>
                            <td style="vertical-align: bottom; background-color: #37B8E8; padding: 10px;">
                                <table>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <P
                                                            style="font-size: 23px; font-weight: bold;  font-family: ubuntu; margin:0px">
                                                            INVOICE</P>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <P style="margin-top: 5px;">INVOICE NUMBER</P>
                                                        <P>{{ $invoiceData['invoice_number'] }}</P>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <P style="margin-top: 5px;">DATE OF ISSUE</P>
                                                        <p style="margin-bottom: 5px;"> {{ $invoiceData['date'] }} </p>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td>
                                <table style="width: 100%; vertical-align: top; ">
                                    <tr>
                                        <td>

                                            <table width="100%" class="content-table" style="border-collapse: collapse">
                                                <thead>
                                                    <tr style=" background-color: #37B8E8;
                                                    text-align: left;
                                                    padding: 15px;">
                                                        <th style="padding: 10px 15px !important;">SPONSORSHIP FEE</th>
                                                    </tr>

                                                </thead>
                                                <tbody>

                                                    <tr >
                                                        <td style=" background-color: lightgray;
                                                        border-bottom: 1px solid rgb(255, 255, 255);
                                                        margin-bottom: 3px; padding: 10px 15px">{{ $invoiceData['labor_sponsorship_fee'] }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <table width="100%" class="content-table" style="border-collapse: collapse">
                                                <thead>
                                                    <tr style=" background-color: #37B8E8;
                                                    text-align: left;
                                                    padding: 15px;">
                                                        <th style="padding: 10px 15px !important;">TAQAT FEE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style=" background-color: lightgray;
                                                        border-bottom: 1px solid rgb(255, 255, 255);
                                                        margin-bottom: 3px; padding: 10px 15px">{{$taqat_payment}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%; margin-top: 20px;">
                        <tr>
                            <td style="vertical-align: top;">
                                <table>

                                    <tr>
                                        <td>
                                            <table style="padding: 10px; ">
                                                <tr>
                                                    <td>SIGNATURE / STAMP</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>TAQAT LLC</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>
                                </table>

                            </td>

                            <td style="">
                                <table width="100%">

                                    <tr>
                                        <td>
                                            <table style="padding: 10px; color:black; text-align: right;"
                                                width="100%">
                                                <tr>
                                                    <td>
                                                        <p>SUBTOTAL :
                                                            {{ $invoiceData['labor_sponsorship_fee'] * ($invoiceData['taqat_percent'] / 100) + $invoiceData['labor_sponsorship_fee'] }}
                                                        </p>


                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>


                                </table>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table style="width: 100%; margin-top: 20px;">
                        <tr>
                            <td style="vertical-align: top;">
                                <table>

                                    <tr>
                                        <td>
                                            <table style="padding: 10px; ">
                                                <tr>
                                                    <td>Please send payments to the following bank account number</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Account number : {{ $invoiceData['taqat_bank_account'] }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Bank name : {{ $invoiceData['taqat_bank_name'] }}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>
                                </table>
                            </td>

                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <table>

                                    <tr>
                                        <td>
                                            <table style="padding: 10px; ">
                                                <tr>
                                                    <td>Once invoice paid , please send pay slip to the
                                                        following WhatsApp number :
                                                        {{ $invoiceData['taqat_whatsapp'] }}</td>
                                                </tr>

                                                <tr>
                                                    {{-- <td>Download Invoice : <a href="{{$pdfUrl}}"></a></td> --}}
                                                    <td>Download Invoice : <a
                                                            href="{{ url('pdf/laborTransferInvoices/' . $pdfUrl) }}">Download</a>
                                                    </td>
                                                </tr>



                                            </table>
                                        </td>



                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr style="text-align: center;">
                <!-- <td style="padding:5px; background-color: #37B8E8;">

                </td> -->
            </tr>


        </table>
    </center>

</body>

</html>

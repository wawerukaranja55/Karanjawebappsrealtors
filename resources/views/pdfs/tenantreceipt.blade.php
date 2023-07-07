<!DOCTYPE html>
<html>
<head>
    <title>Tenant Receipt</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;400;900&display=swap');

        :root {
        --primary: #e45716;
        --secondary: #b33e3e; 
        --white: #fff;
        }

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lato', sans-serif;
        }

        body{
            /* background: var(--secondary); */
            padding: 50px;
            color: var(--secondary);
            
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .bold{
            font-weight: 900;
        }

        .light{
            font-weight: 100;
        }

        .wrapper{
            background: var(--white);
            padding: 30px;
        }

        .invoice_wrapper{
            border: 3px solid var(--primary);
            width: 700px;
            max-width: 100%;
        }

        .invoice_wrapper .header .logo_invoice_wrap,
        .invoice_wrapper .header .bill_total_wrap{
            display: flex;
            justify-content: space-between;
            padding: 30px;
        }

        .invoice_wrapper .header .logo_sec{
            display: flex;
            align-items: center;
        }

        .invoice_wrapper .header .logo_sec .title_wrap{
            margin-left: 5px;
        }

        .invoice_wrapper .header .logo_sec .title_wrap .title{
            text-transform: uppercase;
            font-size: 18px;
            color: var(--primary);
        }

        .invoice_wrapper .header .logo_sec .title_wrap .sub_title{
            font-size: 12px;
        }

        .invoice_wrapper .header .invoice_sec,
        .invoice_wrapper .header .bill_total_wrap .total_wrap{
            text-align: right;
        }

        .invoice_wrapper .header .invoice_sec .invoice{
            font-size: 28px;
            color: var(--primary);
        }

        .invoice_wrapper .header .invoice_sec .invoice_no,
        .invoice_wrapper .header .invoice_sec .date{
            display: flex;
            width: 100%;
        }

        .invoice_wrapper .header .invoice_sec .invoice_no span:first-child,
        .invoice_wrapper .header .invoice_sec .date span:first-child{
            width: 70px;
            text-align: left;
        }

        .invoice_wrapper .header .invoice_sec .invoice_no span:last-child,
        .invoice_wrapper .header .invoice_sec .date span:last-child{
            width: calc(100% - 70px);
        }

        .invoice_wrapper .header .bill_total_wrap .total_wrap .price,
        .invoice_wrapper .header .bill_total_wrap .bill_sec .name{
            color: var(--primary);
            font-size: 20px;
        }

        .invoice_wrapper .body .main_table .table_header{
            background: var(--primary);
        }

        .invoice_wrapper .body .main_table .table_header .row{
            color: var(--white);
            font-size: 18px;
            border-bottom: 0px;	
        }

        .invoice_wrapper .body .main_table .row{
            display: flex;
            border-bottom: 1px solid var(--secondary);
        }

        .invoice_wrapper .body .main_table .row .col{
            padding: 10px;
        }
        .invoice_wrapper .body .main_table .row .col_no{width: 5%;}
        .invoice_wrapper .body .main_table .row .col_hse{width: 20%;}
        .invoice_wrapper .body .main_table .row .col_payment{width: 20%; text-align: center;}
        .invoice_wrapper .body .main_table .row .col_date{width: 20%; text-align: center;}
        .invoice_wrapper .body .main_table .row .col_arrears{width: 15%; text-align: right;}
        .invoice_wrapper .body .main_table .row .col_overpayment{width: 20%; text-align: right;}

        .invoice_wrapper .body .paymethod_grandtotal_wrap{
            display: flex;
            width: 100%;
            justify-content: space-between;
            padding: 5px 0 30px;
            
            align-items: flex-end;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .paymethod_sec{
            padding-left: 30px;
            float: left;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec{
            
            float: right;
            background-color: green;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p{
            display: flex;
            width: 100%;
            padding-bottom: 5px;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p span{
            padding: 0 10px;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p span:first-child{
            width: 60%;
            background: var(--primary);
            padding: 10px;
            color: #fff;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p span:last-child{
            width: 40%;
            text-align: right;
            background: var(--primary);
            padding: 10px;
            color: #fff;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p:last-child span{
            background: var(--primary);
            padding: 10px;
            color: #fff;
        }

        .invoice_wrapper .footer{
            padding: 15px;
        }

        .invoice_wrapper .footer > p{
            color: black;
            font-size: 18px;
        }


        /* table.GeneratedTable {
        width: 100%;
        background-color: #ffffff;
        border-collapse: collapse;
        border-width: 2px;
        border-color: #ffcc00;
        border-style: solid;
        color: #000000;
        }
        
        table.GeneratedTable td, table.GeneratedTable th {
        border-width: 2px;
        border-color: #ffcc00;
        border-style: solid;
        padding: 3px;
        }
        
        table.GeneratedTable thead {
        background-color: #ffcc00;
        } */

        .table{
            width: 95%;
            margin: 50% auto;
            border-collapse: collapse;
            border: none;
        }

        tr:nth-of-type(odd)
        {
            background: whitesmoke;
        }

        th{
            color: white;
            font-weight: bold;
            padding: 10px;
            background-color: black
        }

        td{
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="invoice_wrapper">
            <div class="header">
                <div class="logo_invoice_wrap">
                    <div class="logo_sec">
                        <img src="{{ public_path('/imagesforthewebsite/webicon.png') }}" width="100px" height="100px" alt="W.karanja WebApps Realtors">
                        <div class="title_wrap">
                            <p class="title bold">W.karanjaWebApp Realtors</p>
                            <p class="sub_title"> Limited</p>
                        </div>
                    </div>
                    <div class="invoice_sec">
                        <p class="invoice bold">RECEIPT</p>
                        <p class="invoice_no">
                            <span class="bold">Receipt No</span>
                            <span>{{ $paymentdetails->receipt_number }}</span>
                        </p><br>
                        <p class="date">
                            <span class="bold">Date Receipt Generated</span>
                            <span>{{ \Carbon\Carbon::parse($paymentdetails->created_at)->format('d/m/Y')}}</span>
                        </p>
                    </div>
                </div>
                <div class="bill_total_wrap">
                    <div class="bill_sec">
                        <p class="bold">Tenant Details</p> 
                        {{-- Name:<p>{{ $userdetails->name }}</p> --}}
                        <span>
                            Name:{{ $userdetails->name }}<br/>
                            Phone Number:{{ $userdetails->phone }}<br/>
                           Id Number:{{ $userdetails->id_number }}<br>
                            Rooms:@foreach ($userdetails->hserooms as $room )
                                {{ $room->room_name }},
                            @endforeach
                        </span>
                    </div>
                    <div class="total_wrap">
                        <p>Paid Via:</p>
                          <p class="bold price">{{ $paymentdetails->paymenttransactiontype->name }}</p>
                    </div>
                </div>
            </div>
            <!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
            <div class="body">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>House Details</th>
                            <th>Amount Paid</th>
                            <th>Date Of Payment</th>
                            <th>Arrears For the Month</th>
                            <th>Over_Payment For the Month</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tenantpaymentsforthemonth as $userpayment)
                            <tr>
                                <td data-column="User Id">
                                    <p>{{ $userpayment->id }}</p>
                                </td>
                                <td data-column="House Details">
                                    <p class="bold">{{ $userdetails->rentalhses->rental_name }}</p>
                                    <p>@foreach ($userdetails->hserooms as $room )
                                        {{ $room->room_name }},
                                    @endforeach</p>
                                </td>
                                <td data-column="Amount Paid">
                                    <p>{{ $userpayment->amount_paid }}</p>
                                </td>
                                <td data-column="Date Paid">
                                    <p>{{ $userpayment->date_paid }}</p>
                                </td>
                                <td data-column="Total Arrears">
                                    <p>{{ $userpayment->total_arrears }}</p>
                                </td>
                                <td data-column="Overpaid Amount">
                                    <p>{{ $userpayment->overpaid_amount }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paymethod_grandtotal_wrap" style="margin-top: 30px;">
                    <div class="paymethod_sec">
                        <p class="bold">Our Payment Methods</p>
                        @foreach ($paymenttypes as $type)
                            <p>{{ $type->name }}:{{ $type->number }}</p>
                        @endforeach
                    </div>
                    <div class="grandtotal_sec">
                        <p class="bold">
                            <span>Total Arrears</span>
                            <span>{{ $current_arrear }}</span>
                        </p>
                        <p class="bold">
                            <span>Total Over Payments</span>
                            <span>{{ $tenantpaymentsforthemonth->sum('overpaid_amount') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>Thank you For Paying your Rent.Click <a href="http://wkaranjarealtorsystem.co.ke">here</a> to visit the Company website</p>
            </div>
        </div>
    </div>
</body>
</html>


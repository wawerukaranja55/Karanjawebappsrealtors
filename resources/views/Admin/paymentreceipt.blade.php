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
            background: var(--secondary);
            padding: 50px;
            color: var(--secondary);
            display: flex;
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
            justify-content: space-between;
            padding: 5px 0 30px;
            align-items: flex-end;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .paymethod_sec{
            padding-left: 30px;
        }

        .invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec{
            width: 30%;
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
            padding: 30px;
        }

        .invoice_wrapper .footer > p{
            color: var(--primary);
            text-decoration: underline;
            font-size: 18px;
            padding-bottom: 5px;
        }

        .invoice_wrapper .footer .terms .tc{
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="invoice_wrapper">
            <div class="header">
                <div class="logo_invoice_wrap">
                    <div class="logo_sec">
                        <img src="/imagesforthewebsite/webicon.png" width="100px" height="100px" alt="W.karanja WebApps Realtors">
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
            <div class="body">
                <div class="main_table">
                    <div class="table_header">
                        <div class="row">
                            <div class="col col_no">Id.</div>
                            <div class="col col_hse">House Details</div>
                            <div class="col col_payment">Amount Paid</div>
                            <div class="col col_date">Date Of Payment</div>
                            <div class="col col_arrears">Arrears For the Month</div>
                            <div class="col col_overpayment">Over_Payment For the Month</div>
                        </div>
                    </div>
                    <div class="table_body">
                        @foreach ($tenantpaymentsforthemonth as $userpayment)
                            <div class="row">
                                <div class="col col_no">
                                    <p>{{ $userpayment->id }}</p>
                                </div>
                                <div class="col col_hse">
                                    <p class="bold">{{ $userdetails->rentalhses->rental_name }}</p>
                                    <p>@foreach ($userdetails->hserooms as $room )
                                        {{ $room->room_name }},
                                    @endforeach</p>
                                </div>
                                <div class="col col_payment">
                                    <p>{{ $userpayment->amount_paid }}</p>
                                </div>
                                <div class="col col_date">
                                    <p>{{ $userpayment->date_paid }}</p>
                                </div>
                                <div class="col col_arrears">
                                    <p>{{ $userpayment->total_arrears }}</p>
                                </div>
                                <div class="col col_overpayment">
                                    <p>{{ $userpayment->overpaid_amount }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="paymethod_grandtotal_wrap">
                    <div class="paymethod_sec">
                        <p class="bold">Our Payment Methods</p>
                        <p>payments methods we can pay with</p>
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
                <p>Thank you and Best Wishes</p>
                <div class="terms">
                    <p class="tc bold">Terms & Coditions</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit non praesentium doloribus. Quaerat vero iure itaque odio numquam, debitis illo quasi consequuntur velit, explicabo esse nesciunt error aliquid quis eius!</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


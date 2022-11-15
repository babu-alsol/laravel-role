<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <!-- CHANGE THE TITLE HERE -->
    <title>WATR TECHNOLOGIES LAB REPORT</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BOOTSTRAP V4.0 ALL CDN LINKS START -->

    <style type="text/css">
        /*TABLE BORDER COLOR START*/
        table.table-bordered {
            border: 1px solid black;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid black;
        }

        /*TABLE BORDER COLOR END*/
    </style>


</head>

<body>
    <div class="container">


        <center>
            <h3 style="color:#6086E6">One Pay Cashbooks Report</h3>
        </center>


        <!--       <img src="" alt="Company Logo" style="width: 200px">
 -->

        <table>


            <tr>
                <td>Date Collected:</td>
             
                <td> {{ date('d-m-Y', strtotime(\Carbon\Carbon::now())) }}</td>
               
            </tr>


        </table>


        </tbody>
        </table>
    </div><br>

    <h4 style="color: green"></h4>

    <div class="table-responsive">
        <table class="table table-bordered" width="100%" style="width:100%; align-self: center;" border="0">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Payment Type</th>
                    <th>Payment Details</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($cashbooks as $item)
                    <tr>
                        <td>1</td>
                        <td>
                            <center>{{ $item->amount }}</center>
                        </td>
                        <td>
                            <center>{{ $item->cb_tns_type }}</center>
                        </td>
                        <td>
                            <center>{{ $item->payment_type }}</center>
                        </td>
                        <td>
                            <center>{{ $item->payment_details }}</center>
                        </td>
                        <td>
                            <center>{{date('d-m-Y', strtotime($item->date_time)) }}</center>
                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>
    </div><br>

    </div>
    <br>
</body>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<!-- CHANGE THE TITLE HERE -->
  <title>WATR TECHNOLOGIES LAB REPORT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- BOOTSTRAP V4.0 ALL CDN LINKS START -->
  
  <style type="text/css">

  	/*TABLE BORDER COLOR START*/
  	table.table-bordered{
    border:1px solid black;
    }
    table.table-bordered > thead > tr > th{
        border:1px solid black;
    }
    table.table-bordered > tbody > tr > td{
        border:1px solid black;
    }
/*TABLE BORDER COLOR END*/

  </style>


</head>
<body>
	<div class="container">

 @php

 $partner=$data['partner'];

 $reports=$data['reports'];

 @endphp
	 <center><h3 style="color:#6086E6">WATR TECHNOLOGIES LAB REPORT</h3></center>


<!--       <img src="{{asset('images/logo.png')}}" alt="Company Logo" style="width: 200px">
 -->

<table>  
<tr><td>Order Number:</td><td>1234567890</td></tr> 
<tr><td>Lab Number:</td><td>L{{$partner->id}}</td></tr> 
<tr><td>Name:</td><td>{{$partner->labname}}</td></tr>  
<tr><td>Address:</td><td>72</td></tr> 
<tr><td>City, State, Zip:</td><td>72</td></tr>  
<tr><td>Source/Location:</td><td>{{$partner->location}}</td></tr>  

<tr><td>Date Collected:</td><td>12/07/2020</td></tr>  


</table>  


@php 
  $prevName='';
  $start=1;
@endphp

 @foreach($reports as $report)

  @php 

    $currName=$report->test_name;

  @endphp

@if($prevName!=$currName)

@if($start==0)
      </tbody>
    </table>
  </div><br>
@endif

   <h4 style="color: green">{{$currName}}</h4>

    <div class="table-responsive">
    <table class="table table-bordered" width="100%" style="width:100%; align-self: center;" border="0">
      <thead>
        <tr>
          <th>Parameter</th>
          <th>MCL (NTU)</th>
          <th>MDL (NTU)</th>
          <th>Result (NTU)</th>
        </tr>
      </thead>
      <tbody>

@endif


        <tr>
          <td>{{$report->parameter}}</td>
          <td><center>{{$report->mcl}}</center></td>
          <td><center>{{$report->mdl}}</center></td>
          <td><center>{{$report->result}}</center></td>
        </tr>

@php 
  $prevName=$report->test_name;
  $start=0
@endphp

@endforeach

      </tbody>
    </table>
  </div><br>

</div>
<br>
</body>
</html>
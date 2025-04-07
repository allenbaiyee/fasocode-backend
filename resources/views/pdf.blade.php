<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 0.8rem solid #ffffff;
  text-align: center;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.correct{
    color:green;
}
.wrong{
    color:red;
}
.pass{
    background-color: green;
    width: 500px;
    padding: 10px 20px;
    position: absolute;
    top: -10px;
    left: 70%;
    color:white;
    font-weight: bold;
    font-family: arial;
    font-size: 20px;
}
.fail{
    background-color: red;
    width: 500px;
    padding: 10px 20px;
    position: absolute;
    top: -10px;
    left: 70%;
    color:white;
    font-weight: bold;
    font-family: arial;
    font-size: 20px;
}
</style>
</head>
<body style="width:100%;">
  @php( $total = \App\UserAnswer::where('user_id',Auth::user()->id)->where('exam_sitting_id',$sitting->id)->where('result',1)->get())

  @if (count($total) >= 25)
  <div class="pass">
      <p style="position: relative;">Pass! </p> <img style="height:28px; position: absolute; top: -3px; left: 47px;" src="{{ url('images/happy.png') }}" />
      <p>{{count($total)}}/30 Passed Test</p>
  </div>
  @else
  <div class="fail">
      <p style="position: relative;">Fail! <img style="height:28px; position: absolute; top: -3px; left: 47px;"  src="{{ url('images/sad.png') }}" /></p> 
      <p>{{count($total)}}/30 Try Again</p>
  </div>
  @endif

<h2 style="text-align: center;">{{$exam}}</h2>
<h4 style="text-align: center;">{{$sitting->created_at}}</h4>
<table>
  
  @foreach($questions as $index => $question)
    @php( $user_answer = \App\UserAnswer::where('user_id',Auth::user()->id)->where('question_id',$question->id)->first())
    
    @if($index%3 == 0)
    <tr> 
    @endif
      <td style="text-align: center;">
        <img src="{{url('images/questions/'.$question->image)}}" width="200">
        <br/>
        @if(empty($user_answer))
          <label class="wrong">Choice :</label> <br>

        @elseif($user_answer->result)
          Your Choice: <label class="correct"> {{$user_answer->answer}}</label> <br>
        @else
          Your Choice: <label class="wrong">{{$user_answer->answer}}</label> <br>
        @endif
        Question {{$index+1}} : {{$question->answer}}
      </td>
    @if(($index%3 == 2) )
     <tr>
    @endif

  @endforeach
  

</table>
{{-- {{ dd($questions) }} --}}
</body>
</html>

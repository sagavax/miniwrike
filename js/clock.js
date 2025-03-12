        function startTime()
        {
        var today=new Date();
        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();
         
        // add a zero in front of numbers<10
        m=checkTime(m);
        s=checkTime(s);
        if(h<12)
        document.getElementById('clock').innerHTML=h+":"+m+":"+s + " AM";
        else
        document.getElementById('clock').innerHTML=h+":"+m+":"+s + " PM";
 
        t=setTimeout('startTime()',500);
        }
 
        function checkTime(i)
        {
        if (i<10)
          {
          i="0" + i;
          }
        return i;
        }
Latest load test data using doctrine and 2 levels of joins  plus cache

<pre>k6 run --vus 1000 --duration 1m tests/load/http.js

<font color="#1A92AA">          /\      |‾‾|  /‾‾/  /‾/   </font>
<font color="#1A92AA">     /\  /  \     |  |_/  /  / /    </font>
<font color="#1A92AA">    /  \/    \    |      |  /  ‾‾\  </font>
<font color="#1A92AA">   /          \   |  |‾\  \ | (_) | </font>
<font color="#1A92AA">  / __________ \  |__|  \__\ \___/ .io</font>

  execution: <font color="#1A92AA">local</font>
     output: <font color="#1A92AA">-</font>
     script: <font color="#1A92AA">tests/load/http.js</font>

    duration: <font color="#1A92AA">1m0s</font>, iterations: -
         vus: <font color="#1A92AA">1000</font>, max: <font color="#1A92AA">1000</font>

    done [==========================================================] 1m0s / 1m0s

<font color="#44AA44">    ✓ status was 200</font>

    checks.....................: <font color="#1A92AA">100.00%</font> <font color="#116171">✓ 31313</font>  <font color="#116171">✗ 0</font>     
    data_received..............: <font color="#1A92AA">171 MB</font>  <font color="#116171">2.8 MB/s</font>
    data_sent..................: <font color="#1A92AA">4.4 MB</font>  <font color="#116171">73 kB/s</font>
    http_req_blocked...........: avg=<font color="#1A92AA">213.84ms</font> min=<font color="#1A92AA">83.62µs</font> med=<font color="#1A92AA">144.92µs</font> max=<font color="#1A92AA">15.45s</font>  p(90)=<font color="#1A92AA">1.01s</font>   p(95)=<font color="#1A92AA">1.02s</font>   
    http_req_connecting........: avg=<font color="#1A92AA">213.76ms</font> min=<font color="#1A92AA">48.14µs</font> med=<font color="#1A92AA">83.62µs</font>  max=<font color="#1A92AA">15.45s</font>  p(90)=<font color="#1A92AA">1.01s</font>   p(95)=<font color="#1A92AA">1.02s</font>   
    http_req_duration..........: avg=<font color="#1A92AA">97.44ms</font>  min=<font color="#1A92AA">1.5ms</font>   med=<font color="#1A92AA">54.68ms</font>  max=<font color="#1A92AA">26.8s</font>   p(90)=<font color="#1A92AA">71.58ms</font> p(95)=<font color="#1A92AA">251.85ms</font>
    http_req_receiving.........: avg=<font color="#1A92AA">86.07µs</font>  min=<font color="#1A92AA">27.81µs</font> med=<font color="#1A92AA">79.61µs</font>  max=<font color="#1A92AA">4.26ms</font>  p(90)=<font color="#1A92AA">106.2µs</font> p(95)=<font color="#1A92AA">121.86µs</font>
    http_req_sending...........: avg=<font color="#1A92AA">172.35µs</font> min=<font color="#1A92AA">19.55µs</font> med=<font color="#1A92AA">51.57µs</font>  max=<font color="#1A92AA">31.39ms</font> p(90)=<font color="#1A92AA">98.58µs</font> p(95)=<font color="#1A92AA">168.24µs</font>
    http_req_tls_handshaking...: avg=<font color="#1A92AA">0s</font>       min=<font color="#1A92AA">0s</font>      med=<font color="#1A92AA">0s</font>       max=<font color="#1A92AA">0s</font>      p(90)=<font color="#1A92AA">0s</font>      p(95)=<font color="#1A92AA">0s</font>      
    http_req_waiting...........: avg=<font color="#1A92AA">97.18ms</font>  min=<font color="#1A92AA">1.38ms</font>  med=<font color="#1A92AA">54.54ms</font>  max=<font color="#1A92AA">26.8s</font>   p(90)=<font color="#1A92AA">71.39ms</font> p(95)=<font color="#1A92AA">251.56ms</font>
    http_reqs..................: <font color="#1A92AA">31313</font>   <font color="#116171">521.882523/s</font>
    iteration_duration.........: avg=<font color="#1A92AA">1.31s</font>    min=<font color="#1A92AA">1s</font>      med=<font color="#1A92AA">1.05s</font>    max=<font color="#1A92AA">30.85s</font>  p(90)=<font color="#1A92AA">2.05s</font>   p(95)=<font color="#1A92AA">2.1s</font>    
    iterations.................: <font color="#1A92AA">30824</font>   <font color="#116171">513.732536/s</font>
    vus........................: <font color="#1A92AA">1000</font>    <font color="#116171">min=1000</font> <font color="#116171">max=1000</font>
    vus_max....................: <font color="#1A92AA">1000</font>    <font color="#116171">min=1000</font> <font color="#116171">max=1000</font>
</pre>
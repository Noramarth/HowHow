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

    checks.....................: <font color="#1A92AA">100.00%</font> <font color="#116171">✓ 52145</font>  <font color="#116171">✗ 0</font>     
    data_received..............: <font color="#1A92AA">282 MB</font>  <font color="#116171">4.7 MB/s</font>
    data_sent..................: <font color="#1A92AA">7.3 MB</font>  <font color="#116171">121 kB/s</font>
    http_req_blocked...........: avg=<font color="#1A92AA">66ms</font>     min=<font color="#1A92AA">75.65µs</font>  med=<font color="#1A92AA">137.24µs</font> max=<font color="#1A92AA">7.29s</font>    p(90)=<font color="#1A92AA">271.72µs</font> p(95)=<font color="#1A92AA">100.95ms</font>
    http_req_connecting........: avg=<font color="#1A92AA">65.92ms</font>  min=<font color="#1A92AA">44.09µs</font>  med=<font color="#1A92AA">78.52µs</font>  max=<font color="#1A92AA">7.29s</font>    p(90)=<font color="#1A92AA">180.16µs</font> p(95)=<font color="#1A92AA">100.64ms</font>
    http_req_duration..........: avg=<font color="#1A92AA">82.53ms</font>  min=<font color="#1A92AA">985.08µs</font> med=<font color="#1A92AA">33.95ms</font>  max=<font color="#1A92AA">54.39s</font>   p(90)=<font color="#1A92AA">38.32ms</font>  p(95)=<font color="#1A92AA">52.54ms</font> 
    http_req_receiving.........: avg=<font color="#1A92AA">201.58µs</font> min=<font color="#1A92AA">31.96µs</font>  med=<font color="#1A92AA">80.09µs</font>  max=<font color="#1A92AA">129.14ms</font> p(90)=<font color="#1A92AA">106.64µs</font> p(95)=<font color="#1A92AA">123.84µs</font>
    http_req_sending...........: avg=<font color="#1A92AA">192.89µs</font> min=<font color="#1A92AA">24.18µs</font>  med=<font color="#1A92AA">49.87µs</font>  max=<font color="#1A92AA">50.94ms</font>  p(90)=<font color="#1A92AA">74.5µs</font>   p(95)=<font color="#1A92AA">110.28µs</font>
    http_req_tls_handshaking...: avg=<font color="#1A92AA">0s</font>       min=<font color="#1A92AA">0s</font>       med=<font color="#1A92AA">0s</font>       max=<font color="#1A92AA">0s</font>       p(90)=<font color="#1A92AA">0s</font>       p(95)=<font color="#1A92AA">0s</font>      
    http_req_waiting...........: avg=<font color="#1A92AA">82.13ms</font>  min=<font color="#1A92AA">869.65µs</font> med=<font color="#1A92AA">33.81ms</font>  max=<font color="#1A92AA">54.39s</font>   p(90)=<font color="#1A92AA">38.18ms</font>  p(95)=<font color="#1A92AA">52.3ms</font>  
    http_reqs..................: <font color="#1A92AA">52145</font>   <font color="#116171">869.082469/s</font>
    iteration_duration.........: avg=<font color="#1A92AA">1.15s</font>    min=<font color="#1A92AA">1s</font>       med=<font color="#1A92AA">1.03s</font>    max=<font color="#1A92AA">56.42s</font>   p(90)=<font color="#1A92AA">1.04s</font>    p(95)=<font color="#1A92AA">1.66s</font>   
    iterations.................: <font color="#1A92AA">51193</font>   <font color="#116171">853.215818/s</font>
    vus........................: <font color="#1A92AA">1000</font>    <font color="#116171">min=1000</font> <font color="#116171">max=1000</font>
    vus_max....................: <font color="#1A92AA">1000</font>    <font color="#116171">min=1000</font> <font color="#116171">max=1000</font>

</pre>
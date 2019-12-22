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

    checks.....................: <font color="#1A92AA">100.00%</font> <font color="#116171">✓ 47709</font>  <font color="#116171">✗ 0</font>     
    data_received..............: <font color="#1A92AA">257 MB</font>  <font color="#116171">4.3 MB/s</font>
    data_sent..................: <font color="#1A92AA">6.6 MB</font>  <font color="#116171">111 kB/s</font>
    http_req_blocked...........: avg=<font color="#1A92AA">185.68ms</font> min=<font color="#1A92AA">80.06µs</font>  med=<font color="#1A92AA">140.74µs</font> max=<font color="#1A92AA">15.37s</font>  p(90)=<font color="#1A92AA">1.01s</font>    p(95)=<font color="#1A92AA">1.02s</font>   
    http_req_connecting........: avg=<font color="#1A92AA">185.59ms</font> min=<font color="#1A92AA">43.67µs</font>  med=<font color="#1A92AA">81.36µs</font>  max=<font color="#1A92AA">15.37s</font>  p(90)=<font color="#1A92AA">1.01s</font>    p(95)=<font color="#1A92AA">1.02s</font>   
    http_req_duration..........: avg=<font color="#1A92AA">66.14ms</font>  min=<font color="#1A92AA">744.61µs</font> med=<font color="#1A92AA">12.4ms</font>   max=<font color="#1A92AA">26.84s</font>  p(90)=<font color="#1A92AA">47.14ms</font>  p(95)=<font color="#1A92AA">181ms</font>   
    http_req_receiving.........: avg=<font color="#1A92AA">104.66µs</font> min=<font color="#1A92AA">30.28µs</font>  med=<font color="#1A92AA">78.27µs</font>  max=<font color="#1A92AA">13.13ms</font> p(90)=<font color="#1A92AA">117.07µs</font> p(95)=<font color="#1A92AA">150.48µs</font>
    http_req_sending...........: avg=<font color="#1A92AA">212.33µs</font> min=<font color="#1A92AA">19.48µs</font>  med=<font color="#1A92AA">50.41µs</font>  max=<font color="#1A92AA">42.74ms</font> p(90)=<font color="#1A92AA">142.88µs</font> p(95)=<font color="#1A92AA">292.06µs</font>
    http_req_tls_handshaking...: avg=<font color="#1A92AA">0s</font>       min=<font color="#1A92AA">0s</font>       med=<font color="#1A92AA">0s</font>       max=<font color="#1A92AA">0s</font>      p(90)=<font color="#1A92AA">0s</font>       p(95)=<font color="#1A92AA">0s</font>      
    http_req_waiting...........: avg=<font color="#1A92AA">65.82ms</font>  min=<font color="#1A92AA">636.84µs</font> med=<font color="#1A92AA">12.25ms</font>  max=<font color="#1A92AA">26.83s</font>  p(90)=<font color="#1A92AA">46.91ms</font>  p(95)=<font color="#1A92AA">180.89ms</font>
    http_reqs..................: <font color="#1A92AA">47709</font>   <font color="#116171">795.148142/s</font>
    iteration_duration.........: avg=<font color="#1A92AA">1.25s</font>    min=<font color="#1A92AA">1s</font>       med=<font color="#1A92AA">1.01s</font>    max=<font color="#1A92AA">28.86s</font>  p(90)=<font color="#1A92AA">2.02s</font>    p(95)=<font color="#1A92AA">2.05s</font>   
    iterations.................: <font color="#1A92AA">46759</font>   <font color="#116171">779.314846/s</font>
    vus........................: <font color="#1A92AA">1000</font>    <font color="#116171">min=1000</font> <font color="#116171">max=1000</font>
    vus_max....................: <font color="#1A92AA">1000</font>    <font color="#116171">min=1000</font> <font color="#116171">max=1000</font>
</pre>
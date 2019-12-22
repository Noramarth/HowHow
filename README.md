Latest load test data using doctrine and 2 levels of joins 

k6 run --vus 500 --duration 30s tests/load/http.js


  execution: local
     output: -
     script: tests/load/http.js

    duration: 30s, iterations: -
         vus: 500, max: 500

    done [==========================================================] 30s / 30s

    ✓ status was 200

    checks.....................: 100.00% ✓ 13860 ✗ 0    
    data_received..............: 74 MB   2.5 MB/s
    data_sent..................: 1.9 MB  63 kB/s
    http_req_blocked...........: avg=56.02ms  min=83.07µs med=178.48µs max=3.05s   p(90)=731.84µs p(95)=16.59ms 
    http_req_connecting........: avg=55.91ms  min=48.73µs med=102.39µs max=3.05s   p(90)=467.63µs p(95)=16.42ms 
    http_req_duration..........: avg=42.07ms  min=1.48ms  med=26.46ms  max=1.68s   p(90)=38.31ms  p(95)=69.78ms 
    http_req_receiving.........: avg=134.72µs min=33.67µs med=92.67µs  max=7.06ms  p(90)=262.11µs p(95)=342.12µs
    http_req_sending...........: avg=220.88µs min=25.67µs med=61.41µs  max=34.68ms p(90)=200.06µs p(95)=304.77µs
    http_req_tls_handshaking...: avg=0s       min=0s      med=0s       max=0s      p(90)=0s       p(95)=0s      
    http_req_waiting...........: avg=41.72ms  min=1.34ms  med=26.2ms   max=1.68s   p(90)=38.06ms  p(95)=69.5ms  
    http_reqs..................: 13860   461.998713/s
    iteration_duration.........: avg=1.1s     min=1s      med=1.02s    max=5.7s    p(90)=1.05s    p(95)=1.38s   
    iterations.................: 13369   445.632092/s
    vus........................: 500     min=500 max=500
    vus_max....................: 500     min=500 max=500

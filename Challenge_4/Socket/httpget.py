import socket as sk
from urllib.parse import urlparse
import re
from tcplib import parseTCPMsg


def getMethod(url: str):
    url = urlparse(url)
    sock = sk.socket(sk.AF_INET, sk.SOCK_STREAM)
    sock.connect((url.hostname, url.port or 80))
    msg = 'GET {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
        .format(path=url.path or "/",
                host=url.netloc)
    # print(msg)

    sock.sendall(msg.encode())
    response = ""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk.decode("utf-8")
    sock.close()

    return parseTCPMsg(response)


def getTitle(source: str):
    regex = r"\<title\>([\S\s]+)\<\/title\>"
    return re.search(regex, source).group(1)


if __name__ == '__main__':
    header, body = getMethod("http://45.32.110.240/")
    print(getTitle(body))

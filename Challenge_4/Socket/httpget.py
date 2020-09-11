import argparse
import re
from urllib.parse import urlparse

from tcplib import createSocket
from tcplib import parseTcpMsg
from tcplib import sendTcpMsg


def getMethod(url: str):
    url = urlparse(url)
    sock = createSocket(url.hostname, url.port or 80)

    msg = 'GET {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
        .format(path=url.path or "/",
                host=url.netloc)

    response = sendTcpMsg(sock, msg.encode())

    sock.close()

    return parseTcpMsg(response.decode())


def getTitle(source: str):
    regex = r"\<title\>([\S\s]+)\<\/title\>"
    return re.search(regex, source).group(1)


if __name__ == '__main__':
    parse = argparse.ArgumentParser(description="Get title from wp website")
    parse.add_argument("--url", help="URL")

    args = parse.parse_args()

    url = args.url

    header, body = getMethod(url)
    print(getTitle(body))
